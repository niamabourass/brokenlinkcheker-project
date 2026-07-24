<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class ScanReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $scan;
    public $name;

    public function __construct($scan, $name)
    {
        $this->scan = $scan;
        $this->name = $name;
    }


    public function build()
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'emails.scan-report-pdf',
            [
                'scan' => $this->scan,
                'name' => $this->name,
            ]
        );

        return $this
            ->subject('Website Scan Report')
            ->view('emails.scan-report')
            ->attachData(
                $pdf->output(),
                'Website-Scan-Report.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}