<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
class QRCodeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api');
    }
    public function encrypt($user_id){
        /* $user =  User::find($user_id);
        $data=[];
        $data['user']=$user;
        $data['time']=Carbon::now();
        $string = json_encode($data);
        $encrypt = Crypt::encryptString($string);
        return $encrypt; */
        $data['user']=$user_id;
        $data['time']=Carbon::now();
        $string = json_encode($data);
        $encrypt = Crypt::encryptString($string);
        return $encrypt;
    }
    public function getQR($user_id){
        $string = $this->encrypt($user_id);
        return \QrCode::generate($string);
    }
    public function decrypt($string){
        $decrypted = Crypt::decryptString($string);
        $data = json_decode($decrypted);
        $finalData=[];
        $finalData['user']=$data->user;
        $finalData['time']=$data->time;
        return $finalData;
    }
}
