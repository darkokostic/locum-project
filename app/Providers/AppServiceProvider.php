<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Response::macro( 'myJson', function( $code, $message, $entity ) {
			return Response::json( [
				'code'    => $code,
				'message' => $message,
				'entity'  => $entity,
			], $code );
		} );
	}
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}