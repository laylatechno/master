<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'route', 'status', 'permission_name', 'menu_group_id', 'position'];

 

    // Relasi balik ke MenuGroup
    public function group()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }
}
