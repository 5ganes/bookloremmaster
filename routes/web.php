<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/****************** Inserting a New User **********************************/
// $user = new App\User();
// $user->name = 'user name';
// $user->password = Hash::make('password');
// $user->email = 'email';
// $user->type = 'type';
// $user->save();
/****************** Inserting a New User Ends **********************************/

// migrating a single table
// php artisan migrate:refresh --path=/database/migrations/fileName.php


/****************************** Front End Routing  ******************************************************/
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('/', 'client\HomeController@index');
    Route::get('/bookcategory/{id}', 'client\HomeController@getBooksByCategory');
    Route::get('/booksingle/{id}', 'client\HomeController@getSingleBook');
    Route::get('/archivedbooks/{id}', 'client\HomeController@archivedBooks');
    Route::get('/archivedbooksingle/{id}', 'client\HomeController@getSingleArchivedBook');
    Route::post('/booksearch', 'client\HomeController@searchBooks');
/****************************** Front End Routing Ends  ******************************************************/


/****************************** Backend End Routing  ******************************************************/
// Auth::routes();

Route::get('/admin', 'admin\HomeController@index');
Route::get('/admin/home', 'admin\HomeController@index');

Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Auth\LoginController@login');

// user routes
    Route::post('/admin/logout', 'Auth\LoginController@logout')->name('logout');
    // Route::post('/admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // Route::get('/admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    // Route::post('/admin/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    // Route::get('/admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    // Route::get('/admin/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // Route::post('/admin/register', 'Auth\RegisterController@register');

    Route::get('admin/userlist', 'admin\UserController@index');
    Route::get('admin/adduser', 'admin\UserController@addUser');
    Route::post('admin/storeuser', 'admin\UserController@storeUser');
    Route::get('admin/edituser/{id}', 'admin\UserController@editUser');
    Route::post('admin/updateuser/{id}', 'admin\UserController@updateUser');
    Route::post('admin/deleteuser/{id}', 'admin\UserController@deleteUser');
// user routes end

// book category routes
    Route::get('admin/categorylist', 'admin\CategoryController@index');
    Route::get('admin/addcategory', 'admin\CategoryController@addCategory');
    Route::post('admin/storecategory', 'admin\CategoryController@storeCategory');
    Route::get('admin/editcategory/{id}', 'admin\CategoryController@editCategory');
    Route::post('admin/updatecategory/{id}', 'admin\CategoryController@updateCategory');
    Route::post('admin/deletecategory/{id}', 'admin\CategoryController@deleteCategory');
// book category routes end

// book publisher routes
    Route::get('admin/publisherlist', 'admin\PublisherController@index');
    Route::get('admin/addpublisher', 'admin\PublisherController@addPublisher');
    Route::post('admin/storepublisher', 'admin\PublisherController@storePublisher');
    Route::get('admin/editpublisher/{id}', 'admin\PublisherController@editPublisher');
    Route::post('admin/updatepublisher/{id}', 'admin\PublisherController@updatePublisher');
    Route::post('admin/deletepublisher/{id}', 'admin\PublisherController@deletePublisher');
// book publisher routes end

// author routes
    Route::get('admin/authorlist', 'admin\AuthorController@index');
    Route::get('admin/addauthor', 'admin\AuthorController@addAuthor');
    Route::post('admin/storeauthor', 'admin\AuthorController@storeAuthor');
    Route::get('admin/editauthor/{id}', 'admin\AuthorController@editAuthor');
    Route::post('admin/updateauthor/{id}', 'admin\AuthorController@updateAuthor');
    Route::post('admin/deleteauthor/{id}', 'admin\AuthorController@deleteAuthor');
    Route::post('admin/deleteauthorimageajax', 'admin\AuthorController@deleteAuthorImageAjax');
// author routes end

// books routes
    Route::get('admin/booklist', 'admin\BookController@index');
    Route::get('admin/addbook', 'admin\BookController@addBook');
    Route::post('admin/storebook', 'admin\BookController@storeBook');
    Route::get('admin/editbook/{id}', 'admin\BookController@editBook');
    Route::post('admin/updateabook/{id}', 'admin\BookController@updateBook');
    Route::post('admin/deletebook/{id}', 'admin\BookController@deleteBook');
    Route::post('admin/deletebookcoverimageajax', 'admin\BookController@deleteBookCoverImageAjax');

    // book archive routes
    Route::get('admin/archivedbooklist/{id}', 'admin\BookArchiveController@index');
    Route::get('admin/addarchivedbook/{id}', 'admin\BookArchiveController@addArchivedBook');
    Route::post('admin/storearchivedbook/{id}', 'admin\BookArchiveController@storeArchivedBook');
    Route::get('admin/editarchivedbook/{id}', 'admin\BookArchiveController@editArchivedBook');
    Route::post('admin/updatearchivedbook/{id}', 'admin\BookArchiveController@updateArchivedBook');
    Route::post('admin/deletearchivedbook/{id}', 'admin\BookArchiveController@deleteArchivedBook');

    Route::post('admin/deletearchivedbookcoverimageajax', 'admin\BookArchiveController@deleteArchivedBookCoverImageAjax');
    // book archive routes ends

// books routes end





/****************************** Backend Routing Ends  ******************************************************/