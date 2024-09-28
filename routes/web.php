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
//Public
Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('home.page');
Route::get('/halte', [App\Http\Controllers\PublicController::class, 'halte'])->name('halte.page');
Route::get('/bus', [App\Http\Controllers\PublicController::class, 'bus'])->name('bus.page');
Route::get('/halte/json/{limit}', [App\Http\Controllers\PublicController::class, 'halte_json']);
Route::get('/halte/search/{key}', [App\Http\Controllers\PublicController::class, 'halte_search']);
Route::get('/halte/detail/{id}', [App\Http\Controllers\PublicController::class, 'halte_detail']);
Route::get('/bus/json/{limit}', [App\Http\Controllers\PublicController::class, 'bus_json']);
Route::get('/bus/search/{key}', [App\Http\Controllers\PublicController::class, 'bus_search']);
Route::get('/bus/detail/{id}', [App\Http\Controllers\PublicController::class, 'bus_detail']);
Route::get('/get/node_json_map', [App\Http\Controllers\PublicController::class, 'node_json_map']);
Route::get('/get/halte_json_map', [App\Http\Controllers\PublicController::class, 'halte_json_map']);
Route::get('/get/get_path/{start}/{end}', [App\Http\Controllers\PublicController::class, 'get_path']);
Route::get('/get/get_jarak/{start}/{end}', [App\Http\Controllers\PublicController::class, 'get_jarak']);
Route::get('/get/get_cordinats/{start}/{end}', [App\Http\Controllers\PublicController::class, 'get_cordinats']);
Route::get('/get/filter_halte/{koridor}', [App\Http\Controllers\PublicController::class, 'filter_halte']);
Route::get('/get/filter_marker/{koridor}', [App\Http\Controllers\PublicController::class, 'filter_marker']);
Route::get('/get/opt/halte_json/{id}', [App\Http\Controllers\PublicController::class, 'opt_halte_json_map']);
Route::get('/get/opt/node_json/{id}', [App\Http\Controllers\PublicController::class, 'opt_node_json_map']);
Route::get('/get/halte/nearby/{a}/{b}', [App\Http\Controllers\PublicController::class, 'get_nearby']);

Auth::routes();

//GET
Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/graf', [App\Http\Controllers\GrafController::class, 'index'])->name('admin.graf');
Route::get('/admin/halte', [App\Http\Controllers\HalteController::class, 'index'])->name('admin.halte');
Route::get('/admin/koridor', [App\Http\Controllers\KoridorController::class, 'index'])->name('admin.koridor');
Route::get('/admin/bus', [App\Http\Controllers\BusController::class, 'index'])->name('admin.bus');
Route::get('/admin/rute', [App\Http\Controllers\RuteController::class, 'index'])->name('admin.rute');

//JSON
Route::get('/admin/graf/json/', [App\Http\Controllers\GrafController::class, 'json']);
Route::get('/admin/halte/json/', [App\Http\Controllers\HalteController::class, 'json']);
Route::get('/admin/koridor/json/', [App\Http\Controllers\KoridorController::class, 'json']);
Route::get('/admin/bus/json/', [App\Http\Controllers\BusController::class, 'json']);

//PATCH
Route::PATCH('/admin/halte/update/{id}', [App\Http\Controllers\HalteController::class, 'update']);
Route::PATCH('/admin/koridor/update/{id}', [App\Http\Controllers\KoridorController::class, 'update']);
Route::PATCH('/admin/bus/update/{id}', [App\Http\Controllers\BusController::class, 'update']);

//POST
Route::POST('/admin/halte/store', [App\Http\Controllers\HalteController::class, 'store']);
Route::POST('/admin/koridor/store', [App\Http\Controllers\KoridorController::class, 'store']);
Route::POST('/admin/node/store', [App\Http\Controllers\NodeController::class, 'store']);
Route::POST('/admin/graf/store', [App\Http\Controllers\GrafController::class, 'store']);
Route::POST('/admin/bus/store', [App\Http\Controllers\BusController::class, 'store']);
Route::POST('/admin/rute/store', [App\Http\Controllers\RuteController::class, 'store']);

//DESTROY
Route::get('/admin/halte/delete/{id}', [App\Http\Controllers\HalteController::class, 'destroy']);
Route::get('/admin/koridor/delete/{id}', [App\Http\Controllers\KoridorController::class, 'destroy']);
Route::POST('/admin/node/delete/{id}', [App\Http\Controllers\NodeController::class, 'destroy']);
Route::POST('/admin/bus/delete/{id}', [App\Http\Controllers\BusController::class, 'destroy']);
Route::get('/admin/graf/delete/{id}', [App\Http\Controllers\GrafController::class, 'destroy']);
Route::get('/admin/bus/delete/{id}', [App\Http\Controllers\BusController::class, 'destroy']);
Route::POST('/admin/rute/delete/{id}', [App\Http\Controllers\RuteController::class, 'destroy']);

//GETJSON
Route::get('/admin/halte/getjson/{id}', [App\Http\Controllers\HalteController::class, 'getjson']);
Route::get('/admin/koridor/getjson/{id}', [App\Http\Controllers\KoridorController::class, 'getjson']);
Route::get('/admin/bus/getjson/{id}', [App\Http\Controllers\BusController::class, 'getjson']);
Route::get('/admin/rute/getjson/{id}', [App\Http\Controllers\RuteController::class, 'getjson']);

//EDIT PAGE
Route::get('/admin/halte/edit/{id}', [App\Http\Controllers\HalteController::class, 'edit'])->name('halte.edit');
Route::get('/admin/koridor/edit/{id}', [App\Http\Controllers\KoridorController::class, 'edit'])->name('koridor.edit');
Route::get('/admin/bus/edit/{id}', [App\Http\Controllers\BusController::class, 'edit'])->name('bus.edit');

//NEW PAGE
Route::get('/admin/halte/new', [App\Http\Controllers\HalteController::class, 'new'])->name('halte.new');
Route::get('/admin/koridor/new', [App\Http\Controllers\KoridorController::class, 'new'])->name('koridor.new');
Route::get('/admin/bus/new', [App\Http\Controllers\BusController::class, 'new'])->name('bus.new');

//MAP
Route::get('/admin/node/json_map', [App\Http\Controllers\NodeController::class, 'json_map']);
Route::get('/admin/halte/json_map', [App\Http\Controllers\HalteController::class, 'json_map']);
Route::get('/admin/rute/find_graf/{id}', [App\Http\Controllers\RuteController::class, 'findGraf']);
Route::get('/admin/rute/get_mark/{id}', [App\Http\Controllers\RuteController::class, 'get_mark']);

//GrafPage
Route::get('/admin/graf/detail_rute/{id}', [App\Http\Controllers\GrafController::class, 'detail_rute']);
Route::get('/admin/graf/get_halte/{id}', [App\Http\Controllers\GrafController::class, 'get_halte']);
