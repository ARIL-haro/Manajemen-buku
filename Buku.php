<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // TODO: definisikan model buku anda disini

    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'pengarang',
        'tahun_terbit',
        'penerbit',
        'kategori',
    ];
}
