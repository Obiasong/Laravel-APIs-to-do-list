<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    //update boot method of AppService provider with Model::unguard if you want to ignore $fillable array
    protected $fillable = ['item', 'description', 'status', 'photo'];
    protected $casts = [
        'status' => ['pending' => 'pending', 'active' => 'active', 'completed' => 'completed']
    ];

    /**
     * Filter items base on the status
     * @param $query
     * @param array $filters
     */
    public function scopeFilter($query, array $filters)
    {
        if ($filters['status'] ?? false) {
            $query->where('status', $filters['status']);
        }
    }
}
