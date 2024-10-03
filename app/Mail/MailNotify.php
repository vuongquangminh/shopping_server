<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vuongquangminh120802@gmail.com') // Địa chỉ email gửi
            ->subject('Notification email') // Chủ đề email
            ->view('mails.mail-notify') // Đường dẫn đến view email
            ->with(['data' => $this->data]); // Truyền dữ liệu vào view
    }
}
