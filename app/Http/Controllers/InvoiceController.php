<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Http\Requests\Invoice\getLocumInvoice;
use App\Invoice;
use App\Practice;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class InvoiceController extends Controller {
	
	/**
	 * Creating an invoice and redirecting
	 * @return \App\Invoice
	 */
	public function create() {
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
		$practice               = Practice::where( 'user_id', $user->id )->first();
		$invoice                = new Invoice;
		$invoice->payment_terms = Constant::PAYMENT_TERMS;
		$invoice->practice_id   = $practice->id;
		$invoice->user_id       = $user->id;
		if($invoice->save()) {
			return $invoice;
		}
	}
	
	/**
	 * Create Invoice for corporation
	 *
	 * @param $id
	 * @return \App\Invoice
	 */
	public function corporationCreate( $id ) {
		$invoice                 = new Invoice;
		$invoice->payment_terms  = Constant::PAYMENT_TERMS;
		$invoice->corporation_id = $id;
		if($invoice->save()) {
			return $invoice;
		}
	}
	
	/**
	 * get invoices for locums and search by
	 * practice name, paid status, job_start, job_end
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function getLocumInvoices( Request $request ) {
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
		
		$invoices = Invoice::with( 'user', 'practice', 'job.percentages' )->whereHas( 'practice', function( $query ) use ( $request ) {
			$query->where( 'practice_name', 'like', '%' . $request->practice_name . '%' );
		} )->where( 'user_id', $user->id );
		if($request->paid_status != NULL) {
			switch($request->paid_status) {
				case 'paid':
					$invoices->where( 'paid_status', TRUE );
					break;
				case 'not_paid':
					$invoices->where( 'paid_status', FALSE );
					break;
			}
		}
		
		if($request->job_start != NULL && $request->job_end != NULL) {
			$invoices->whereHas( 'job', function( $query ) use ( $request ) {
				$query->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
			} );
		}
		
		$invoices = $invoices->paginate( 5 );
		
		if(!$invoices->isEmpty()) {
			return response()->myJson( 200, 'Successfully retrived invoices.', $invoices );
		} else {
			return response()->myJson( 400, 'Cant\'t find invoices.', NULL );
		}
	}
	
	/**
	 * get invoices for practice and search by
	 * locum name, paid status, job_start, job_end
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function getPracticeInvoices( Request $request ) {
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
		$invoices = Invoice::with( 'user', 'practice', 'job.percentages' )->whereHas( 'user', function( $query ) use ( $request ) {
			$query->where( 'name', 'like', '%' . $request->locum_name . '%' )->where( 'role', Constant::ROLE_USER );
		} )->where( 'practice_id', $owner->practice()->first()->id );
		
		if($request->paid_status != NULL) {
			switch($request->paid_status) {
				case 'paid':
					$invoices->where( 'paid_status', TRUE );
					break;
				case 'not_paid':
					$invoices->where( 'paid_status', FALSE );
					break;
			}
		}
		if($request->job_start != NULL && $request->job_end != NULL) {
			$invoices->whereHas( 'job', function( $query ) use ( $request ) {
				$query->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
			} );
		}
		
		$invoices = $invoices->paginate( 5 );
		
		if($invoices->count() > 0) {
			return response()->myJson( 200, 'Successfully retrived invoice.', $invoices );
		} else {
			return response()->myJson( 404, 'Cant\'t find invoice.', NULL );
		}
	}
	
	/**
	 * Locum confirm if practice paid
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function confirmPayment( Request $request ) {
		$invoice              = Invoice::find( $request->invoice_id );
		$invoice->paid_status = 1;
		if($invoice->save()) {
			return response()->myJson( 200, 'Successfully updated invoice.', $invoice );
		} else {
			return response()->myJson( 400, 'Cant\'t updated invoice.', $invoice );
		}
	}
}
