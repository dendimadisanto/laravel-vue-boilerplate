<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class KegiatanFisik extends Model
{
    //
    protected $table = 'kegiatan_fisik';
    protected $primaryKey = 'id';
    protected $fillable = ['kegiatan','jenis_kegiatan','lat','lng','alamat','sumber_dana_id','anggaran','volume','tahun','pelaksana'];
    public $timestamps = false;

    public function SumberDana(){
        return $this->belongsTo('App\Models\SumberDana');
    }
}
