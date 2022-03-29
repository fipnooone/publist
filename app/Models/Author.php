<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class Author extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password) {
        $this->attributes['password'] = Hash::make($password);
        //$this->attributes['api_token'] = Str::random(60);
    }

    public function isAdmin() {
        if($this->attributes['admin']) return true;
    }

    public static function getAll() {
        return DB::table('authors')
            ->select('authors.id', 'authors.name', 'authors.email', 'authors.admin', DB::raw('count(books.id) as books_num'))
            ->leftJoin('books', 'books.author_id', '=', 'authors.id')
            ->groupBy('authors.id')
            ->get();
    }
}
