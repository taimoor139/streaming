<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CameraAuthentication;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class CameraAuthenticationController extends Controller
{
    //camera auth add 
    public function authAdd(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users',
                'password' => 'required',
                'port' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'msg' => $validator->errors()->all()]);
            }
            else{
                $cameraAuth = new CameraAuthentication();
                $cameraAuth->username = $request->username;
                $cameraAuth->password = $request->password;
                $cameraAuth->port = $request->port;
                $user = User::where('id',Auth::user()->id)->first();
                if($user){
                    $cameraAuth->user_id = $user()->id;
                }else{
                    return response()->json(['status'=>'fail','msg'=>'user not found']);
                }
                $cameraAuth->token = base64_encode($request->username.$request->password);
                $cameraAuth->save();
                return response()->json(['status'=>'success','msg'=>'Camera auth generated successfully']);
            }
        }
        catch(Exception $e){
            return response()->json(['status'=>'fail','msg'=>$e->getMessage(),'error line'=>$e->getLine()]);
        }
    }

    //camera get channel list
    public function getChannelList(Request $request){
        try{
            $URL = "http://68.195.234.210:3065/GetChannelList";
            $Username = "admin";
            $Password = "troiano10!";
             $ch = curl_init($URL);
             curl_setopt($ch, CURLOPT_URL,$URL);
             curl_setopt($ch, CURLOPT_POST, TRUE);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
             curl_setopt($ch, CURLOPT_USERPWD, "$Username:$Password");
             curl_setopt($ch, CURLOPT_HTTPHEADER,
                 array(
                     'Content-Type:application/json'
                 )
             );
             $curl_response = curl_exec($ch);
             return $curl_response;
             curl_close($ch);
            //  return $curl_response;
            //  $data = file_get_contents($curl_response);
             $xmlObject = simplexml_load_string($curl_response);
                     
             $json = json_encode($xmlObject);
             $array = json_decode($json, true);
             return $array;
        }
        catch(Exception $e){
            return response()->json(['status'=>'fail','msg'=>$e->getMessage()]);
        }
    }

}
