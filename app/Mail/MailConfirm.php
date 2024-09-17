<?php

namespace App\Mail;

use App\Models\SanPham;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $sanPham;
    /**
     * Create a new message instance.
     */
    public function __construct(SanPham $sanPham)
    {
        $this->sanPham = $sanPham;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mail Confirm',
        );
    }

    //Hàm build message mặc định
    public function build(){
    return $this->subject('Xác nhận thêm sản phẩm')
           ->markdown('admins.mail.mailconfirm')
           ->with('sanPham', $this->sanPham);  //chuyền nhiều thì sử dụng mảng
    }
    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         markdown: 'admins.mail.mailconfirm',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}