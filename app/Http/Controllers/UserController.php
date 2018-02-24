<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\FileHandler;
use App\Http\Requests\User\AuthUserRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Job;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller {
	/**
	 * Default constructor
	 */
	public function __construct() {
		$this->middleware( 'jwt.auth', [
			'except' => [
				'authenticate',
				'store',
				'tokenCheck',
				'show',
			],
		] );
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
	
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateUserRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( CreateUserRequest $request ) {
		
		try {
			$payload = $request->only( 'email', 'password' );
			$entity  = User::where( 'email', '=', $payload['email'] )->where( 'password', '=', bcrypt( $payload['password'] ) )->first();
			if(!$found = $entity) {
				$entity = new User;
				$entity->fill( $request->all() );
				$entity->password = bcrypt( $request->password );
				if($entity->save()) {
					$token = JWTAuth::attempt( $payload );
					if($token) {
						$entity->token = $token;
						$message       = 'Successfully authorized.';
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
	 * @param $id
	 * @return
	 */
	public function show( $id ) {
		$user = User::findOrFail( $id );
		
		return response()->json( [
			'message' => 'Successfully retrieved locum.',
			'entity'  => $user,
			'code'    => 200,
		], 200 );
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param \App\Http\Requests\User\UpdateUserRequest|\Illuminate\Http\Request $request
	 * @param \App\User                                                          $locum
	 * @return \Illuminate\Http\Response
	 * @internal param \App\User $user
	 * @internal param int $id
	 */
	public function update( UpdateUserRequest $request, User $locum ) {
		$fileHandler = new FileHandler;
		$file        = $request->file( 'files' );
		$basePath    = Constant::absolutePath( "LOCUM_AVATAR_PATH" );
		if($file) {
            $image = Image::make($file->getRealPath());
            $image->fit(200,200, function ($constraint) {
                $constraint->upsize();
            });
            $name = md5( Carbon::now() ) . '.' . $file->getClientOriginalExtension();
            $image->save($basePath . $name);
            if($locum->getOriginal( 'avatar' ) != Constant::LOCUM_DEFAULT_AVATAR_PATH) {
				$fileHandler->removeFile( public_path() . $locum->avatar );

			}
            $locum->avatar =Constant::LOCUM_AVATAR_PATH .$name;
		}
		$locum->fill( $request->all() );
		$locum->save();
		
		return response()->json( [
			'message' => 'Successfully edited locum',
			'entity'  => $locum,
			'code'    => 200,
		], 200 );
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}
	
	/**
	 * Authenticate user
	 *
	 * @param  \App\Http\Requests\User\AuthUserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authenticate( AuthUserRequest $request ) {
		
		try {
			$payload = $request->only( 'email', 'password' );
			$token   = JWTAuth::attempt( $payload );
			
			if(!$token) {
				throw new \Exception( 'No matching credentials found.' );
			} else if(User::where( 'email', '=', $payload['email'] )->first()->role == Constant::ROLE_ADMIN) {
				throw new \Exception( 'No matching credentials found.' );
			} else {
				$entity        = User::where( 'email', '=', $payload['email'] )->first();
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
	
	public function tokenCheck() {
		try {
			$user = JWTAuth::parseToken()->authenticate();
			$user->load( 'practice' );
			
			if(!$user) {
				return response()->json( ['user_not_found'], 404 );
			} else {
				return response()->json( [
					'message' => 'Successfully retrieved logged in user.',
					'entity'  => $user,
					'code'    => 200,
				] );
			}
			
		} catch(TokenExpiredException $e) {
			return response()->json( [
				'message' => 'token_expired',
				'entity'  => NULL,
				'code'    => 401,
			] );
		} catch(TokenInvalidException $e) {
			return response()->json( [
				'message' => 'token_invalid',
				'entity'  => NULL,
				'code'    => 401,
			] );
			
		} catch(JWTException $e) {
			return response()->json( [
				'message' => 'token_absent',
				'entity'  => NULL,
				'code'    => 401,
			] );
			
		}
		
		// the token is valid and we have found the user via the sub claim
		return response()->json( compact( 'user' ) );
	}
	
}
