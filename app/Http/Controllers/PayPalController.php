<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Netshell\Paypal\Facades\Paypal;

class PayPalController extends Controller
{
    private $_api_context;

    private  $job;
    public function __construct(){

        $this->_apiContext = Paypal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'service.EndPoint' => 'https://api.sandbox.paypal.com',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/paypal.log'),
            'log.LogLevel' => 'FINE'
        ));
    }
    public function setJob(Job $job){
        $this->job = $job;
    }
    public function postPayment(){

        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('USD');
        $amount->setTotal(42); // This is the simple way,
        // you can alternatively describe everything in the order separately;
        // Reference the PayPal PHP REST SDK for details.

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('What are you selling?');

        $redirectUrls = PayPal:: RedirectUrls();
        $redirectUrls->setReturnUrl(URL::route('payment.status.done'));
        $redirectUrls->setCancelUrl(URL::route('payment.status.cancled'));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);
        $redirectUrl = $response->links[1]->href;

        return Redirect::to( $redirectUrl );
    }
    public function getDone(Request $request)
    {
        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        // Clear the shopping cart, write to database, send notifications, etc.

        // Thank the user for the purchase
        $job = $this->job;
        $job->save();

        if($job->completed == TRUE) {
            $invoice                = new Invoice;
            $invoice->payment_terms = Constant::PAYMENT_TERMS;
            $practice               = Practice::find( $job->practice_id );
            $user                   = User::find( $job->user_id );
            $invoice->practice_id   = $practice->id;
            $invoice->user_id       = $user->id;
            $invoice->save();

            $job->invoice_id = $invoice->id;
            $job->save();

            $pdf = \PDF::loadView( 'email.invoice', [
                'jobs'     => [$job],
                'invoice'  => $invoice,
                'practice' => $practice,
                'user'     => $user,
            ] );

            Storage::put( $invoice->id . '_invoices.pdf', $pdf->output() );

//            Mail::to( [
//                $practice->practice_email,
//                $user->email,
//            ] )->send( new InvoiceMail( [$job], $invoice, $practice, $user ) );
        }

    }
    public function getCancel()
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        return Redirect::to('/#!/practice/practice_all_jobs');
    }
}
