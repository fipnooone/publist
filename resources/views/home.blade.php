<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,400;0,500;0,600;1,200&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <title>Home — publist </title>
</head>
<body>
    <header class="header">
        <a href="/"><img src="{{ asset('images/Logo.svg') }}" alt="publist" class="logo"></a>
        <div class="mini-profile">
            <span class="name">{{ Auth::user()->name }}</span>
            <a href="/logout" class="logout">Logout</a>
        </div>
    </header>
    @include('modal', $authors)
    <div class="home">
        @if (Auth::check() && Auth::user()->isAdmin())
            <div class="books">
                <div class="controls">
                    <span class="title">Books ({{ count($books) }})</span>
                    <div class="create-new" onclick='showModal(false, false, {{ json_encode([
                            "fields" => [
                                [
                                    "type" => "text",
                                    "text" => "Title",
                                    "name" => "title"
                                ],
                                [
                                    "type" => "select",
                                    "text" => "Author",
                                    "name" => "author_id"
                                ],
                                [
                                    "type" => "text",
                                    "text" => "Description",
                                    "name" => "description"
                                ]
                            ]
                    ]) }})'><div class="plus"></div></div>
                </div>
                @foreach ($books as $book)
                    <div class="book" 
                        onclick='showModal(false, true, {{ json_encode([ 
                            "name" => $book->title,
                            "id" => $book->id,
                            "fields" => [
                                [
                                    "type" => "text",
                                    "value" => $book->title,
                                    "text" => "Title",
                                    "name" => "title"
                                ],
                                [
                                    "type" => "select",
                                    "value" => $book->author_id,
                                    "text" => "Author",
                                    "name" => "author_id"
                                ],
                                [
                                    "type" => "text",
                                    "value" => $book->description,
                                    "text" => "Description",
                                    "name" => "description"
                                ]
                            ]
                        ]) }})'>
                        <span class="title">Title: {{ $book->title }}</span>
                        <span class="author-name">Author: {{ $book->name }}</span>
                        <span class="description">Description: {{ $book->description }}</span>
                    </div>
                @endforeach
            </div>
            <div class="authors">
                <div class="controls">
                    <span class="title">Authors ({{ count($authors) }})</span>
                    <div class="create-new" onclick='showModal(true, false, {{ json_encode([
                            "fields" => [
                                [      
                                    "type" => "text",
                                    "text" => "Name",
                                    "name" => "name"
                                ],
                                [
                                    "type" => "email",
                                    "text" => "Email",
                                    "name" => "email"
                                ],
                                [
                                    "type" => "password",
                                    "text" => "Password",
                                    "name" => "password"
                                ]
                            ]
                    ]) }})'><div class="plus"></div></div>
                </div>
                @foreach ($authors as $author)
                    <div class="author" 
                        onclick='showModal(true, true, {{ json_encode([
                            "name" => $author->name,
                            "id" => $author->id,
                            "fields" => [
                                [      
                                    "type" => "text",
                                    "value" => $author->name,
                                    "text" => "Name",
                                    "name" => "name"
                                ],
                                [
                                    "type" => "email",
                                    "value" => $author->email,
                                    "text" => "Email",
                                    "name" => "email"
                                ],
                                [
                                    "type" => "password",
                                    "text" => "Password",
                                    "name" => "password"
                                ]
                            ]
                        ]) }})'>
                        <span class="name">Name: {{ $author->name }}</span>
                        <span class="email">Email: {{ $author->email }}</span>
                        <span class="email">Books written: {{ $author->books_num }}</span>
                        @if ($author->admin)
                            <span class="admin">Admin</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>