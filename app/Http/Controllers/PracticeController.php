<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\FileHandler;
use App\Http\Requests\Practice\AuthPracticeRequest;
use App\Http\Requests\Practice\CreatePracticeRequest;
use App\Http\Requests\Practice\DeletePracticeRequest;
use App\Http\Requests\Practice\PracticeDashboardRequest;
use App\Http\Requests\Practice\UpdatePracticeRequest;
use App\Http\Requests\Session\GetPracticeSession;
use App\Job;
use App\Practice;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

use Intervention\Image\ImageManagerStatic as Image;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class PracticeController
 * @package App\Http\Controllers
 */
class PracticeController extends Controller {
	
	/**
	 * Default constructor
	 */
	public function __construct() {
		
		$this->middleware( 'jwt.auth', [
			'except' => [
				'authenticate',
				'store',
				'myLocum',
				'show',
			],
		] );
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreatePracticeRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( CreatePracticeRequest $request ) {
		
		try {
			$payload = $request->only( 'email', 'password' );
			$entity  = User::where( 'email', '=', $payload['email'] )->where( 'password', '=', bcrypt( $payload['password'] ) )->first();
			if(!$found = $entity) {
				$user              = new User;
				$user->email       = $request->email;
				$user->password    = bcrypt( $request->password );
				$user->city        = $request->city;
				$user->postal_code = $request->postal_code;
				$user->role        = Constant::ROLE_OWNER;
				
				if($user->save()) {
					$entity = new Practice();
					$entity->fill( $request->all() );
					$entity->user_id = $user->id;
					$entity->save();
					$token = JWTAuth::attempt( $payload );
					if($token) {
						$entity->token = $token;
						$entity->user  = $user;
						$message       = 'Successfully register and authorized practice.';
						$code          = 200;
					}
				}
			}
			if($found && (!isset( $token ) || !$token)) {
				throw new \Exception( 'Failed to register, try again later.' );
			}
		} catch(\Exception $e) {
			$entity  = NULL;
			$message = $e->getMessage() . ':' . $e->getLine();
			$code    = 500;
		}
		
		return response()->json( [
			'message' => $message,
			'entity'  => $entity,
			'code'    => $code,
		], $code );
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param \App\Practice $practice
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 *
	 */
	public function show( Practice $practice ) {
		return response()->myJson( 200, 'Successfully retrieved practice.', $practice );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\Practice\UpdatePracticeRequest $request
	 * @param \App\Practice                                     $practice
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function update( UpdatePracticeRequest $request, Practice $practice ) {
		$fileHandler = new FileHandler;
		$file        = $request->file( 'files' );
		$basePath    = Constant::absolutePath( "PRACTICE_AVATAR_PATH" );
		if($file) {
            $image = Image::make($file->getRealPath());
            $image->fit(200,200, function ($constraint) {
                $constraint->upsize();
            });
            $name = md5( Carbon::now() ) . '.' . $file->getClientOriginalExtension();
            $image->save($basePath . $name);
			if($practice->getOriginal( 'avatar' ) != Constant::PRACTICE_DEFAULT_AVATAR_PATH) {
                $fileHandler->removeFile(public_path() . $practice->avatar);
            }
            $practice->avatar =Constant::PRACTICE_AVATAR_PATH .$name;
			
		}
		$practice->fill( $request->all() );
		$practice->save();
		
		return response()->json( [
			'message' => 'Successfully edited locum',
			'entity'  => $practice,
			'code'    => 200,
		], 200 );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Http\Requests\Practice\DeletePracticeRequest $request
	 * @param \App\Practice                                     $practice
	 * @return \Illuminate\Http\Response
	 * @internal param $
	 */
	public function destroy( DeletePracticeRequest $request, Practice $practice ) {
		if(Practice::destroy( $practice->id ) > 0) {
			$message = 'Successfully deleted practice.';
			$code    = 200;
		} else {
			$message = 'Internal server error';
			$code    = 500;
		}
		
		return response()->json( [
			'message' => $message,
			'entity'  => NULL,
			'code'    => $code,
		], $code );
	}
	
	/**
	 * Authenticate practice
	 *
	 * @param AuthPracticeRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authenticate( AuthPracticeRequest $request ) {
		
		try {
			$payload = $request->only( 'email', 'password' );
			$token   = JWTAuth::attempt( $payload );
			if(!$token) {
				throw new \Exception( 'No matching credentials found.' );
			} else {
				#$entity = User::with('practice')->where('practice.practice_email', '=', $payload['email'])->orWhere('email', '=', $payload['email'])->first();
				$entity        = User::with( 'practice' )->where( 'email', '=', $payload['email'] )->first();
				$entity->token = $token;
				$message       = 'Successfully authorized.';
				$code          = 200;
			}
		} catch(\Exception $e) {
			$entity  = NULL;
			$message = $e->getMessage();
			$code    = 500;
		}
		
		return response()->json( [
			'message' => $message,
			'entity'  => $entity,
			'code'    => $code,
		], $code );
	}
	
	public function dashboard( PracticeDashboardRequest $request ) {
		$user     = JWTAuth::parseToken()->authenticate();
		$practice = Practice::where( 'user_id', $user->id )->first();
		
		$jobs           = Job::where( 'practice_id', $practice->id )->get();
		$completed_jobs = $jobs->where( 'completed', TRUE )->count();
		#$completed_jobs = Job::where( 'practice_id', $practice->id )->where( 'completed', TRUE )->count();
		#$posted_jobs    = Job::where( 'practice_id', $practice->id )->where( 'completed', FALSE )->count();
		$posted_jobs = $jobs->where( 'completed', FALSE )->count();
		$activities  = Job::where( 'practice_id', $practice->id )->where( 'completed', FALSE )->simplePaginate( 4 );
		
		//$prevousion_locum = sizeof(Job::distinct()->select('user_id')->where('practice_id', $practice->id)->groupBy('user_id')->get());
		$prevousion_locum = sizeof( Job::distinct()->select( 'user_id' )->where( 'practice_id', $practice->id )->groupBy( 'user_id' )->get() );
		$lat              = $practice->lat;
		$lng              = $practice->lng;
		
		return response()->json( [
			'completed_jobs'   => $completed_jobs,
			'activities'       => $activities,
			'posted_jobs'      => $posted_jobs,
			'prevousion_locum' => $prevousion_locum,
		], 200 );
	}
	
	public function nearestLocum() {
		
		$user     = JWTAuth::parseToken()->authenticate();
		$practice = Practice::where( 'user_id', $user->id )->first();
		$lat      = $practice->lat;
		$lng      = $practice->lng;
		
		$nearestLocum = DB::table( 'users' )->select( DB::raw( '*, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance' ) )->orderBy( 'distance' )->where( 'role', Constant::ROLE_USER )->paginate( 2 );
		
		if($nearestLocum->count() > 0) {
			return response()->myJson( 200, 'Nearest Locum', $nearestLocum );
		} else {
			return response()->myJson( 404, 'Nearest locum not found', NULL );
		}
		
	}
	
	public function send( Request $request ) {
		$user     = User::find( $request->user_id );
		$owner    = JWTAuth::parseToken()->authenticate();
		$practice = $owner->practice;
		
		$mail = Mail::send( 'mail', [
			'subject' => $request->mail_subject,
			'content' => $request->mail_content,
		], function( $message ) use ( $user, $practice ) {
			$message->from( $practice->practice_email, $practice->practice_name );
			$message->to( $user->email );
		} );
		
		if(!$mail) {
			return response()->json( [
				'message' => "Email sent!",
				'entity'  => NULL,
				'code'    => 200,
			], 200 );
		} else {
			return response()->json( [
				'message' => "Email not sent!",
				'entity'  => NULL,
				'code'    => 400,
			], 400 );
		}
	}

	public function sendContracts( Request $request ) {
//		$user     = User::find( $request->user_id );
//		$owner    = JWTAuth::parseToken()->authenticate();
//		$practice = $owner->practice;
//		$job = Job::find($request->job_id);
//		$data = ['practice' => $practice, 'job' => $job, 'user'=> $user];
//
//		Mail::send('email.contract', $data, function ($message) use ($data, $practice) {
//		    $message->from('do-not-reply@locumod.com', 'Application accepted');
//		    $pdf = \PDF::loadView('pdf.contract', $data);
//		    $message->attachData($pdf->output(), 'contract.pdf');
//		    $message->to($practice->practice_email);
//		});
//
//		Mail::send('email.contract', $data, function ($message) use ($data, $user) {
//		    $message->from('do-not-reply@locumod.com', 'Application accepted');
//		    $pdf = \PDF::loadView('pdf.contract', $data);
//		    $message->attachData($pdf->output(), 'contract.pdf');
//		    $message->to($user->email);
//		});
//
//
		return response()->json( [
			'message' => "Contract sent by email.",
			'entity'  => NULL,
			'code'    => 200,
		], 200 );
	}
	
	public function practiceSession( Request $request ) {
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
		
		$jobs = Job::with( 'user', 'percentages', 'practice' )->where( 'practice_id', $practice->id )->whereNotNull( 'user_id' );
		if($request->locum_name != NULL) {
			$jobs->whereHas( 'user', function( $query ) use ( $request ) {
				$query->where( 'name', 'like', '%' . $request->locum_name . '%' );
			} );
		}
		
		if($request->job_start != NULL && $request->job_end != NULL) {
			$jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
			
		}
		
		$jobs = $jobs->paginate( 5 );
		
		if(!$jobs->isEmpty()) {
			return response()->myJson( 200, 'Successfully get my sessions.', $jobs );
		} else {
			return response()->myJson( 404, 'Can\'t find sessions.', NULL );
		}
		
	}
	
	
	//	public function myLocum( Request $request ) {
	//		try {
	//			$owner = JWTAuth::parseToken()->authenticate();
	//		} catch(TokenExpiredException $e) {
	//			return response()->myJson( 400, $e->getMessage(), NULL );
	//		} catch(TokenInvalidException $e) {
	//			return response()->myJson( 400, $e->getMessage(), NULL );
	//		} catch(JWTException $e) {
	//			return response()->myJson( 400, $e->getMessage(), NULL );
	//		} catch(\Exception $e) {
	//			return response()->myJson( 400, $e->getMessage(), NULL );
	//		}
	//
	//		$practice = Practice::where( 'user_id', $owner->id )->first();
	//
	//		$jobs = Job::with( 'user', 'percentages', 'practice' )->where( 'practice_id', $practice->id )->paginate( 5 );
	//
	//		$jobs->load( [
	//			'user' => function( $query ) {
	//				$query->get();
	//			},
	//		] );
	//
	//		if($jobs->count() > 0) {
	//			return response()->myJson( 200, 'My locums.', $jobs );
	//		} else {
	//			return response()->myJson( 404, 'My locums not found.', NULL );
	//		}
	//	}
	/*
	public function myLocumSearch( Request $request ) {
		
		$owner    = JWTAuth::parseToken()->authenticate();
		$practice = Practice::where( 'user_id', $owner->id )->first();
		
		$jobs = Job::with( 'user', 'percentages' )->where( 'practice_id', $practice->id )->where( 'completed', $request->completed );
		if($request->job_start != NULL && $request->job_end != NULL && $request->search_key != NULL) {
			
			$jobs = $jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
			$jobs = $jobs->where( 'title', 'like', '%' . $request->search_key . '%' );
		} else if($request->job_start != NULL && $request->job_end != NULL) {
			$jobs = $jobs->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
			
		} else if($request->search_key != NULL) {
			$jobs = $jobs->where( 'title', 'like', '%' . $request->search_key . '%' );
		}
		
		$jobs = $jobs->get();
		$jobs->load( [
			'user' => function( $query ) {
				$query->get();
			},
		] );
		
		if($jobs->count() > 0) {
			return response()->myJson( 200, 'My locums.', $jobs );
		} else {
			return response()->myJson( 404, 'My locums not found.', NULL );
		}
	}*/
	
	public function allPracticeJobs( Request $request ) {
		
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
		
		$query = Job::whereHas( 'practice', function( $query ) use ( $practice ) {
			$query->where( 'id', '=', $practice->id );
		} )->with( [
			'user',
			'percentages',
		] );
		
		if($request->title) {
			$query = $query->where( function( $query ) use ( $request ) {
				$query->where( 'title', 'like', '%' . $request->title . '%' )->orWhere( 'desc', 'like', '%' . $request->title . '%' );
			} );
		}
		
		if($request->job_start != NULL && $request->job_end != NULL) {
			$query->where( 'job_start', '>=', $request->job_start )->where( 'job_end', '<=', $request->job_end );
		}
		$query = $query->paginate( 6 );
		
		if($query->count() > 0) {
			return response()->myJson( 200, 'All my jobs.', $query );
		} else {
			return response()->myJson( 404, 'Jobs not found.', NULL );
		}
	}
	
}
