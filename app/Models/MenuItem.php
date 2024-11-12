<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';
    protected $guarded = [];
 

    // Relasi balik ke MenuGroup
    public function group()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }
}
