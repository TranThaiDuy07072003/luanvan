<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // 1. Cấu hình tiêu đề Email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác nhận đơn hàng #' . $this->order->id . ' - NongSanSach',
        );
    }

    // 2. Cấu hình nội dung (View)
    // Bạn sửa 'view.name' thành đường dẫn view invoice của bạn
    public function content(): Content
    {
        return new Content(
            view: 'admin.emails.invoice',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
