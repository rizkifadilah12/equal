<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualanModel extends Model
{
	use HasFactory;

	protected $table = 'penjualan';

	protected $fillable = ['description', 'date', 'qty', 'cost', 'price', 'total_cost', 'qty_balance', 'value_balance','hpp'];


}
