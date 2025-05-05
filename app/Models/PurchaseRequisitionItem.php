<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class PurchaseRequisitionItem extends Model
{
    protected $table = 'purchase_requisition_items';
    protected $guarded = ['id'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function purchase_requisition()
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }
}
