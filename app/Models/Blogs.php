<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blogs extends Model
{
    use HasFactory;

    public mixed $id;
    protected $fillable = [
        'title', 'content', 'status', 'category_id', 'user_id'
    ];

    protected $hidden = [
        'status'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
