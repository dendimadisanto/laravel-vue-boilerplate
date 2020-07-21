<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanFisik;
use Illuminate\Support\Facades\DB;

class GisController extends Controller
{
    public function get(){
        
        $geoJson = DB::table('geojson')->first();
        if($geoJson){
            return $this->res_successMsg('berhasil', $geoJson);
        }
        else{
            return $this->res_errorMsg('Error');
        }
    }

    public function getKegiatan(Request $request){
        try{
            $query = KegiatanFisik::with('SumberDana')->where('tahun','=',$request->tahun);
            if($request->sumber_dana_id != 0){
                $query->where('sumber_dana_id','=',$request->sumber_dana_id);
            }
            $res = $query->get();

            if($res){
               return $this->res_successMsg('Berhasil', $res);
            }
            else{
                return $this->res_errorMsg('Something Wrong');
            }
        }
        catch(Exception $error){
            
        }
    }
}
