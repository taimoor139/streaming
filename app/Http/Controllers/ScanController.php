<?php

namespace App\Http\Controllers;

use App\Models\WalkinAppointment;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Twilio\Rest\Client;
use Exception;

class ScanController extends Controller
{
    public function imageScan(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required',

            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }


            $img = $request->image;

        
            if ($request->type == "image") {

                $img_date = file_get_contents($request->file('image')->getPathName());
                
                $image = 'data:image/jpeg;base64,'.base64_encode($img_date);

            } elseif ($request->type == "base64") {

                $image =$img;
               

            }
            
            $args['image'] = new \CurlFile($image, 'image/jpeg', 'image');

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://ocr.idware.net/api/ocr/recognize',
                CURLOPT_USERPWD => "123",
                CURLOPT_POST => 1,
                CURLOPT_HTTPHEADER => array("Content-Type:multipart/form-data","Authorization:ApiKey 350f41b3-0164-430b-9bc5-9bd3540dc687"),
                CURLOPT_POSTFIELDS => $args
            ));
            $resp = curl_exec($curl);
            curl_close($curl);


           $result = json_decode($resp,true);
           $res=  $result[0];
           $status =  $res["Status"];

           if(isset($status) && $status == "Success"){
                $data = $res["Document"];      
                if(isset($data["Picture"])){
                    $html = $this->htmlCode($data,$image);
                    return response()->json(['status'=>'success','html'=>$html]);
                }else{
                    return response()->json([
                        'status' => 'fail',
                        'msg' => 'Failed to id scan result, retry'
                    ], 200);
                }         
                

           }else{
            return response()->json([
                'status' => 'fail',
                'msg' => 'Failed to id scan result, retry'
            ], 200);
           }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }


    }


    public function htmlCode($data,$image)
    {
        $pic = $data["Picture"];
        if($pic["Value"]=="Face"){
            $value = 'data:image/jpeg;base64,'.$pic["ImageBase64"];
            $img = '<img src="'.$value.'" style="width:80px;">';
        }else{

            $img = '<img src="'.asset('assets/images/users/1.jpg').'" style="width:80px;">';

        }
        $html='


        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1"></div>
        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10">
          <div class="card" style="">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 p-5" style="">
                <p class="text-dark" style="font-weight:600 ;">Photo Detail</p>
                <p class="text-dark">Type: '.$data["IDType"]["Value"].'</p>
                <p class="text-dark">State: '.$data["State"]["Value"].'</p>
                '.$img.'
                
            </div>
              <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 p-2 text-center">
                <img src="'.$image.'" style="max-width:250px">
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1"></div>
    
    
    
        <br>
        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1"></div>
        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10">
          <div class="card" style="">
            <div class="card-header">
              <div class="col-12">
                <div class="row">
                  <div class="col-6 text-start">
                    <p><b>Match Quality</b></p>
    
                  </div>
                  <div class="col-6 text-end">
                    <button class="btn btn-primary" id="ResetBtn">Reset</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="col-12">
    
                <div class="row" style="border-bottom:1px solid black ;">
                  <div class="col-6 text-start">
                    <p><b>Issuing State</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="issuing_state">'.$data["Issued"]["Value"].'</p>
                  </div>
                  <hr>
                </div>
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>First Name</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="first_name">'.$data["FirstName"]["Value"].'</p>
                  </div>
                </div>
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>Middle Name</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="middle_name">'.$data["MiddleName"]["Value"].'</p>
                  </div>
                </div>
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>Last Name</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="last_name">IZBASATBJ</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5" style="border-bottom:1px solid black;">
                  <div class="col-6 text-start">
                    <p><b>Full Name</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="full_name">'.$data["FullName"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>DOB</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="dob">'.$data["DOB"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b> Issued</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="issued">'.$data["Issued"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5" style="border-bottom:1px solid black;">
                  <div class="col-6 text-start">
                    <p><b> Expires</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="expires">'.$data["Expires"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>Address</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="address">'.$data["Address"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>City</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="city_value">'.$data["City"]["Value"].'</p>
                  </div>
                </div>
    
    
                <div class="row mt-5 pb-5">
                  <div class="col-6 text-start">
                    <p><b>State</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="state">'.$data["State"]["Value"].'</p>
                  </div>
                </div>
    
    
    
                <div class="row mt-5 pb-5" style="border-bottom:1px solid black;">
                  <div class="col-6 text-start">
                    <p><b>ZIP</b></p>
                  </div>
                  <div class="col-6 text-end">
                    <p id="zip">'.$data["Zip"]["Value"].'</p>
                  </div>
                </div>
              </div>
            </div>
    
            <div class="card-footer">
                <div class="col-12 text-center">
                    <a href="javascript:;" id="addVisitor">
                        <i class="fa fa-spinner fa-spin fa-add" style="display:none"></i> <b>Create Appointment</b>
                    </a>
                </div>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1"></div>
        ';

        return $html;
    }

 

    public function sendSMS(Request $request)
    {
        try {
            $number = $request->number;
            if ($number) {
                //twillo sms
                $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
                $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
                $twilio_number = '+18152408707';

                $receiverNumber = $number;

                $message = "Hi, we are testing sms feature. Please informed me, if working well";

                $client = new Client($account_sid, $auth_token);
                $res_client = $client->messages->create($receiverNumber, [
                    'from' => $twilio_number,
                    'body' => $message
                ]);
                return response()->json(['status' => 'success', 'msg' => 'SMS sent', 'data' => $res_client]);
            } else {
                return response()->json(['status' => 'fail', 'msg' => 'Number is required']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }


    public function createAppointment(Request $request){

        try{
            $user = User::find($request->client_id);
            $today = Carbon::now();
            $app = new WalkinAppointment();
            $app->tenant_id = $request->client_id;
            $app->site_id = $user->site_id;
            $app->name = $request->name;
            $app->country = $request->country;
            $app->city = $request->city;
            $app->address = $request->address;
            $app->gender = $request->gender;
            $app->created_at = $today;
            $app->save();

            if($app){
                
                $client = User::find($app->tenant_id);
                $ap = WalkinAppointment::where('id',$app->id)->first();
                $visitor_id = Crypt::encryptString($ap->id);
                Mail::send('templates.email.new_walkin_visitor', ['client'=>$client,'visitor'=>$ap,'visitorId'=>$visitor_id], function ($message) use ($client) {
                    $message->to($client->email);
                    $message->subject('Walk-in-visitor');
                    $message->from('donotreply@fastlobby.com', env('MAIL_FROM'));
                });
                
                
                //twillo sms
                $account_sid = 'ACbe9332f45de09e658c04c6c08eb989e3';
                $auth_token = '831ddaf868f19b9ecdcb5a6234c4759f';
                $twilio_number = '+18152408707';

                $receiverNumber = $client->phone;
                
                if(isset($receiverNumber) && $receiverNumber!=" "){
                    
                
                    $url = route('walk-in-visitors/detail',['id'=>$visitor_id]);
                    $message = "You have a walk-in-visitor ('.$ap->name.') at the door. please click the below link to checkout the visitor details.link is:'.$url.'";
    
                    $client = new Client($account_sid, $auth_token);
                    $client->messages->create($receiverNumber, [
                        'from' => $twilio_number, 
                        'body' => $message
                    ]);
                    
                }

                return response()->json(['status'=>'success','msg'=>'Visitor information is sent to the client']);

            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'fail',
                'msg' => $e->getMessage()
            ], 200);
        }

    }
}
