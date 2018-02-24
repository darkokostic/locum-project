<?php

namespace App\Http\Controllers;

use App\Application;
use App\Calendar;
use App\Helpers\Constant;
use App\Http\Requests\Job\CreateJobRequest;
use App\Http\Requests\Job\DeleteJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Job;
use App\Mail\InvoiceMail;
use App\Invoice;
use App\Percentage;
use App\Practice;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Netshell\Paypal\Facades\Paypal;

/**
 * Class JobController
 * @package App\Http\Controllers
 */
class JobController extends PayPalController {
	/**
	 * Default constructor
	 */
    private $_api_context;
    private  $job;
	public function __construct() {

		$this->middleware( 'jwt.auth', [
			'except' => [
				'vacancies',
				'locumVacancies',
				'practiceVacancies',
				'jobWithAllApplications',
				'show',
                'getDone',
			],
		] );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		if($jobs = Job::orderBy( 'created_at', 'desc' )->get()) {
			return response()->myJson( 200, 'Successfully get all jobs.', $jobs );
		} else {
			return response()->myJson( 404, 'Jobs not found.', NULL );
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\Job\CreateJobRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store( CreateJobRequest $request ) {

		try {
			$owner = JWTAuth::parseToken()->authenticate();
		} catch(TokenExpiredException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(TokenInvalidException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(JWTException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(\Exception $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		}

		$practice = Practice::where( 'user_id', $owner->id )->first();

		$job = new Job;
		$job->fill( $request->all() );
		$job->practice()->associate( $practice );
		$job->save();

		if($request->has( 'percentage' )) {
			$job->job_start = Carbon::parse( $job->job_start );
			$job->job_end   = Carbon::parse( $job->job_end );
			$job->job_end->addDay();
			$step   = CarbonInterval::day();
			$period = new DatePeriod( $job->job_start, $step, $job->job_end );

			$range = collect( [] );

			foreach($period as $day) {
				$singleDay = new Carbon( $day );
				$singleDay = Carbon::parse( $singleDay )->format( 'Y-m-d' );
				$range->push( $singleDay );
				$percentages      = new Percentage;
				$percentages->day = $singleDay;

				$percentages->job()->associate( $job );
				$percentages->save();
			}
		}

		return response()->myJson( 200, 'Successfully created new job', $job );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Job $job
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function show( Job $job ) {
		$job->load(['percentages', 'practice', 'user']);
		return response()->myJson( 200, 'Successfully retrieved job', $job );
	}

	/**
	 * Update the specified resource in storage.
	 * And, id $job->completed true mail send for invoices
	 *
	 * @param \App\Http\Requests\Job\UpdateJobRequest $request
	 * @param \App\Job                                $job
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 * @internal param $
	 */
    public function update( UpdateJobRequest $request, Job $job ) {

        $job->fill( $request->all() );
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

            Mail::to( [
                $practice->practice_email,
                $user->email,
            ] )->send( new InvoiceMail( [$job], $invoice, $practice, $user ) );
        }

        return response()->myJson( 200, 'Successfully edited job', $job );
    }
	public function payPalUpdate( $id,$userID ) {
        $job = Job::find($id);
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
        $payer = PayPal::Payer();
        $payer->setPaymentMethod('paypal');

        $amount = PayPal:: Amount();
        $amount->setCurrency('USD');
        $amount->setTotal($job->totalDays * 50); // This is the simple way,
        // you can alternatively describe everything in the order separately;
        // Reference the PayPal PHP REST SDK for details.

        $transaction = PayPal::Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('What are you selling?');

        $redirectUrls = PayPal:: RedirectUrls();
        $userLogedIn = JWTAuth::parseToken()->authenticate();
        $redirectUrls->setReturnUrl(URL::route('payment.status.done', array('job'=>$job->id, 'user'=>$userID,'logedIn'=>$userLogedIn->id)));
        $redirectUrls->setCancelUrl(URL::route('payment.status.cancled'));

        $payment = PayPal::Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setRedirectUrls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $response = $payment->create($this->_apiContext);
        $redirectUrl = $response->links[1]->href;
        return response()->myJson( 200, 'Successfully edited job', $redirectUrl );


	}
    public function getDone(Request $request)
    {
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
        $id = $request->get('paymentId');
        $token = $request->get('token');
        $payer_id = $request->get('PayerID');

        $payment = PayPal::getById($id, $this->_apiContext);

        $paymentExecution = PayPal::PaymentExecution();

        $paymentExecution->setPayerId($payer_id);
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        // Clear the shopping cart, write to database, send notifications, etc.

        // Thank the user for the purchase
        $job = Job::find($request->job_id);
        $job->user_id = $request->user_id;
        $job->save();
        $user_first     = User::find( $request->user_id );
        $owner_first    = User::find($request->logedIn);
        $practice_first = $owner_first->practice;
        $job_first = Job::find($request->job_id);
        $data_first = ['practice' => $practice_first, 'job' => $job_first, 'user'=> $user_first];

        Mail::send('email.contract', $data_first, function ($message) use ($data_first, $practice_first) {
            $message->from('do-not-reply@locumod.com', 'Application accepted');
            $pdf = \PDF::loadView('pdf.contract', $data_first);
            $message->attachData($pdf->output(), 'contract.pdf');
            $message->to($practice_first->practice_email);
        });

        Mail::send('email.contract', $data_first, function ($message) use ($data_first, $user_first) {
            $message->from('do-not-reply@locumod.com', 'Application accepted');
            $pdf = \PDF::loadView('pdf.contract', $data_first);
            $message->attachData($pdf->output(), 'contract.pdf');
            $message->to($user_first->email);
        });
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

            Mail::to( [
                $practice->practice_email,
                $user->email,
            ] )->send( new InvoiceMail( [$job], $invoice, $practice, $user ) );
        }

        return Redirect::to('/#!/practice/practice_all_jobs');
    }
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Http\Requests\Job\DeleteJobRequest $request
	 * @param \App\Job                                $job
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( DeleteJobRequest $request, Job $job ) {
		if(Job::destroy( $job->id ) > 0) {
			return response()->myJson( 200, 'Successfully deleted job.', NULL );
		} else {
			return response()->myJson( 400, 'Can\'t delete job.', NULL );
		}
	}
	
	/**
	 * Return all jobs where specified user applied
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jobWithMyApplications( $id ) {
		$jobs = Application::with( 'job' )->where( 'user_id', $id )->simplePaginate( 3 );
		$jobs->load( [
			'job' => function( $query ) {
				$query->with( 'practice' );
			},
		] );
		
		if($jobs->isEmpty()) {
			return response()->myJson( 404, 'Can\'t get jobs with applications.', NULL );
		} else {
			return response()->myJson( 200, 'Successfully get jobs with applications.', $jobs );
		}
	}
	
	/**
	 * Now this method return only application for job id
	 * Return jobs with all application
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function jobWithAllApplications( $id ) {
		$jobs = Job::with( 'applications' )->where( 'id', $id )->first();
		$jobs = $jobs->applications()->paginate( 5 );
		
		$jobs->load( [
			'user' => function( $query ) {
				$query->get();
			},
		] );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get jobs with applications.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t get jobs with applications.', NULL );
		}
	}
	
	/**
	 * Return booked jobs and search booked jobs
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function bookedJobs( Request $request ) {
		
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(TokenExpiredException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(TokenInvalidException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(JWTException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(\Exception $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		}
		
		$jobs = Job::with( 'practice', 'percentages' )->where( 'user_id', $user->id );
		if($request->job_start != NULL && $request->job_end != NULL) {
			$jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
		}
		
		if($request->practice_name != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_name', 'like', '%' . $request->practice_name . '%' );
			} );
		}
		if($request->practice_city != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_city', 'like', '%' . $request->practice_city . '%' );
			} );
		}
		
		$jobs = $jobs->paginate( 6 );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get jobs.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t get jobs.', NULL );
		}
	}
	
	/**
	 * Return completed jobs and search completed jobs
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function completedJobs( Request $request ) {
		
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(TokenExpiredException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(TokenInvalidException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(JWTException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(\Exception $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		}
		
		$jobs = Job::with( 'practice', 'percentages' )->where( 'user_id', $user->id )->where( 'completed', TRUE );
		
		if($request->job_start != NULL && $request->job_end != NULL) {
			$jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
		}
		
		if($request->practice_name != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_name', 'like', '%' . $request->practice_name . '%' );
			} );
		}
		if($request->practice_city != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_city', 'like', '%' . $request->practice_city . '%' );
			} );
		}
		
		$jobs = $jobs->paginate( 6 );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get jobs.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t get jobs.', NULL );
		}
	}
	
	/**
	 * Find jobs and search jobs
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function findJob( Request $request ) {
		
		$jobs = Job::with( 'practice', 'percentages' )->where( 'completed', FALSE )->where( 'user_id', NULL );
		
		if($request->job_start != NULL && $request->job_end != NULL) {
			$jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
		}
		
		if($request->practice_name != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_name', 'like', '%' . $request->practice_name . '%' );
			} );
		}
		if($request->practice_city != NULL) {
			$jobs->whereHas( 'practice', function( $query ) use ( $request ) {
				$query->where( 'practice_city', 'like', '%' . $request->practice_city . '%' );
			} );
		}
		
		$jobs = $jobs->paginate( 6 );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get jobs.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t get jobs.', NULL );
			
		}
	}
	
	/**
	 * Get completed jobs for certain user
	 *
	 * @return mixed
	 */
	public function getCompletedJobs() {
		try {
			$user = JWTAuth::parseToken()->authenticate();
		} catch(TokenExpiredException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(TokenInvalidException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(JWTException $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		} catch(\Exception $e) {
			return response()->myJson( 400, $e->getMessage(), NULL );
		}
		$jobs = Job::with( 'practice' )->where( 'user_id', $user->id )->where( 'completed', TRUE )->get();
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get completed jobs.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t get completed jobs.', NULL );
		}
	}
	
	/**
	 * Get last 6 vacancies
	 *
	 * @return mixed
	 */
	public function vacancies() {
		$calendars = Calendar::with( 'user' )->get();
		$jobs      = Job::with( [
			'practice',
			'practice.user',
		] )->where( 'completed', FALSE )->get();
		
		$merged = $calendars->merge( $jobs );
		$merged = $merged->sortByDesc( 'created_at' )->take( 6 );
		
		return response()->myJson( 200, 'Successfully get latest vacancies.', $merged );
	}
	
	/**
	 * Get last 6 created jobs
	 *
	 * @return mixed
	 */
	public function locumVacancies() {
		
		$jobs = Job::with( 'practice' )->where( 'completed', FALSE )->orderBy( 'created_at' )->take( 6 )->get();
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get latest vacancies.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t return latest vacancies', NULL );
		}
	}
	
	/**
	 * Get last 6 locums calendars
	 *
	 * @return mixed
	 */
	public function practiceVacancies() {
		
		$calendars = Calendar::with( 'user' )->orderBy( 'created_at' )->take( 6 )->get();
		
			if(!$calendars->isEmpty()) {
			return response()->myJson( 200, 'Successfully get latest vacancies.', $calendars );
		} else {
			return response()->myJson( 404, 'Can\'t return latest vacancies', NULL );
		}
	}
}
