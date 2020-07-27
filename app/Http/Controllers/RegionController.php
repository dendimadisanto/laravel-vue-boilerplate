<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RegionRepo;

class RegionController extends Controller
{

    protected $region;

    public function __construct(RegionRepo $region)
    {
        $this->region = $region;
    }


    public function get(Request $request){
        
    try{
            $res = $this->region->get($request);
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

     public function save(Request $request){
        try{
           
            $res = $this->region->save($request);
       
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
           
            $res = $this->region->delete($request);

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

    public function getById(Request $request){
        try{
           
            $res = $this->region->find($request->id);
            
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


}
