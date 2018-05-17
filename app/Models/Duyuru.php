<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Duyuru extends Model
{
	
	protected $table='duyuru';

	protected $fillable=[
		'baslik',
		'metin',
		'rank',
		'isactive'	
	];
	protected $primarykey='Id';
	
}