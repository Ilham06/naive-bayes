<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionData extends Model
{
    use HasFactory;

    protected $table = 'condition_datas';
    protected $guarded = [];

    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id', 'id');
    }
}
