<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;


class tenantEmployeeController extends Controller
{
    // add user
    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }

            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                . mt_rand(1000000, 9999999)
                . $characters[rand(0, strlen($characters) - 1)];
            $pin = substr($pin, 0, 8);

            if (User::where('email', $request->email)->exists()) {

                return response()->json(['status' => 'fail', 'msg' => 'Email Already Exists!']);
            }

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $tenant = Auth::user();
            $user->parent_id = $tenant->id;
            if(isset($tenant->site_id)){
                $user->site_id = $tenant->site_id;
            }
            $user->password = bcrypt($pin);
            $user->save();
            $usr = User::where('id', $user->id)->first();
            $usr->assignRole('Employee');

            Mail::send('templates.email.add_user', ['user' => $user, 'password' => $pin], function ($message) use ($user) {
                $message->to($user->email)
                    ->from(env('MAIL_FROM_ADDRESS'), env('app_name'))
                    ->subject("Your account has been created");
            });

            //twillo sms
            $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
            $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
            $twilio_number = '+18152408707';
            $receiverNumber = $request->phone;
            $message = 'Your account has been created on '.env('app_name').'Your login credentials are, Email: '.$user->email.' Password: '.$pin.'.';
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message
            ]);

            $responseArray = [];
            $responseArray['token'] = $usr->createToken(env('app_name'))->accessToken;


            return response()->json([
                'status' => 'success',
                'msg' => 'User account created successfully'
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
            
        }
    }

    // user count
    public function userCount(Request $request)
    {
        $filterRole = $request->filterRole;
        $filterTitle = $request->filterTitle;
        $filterLength = $request->filterLength;
        $result = User::query();
        $result = $result->where('parent_id',auth()->user()->id);
        $result = $result->whereHas('roles',function($q){
            $q->where('name','Employee');
        });
        
        if ($filterTitle != '') {
            $result = $result->where('first_name', 'like', '%' . $filterTitle . '%');
        }
        if ($filterRole != 'All') {
            $result = $result->role($filterRole);
        }


        $count = $result->count();

        if ($count > 0) {
            return response()->json(['status' => 'success', 'data' => $count]);
        } else {
            return response()->json(['status' => 'fail', 'msg' => 'No Data Found']);
        }
    }

    // append data  
    public function users(Request $request)
    {
        $filterRole = $request->filterRole;
        $filterTitle = $request->filterTitle;
        $filterLength = $request->filterLength;
        $result = User::query();
        $result = $result->where('parent_id',auth()->user()->id);
        $result = $result->whereHas('roles',function($q){
            $q->where('name','Employee');
        });

        if ($filterTitle != '') {
            $result = $result->where('first_name', 'like', '%' . $filterTitle . '%')->orWhere('last_name', 'like', '%' . $filterTitle . '%');
        }



        $user = $result->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();
        if (isset($user) && sizeof($user) > 0) {
            $html = '';
            foreach ($user as $usr) {
                if ($usr->image == NULL) {
                    $img = '<img class="avatar avatar-xxl brround cover-image br-7 w-100"
                    style="height:110px !important; width:110px !important;"
                    src="' . asset('assets/images/users/15.jpg') . '" alt="img">';
                } elseif (file_exists("uploads/files/" . $usr->image)) {
                    $img = '<img src="' . asset('uploads/files/' . $usr->image) . '" alt="img"
                                                class="rounded-circle "  style="height:110px !important; width:110px !important;">';
                } elseif (!file_exists("uploads/files/" . $usr->image)) {
                    $img = '<img class="avatar avatar-xxl brround cover-image br-7 w-100"
                    style="height:110px !important; width:110px !important;"
                    src="' . asset('assets/images/users/15.jpg') . '" alt="img">';
                }
                if ($usr->status == "active") {
                    $status = "Active";
                    $bg = "bg-success";
                } else {
                    $status = "Block";
                    $bg = "bg-danger";
                }


                if (Auth::user()->id == $usr->id) {

                    $btun = '';
                } else {

                    $btun = '                                                                    
                    <a class="dropdown-item btnDelete" id="' . $usr->id . '" href="javascript:void(0)"><i class="fe fe-trash me-2"></i>
                    Delete</a>';
                }

                if (Auth::user()->id == $usr->id || (Auth::user()->hasRole('Tenant') && $usr->hasRole('Admin'))) {
                    $btn = '';
                } else {
                    $btn = '
                        <li>
                        <a href="/tenant/user/detail/' . $usr->id . '" class="bg-primary text-white border-primary border text-center"
                            style="height:30px !important; width:30px !important; line-height:30px !important;">
                            <i class="fe fe-eye "> </i> </a>
                    </li>
                    <li>
                        <a href="/tenant/user/edit/' . $usr->id . '" class="btnEdit bg-success text-white border-success border"
                            style="height:30px !important; width:30px !important; line-height:30px !important;"><i
                                class="fe fe-edit"></i></a>
                    </li>
                    
                    <li><a href="javascript:void(0)" class="bg-danger btnDelete text-white border-danger border" id="' . $usr->id . '"
                            style="height:30px !important; width:30px !important; line-height:30px !important;"><i
                                class="fe fe-x"></i></a></li>';
                }
                $html .= '
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="card">
                        <div class="product-grid6">
                            <div class="product-image6 pt-5 ">
                                <ul class="icons ">
                                    ' . $btn . '
                                </ul>
                                <a href="javasccript:;"> 
                                    ' . $img . '
                                </a>

                            </div>
                            <div class="card-body pt-2 pb-2">
                                <div class="product-content text-center pb-0 mb-0">

                                    <h4 class="h4 mb-0 pb-0 title fw-bold fs-20 p-0">' . $usr->first_name . ' ' . $usr->last_name . ' </h4>
                                    <span class="badge bg-success-transparent rounded-pill text-success px-3">' . $usr->roles->pluck('name')[0] . '</span> |
                                    <span class="badge rounded-pill ' . $bg . '   px-3">' . $status . '</span>

                                    <div class="row mt-2 mb-0 pb-0">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-mail fs-20"></i></span>
                                            </div>
                                            <div class="text-muted text-truncate">
                                                <strong class="text-truncate">' . $usr->email . '</strong>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-phone fs-20"></i></span>
                                            </div>
                                            <div class="text-muted">
                                                <strong>' . $usr->phone . ' </strong>
                                            </div>
                                        </div>
                                        <!-- <div class="d-flex align-items-center mb-1">
                                            <div class="me-4 text-center text-primary">
                                                <span><i class="fe fe-briefcase fs-20"></i></span>
                                            </div>
                                            <div class="text-muted">
                                                <strong>
                                                </strong>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center p-0 px-3 py-2">
                                <div class="row">
                                    <div class="col-9 text-start">
                                        <p class="card-text"><small class="text-muted">Created at: ' . date('d M,Y', strtotime($usr->created_at)) . '</small></p>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="ms-auto mt-1 file-dropdown">
                                            <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"><i class="fe fe-more-vertical fs-18"></i></a>
                                            <div class="dropdown-menu dropdown-menu-start">
                                            <a class="dropdown-item btnEdit" href="/tenant/user/edit/' . $usr->id . '"><i class="fe fe-edit me-2"></i> Edit</a>  
                                            ' . $btun . '               
                                            <a class="dropdown-item" href="/tenant/user/detail/' . $usr->id . '" ><i class="fe fe-eye me-2"></i>
                                            Detail</a>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
            return response()->json(['status' => 'success', 'rows' => $html]);
        } else {
            return response()->json(['status' => 'fail', 'msg' => 'No User Found!']);
        }
    }

    // delete user
    public function deleteUser($id)
    {
        $user = User::find($id);
        $currentImage = $user->photo;
        $path = public_path() . '/uploads/files/';

        if (file_exists($path . $currentImage)) {
            @unlink($path . $currentImage);
        }
        $user->delete();
        if ($user) {
            return response()->json(['status' => 'success', 'msg' => 'User is Deleted']);
        }
        return response()->json(['status' => 'fail', 'msg' => 'failed to delete User']);
    }

    // view add user
    public function viewAdd()
    {
        if (!Auth::user()->hasRole('User')) {
            return view('templates.tenant.employee.add');
        } else {
            return view('templates.404');
        }
    }

    // edit user
    public function editUser($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            return view('templates/tenant/employee/edit', ['user' => $user]);
        } else {
            return view('templates.404');
        }
    }

    // update user
    public function updateUser(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            if ($request->photo) {
                $currentimage = $user->image;
                $image = $request->photo;
                $img_name = time() . '-' . $image->getClientOriginalName();
                $path = public_path('/uploads/files/');
                $image->move($path, $img_name);
                if (file_exists($path . $currentimage)) {
                    @unlink($path . $currentimage);
                }
                $user->image = $img_name;
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            if (User::where('email', $request->email)->where('id', '!=', $user->id)->exists()) {
                return response()->json(['status' => 'fail', 'msg' => 'Email Already Exists!']);
            } else {
                $user->email = $request->email;
            }
            $user->phone = $request->phone;
            $user->address = $request->address;
            if ($user->save()) {
                return response()->json([
                    'status' => 'success',
                    'msg' => 'User Account Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'something went wrong'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    // user deatail 
    public function userDetail($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            return view('templates.tenant.employee.detail', ['user' => $user]);
        } else {
            return view('templates.404', ['user' => $user]);
        }
    }

    ######################### Profile Section ##########################################
    public function profile()
    {
        $user = Auth::user();
        return view('templates.profile.profile', ['users' => $user]);
    }

    // change photo
    public function changePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'mimes:jpeg,jpg,png,PNG|required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
        }
        $user = User::where('id', auth()->user()->id)->first();
        if ($request->photo != '') {
            $path = public_path() . '/uploads/files/';
            //upload new file
            $currentImage = $user->image;
            $file = $request->photo;
            if ($file != $currentImage) {
                $filename = time() . '.' .  $file->getClientOriginalName();
                $file->move($path, $filename);

                if (file_exists($path . $currentImage)) {
                    @unlink($path . $currentImage);
                }
            } else {
                $filename = $currentImage;
            }
            $user->image = $filename;
            $user->save();
            return response()->json(['status' => 'success', 'msg' => 'Files changed successfully']);
        }
        return response()->json(['status' => 'fail', 'msg']);
    }

    // change passsword
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
        }
        $user = User::where('id', auth()->user()->id)->first();
        if ($user) {
            if (Hash::check($request->get('current_password'), Auth::user()->password)) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                return response()->json(['status' => 'success', 'msg' => 'You have successfully change your password']);
            }
            return response()->json(['status' => 'fail', 'msg' => 'Current password didnt match']);
        }
    }

    // update profile
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }

            $user = User::where('id', auth()->user()->id)->first();
            if (User::where('email', $request->email)->where('id', '!=', auth()->user()->id)->exists()) {
                return response()->json(['status' => 'fail', 'msg' => 'Email already exists!']);
            }

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->ph_number;
            if ($user->save()) {
                return response()->json(['status' => 'success', 'msg' => 'Your profile has been updated ']);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'Failed to update the profile']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
}
