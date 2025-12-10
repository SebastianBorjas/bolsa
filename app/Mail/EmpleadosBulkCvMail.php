<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmpleadosBulkCvMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $empleados;
    public string $subjectLine;
    public string $bodyMessage;
    public array $pdfAttachments;

    public function __construct(array $empleados, string $subjectLine, string $bodyMessage, array $attachments = [])
    {
        $this->empleados = $empleados;
        $this->subjectLine = $subjectLine;
        $this->bodyMessage = $bodyMessage;
        $this->pdfAttachments = $attachments;
    }

    public function build()
    {
        $mail = $this->subject($this->subjectLine)
            ->view('emails.empleados-cv-bulk', [
                'empleados' => $this->empleados,
                'bodyMessage' => $this->bodyMessage,
            ]);

        foreach ($this->pdfAttachments as $filePath) {
            $mail->attach($filePath, [
                'as' => basename($filePath),
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
