<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function get(Request $request){
        try{
            $res = Supplier::paginate(2);
            if($res){
               return $this->res_successMsg('Saved Successfully', $res);
            }
            else{
                return $this->res_errorMsg('Something Wrong');
            }
        }
        catch(Exception $error){
            
        }
    }
    public function getById(Request $request){
        try{
            $model = new Supplier();
            $res = $model->find($request->id);
            
            if($res){
                $out = $this->res_successMsg('Get Data Succesfull', $res);
            }
            else{
                $out = $this->res_errorMsg('Something Wrong');
            }

            return $out;
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
      
    }

    public function save(Request $request){
        try{
            $model = new Supplier();

        
            $validation = $model->validation($request);


            if($request->id==0){
                unset($request->id);
                $res = $model->create($request->all());
            }
            else{
                $q = $model->find($request->id);
                $res = $q->update($request->all()); 
            }
       
            if($res){
                $out = $this->res_successMsg('Data Berhasil Disimpan');
            }
            else{
                $out = $this->res_errorMsg('Data Gagal Disimpan');
            }

            return $out;
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
    }
}
