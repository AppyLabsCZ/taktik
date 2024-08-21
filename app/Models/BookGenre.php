<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookGenre extends Model
{
    use HasFactory;

    protected $table = 'book_genres';

    protected $fillable = [
        'book_id',
        'genre_id',
    ];

    protected function casts(): array
    {
        return [
            'book_id' => 'int',
            'genre_id' => 'int',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

}
