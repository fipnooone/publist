<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Api

В запросах с обязательной авторизацией нужно указать токен, ранее полученный в /login, в заголовке Authorization как Bearer токен.
Дополнительно нужно добавить заголовок Accept: application/json

a. Запрос на авторизацию пользователя (аутентификация с помощью токенов).
```
POST: /api/login
Keys: email, password
```
```
Returns: 
{"token": string}
```

b. Получение списка книг с именем автора, авторизация не обязательна.
```
GET: /api/books
```
```
Returns: Array
[{
    "id": int,
    "author_id": int,
    "title": string,
    "description": string,
    "author_name": string
 }]
```
c. Получение данных книги по id, авторизация не обязательна.
```
GET: /api/books/{id}
```
```
Returns: 
{
    "id": int,
    "author_id": int,
    "title": string,
    "description": string
}
```
d. Обновление данных книги, авторизация под автором книги обязательна.
```
PATCH: /api/books
Keys: id, title, author_id, description
```
e. Удаление книги, авторизация под автором книги обязательна.
```
DELETE: /api/books
Keys: id
```
f. Получение списка авторов с указанием количества книг, авторизация не обязательна.
```
GET: /api/authors
```
```
Returns: Array
[{
    "id": int,
    "name": string,
    "email": string,
    "admin": int,
    "books_num": int
}]
```
g. Получение данных автора со списком книг, авторизация не обязательна.
```
GET: /api/authors/{id}
```
```
Returns:
{
    "name": string,
    "email": string,
    "books": [
        {
            "id": int,
            "title": string,
            "description": string,
            "author_id": int
        }
    ]
}
```
h. Обновление данных автора, авторизация под  автором обязательна (можно обновлять только свои данные).
```
PATCH: /api/authors
Keys: name, email, password
```
