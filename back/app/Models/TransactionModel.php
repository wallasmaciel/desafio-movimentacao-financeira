<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionModel extends Model
{
    protected $table = "tb_transactions";
    protected $keyType = "string";
    protected $fillable = [
        "user_id",
        "category_id",
        "description",
        "ammount"
    ];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
}
