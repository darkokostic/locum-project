<?php

namespace App\Http\Controllers;

use TomLingham\Searchy\Facades\Searchy;

class LiveSearchController extends Controller {
	
	/**
	 * Live search by practice name
	 *
	 * @param $name
	 * @return mixed
	 */
	public function getPracticeName( $name ) {
		$practice = Searchy::search( 'practices' )->fields( 'practice_name' )->query( $name )->select( 'practice_name' )->get();
		
		return response()->myJson( 200, NULL, $practice );
	}
	
	/**
	 * Live search by locum name
	 *
	 * @param $name
	 * @return mixed
	 */
	public function getLocumName( $name ) {
		$users = Searchy::search( 'users' )->fields( 'name' )->query( $name )->select( 'name' )->get();
		
		return response()->myJson( 200, NULL, $users );
	}
}
