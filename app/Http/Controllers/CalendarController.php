<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Helpers\Constant;
use App\Http\Requests\Calendar\CreateCalendarRequest;
use App\Http\Requests\Calendar\DeleteCalendarRequest;
use App\Http\Requests\Calendar\UpdateCalendarRequest;
use App\Http\Requests\Calendar\UserCalendarsRequest;
use App\Http\Requests\Calendar\ViewCalendarRequest;
use App\Job;
use App\Practice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class CalendarController
 * @package App\Http\Controllers
 */
class CalendarController extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		
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
		
		$calendars = Calendar::where( 'user_id', $user->id )->get();
		
		if($calendars) {
			return response()->myJson( 200, 'Successfully retrieved calendars for ' . $user->name, $calendars );
		} else {
			return response()->myJson( 404, 'Can\'t find calendars for ' . $user->name, NULL );
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 * @param \App\Http\Requests\Calendar\CreateCalendarRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 * @internal param \App\User $user
	 */
	public function store( CreateCalendarRequest $request ) {
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
		
		$calendar = new Calendar;
		$calendar->fill( $request->all() );
		$calendar->user()->associate( $user );
		$calendar->desc = "Available for hire";
		$calendar->save();
		
		return response()->myJson( 200, 'Successfully created new availability.', $calendar );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param \App\Http\Requests\Calendar\ViewCalendarRequest $request
	 * @param \App\Calendar                                   $calendar
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show( ViewCalendarRequest $request, Calendar $calendar ) {
		return response()->myJson( 200, 'Successfully retrieved availability.', $calendar );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @para
	 * @param \App\Http\Requests\Calendar\UpdateCalendarRequest $request
	 * @param \App\Calendar                                     $calendar
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update( UpdateCalendarRequest $request, Calendar $calendar ) {
		$calendar->fill( $request->all() );
		$calendar->save();
		
		return response()->myJson( 200, 'Successfully edited availability.', $calendar );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Http\Requests\Calendar\DeleteCalendarRequest $request
	 * @param \App\Calendar                                     $calendar
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( DeleteCalendarRequest $request, Calendar $calendar ) {
		if(Calendar::destroy( $calendar->id ) > 0) {
			response()->myJson( 200, 'Successfully deleted calendar.', NULL );
		} else {
			response()->myJson( 400, 'Can\'t delet calendar.', NULL );
		}
	}
	
	/**
	 * practice search locums availability and self job
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function practiceFilter( Request $request ) {
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
		
		$jobs = Job::where( 'practice_id', $practice->id )->get();
		
		if($request->locum_name != NULL) {
			$user = User::with( 'calendars' )->where( 'role', Constant::ROLE_USER )->where( 'name', $request->locum_name )->get();
		} else {
			$user = User::with( 'calendars' )->where( 'role', Constant::ROLE_USER )->get();
		}
		
		if($request->end_date != NULL && $request->start_date != NULL) {
			$user = User::where( 'role', Constant::ROLE_USER )->with( array('calendars' => function( $query ) use ( $request ) {
				$query->whereBetween( 'start_date', [ $request->start_date,$request->end_date] )->orWhereBetween( 'end_date',  [ $request->start_date,$request->end_date] )
				->orWhere([['start_date','<=',$request->start_date],['end_date','>=',$request->end_date]]);
			} ))->get();
		}
		
		$entity = [
			'jobs'   => $jobs,
			'locums' => $user,
		];
		
		return response()->myJson( 200, 'Successfully get calendars.', $entity );
	}
	
	/**
	 * locum search practices jobs and self calendars
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	public function locumFilter( Request $request ) {
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
		
		$practices = Practice::with( 'jobs.percentages' )->where( 'practice_name', 'like', '%' . $request->practice_name . '%' )->get();
		
		if($request->start_date != NULL && $request->end_date != NULL) {
			
			$start_date = Carbon::createFromFormat( 'Y-m-d', $request->start_date );
			$end_date   = Carbon::createFromFormat( 'Y-m-d', $request->end_date );
			
			$calendar = Calendar::where( 'user_id', $user->id )->whereHas( 'user', function( $query ) {
				$query->where( 'role', Constant::ROLE_USER );
			} )->with( 'user' )->get();
			
			$practices->load( [
				'jobs' => function( $query ) use ( $start_date, $end_date,$request ) {
					$query->where( 'user_id', NULL );
					$query->whereBetween( 'job_start', [$request->start_date ,$request->end_date] )->orWhereBetween( 'job_end', [$start_date,$request->end_date] )
					->orWhere([['job_start','<=',$request->start_date],['job_end','>=',$request->end_date]])->get();
				},
			] );
			
			$practices = $practices->filter( function( $value ) {
				return !$value->jobs->isEmpty();
			} )->values()->all();

			
			
		} else {
			$calendar = Calendar::where( 'user_id', $user->id )->whereHas( 'user', function( $query ) {
				$query->where( 'role', Constant::ROLE_USER );
			} )->with( 'user' )->get();
			
			$practices->load( [
				'jobs' => function( $query ) use ( $request ) {
					$query->where( 'user_id', NULL )->get();
				},
			] );

			
			$practices = collect( $practices->filter( function( $value ) {
				return !$value->jobs->isEmpty();
			} )->all() );
		}

		$entity = [
			'calendars' => $calendar,
			'practices' => $practices,
		];
		
		return response()->myJson( 200, 'Successfully get calendars.', $entity );
	}
	
	/**
	 * get all calendar for certain user
	 *
	 * @param $user_id
	 * @return mixed
	 */
	public function getAllCalendars( $user_id ) {
		
		$cal = Calendar::where( 'user_id', $user_id )->get();
		
		if(!$cal->isEmpty()) {
			return response()->myJson( 200, 'Successfully get calendars.', $cal );
		} else {
			return response()->myJson( 404, 'No result for calendars.', NULL );
		}
	}
}
