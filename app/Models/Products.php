<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */

    protected $table = 'products';
    protected $guarded = [];

    public function achievements()
    {
        return $this->belongsToMany(Achievements::class, 'achievement_products');
    }

}
