@extends('template')

@section('title', '送信完了 | ThankYou-Talk-laravel')

@section('content')
<div class="container text-center">
    <h1 class="my-4">
        ThankYou-Talk-laravelの<br />
        送信を完了いたしました。
    </h1>
    <a href="{{ route('index') }}">他の人にも送信する</a>
</div>
@endsection
