<?php

use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('user/conversations/max', [ConversationController::class, 'max']);
Route::get('user/conversations/join', [ConversationController::class, 'join']);
Route::get('user/conversations/eloquent', [ConversationController::class, 'eloquent']);

Route::get('all/conversations/max', [ConversationController::class, 'allMax']);
Route::get('all/conversations/join', [ConversationController::class, 'allJoin']);
Route::get('all/conversations/eloquent', [ConversationController::class, 'allEloquent']);

