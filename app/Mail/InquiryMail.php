<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    // ここから追加
    // 追加した変数は、ビュー内で利用する変数を定義しています。
    // クラス内のpublic変数に値をセットする事で、buildメソッド内のビューファイル内で同名の変数を利用する事が出来ます。
    public $email;
    public $name;
    public $relationship;
    public $content;
    // ここまで追加

    /**
     * Create a new message instance.
     */

    // ここから編集
    // コンストラクタに渡された引数をpublic変数に代入するコードを追加しています。
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
    // ここまで編集


    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Inquiry Mail',
    //     );
    // }


    // ここから編集
    /**
     * Build the message.
     *
     * @return $this
     */

    //  最後に追加した部分は、メールの生成部分のコードになります。
    public function build()
    {
        // subjectメソッドは件名を生成しています。
        // textメソッドは引数としてビューのパスを渡すことで、テキストメールとして本文を生成します。
        return $this->subject($this->name . 'さんにお知らせがあります')
            ->text('emails.inquiry');
        // ここまで編集
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
