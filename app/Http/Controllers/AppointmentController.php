<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Site;
use App\Models\Appointment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\visitorConfirmation;
use App\Mail\externalVisitor;
use App\Models\WalkinAppointment;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class AppointmentController extends Controller
{
    //add

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            $today = Carbon::now();
            $app = new Appointment();
            $app->name = $request->name;
            $app->email = $request->email;
            $app->phone = $request->phone;
            $app->date = $request->date;
            $app->time = $request->time;
            $app->tenant_id = Auth::user()->id;
            $app->site_id = auth()->user()->site_id;
            $app->unique_code = $this->generateUniqueCode();
            $app->created_at = $today;
            $app->save();

            if ($app) {
                $ap = Appointment::find($app->id);
                $link = url('appointment/handling/'.$ap->unique_code);

                $client = User::find($ap->tenant_id);
                $visitor_id = $ap->unique_code;
                $site = $client->site->name;

                QrCode::format('png')->size(200)->generate($link, 'images/codes/' . $ap->id . '.png');
                $img_url = ('images/codes/' . $ap->id . '.png');

                DB::table('appointments')->where('id', $ap->id)->update(["qr_code" => $img_url]);


                $data=[];
                $data["visitor_name"] = $ap->name;
                $data["site"] = $site;
                $data["image_url"] = asset($ap->qr_code);
                $data["id"]=$ap->id;
                Mail::to($ap->email)->send(new visitorConfirmation($data));

                //twillo sms
                $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
                $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
                $twilio_number = '+18152408707';
                $site = Site::where('id',$client->site->id)->first();
                $siteName = $site->name;
                $receiverNumber = $request->phone;
                $url = route('detail',['id'=>$visitor_id]);
                $message = 'You have been invited to visit '.$siteName.' please click this link and check the invitation details link is:'.$url.'';

                $client = new Client($account_sid, $auth_token);
                $client->messages->create($receiverNumber, [
                    'from' => $twilio_number, 
                    'body' => $message
                ]);

                
                // Mail::send('templates.email.visitor_register_invitation', ['client'=>$client,'visitor'=>$ap,'visitorId'=>$visitor_id], function ($message) use ($ap) {
                //     $message->to($ap->email);
                //     $message->subject('Visiting Invitation');
                //     $message->from(env('MAIL_FROM_ADDRESS'), 'VM-Platform');
                // });




                return response()->json(['status' => 'success', 'msg' => 'Appointment added successfully']);
            } else {

                return response()->json(['status' => 'fail', 'msg' => 'Failed to add appointment']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    
    public function externalAppointmentCreate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'gender' => 'required',
                'tenant' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }

            $today = Carbon::now();
            $app = new WalkinAppointment();
            $app->name = $request->name;
            $app->gender = $request->gender;
            $app->tenant_id = $request->tenant;
            $app->address = $request->address;
            $app->site_id = $request->site_id;
            $app->created_at = $today;
            $app->save();
            if ($app) {
                $ap = WalkinAppointment::find($app->id);
                $client = User::find($ap->tenant_id);
                $site = $client->site->name;
                $user = User::where('id',$app->tenant_id)->first();
                if(isset($user->email)){
                    $data = [];
                    $data["visitor_name"] = $ap->name;
                    $data["tenant_name"] = $user->first_name." ".$user->last_name;
                    $data["site"] = $site;
                    $data["image_url"] = asset($ap->qr_code);
                    $data["id"] = $ap->id;
                    Mail::to($user->email)->send(new externalVisitor($data));                    
                }
                // //twillo sms
                // $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
                // $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
                // $twilio_number = '+18152408707';
                // $site = Site::where('id', $client->site->id)->first();
                // $siteName = $site->name;
                // $receiverNumber = $request->phone;

                // $client = new Client($account_sid, $auth_token);
                // $client->messages->create($receiverNumber, [
                //     'from' => $twilio_number,
                // ]);


                return response()->json(['status' => 'success', 'msg' => 'Appointment added successfully']);
            } else {

                return response()->json(['status' => 'fail', 'msg' => 'Failed to add appointment']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }
    
    //add qr to sites
    public function addQr(Request $request){
        try{
            $sites = Site::all();
            if(isset($sites) && sizeof($sites)){
                foreach($sites as $site){
                    $site_id = Crypt::encryptString($site->id);
                    $link = url("external/appointment/create/" . $site_id);
                    QrCode::format('png')->size(200)->generate($link, 'images/codes/' . $site->id . '.png');
                    $img_url = ('images/codes/' . $site->id . '.png');
                    if ($site->qr_code == NULL) {
                        DB::table('sites')->where('id', $site->id)->update(["qr_code" => $img_url]);
                    }
                          return 'Done';
                }
            }else{
                return view('templates.404');
            }
        }
        catch(Exception $e){
            return view('templates.404'); 
        }
    }
    
    
    public function guardRecentAppointment()
    {
        try {
            $today = Carbon::now()->format('Y-m-d');
            $site = User::find(auth()->user()->id);
            $clients = User::whereHas('roles', function ($q) {
                $q->where('name', 'Tenant');
            })->where('site_id', $site->site->id)->get();
            if ($clients) {
                foreach ($clients as $client) {
                    $clientIds[] = $client->id;
                }
                $apps = Appointment::whereIn('tenant_id', $clientIds)->whereDate('created_at', $today)->orderBy('id', 'DESC')->get();
                if($apps){
                     $html = "";
                    foreach($apps as $key => $app){
                        if($app->status=="pending"){
                            $status = '<span class="badge bg-warning text-white p-1" style="border-radius:10px">'.ucwords($app->status).'</span>';
                        }elseif($app->status=="check_in"){
                            $status = '<span class="badge bg-primary text-white p-1" style="border-radius:10px">Checked In</span>';
                        }elseif($app->status=="decline"){
                            $status = '<span class="badge bg-danger text-white p-1" style="border-radius:10px">'.ucwords($app->status).'</span>';
                        }
                        $html.='><tr>
                        <td><b>'.ucwords($app->user->first_name).' '.ucwords($app->user->last_name).'</b></td>
                        <td><b>'.ucwords($app->user->email).'</b></td>
                        <td><b>'.ucwords($app->name).'</b></td>
                        <td><b>'.ucwords($app->email).'</b></td>
                        <td><b>'. date('M d,Y', strtotime($app->date)) .'</b></td>
                        <td><b>'. strtoupper($app->time) .'</b></td>
                        <td><b>'.$status.'</b></td>
                        </tr>';
                    }
                    return response()->json(['status' => 'success', 'data'=> $html]);
                }
                
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'No data found!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage(),'line'=>$e->getLine()]);
        }
    }
    
    
    
    // count
    public function count(Request $request)
    {
        try {
            $filterSearch = $request->filterSearch;
            $filterLength = $request->filterLength;
            $filterStatus = $request->filterStatus;
            $filterPhone = $request->filterPhone;

            $result = Appointment::query();
            $result = $result->where('tenant_id', Auth::user()->id);
            if (isset($filterSearch) && $filterSearch != '') {

                $result = $result->where('name', 'like', '%' . $filterSearch . '%');
            }

            if (isset($filterStatus) &&  $filterStatus != 'all') {
                $result = $result->where('status', $filterStatus);
            }

            if (isset($filterPhone) &&  $filterPhone != ' ') {

                $result = $result->where('phone', $filterPhone);
            }


            $count = $result->count();
            if ($count > 0) {
                return response()->json(['status' => 'success', 'data' => $count]);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'No Data Found']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    //External appointment schedule page
    public function externalAppointmentForm($id)
    {
        try {
            // $site_id = Crypt::decrypt($id);
            $site = Site::where('id',$id)->first();
            if ($site) {
                return view('templates/external/appointment',['site'=>$site]);
            } else {
                return view('templates/404')->with(['msg'=>'Sites not found!']);
            }
        } catch (Exception $e) {
            return view('templates/404');
        }
    }

    //External appointment page
    public function externalVisitorDetailPage($id)
    {
        $visitor = WalkinAppointment::find($id);
        if ($visitor) {
                $client = User::where('id', $visitor->tenant_id)->first();
                return view('templates.external.visitor_approval', ['visitor' => $visitor, 'client' => $client]);
            } else {
            return abort('404');
        }
    }

    // list
    public function list(Request $request)
    {
        try {
            $filterSearch = $request->filterSearch;
            $filterLength = $request->filterLength;
            $filterStatus = $request->filterStatus;
            $filterPhone = $request->filterPhone;
            // $filterTitle=$request->filterTitle;
            // $filterLength=$request->filterLength;
            $result = Appointment::query();
            $result = $result->where('tenant_id', Auth::user()->id);
            if (isset($filterSearch) &&  $filterSearch != '') {
                $result = $result->where('name', 'like', '%' . $filterSearch . '%');
            }



            if (isset($filterStatus) &&  $filterStatus != 'all') {
                $result = $result->where('status', $filterStatus);
            }

            if (isset($filterPhone) &&  $filterPhone != ' ') {
                $result = $result->where('phone', $filterPhone);
            }

            $i = 1;
            $appointments = $result->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();
            if (isset($appointments) && sizeof($appointments) > 0) {
                $html = '';
                foreach ($appointments as $value) {
                    if ($value->status == "pending") {
                        $status = '<span class="badge bg-warning text-white p-1" style="border-radius:10px">' . ucwords($value->status) . '</span>';
                    } elseif ($value->status == "check_in") {
                        $status = '<span class="badge bg-primary  text-white p-1" style="border-radius:10px">Checked In</span>';
                    } elseif ($value->status == "decline") {
                        $status = '<span class="badge bg-danger  text-white p-1" style="border-radius:10px">' . ucwords($value->status) . '</span>';
                    }
                    $html .= '
                            <tr class="border-bottom" id="row' . $value->id . '" data-id="' . $value->id . '"> 
                                
                                <td>
                                    <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                    ' . ucwords($value->name) . '
                                        </h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . ucwords($value->email) . '</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . $value->phone . '</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . date('M d,Y', strtotime($value->date)) . '</h6>
                                </td>
                                <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    '. strtoupper($value->time) . '</h6>
                                </td>
                                <td id="td_' . $value->id . '">
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . $status . '</h6>
                                </td>
                                <td>
    
                                   
                                    <div class="btn-group btn-group-sm" role="group">
                                    <a  href="/appointment/detail/' . $value->unique_code . '" class="btn btn-info btn-sm">Details</a>
                                    <a  class="btn btn-danger text-white btnDelete" id="' . $value->id . '">Delete</a>
                                </div>
                                </div>
                                    
                                </td>
                            </tr>
                        ';
                }
                return response()->json(['status' => 'success', 'rows' => $html]);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'No Form Found!']);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }
    }

    public function detail($id,Request $req){

        $app = Appointment::where('unique_code',$id)->first();
        if($app){
            $client = User::find($app->tenant_id);
            if(isset($req->data) && $req->data!=""){
                $value = $req->data;
            }else{
                $value="out";
            }
            
            return view('templates.appointment.register_visitor_detail' , compact('client','app','value'));

        }else{
            return view('templates/404');
        }
    }

      public function informClient(Request $request){
        $visitor = Appointment::find($request->id);
        $client = User::find($visitor->tenant_id);

        

        Mail::send('templates.email.visitor_appointment_request', ['client'=>$client,'visitor'=>$visitor], function ($message) use ($client) {
            $message->to($client->email);
            $message->subject('Guest Arrived');
            $message->from(env('MAIL_FROM_ADDRESS'), 'Fastlobby');
        });

        //twillo sms
        $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
        $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
        $twilio_number = '+18152408707';

        $receiverNumber = $client->phone;

        $message = 'Your Guest ('.$visitor->name.') Has Arrived';
        if($receiverNumber!=" "){

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message
            ]);
        }
        $visitor->status = "check_in";
        $visitor->save();
        return response()->json(['status'=>'success','msg'=>'Mail sent']);


    } 
    
        //walkin count
        public function walkinCount(Request $request)
        {
            try {
                $filterSearch = $request->filterSearch;
                $filterLength = $request->filterLength;
                $filterStatus = $request->filterStatus;
    
                $result = WalkinAppointment::query();
                $result = $result->where('tenant_id', Auth::user()->id);
                if (isset($filterSearch) && $filterSearch != '') {
    
                    $result = $result->where('name', 'like', '%' . $filterSearch . '%');
                }
    
    
    
                if (isset($filterStatus) &&  $filterStatus != 'all') {
                    $result = $result->where('status', $filterStatus);
                }

    
                $count = $result->count();
                if ($count > 0) {
                    return response()->json(['status' => 'success', 'data' => $count]);
                } else {
                    return response()->json(['status' => 'fail', 'msg' => 'No Data Found']);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => $e->getMessage()
                ], 200);
            }
        }
    
    
        // list
        public function walkinVisitors(Request $request)
        {
            try {
                $filterSearch = $request->filterSearch;
                $filterLength = $request->filterLength;
                $filterStatus = $request->filterStatus;
                // $filterTitle=$request->filterTitle;
                // $filterLength=$request->filterLength;
                $result = WalkinAppointment::query();
                $result = $result->where('tenant_id', Auth::user()->id);
                if (isset($filterSearch) &&  $filterSearch != '') {
                    $result = $result->where('name', 'like', '%' . $filterSearch . '%');
                }
    
    
    
                if (isset($filterStatus) &&  $filterStatus != 'all') {
                    $result = $result->where('status', $filterStatus);
                }
    

                $i = 1;
                $appointments = $result->take($filterLength)->skip($request->offset)->orderBy('id', 'DESC')->get();
                if (isset($appointments) && sizeof($appointments) > 0) {
                    $html = '';
                    foreach ($appointments as $value) {
                        $visitor_id = Crypt::encryptString($value->id);
                        $html .= '
                                <tr class="border-bottom"> 
                                    <td>' . $i++ . '</td>
                                    <td>
                                        <h6 class="mb-0 m-0 fs-14 fw-semibold">
                                        ' . ucwords($value->name) . '
                                            </h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 m-0 fs-14 ">
                                        ' . ucwords($value->gender) . '</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 m-0 fs-14 ">
                                        ' . $value->Country . '</h6>
                                    </td>
                                    <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . $value->city . '</h6>
                                    </td>
                                    <td>
                                    <h6 class="mb-0 m-0 fs-14 ">
                                    ' . $value->address . '</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 m-0 fs-14 ">
                                        ' . $value->status . '</h6>
                                    </td>

                                    <td>
        
                                        <a  href="/walk-in-visitors/detail/' . $visitor_id . '" class="btn btn-info btn-sm">Details</a>
        
                                    </div>
                                        
                                    </td>
                                </tr>
                            ';
                    }
                    return response()->json(['status' => 'success', 'rows' => $html]);

                } else {
                    return response()->json(['status' => 'fail', 'msg' => 'No Form Found!']);
                }
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => $e->getMessage()
                ], 200);
            }
        }

        //walkin visitor detail page
        public function walikInVisitorDetails($id){
            $visitor_id = Crypt::decryptString($id);
            if($visitor_id){
                $app = WalkinAppointment::find($visitor_id);
                if ($app) {
                    $client = User::where('id',$app->tenant_id)->first();
                        return view('templates.appointment.walkin_visitor_detail',['visitor'=>$app,'client'=>$client]);
                    } else {
                        return abort('404');
                    }
                }else{
                    return abort('404');
            }
        }
        public function ApproveWalkInRequest(Request $request){
            try{
                $app = WalkinAppointment::where('id',$request->id)->first();
                if($app){
                    $app->status = $request->status;
                    $app->save();
                    return response()->json(['status'=>'success','msg'=>'Appointment request updated']);
                }else{
                    return response()->json(['status'=>'fail','msg'=>'Appointment not found!']);
                }
            }catch(Exception $e){
                return response()->json(['status'=>'fail','msg'=>$e->getMessage()]);

            }
        }

        public function generateUniqueCode()
        {
            do {
                $randomString = Str::random(30);
            } while (Appointment::where("unique_code", "=", $randomString)->first());
      
            return $randomString;
        }

        public function delete($id){

            $app = Appointment::find($id);
            if($app){
                $path=asset('images/codes/');
                $qrcode = $app->id;

                if(file_exists($path.$qrcode)){
                    unlink($path.$qrcode);
                }

                $app->delete();

                return response()->json(['status'=>'success']);
            }else{

                return response()->json(['status'=>'fail']);

            }
        }


        public function walkinAppointmentList()
        {
            $site = User::find(auth()->user()->id);
            $clients = User::whereHas('roles', function ($q) {
                $q->where('name', 'Tenant');
            })->where('site_id', $site->site->id)->get();
            $clientIds = [];
            if (isset($clients) && sizeof($clients)>0) {
    
                foreach ($clients as $c) {
    
                    if (!in_array($c->id, $clientIds)) {
                        $clientIds[] = $c->id;
                    }
                }
                
                $today = \Carbon\Carbon::now()->format('Y-m-d');
                $i = 1;
    
                $apps = WalkinAppointment::whereIn('tenant_id', $clientIds)->whereDate('created_at', $today)->get();
                $html = " ";

                if (isset($apps) && sizeof($apps)>0) {
     
                    foreach ($apps as $app) {

                        if($app->status=="pending"){
                            $bg="bg-warning";
                        }elseif($app->status=="aprove"){
                            $bg="bg-primary";
                        }else{
                            $bg= "bg-danger";
                        }


                        $html .= '<tr>
                            <td>' . ucwords($app->user->first_name) . ' ' . ucwords($app->user->last_name) . '</td>
                            <td>' . ucwords($app->user->email) . '</td>
                            <td>' . ucwords($app->name) . '</td>
                            <td>' . $app->phone . '</td>
                            <td>
                                <span class="badge '.$bg.'" style="rounded-circle:10px;">'.$app->status.'</span>
                            </td>
                        </tr>';
                        $i++;
                    }
    
                    return response()->json(['status' => 'success', 'data' => $html]);
    
                } else {
    
                    return response()->json(['status' => 'fail', 'msg' => 'no appointment found!']);
    
                }
    
    
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'Client not found!']);
            }
        }


        public function statusList(Request $request){

            $app = Appointment::find($request->id);

            if($app){

                if($app->status=="pending"){
                    $status = '<span class="badge bg-warning text-white p-1" style="border-radius:10px">'.ucwords($app->status).'</span>';
                }elseif($app->status=="check_in"){
                    $status = '<span class="badge bg-primary text-white p-1" style="border-radius:10px">Checked In</span>';
                }elseif($app->status=="decline"){
                    $status = '<span class="badge bg-danger text-white p-1" style="border-radius:10px">'.ucwords($app->status).'</span>';
                }

                return response()->json(['status'=>'success','html'=>$status]);

            }
        }


        public function AppointmentHandling($id){

            $value = "portal";
            return redirect('appointment/detail/'.$id.'/'.$value);

        }
    
}
