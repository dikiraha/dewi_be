<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class PurchaseRequisition extends Model
{
    protected $table = 'purchase_requisitions';
    protected $guarded = ['id'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
