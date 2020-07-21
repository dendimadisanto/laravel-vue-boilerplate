<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanFisik;

class KegiatanFisikController extends Controller
{


    public function get(){
        try{
            $res = KegiatanFisik::with('SumberDana')->paginate(20);
            foreach($res as $key => $value){
                $res[$key]['no'] = $key + 1;
            }
            if($res){
                $out = $this->res_successMsg('Berhasil', $res);
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

    public function getByid($id){
        try{
            $res = KegiatanFisik::find($id);
            $res['marker'] = [$res['lat'], $res['lng']];
            if($res){
              return  $this->res_successMsg('Berhasil', $res);
            }
            else{
               return $this->res_errorMsg('Something Wrong') ;
            }
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
    }
    public function simpan(Request $request){
        try{
            $this->rules($request);

            if($request->id==0){
                unset($request->id);
                $res = KegiatanFisik::create($request->all());
            }
            else{
                $q = KegiatanFisik::find($request->id);
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

    function hapus($id){
        try{
            $q = KegiatanFisik::find($id);

            $res = $q->delete();
            if($res){
                return $this->res_successMsg('Data Berhasil Di hapus');
            }
            else{
                return $this->res_errorMsg('Data Gagal Di hapus');
            }
        }
        catch(Exception $error){
            return $this->res_errorMsg('Something Wrong', $error);
        }
       
    }

    function rules($request){
        if($request->lat==0 || $request->lng==0 ){
            $request->merge(['lat' => null]);
            $request->merge(['lng' => null]);
        }

        if($request->sumber_dana_id==0 ){
            $request->merge(['sumber_dana_id' => null]);
        }

        return $this->validate(
        $request,[
            'kegiatan' => 'required',
            'jenis_kegiatan' =>'required',
            'sumber_dana_id'=>'required',
            'lat'=>'required',
            'lng'=>'required',
        ]);
    }
}
