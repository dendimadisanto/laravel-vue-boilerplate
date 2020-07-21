<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SumberDana;

class SumberDanaController extends Controller
{


   function all(){
       try{
            $res = SumberDana::all();
            if($res){
                $out = [
                    'success' => true,
                    'results' => $res
                ];
            }
            else{
                $out = $this->res_error;
            }

            return response()->json($out);
       }
       catch(Exception $error){
            response()->json($this->res_error);
       }
   }

   function get(){
       try{
            $table = new SumberDana();
            $res = $table->paginate(10);
            $data = [];

            foreach($res as $key => $value){
               $res[$key]['no'] = $key + 1;
            }
            if($res){
                $out = [
                    'success' => true,
                    'data' => $res ,
                ];
            }
            else{
                $out = [
                    'success' => false,
                    'msg' => 'Something wrong' 
                ];
            }
    
            return response()->json($out);
       }
       catch(Exception $error){
        return response()->json([
            'success' => false,
            'msg' => 'Error' 
        ]);
       }
   }

   function getById($id){
    try{
        $res = SumberDana::find($id);

         if($res){
             $out = [
                 'success' => true,
                 'data' => $res 
             ];
         }
         else{
             $out = [
                 'success' => false,
                 'msg' => 'Something wrong' 
             ];
         }
 
         return response()->json($out);
    }
    catch(Exception $error){
     return response()->json([
         'success' => false,
         'msg' => 'Error' 
     ]);
    }
}

   function addData(Request $request){
    try {
        if($request->id==0){
            $this->validate($request,[
                'sumber_dana' => 'required',
                'file' => 'required|mimes:jpg,png,jpeg'
            ]);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path("upload/marker"), $filename);
            }
            $params = array(
                'nama' => $request->sumber_dana,
                'icon' => $filename
            );
            
            $res = SumberDana::create($params);
        }

        else{
            
            $this->validate($request,[
                'sumber_dana' => 'required',
            ]);
            
            $filename = $request->icon;
            if ($request->hasFile('file')) {
                if(file_exists($this->path_icon.$filename)){
                    unlink($this->path_icon.$filename);
                }
                $file = $request->file('file');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path("upload/marker"), $filename);
            }

            $tabel = SumberDana::find($request->id);
            $tabel->nama = $request->sumber_dana;
            $tabel->icon = $filename;
            $res = $tabel->save();
        }
       

        if($res){
            $out = [
                'success' => true,
                'msg' => 'Data Berhasil Disimpan' 
            ];
        }
        else{
            $out = [
                'success' => false,
                'msg' => 'Data Gagal Disimpan' 
            ];
        }

        return response()->json($out);
    } catch (Exception $error) {
       
        return response()->json([
            'success' => false,
            'msg' => 'Data Gagal Disimpan' 
        ]);
    }
   
   }

   function hapus($id){
       try{
            $tabel = SumberDana::find($id);
            $icon = $tabel->icon;
            
            if(file_exists($this->path_icon.$icon)){
                unlink($this->path_icon.$icon);
            }

            $res = $tabel->delete();
            if($res){
                $out = [
                    'success' => true,
                    'msg' => 'Data Berhasil Di Hapus' 
                ];
            }
            else{
                $out = [
                    'success' => false,
                    'msg' => 'Data Gagal Di Hapus' 
                ];
            }
    

            return response()->json($out);
       }
       catch(Exception $error){
        return response()->json([
            'success' => false,
            'msg' => 'Ada Kesalahan Server' 
        ]);
       }
   }
}
