<?php

namespace App\Mail;

use App\Invoice;
use App\Job;
use App\Practice;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $job, $invoice, $practice, $user, $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jobs, Invoice $invoice, Practice $practice, User $user)
    {
        $this->jobs = $jobs;
        $this->invoice = $invoice;
        $this->practice = $practice;
        $this->user = $user;
        $this->total = 0;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach ($this->jobs as $job) {
            $fdate = $job->job_start;
            $tdate = $job->job_end;
            $datetime1 = new \DateTime($fdate);
            $datetime2 = new \DateTime($tdate);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');
            $job->days = $days;
			if(isset($job->day_rate)){
				$this->total += $job->day_rate * $job->days;
			}else{
				$this->total += $job->current_income;
			}
            
           
        }

        $pdf = \PDF::loadView('email.invoice', [
            'jobs' => $this->jobs,
            'invoice' => $this->invoice,
            'practice' => $this->practice,
            'user' => $this->user,
            'total' => $this->total,
        ]);

        Storage::put($this->invoice->id.'_invoices.pdf', $pdf->output());
        
        return $this->from('locum@example.com')
            ->view('email.email_invoice')->with([
                'jobs' => $this->jobs,
                'invoice' => $this->invoice,
                'practice' => $this->practice,
                'user' => $this->user,
                'total' => $this->total,
            ])->attachData($pdf->output(), 'invoice.pdf');
    }
}
