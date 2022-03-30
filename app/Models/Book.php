<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    public $table = 'books';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    public function author() {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
