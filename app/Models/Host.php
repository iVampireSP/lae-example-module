<?php

namespace App\Models;

use App\Models\Client;
use App\Models\WorkOrder\WorkOrder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Host extends Model
{
    use HasFactory;

    protected $table = 'hosts';

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'host_id',
        'price',
        'status',
    ];

    protected $casts = [
        'configuration' => 'array',
        'suspended_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'host_id';
    }

    // scope thisUser
    public function scopeThisUser($query, $user_id = null)
    {
        $user_id = $user_id ?? request('user_id');
        return $query->where('user_id', $user_id);
    }


    // user
    public function user()
    {
        return $this->belongsTo(User::class);

    }

    // workOrders
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    // scope
    public function scopeRunning($query)
    {
        return $query->where('status', 'running')->where('price', '!=', 0);
    }

    public function calcPrice()
    {

        // 你可以自定义价格计算器。

        // $this->load('location');
        $price = 0;
        // $price += $this->location->price;
        // $price += ($this->cpu_limit / 100) * $this->location->cpu_price;
        // $price += ($this->memory) *
        //     $this->location->memory_price;
        // $price += ($this->disk / 1024) *
        //     $this->location->disk_price;
        // $price += $this->backups *
        //     $this->location->backup_price;
        // $price += $this->allocations *
        //     $this->location->allocation_price;
        // $price += $this->databases *
        //     $this->location->database_price;

        return $price;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $http = Http::remote('remote')->asForm();
            // if id exists
            if ($model->where('id', $model->id)->exists()) {
                return false;
            }

            $model->price = $model->calcPrice();

            // 云端 Host 应该在给 Model 创建数据之前被创建。

            // 云端 Host 创建后，再到这里计算价格。
            $http->patch('/hosts/' . $model->host_id, [
                'price' => $model->price
            ]);
        });

        // update
        static::updating(function ($model) {
            $http = Http::remote('remote')->asForm();


            if ($model->status == 'suspended') {
                $model->suspended_at = now();
            } else if ($model->status == 'running') {
                $model->suspended_at = null;
            }

            // 当更新时，重新计算价格。
            $model->price = $model->calcPrice();

            $http->patch('/hosts/' . $model->host_id, [
                'price' => $model->price
            ]);
        });
    }
}
