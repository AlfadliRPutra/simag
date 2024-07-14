<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/intern', function () {
    return view('admin.intern');
});

Route::get('/admin/dokumen', function () {
    return view('admin.dokumen');
});
