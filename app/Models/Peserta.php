<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';
    protected $fillable = [
        'nomor_telpon',
        'nama_lengkap',
        'email',
        'institusi',
        'jenis_pendaftaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'biaya',
    ];
}
