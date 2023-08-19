<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// 本講座ではモデルのクラス名を「Inquiry」、テーブル名を「Inquiries」としています。

class Inquiry extends Model
{
    use HasFactory;

    // ここから追加
    // 追加した $fillable プロパティは、createメソッドやsaveメソッド等を利用してデータを保存する際に、値を入力するカラムを定義します。
    // idやcreated_atカラムは、MySQLやLaravelによって自動で入力される値になるため、$fillableには含めないようにします。
    protected $fillable = [
        'name',
        'email',
        'relationship',
        'content',
    ];
    // ここまで追加

}
