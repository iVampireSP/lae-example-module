<?php

namespace App\Models\WorkOrder;

use App\Models\Client;
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
        'created_at',
        'updated_at',
    ];

    public $incrementing = false;

    // 取消自动管理 timestamp
    public $timestamps = false;


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

    public function client()
    {
        return $this->belongsTo(Client::class);
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
