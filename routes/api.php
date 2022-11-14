<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/pessoa', 'Api\PessoaController@index');
    Route::post('/pessoa', 'Api\PessoaController@store');
    Route::put('/pessoa/{id}', 'Api\PessoaController@update');
    Route::get('/pessoa/{id}', 'Api\PessoaController@show')->where('id', '[1-9]+');
});
