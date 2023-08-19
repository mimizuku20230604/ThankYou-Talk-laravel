
{{-- このViewファイルで使用するテンプレートを指定 --}}
@extends('template')

@section('title', 'ThankYou-Talk-laravel')

@section('content')
<div class="jumbotron">
    <div class="container">
        <h1 class="display-5">職場の人に匿名メールであなたの気持ちを送ろう！</h1>
        <p class="lead">
            「励ましてあげたいけど、直接言うのは。。。」「感謝の気持を伝えたいけど気恥ずかしい。」そんな時ありませんか？<br />
            そんな相手に匿名でメールを送ってみましょう。
        </p>
    </div>
</div>
<div class="container">
    <form action="{{ route('inquiry') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">気持ちを伝えたい相手のお名前</label>
            {{-- ここから編集(name) --}}
            {{-- old関数はLaravelの関数で、バリデーションエラーなどでリダイレクトされた際、一つ前の入力内容を復元してくれる関数です。 --}}
            {{-- 第1引数は各inputタグのname属性になります。 --}}
            {{-- 第2引数はデータがない場合にかわりに表示するデータで、ここにsession関数の内容を入れることによって、 --}}
            {{-- 「入力データ優先で、次にセッションデータの表示を試みる」という動作が可能です。 --}}
            <input type="text"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                placeholder="お名前"
                value="{{ old('name', session('inquiry.name')) }}">
            {{-- ここまで編集(name) --}}
            <div class="invalid-feedback">
                @error('name')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email">気持ちを伝えたい相手のメールアドレス</label>
            {{-- ここから編集(email) --}}
            <input type="text"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                placeholder="メールアドレス"
                value="{{ old('email', session('inquiry.email')) }}">
            {{-- ここまで編集(email) --}}
            <div class="invalid-feedback">
                @error('email')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="relationship">気持ちを伝えたい相手との関係</label>
            <select name="relationship" class="form-control @error('relationship') is-invalid @enderror" id="relationship">
                <option value="">選択してください</option>
                @foreach (config('relationship') as $value)
                    {{-- ここから編集(relationship) --}}
                    <option value="{{ $value }}"@if (old('relationship', session('inquiry.relationship')) === $value) selected  @endif>{{ $value }}</option>
                    {{-- ここまで編集(relationship) --}}
                @endforeach
            </select>
            <div class="invalid-feedback">
                @error('relationship')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="content">伝えたいこと</label>
            {{-- ここから編集(content) --}}
            <textarea name="content"
                class="form-control @error('content') is-invalid @enderror"
                id="content"
                rows="3"
                placeholder="伝えたいことを入力してください">{{ old('content', session('inquiry.content')) }}</textarea>
            {{-- ここまで編集(content) --}}
            <div class="invalid-feedback">
                @error('content')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">確認画面へ</button>
        </div>
    </form>
</div>
@endsection