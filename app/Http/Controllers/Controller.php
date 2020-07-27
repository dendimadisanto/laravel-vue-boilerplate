<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
       $this->path_icon = public_path("upload/marker/");
       $this->res_error = [
            'success' => false,
            'msg' => 'Ada Kesalahan Server'
       ];
    }

    public function res_successMsg($msg = 'Success', $data = []){
        $res = [
            'success' => true,
            'result' => $data,
            'msg' => $msg
       ];
        return response()->json($res);
    }

    public function res_errorMsg($msg = 'Ada Kesalahan Server', $error = []){
        $res = [
            'success' => false,
            'error' => $error,
            'msg' => $msg
       ];
        return response()->json($res);
    }
}
