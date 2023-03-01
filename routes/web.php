<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('Blogs.index');
})->name('blog.index');

Route::get('/blog/{id}', function () {
    return view('Blogs.show');
});

Route::get('/blog/add/new', function () {
    return view('Blogs.add');
})->name('blogs.add');

Route::get('user/login', function () {
    return view('user.login');
})->name('user.login');

Route::get('user/register', function () {
    return view('user.register');
})->name('user.register');

Route::get('user/blogs', function () {
    return view('user.blogs');
})->name('user.blogs');

Route::get('user/blog/{id}', function () {
    return view('User.show');
});

Route::get('user/blog/edit/{id}', function () {
    return view('Blogs.edit');
})->name('user.blogs.edit');
