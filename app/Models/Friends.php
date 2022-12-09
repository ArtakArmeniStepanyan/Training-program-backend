<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Friends extends Model
{
    use HasFactory;
    protected $table = 'friends';
    protected $fillable = ['userId', 'friendId'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'friendId', 'id');
    }
}
