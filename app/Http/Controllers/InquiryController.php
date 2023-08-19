<?php

namespace App\Http\Controllers;

// バリデーション設定があるファイルのuse宣言。「App\Http\Requests\InquiryRequest」にある。
use App\Http\Requests\InquiryRequest;

// 確認画面での送信ボタンを押した際のpostConfirmメソッドに対して、メール送信処理を追加していきます。
// InquiryMailは先程作成したクラス、MailはLaravelのメール操作用のクラスです。
use App\Mail\InquiryMail;

// Inquiryクラスを使うための宣言を記述しています。
use App\Models\Inquiry;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    // indexメソッドが実行されたらindexページを表示する。
    public function index()
    {
        return view('index');
    }

    // バリデーションチェックしたら、リクエストされた情報をconfirm（確認画面）へ。
    // Laravelではフォームリクエストクラス(InquiryRequest)のvalidatedメソッドを使って、配列形式でバリデーション通過後のデータを取得することが出来ます。
    // フォームリクエストクラスのsessionメソッドで、セッションの読み書きをするためのオブジェクトを取得することが出来ます。
    // ここではputメソッドを使って、「inquiry」という名前でバリデーション後の入力値を保存しています。
    // 続くreturnの部分ではLaravelのredirect関数を利用して、リダイレクトを行っています。
    // 引数はURLとなりますので、route関数を利用してURL生成を行っています。
    // Route::get('confirm', 'InquiryController@showConfirm')->name('confirm');
    // nameがconfirmと定義されているshowConfirmメソッドへのリダイレクトになります。
    public function postInquiry(InquiryRequest $request)
    {
        $validated = $request->validated();
        $request->session()->put('inquiry', $validated);
        return redirect(route('confirm'));
    }

    // showConfirmメソッドではLaravelのdd関数を利用して、セッションに保存した「inquiry」のデータを取り出して表示しています。
    // dd関数は引数を表示し、即時終了するデバッグ用の関数です。
    public function showConfirm(Request $request)
    {
        // dd($request->session()->get('inquiry'));

        // 最初にセッションに「inquiry」の名前で保存した、バリデーション結果のデータを取り出しています。
        $sessionData = $request->session()->get('inquiry');

        // 「confirm」へ直接アクセスがある場合、セッションにデータが未保存の状態です。
        // データが未保存の場合、 $sessionData = $request->session()->get('inquiry'); はnullを返却します。
        // ここでは、nullかどうかを判定するPHPのis_null関数を利用し、セッションデータがない場合はトップへ戻す処理を行っています。
        if (is_null($sessionData)) {
            return redirect(route('index'));
        }
        // ここまで追加

        // $messageは、view関数の第1引数に'emails.inquiry'、第2引数に$sessionDataをセットしているため、
        // Viewファイルはresources/emails/inquiry.blade.phpで、View内で利用するデータの配列が$sessionDataとなります。
        // $sessionDataの中身は前パートで確認したとおり、「name」「email」「relationship」「content」が含まれた配列になります。
        $message = view('emails.inquiry', $sessionData);
        return view('confirm', ['message' => $message]);
    }

    // 確認画面の送信があったら「sent」へリダイレクトする処理を入れています。
    public function postConfirm(Request $request)
    {

        // 次に追加した部分は、セッションデータを取得したあと、forgetメソッドでセッションデータを削除しています。
        // これは送信後、セッションデータを残したままですと、トップページに戻った場合に入力内容が復元されてしまう事を防ぐためになります。
        $sessionData = $request->session()->get('inquiry');

        // ここから追加
        if (is_null($sessionData)) {
            return redirect(route('index'));
        }
        // ここまで追加

        $request->session()->forget('inquiry');

        // コントローラ内の追加コードはInquiriesテーブルへの新規データ保存を行います。
        // パラメータは保存するカラム名と値の配列なので、$sessionDataがそのまま利用できます。
        // $Inquiry::create($sessionData);
        // ここまで追加
        

        // 最後の部分はメール送信処理になります。
        // toメソッドをメールの送信先アドレスを指定しますので、セッションに保存しているメールアドレスを使っています。
        // sendメソッドの引数はMailableクラスのインスタンスを指定しますので、本パート前半で作成したInquiryMailクラスを作成し、引数として指定します。
        Mail::to($sessionData['email'])
            ->send(new InquiryMail($sessionData));


        // また、「sent」についてはforgetメソッドでセッション内容を削除している状態のため、別の方法を使います。
        // メール送信後の処理で、次の1回のみ有効なセッションデータ(フラッシュデータとも言います)を渡すことのできるwithメソッドを利用しています。
        return redirect(route('sent'))->with('sent_inquiry', true);
        // ここまで編集
    }

    // 引数に Request $request を追加
    public function showSentMessage(Request $request)
    {
        // 送信完了画面でリロードを行った際、フラッシュデータである「sent_inquiry」のデータは既に無くなってしまっています。
        // 完了画面が表示されている場合にリロードした場合はそのまま完了画面を出しておきたいので、
        // この画面のみ「sent_inquiry」のデータを保持するためkeepメソッドを呼び出しています。
        $request->session()->keep('sent_inquiry');
        // この処理によって、送信した際のみ「sent_inquiry」の名前のセッションが存在する事になりますので、この値で判定を追加します。
        $sessionData = $request->session()->get('sent_inquiry');
        if (is_null($sessionData)) {
            return redirect(route('index'));
        }

        return view('sent');
    }
}
