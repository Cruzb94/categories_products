<?php

Route::get('/', 'HomeController@index')->name('home');

//products
// Route::resource('/products', 'ProductsController');
// Route::get('/getProducts', 'ProductsController@getProducts')->name('getProducts');
// Route::get('/deleteProduct/{id}', 'ProductsController@destroy')->name('deleteProduct');
// Route::get('/getProduct/{id}', 'ProductsController@edit')->name('getProduct');
// Route::post('/updateProduct', 'ProductsController@update')->name('updateProduct');


// //clients
// Route::resource('/clients', 'ClientsController');
// Route::get('/getClients', 'ClientsController@getClients')->name('getClients');
// Route::get('/deleteClient/{id}', 'ClientsController@destroy')->name('deleteClient');
// Route::get('/getClient/{id}', 'ClientsController@edit')->name('getClient');
// Route::post('/updateClient', 'ClientsController@update')->name('updateClient');

//categories
Route::resource('/categories', 'CategoriesController');
Route::get('/getCategories', 'CategoriesController@getCategories')->name('getCategories');
Route::post('/updateCategorie', 'CategoriesController@update')->name('updateCategorie');
