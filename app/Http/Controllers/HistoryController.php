<?php

namespace App\Http\Controllers;

// inquiriesテーブルを取り扱うため、Inquiryモデルの使用を定義しています。
use App\Models\Inquiry;
// ここまで追加

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    // 追加したshowメソッドの中身は、inquiriesテーブルの中身を取得し、viewに渡して表示する、というコードとなります。
    public function show()
    {
        // Inquiry::orderBy メソッドは、指定したカラムと順序でデータを取得します。今回の場合ですと、idカラムの降順となります。
        // 続くpaginateメソッドは、ページャーでページ送りを利用可能なデータを取得します。引数は1ページに表示する件数を渡します。
        $inquiries = Inquiry::orderBy('id', 'desc')->paginate(10);
        return view('history', ['inquiries' => $inquiries]);
    }
    // ここまで追加
}
