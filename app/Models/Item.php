<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    //update boot method of AppService provider with Model::unguard if you want to ignore $fillable array
    protected $fillable = ['item', 'description', 'status', 'photo'];
    /**
     * @var mixed
     */
    private string $status;
    private string $item;
    private string $description;
    private string $photo;

    /**
     * Filter items using search text
     * @param $query
     * @param array $filters
     */
    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('item', 'like', '%' . $filters['search'] . '%');
        }
    }

    /**
     * Change item's status to completed
     * @return bool
     */
    public function complete(): bool
    {
        return $this->update(['status' => 'completed']);
    }

    /**
     * Change status of item to active
     * @return bool
     */
    public function activate(): bool
    {
        $this->update(['status' => 'active']);
    }

    /**
     * Check if item is completed
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status == 'completed';
    }
}
