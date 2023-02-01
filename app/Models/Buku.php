<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $primaryKey = "id_buku";
    protected $table = "buku";
    protected $fillable = array('judul', 'kategori', 'pengarang', 'penerbit', 'tahun_terbit');

    public $timestamps = true;
}

?>