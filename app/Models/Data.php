<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'datas';
    protected $guarded = [];

    public function condition_data()
    {
        return $this->hasMany(ConditionData::class, 'data_id', 'id');
    }
}
