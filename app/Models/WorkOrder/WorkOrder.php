<?php

namespace App\Models\WorkOrder;

use App\Models\Host;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_orders';

    protected $fillable = [
        'id',
        'title',
        'content',
        'host_id',
        'client_id',
        'status',
    ];

    public $incrementing = false;


    // replies
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // host
    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function scopeClient($query)
    {
        return $query->where('client_id', auth()->id());
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
