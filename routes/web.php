<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 初期のルーティング部分。コメントアウト。
// Route::get('/', function () {
//     return view('welcome');
// });


// 新しくルーティング情報を追加（うまく行かない。。。）
// Route::get('/', 'InquiryController@index');

// 最初の画面にindexページを表示させるためのルーティング設定を追加
// 確認画面の戻るボタンでも使用。
Route::get('/', [App\Http\Controllers\InquiryController::class, 'index'])->name('index');

// indexページの情報をポストするためのルーティング設定を追加
Route::post('/inquiry', [App\Http\Controllers\InquiryController::class, 'postInquiry'])->name('inquiry');

// 確認画面のコントローラを指すためのルーティング設定を追加
// 「confirm」にアクセスがきたら、「InquiryControllerコントローラのshowConfirmメソッドを実行する」
Route::get('/confirm', [App\Http\Controllers\InquiryController::class, 'showConfirm'])->name('confirm');

// 「confirm」にフォームが送信されてきた際、「InquiryControllerコントローラのpostConfirmメソッドを実行」というルーティングも追加しておきます。
Route::post('/confirm', [App\Http\Controllers\InquiryController::class, 'postConfirm'])->name('confirm');

// 完了画面のコントローラを指すためのルーティング設定を追加
// 「sent」にアクセスがきたら、「InquiryControllerコントローラのshowSentMessageメソッドを実行する」というものになります。
// このあたりはconfirmの分と同じ様な内容です。
Route::get('/sent', [App\Http\Controllers\InquiryController::class, 'showSentMessage'])->name('sent');

// 「history」にアクセスがきたら、「HistoryControllerコントローラのshowメソッドを実行する」というものになります。
Route::get('/history', [App\Http\Controllers\HistoryController::class, 'show'])->name('history');