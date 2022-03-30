<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    public static function getAll() {
        return DB::table('books')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->select('books.*', DB::raw('authors.name as author_name'))
            ->get();
    }
}
