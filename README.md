<h2> Основные роуты приложения( файл api.php) </h2>
<p>
    
```
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('registration', 'AuthController@registration');

});
Route::group([
    'prefix' => 'liblary'
], function () {
    Route::get('/authors', 'LiblaryController@getAuhtors');
    Route::get('/books', 'LiblaryController@getBooks');
    Route::get('/author/{id}/books', 'LiblaryController@getBooksAuthor');

});
Route::group([
    'prefix' => 'liblary',

    'middleware' => 'auth'
], function () {
    Route::post('/userBooks', 'LiblaryController@userBooks');
    Route::post('/createBook', 'LiblaryController@create');
    Route::post('/editBook', 'LiblaryController@edit');
    Route::post('/removeBook/{id}', 'LiblaryController@remove');
});

```
</p>
