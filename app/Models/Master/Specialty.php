<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Specialty extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'specialties';

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'specialty_id');
    }
}
