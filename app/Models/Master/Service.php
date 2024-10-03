<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';
    protected $fillable = [
        'service_code',
        'service_name',
        'price',
        'description',
        'service_type',
        'created_by',
        'updated_by',
    ];
}
