<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
     // upメソッドはマイグレーションコマンドで実行させるコードを記述します。
    //  --createオプションでマイグレーションファイルを作成していますので、予めテーブル作成の雛型が用意されています。
    public function up(): void
    {
        // マイグレーションファイル内では、 Schema::create メソッドでテーブルを作成します。第1引数はテーブル名、第2引数にはテーブル作成の関数を記述します。
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            // ここから追加
            // $table->string() メソッドは、文字長を指定したVARCHARカラムを定義します。デフォルトの文字長は255文字です。
            $table->string('name');
            $table->string('email');
            $table->string('relationship');
            // $table->text() メソッドは、TEXTカラムを定義します。こちらも文字列を保存するカラムですが、文字長は可変で、65535文字まで入ります。
            $table->text('content');
            // ここまで追加
            // $table->timestamps() メソッドは、TIMESTAMPカラム「created_at」と「updated_at」を定義します。
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
