<?php

namespace App\Repositories;

use App\Contracts\RegionInterface;
use Illuminate\Support\Facades\DB;

class RegionRepo implements RegionInterface
{   
    public function __construct()
    {
        
    }

    public function get($request)
    {
        $tabel = DB::table('tree_wilayah as t');
            $tabel->SelectRaw(' id, nama text , length(id) - length(replace(id, ".", "")) level, "'.$request->id.'" parent_id')
                ->selectSub("select id FROM tree_wilayah where id like concat(t.id,'%') and LENGTH(id) - LENGTH(replace(id, '.', '')) = ".$request->level." + 2  limit 1","child");

            if(empty($request->id)){
                $tabel->whereRaw('length(id) - length(replace(id, ".", "")) = 1');
            }
            else{
                $tabel->whereRaw(' id like ? and length(id) - length(replace(id, ".", "")) = ?',array($request->id.'%', $request->level + 1));
            }
            $res = $tabel->get();
            $data = [];
            $jum = 0;
            foreach ($res as $key => $value) {
                $value->state =  "closed";

                if(empty($value->child)){
                    $value->state = "opened";
                }


                $data[] = $value;
            }
        return $data;
    }

    public function save($request){
        $tabel = DB::table('tree_wilayah');
        $level = $request->level;
        $params = [];

        $this->validation($request);

        if($request->id==0){

            if($level == '0'){
                  $q = $tabel->SelectRaw("max(cast(replace(id,'.', '') as signed)) + 1 id")->whereRaw("length(id) - length(replace(id, '.','')) = 1")->first();
            }
            else{
                  $q = $tabel->SelectRaw("concat('".$request->parent_id."', COALESCE(cast(max(replace(substring(id, length('".$request->parent_id."')+1, length(id)),'.','')) as signed),0) + 1, '.') id")->whereRaw("id like concat('".$request->parent_id."', '%') and LENGTH(id) - LENGTH(replace(id,'.','')) = LENGTH('".$request->parent_id."') - LENGTH(replace('".$request->parent_id."','.','')) + 1")->first();
            }
            
            switch ($level) {
            case '0':
                $params['provinsi'] = $request->nama;
                $model = DB::table('provinsi');
              
                $params['id'] = $q->id;
                break;
            case '1':
                $params['kabupaten'] = $request->nama;
                $id = explode('.', $q->id);
                $params['provinsi_id'] = $id[0];
                $params['id'] = $id[1];
                $model = DB::table('kabupaten');
                break;
             case '2':
                $params['kecamatan'] = $request->nama;
                $id = explode('.', $q->id);
                $params['provinsi_id'] = $id[0];
                $params['kabupaten_id'] = $id[1];
                 $params['id'] = $id[2];
                $model = DB::table('kecamatan');
                break;
             case '3':
                $params['desa'] = $request->nama;
                $id = explode('.', $q->id);
                $params['provinsi_id'] = $id[0];
                $params['kabupaten_id'] = $id[1];
                $params['kecamatan_id'] = $id[2];
                $params['id'] = $id[3];
                $model = DB::table('desa');
                break;
            default:
                # code...
                break;
            }
            
            $res = $model->insert($params);
        }
        else{

            // update data
            $id = explode('.', $request->id);
            $nama = $request->nama;
            switch ($level) {
                case '1':
                    $res = DB::table('provinsi')->where('id','=', $id[0])->update(['provinsi'=> $nama]);
                    // dd($res);
                    // exit;
                    break;
                 case '2':
                    $res = DB::table('kabupaten')->where('provinsi_id','=', $id[0])
                    ->where('id','=',$id[1])
                    ->update(['kabupaten'=> $nama]);
                    break;
                case '3':
                    $res = DB::table('kecamatan')->where('provinsi_id','=', $id[0])
                    ->where('kabupaten_id','=',$id[1])
                    ->where('id','=',$id[2])
                    ->update(['kecamatan'=> $nama]);
                    break;
                 case '4':
                    $res = DB::table('desa')->where('provinsi_id','=', $id[0])
                    ->where('kabupaten_id','=',$id[1])
                    ->where('kecamatan_id','=',$id[2])
                    ->where('id','=',$id[3])
                    ->update(['desa'=> $nama]);
                    break;
                
                default:
                    # code...
                    break;
            }
          
        }

        return $res;
    }

    public function delete($request){
        $id = explode('.', $request->id);
            
        $level = $request->level;

        switch ($level) {
            case '1':
                $res = DB::table('provinsi')->where('id','=',$id[0])->delete();
                DB::table('kabupaten')->where('provinsi_id','=',$id[0])->delete();
                DB::table('kecamatan')->where('provinsi_id','=',$id[0])->delete();
                DB::table('desa')->where('provinsi_id','=',$id[0])->delete();
                break;
             case '2':
                $res = DB::table('kabupaten')->where('provinsi_id','=',$id[0])->where('id','=',$id[1])->delete();
                DB::table('kecamatan')->where('provinsi_id','=',$id[0])->where('kabupaten_id','=',$id[1])->delete();
                DB::table('desa')->where('provinsi_id','=',$id[0])->where('kabupaten_id','=',$id[1])->delete();

                break;
             case '3':
                 $res = DB::table('kecamatan')->where('provinsi_id','=',$id[0])
                 ->where('kabupaten_id','=',$id[1])
                 ->where('id','=',$id[2])->delete();

                 DB::table('desa')->where('provinsi_id','=',$id[0])
                 ->where('kabupaten_id','=',$id[1])
                 ->where('kecamtan_id','=',$id[2])->delete();
                break;
             case '4':
                 $res = DB::table('desa')->where('provinsi_id','=',$id[0])
                 ->where('kabupaten_id','=',$id[1])
                 ->where('kecamatan_id','=',$id[2])
                 ->where('id','=',$id[3])->delete();
                break;
            
            default:
                # code...
                break;
        }

        return $res;
    }

    public function find($id){
        $model = DB::table('tree_wilayah')->SelectRaw(' *, length(id) - length(replace(id, ".", "")) level ');
        $res = $model->find($id);

        return $res;
    }

    public function validation($request){
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);

        return $validatedData;
    }
}