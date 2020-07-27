<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\SupplierRepo;

class SupplierController extends Controller
{
    protected $supplier;

    public function __construct(SupplierRepo $supplier)
    {
        $this->supplier = $supplier;
    }

    public function get(Request $request){
        try{
            $res = $this->supplier->paginate(25);
            if($res){
               return $this->res_successMsg('Get Data Succesfull', $res);
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
            $res = $this->supplier->find($request->id);
            
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

            if($request->id==0){
                unset($request->id);
                $res = $this->supplier->create($request);
            }
            else{
                $res =$this->supplier->update($request, $request->id); 
            }
       
            if($res){
                $out = $this->res_successMsg('Saved Successfully');
            }
            else{
                $out = $this->res_errorMsg('Failed to save data');
            }

            return $out;
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
    }

    public function del(Request $request){
        try{

            $res = $this->supplier->delete($request->id);
            if($res){
                return $this->res_successMsg('Your data was Successfully deleted');
            }
            else{
                return $this->res_errorMsg('Failed to delete data');
            }
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
    }
}
