<?php

namespace App\Console;

use App\Corporation;
use App\Http\Controllers\InvoiceController;
use App\Invoice;
use App\Mail\InvoiceMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $corporations = Corporation::with('practices.invoices')->get();
            $jobs = array();
            foreach ($corporations as $corporation) {
                foreach ($corporation->practices as $practice) {

                    foreach ($practice->invoices as $invoice) {
                        if (sizeof($invoice->job) > 0) {
                            foreach ($invoice->job()->get() as $job) {
                                array_push($jobs, $job);
                            }
                        }
                    }
                }

                if (sizeof($jobs) > 0){
                    $invoiceCtrl = new InvoiceController();
                    $invoice = $invoiceCtrl->corporationCreate($corporation->id);
                    $pdf = \PDF::loadView( 'email.corporation_invoice', [
                        'jobs'      => $jobs,
                        'invoice'   => $invoice,
                        'corporation'  => $corporation,
                    ] );
                    Log::info($jobs);
                    Storage::put( 'corporation/'.$invoice->id . '_invoices.pdf', $pdf->output() );
                    DB::table( 'corporation_invoice' )->insert( [
                        'corporation_id'       => $corporation->id,
                        'invoice_id'      => $invoice->id,
                        'created_at' => Carbon::now(),
                    ] );
                    Mail::to($corporation->email)->send(new InvoiceMail($jobs, $invoice, $practice, new User()));
                }

            }
        })->monthly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
