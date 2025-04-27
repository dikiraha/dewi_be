<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Department extends Model
{
    protected $table = 'departments';
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_departments', 'department_id', 'model_id');
    }
}
