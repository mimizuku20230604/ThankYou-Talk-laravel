
{{-- このViewファイルで使用するテンプレートを指定 --}}
@extends('template')

@section('title', '送信内容の確認 | ThankYou-Talk-laravel')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-5">送信内容の確認</h1>
        <p class="lead">
            以下の内容でメールを送信します。<br />
            内容を確認し、よろしければ送信してください。
        </p>
    </div>
</div>
<div class="container">
    <form action="{{ route('confirm') }}" method="post">
        @csrf
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">from</th>
                    {{-- config関数はLaravelの関数で、コンフィグファイルの中の1項目を抽出しています。 --}}
                    {{-- config('mail.from.name') と記載した場合、「config/mail.phpの中の、fromの中のnameの値」を抽出します。 --}}
                    {{-- 項目としては差出人名で、この項目は.envのMAIL_FROM_NAMEを参照しています。 --}}
                    {{-- 続くconfig('mail.from.address')も同様に、.envのMAIL_FROM_ADDRESSを参照します。 --}}
                    <td>{{ config('mail.from.name') }} &lt;{{ config('mail.from.address') }}&gt;</td>
                </tr>
                <tr>
                    <th scope="row">to</th>
                    {{-- session('inquiry.email') は、こちらもLaravelに用意されているsession関数になります。 --}}
                    {{-- 今回はコントローラのpostInquiryメソッド内でセッション「inquiry」にvalidated配列を格納しているので、ドット記法で各項目を表示しています。 --}}
                    <td>{{ session('inquiry.email') }}</td>
                </tr>
                <tr>
                    <th scope="row">件名</th>
                    <td>{{ session('inquiry.name') }}さんに伝えたい気持ちがあります</td>
                </tr>
                <tr>
                    <th scope="row">本文</th>
                    {{-- 通常、Laravelのビュー上での変数出力は {{ $variable }} の形式で書きますが、 --}}
                    {{-- この形式での出力はクロスサイトスクリプティング攻撃を防ぐため、html記号 < > 等が自動的にエスケープされます。 --}}
                    {{-- nl2brはphpの標準関数で、改行をbrタグに変換して出力するものなのですが、 --}}
                    {{-- htmlタグを{{ nl2br($message) }}の様にして出力してしまうとLaravelのエスケープ機能によって、htmlタグが画面にそのまま表示されてしまいます。 --}}
                    {{-- これを防ぐため、{!! <変数> !!} というエスケープさせない記法で出力しています。 --}}
                    <td>{!! nl2br($message) !!}</td>
                </tr>
            </tbody>
        </table>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">送信する</button>
            <a class="btn btn-secondary" href="{{ route('index') }}">戻る</a>
        </div>
    </form>
</div>
@endsection