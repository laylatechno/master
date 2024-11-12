<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;

    protected $table = 'menu_groups';
    protected $guarded = [];
  

    // Relasi dengan MenuItem
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_group_id');  // Pastikan nama kolom relasi sesuai dengan kolom yang ada di menu_items
    }
}
