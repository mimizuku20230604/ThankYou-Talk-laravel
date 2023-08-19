
{{-- このViewファイルで使用するテンプレートを指定 --}}
@extends('template')

@section('title', '送信履歴 | ThankYou-Talk-laravel')

@section('content')
<div class="container">
@if (count($inquiries) > 0)
    <h2>送信履歴</h2>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>お名前</th>
            <th>メールアドレス</th>
            <th>関係</th>
            <th>伝えたいこと</th>
            <th>送信日時</th>
        </tr>
    @foreach ($inquiries as $inquiry)
        <tr>
            <td>{{ $inquiry->id }}</td>
            <td>{{ $inquiry->name }}</td>
            <td>{{ $inquiry->email }}</td>
            <td>{{ $inquiry->relationship }}</td>
            <td>{!! nl2br(e($inquiry->content)) !!}</td>
            <td>{{ $inquiry->created_at }}</td>
        </tr>
    @endforeach
    </table>
    {{-- コントローラ内でpaginateメソッドを利用しているため、取得結果である $inquiriesのlinksメソッドを使うことで、ページを送るためのページャーが表示できます。 --}}
    {{ $inquiries->links() }}
@endsection
@else
    <h2>送信履歴はありません。</h2>
</div>
@endif