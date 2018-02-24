<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Requests\Application\CreateApplicationRequest;
use App\Http\Requests\Application\DeleteApplicationRequest;
use App\Job;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ApplicationController
 * @package App\Http\Controllers
 */
class ApplicationController extends Controller {
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \App\Http\Requests\Application\CreateApplicationRequest $request
	 * @return \Illuminate\Http\Response
	 * @internal param $ \Illuminate\Http\
	 */
	public function store( CreateApplicationRequest $request ) {
		
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
		
		$application = new Application;
		
		if($job = Job::find( $request->job_id )) {
			if(Carbon::now()->format('Y-m-d') <= Carbon::createFromFormat( 'Y-m-d', $job->application_end )->format('Y-m-d')) {
				$application->fill( $request->all() );
				$application->user()->associate( $user );
				$application->save();
				
				return response()->myJson( 200, 'You have successfully applied for this job.', $application );
			} else {
				return response()->myJson( 400, 'Time for application is ran out.', NULL );
			}
		} else {
			return response()->myJson( 400, 'Can\'t find this job.', NULL );
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Http\Requests\Application\DeleteApplicationRequest $request
	 * @param \App\Application                                        $application
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 */
	public function destroy( DeleteApplicationRequest $request, Application $application ) {
		
		if($application->delete()) {
			return response()->myJson( 200, 'Successfully deleted application.', NULL );
		} else {
			return response()->myJson( 400, 'Can\'t deleted application.', NULL );
		}
	}
	
	/**
	 * Get all user applications by user_id
	 *
	 * @param $user_id
	 * @return mixed
	 */
	public function getByUserId( $user_id){
		$application = Application::with('user')->where('user_id' , $user_id)->first();

		if($application) {
			return response()->myJson( 200, 'Successfully get application.', $application );
		} else {
			return response()->myJson( 400, 'Can\'t get application.', NULL );
		}
	}
}
