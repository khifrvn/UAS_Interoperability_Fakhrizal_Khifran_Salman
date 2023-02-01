<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = "id_member";
    protected $table = "member";
    protected $fillable = array('name', 'umur', 'alamat', 'no_telp');

    public $timestamps = true;

    // public function user()
	// {
	// 	return $this->belongsTo('App\Models\User');
	// }
}



?>
