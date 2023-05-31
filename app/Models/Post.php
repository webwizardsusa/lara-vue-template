<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Post extends BaseModel
{
    protected $fillable = [
        'user_id', 'name', 'description', 'status'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $id = Auth::id();
            $user = User::find($id);
            if ($user->role_id == 2) {
                $model->user_id = $id;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
