<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = "id_admin";
    protected $table = "admin";
    protected $fillable = array('name', 'umur', 'no_telp');

    public $timestamps = true;

    // public function user()
	// {
	// 	return $this->belongsTo('App\Models\User');
	// }
}



?>