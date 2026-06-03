<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $subject;
    public string $body;
    public string $siteName;
    public ?string $logoUrl;
    public string $siteUrl;
    public string $headerColor;
    public ?string $footerText;

    public function __construct(string $subject, string $body)
    {
        $this->subject     = $subject;
        $this->body        = $body;
        $this->siteName    = Setting::get('site_name', config('app.name'));
        $this->siteUrl     = url('/');
        $this->headerColor = Setting::get('email_header_color', '#6366f1');
        $this->footerText  = Setting::get('email_footer_text');

        $logo = Setting::get('site_logo');
        $this->logoUrl = $logo ? asset('storage/' . $logo) : null;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.notification');
    }

    public function attachments(): array
    {
        return [];
    }
}
