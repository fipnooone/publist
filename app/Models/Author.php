<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public static function getByIdWithBooks($id) {
        $author = DB::table('authors')->select('name', 'email')->where('id', '=', $id)->get()[0];
        return [
            'name' => $author->name,
            'email' => $author->email,
            'books' => DB::table('books')->select('id', 'title', 'description', 'author_id')->where('author_id', '=', $id)->get()
        ];
    }

    public function edit(Request $request) {
        $userId = Auth::user()->id;

        $fields = $request->validate([
            'name' => 'string',
            'email' => 'string|email|unique:authors,email,' . $userId,
            'password' => 'string'
        ]);

        $newData = [];

        foreach (['name', 'password', 'email'] as $key) {
            if (array_key_exists($key, $fields) && $fields[$key])
                $newData[$key] = $fields[$key];
        }

        if (array_key_exists('password', $newData) && $newData['password']) $newData['password'] = Hash::make($newData['password']);

        if (!count($newData))
            return ['error'=>'No data provided'];

        Author::whereId($userId)->update($newData);

        return ['success'=>true];
    }
}
