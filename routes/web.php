<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function() use ($router){
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

// Member
$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/member', 'MemberController@index'); //Accept header request
    $router->post('/member', 'MemberController@store'); // Accept header request, Content-Type header
    $router->get('/member/{id}', 'MemberController@show'); //Accept header request
    $router->put('/member/{id}', 'MemberController@update'); // Accept header request, Content-Type header
    $router->delete('/member/{id}', 'MemberController@destroy'); //Accept header request
});

// Buku
$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/buku', 'BukuController@index'); //Accept header request
    $router->post('/buku', 'BukuController@store'); // Accept header request, Content-Type header
    $router->get('/buku/{id}', 'BukuController@show'); //Accept header request
    $router->put('/buku/{id}', 'BukuController@update'); // Accept header request, Content-Type header
    $router->delete('/buku/{id}', 'BukuController@destroy'); //Accept header request
});

// Admin
$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/admin', 'AdminController@index'); //Accept header request
    $router->post('/admin', 'AdminController@store'); // Accept header request, Content-Type header
    $router->get('/admin/{id}', 'AdminController@show'); //Accept header request
    $router->put('/admin/{id}', 'AdminController@update'); // Accept header request, Content-Type header
    $router->delete('/admin/{id}', 'AdminController@destroy'); //Accept header request
});

// Pinjam
$router->group(['middleware' => ['auth']], function ($router) {
    $router->get('/pinjam', 'PinjamController@index'); //Accept header request
    $router->post('/pinjam', 'PinjamController@store'); // Accept header request, Content-Type header
    // $router->get('/pinjam/{id}', 'PinjamController@show'); //Accept header request
    // $router->put('/pinjam/{id}', 'PinjamController@update'); // Accept header request, Content-Type header
    $router->delete('/pinjam/{id}', 'PinjamController@destroy'); //Accept header request
});