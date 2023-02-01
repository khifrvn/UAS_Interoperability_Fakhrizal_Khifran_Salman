<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $primaryKey = "kode_pinjam";
    protected $table = "pinjam";
    protected $fillable = array('id_member', 'tgl_pinjam', 'tgl_kembali', 'jumlah_buku');

    public $timestamps = true;

    public function member()
	{
		return $this->belongsTo('App\Models\Member');
	}
}



?>
