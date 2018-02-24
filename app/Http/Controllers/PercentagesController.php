<?php

namespace App\Http\Controllers;

use App\Job;
use App\Percentage;
use Illuminate\Http\Request;

class PercentagesController extends Controller {
	
	/**
	 * Default constructor
	 */
	public function __construct() {
		
		$this->middleware( 'jwt.auth' );
	}
	
	/**
	 * Update percentage amount
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function update( Request $request ) {
		
		$percentage = Percentage::find( $request->id );
		$percentage->fill( $request->only( 'amount' ) );
		$percentage->isSent = TRUE;
		
		if($percentage->save()) {
			return response()->myJson( 200, 'Successfully update percentage.', $percentage );
		} else {
			return response()->myJson( 400, 'Can\'t update percentage.', $percentage );
		}
	}
	
	/**
	 * Approve locum amount for percentage
	 *
	 * @param $id
	 * @return mixed
	 */
	public function approveAmount( $id ) {
		$percentage           = Percentage::find( $id );
		$percentage->approved = TRUE;
		$percentage->save();
		
		$job = Job::find( $percentage->job_id );
		$job->current_income += $percentage->amount;
		
		if($job->save()) {
			return response()->myJson( 200, 'Successfully approved percentage.', $percentage );
		} else {
			return response()->myJson( 400, 'Can\'t approved percentage.', $percentage );
		}
	}
	
	/**
	 * Decline locum amount for percentage
	 *
	 * @param $id
	 * @return mixed
	 */
	public function declineAmount( $id ) {
		
		$percentage           = Percentage::find( $id );
		$percentage->approved = FALSE;
		$percentage->amount   = 0;
		$percentage->isSent   = FALSE;
		
		if($percentage->save()) {
			return response()->myJson( 200, 'Successfully decline percentage.', $percentage );
		} else {
			return response()->myJson( 400, 'Can\'t decline percentage.', $percentage );
		}
	}
}
