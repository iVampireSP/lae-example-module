<?php

namespace App\Models;

use App\Models\Client;
use App\Models\WorkOrder\WorkOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Host extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hosts';

    protected $fillable = [
        'id',
        'name',
        'client_id',
        'price',
        'configuration',
        'status',
        'created_at',
        'updated_at',
    ];

    // stop auto increment
    public $incrementing = false;
    public $timestamps = false;
    
    protected $casts = [
        'configuration' => 'array'
    ];


    // client
    public function client() {
        return $this->belongsTo(Client::class);
    }

    // workOrders
    public function workOrders() {
        return $this->hasMany(WorkOrder::class);
    }

    // scope
    public function scopeRunning($query) {
        return $query->where('status', 'running')->where('price', '!=', 0);
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
