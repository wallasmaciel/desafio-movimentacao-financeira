<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryModel extends Model
{
    protected $table = "tb_categories";
    protected $keyType = "string";
    protected $fillable = [
        "name",
        "description",
        "type"
    ];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
