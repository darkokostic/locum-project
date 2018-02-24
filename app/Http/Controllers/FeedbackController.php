<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Helpers\Constant;
use App\Job;
use App\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller {
	
	/**
	 * Create feedback
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param                          $id
	 * @return mixed
	 */
	public function create( Request $request, $id ) {
		
		$job  = Job::find( $request->job_id );
		$user = User::find( $id );
		
		if($user->role == Constant::ROLE_USER) {
			$job->locumRated = TRUE;
		} elseif($user->role == Constant::ROLE_OWNER) {
			$job->practiceRated = TRUE;
		}
		$job->save();
		
		$feedback = new Feedback();
		$feedback->fill( $request->all() );
		$feedback->user_id = $id;
		
		if($feedback->save()) {
			return response()->myJson( 200, 'Successfully created feedback.', $feedback );
		} else {
			return response()->myJson( 400, 'Can\'t created feedback.', NULL );
		}
		
	}
	
	/**
	 * Show feedback for certain locum
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showLocumFeedback( $id ) {
		$jobs = Job::has('feedback')->with( 'feedback' )->where( 'user_id', $id )->paginate( 4 );
		
		$jobs->load( [
			'feedback' => function( $query ) {
				$query->with( 'user' );
			},
		] );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get locum jobs with feedback.', $jobs );
		} else {
			return response()->myJson( 400, 'Can\'t get locum jobs with feedback.', NULL );
		}
	}
	
	/**
	 * Show feedback for certain practice
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showPracticeFeedback( $id ) {
		$jobs = Job::has('feedback')->with( 'feedback' )->where( 'practice_id', $id )->paginate( 4 );
		
		$jobs->load( [
			'feedback' => function( $query ) {
				$query->with( 'user' );
			},
		] );
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get practice jobs with feedback.', $jobs );
		} else {
			return response()->myJson( 400, 'Can\'t get practice jobs with feedback.', NULL );
		}
	}
}