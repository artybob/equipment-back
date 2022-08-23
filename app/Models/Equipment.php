<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'code',
        'type_id',
        'serial_num',
        'desc',
    ];

    use HasFactory;

    public function type()
    {
        return $this->hasOne(EquipmentType::class, 'id', 'type_id');
    }
}
