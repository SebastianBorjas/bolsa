<?php

namespace App\Mail;

use App\Models\Empleado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmpleadoCvMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Empleado $empleado,
        public string $subjectLine,
        public string $bodyMessage,
        public ?string $attachmentPath = null,
    ) {
    }

    public function build()
    {
        $mail = $this->subject($this->subjectLine)
            ->view('emails.empleado-cv', [
                'empleado' => $this->empleado,
                'bodyMessage' => $this->bodyMessage,
            ]);

        if ($this->attachmentPath) {
            $mail->attach($this->attachmentPath, [
                'as' => basename($this->attachmentPath),
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
