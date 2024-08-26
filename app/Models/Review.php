<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'body',
        'rating',
        'reviewable_type',
        'reviewable_id'
    ];

    protected function casts(): array
    {
        return [
            'reviewable_id' => 'int',
            'user_id' => 'int',
            'rating' => 'int',
        ];
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

}
