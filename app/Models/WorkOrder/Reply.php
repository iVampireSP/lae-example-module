<?php

namespace App\Models\WorkOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'work_order_replies';

    protected $fillable = [
        'id',
        'content',
        'work_order_id',
        // 'user_id',
        'is_pending',
    ];

    public $incrementing = false;


    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function scopeWorkOrderId($query, $work_order_id)
    {
        return $query->where('work_order_id', $work_order_id);
    }


    // on createing
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // if id exists
            if ($model->where('id', $model->id)->exists()) {
                return false;
            }
        });
    }
}
