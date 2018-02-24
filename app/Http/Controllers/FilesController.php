<?php

namespace App\Http\Controllers;

use App\Http\Requests\Invoice\GetInvoicePDF;
use Carbon\Carbon;
use Spatie\UrlSigner\Laravel\UrlSignerFacade;

class FilesController extends Controller {
	
	/**
	 * get file url with time limit for practices and locums
	 *
	 * @param \App\Http\Requests\Invoice\GetInvoicePDF $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function signer( GetInvoicePDF $request ) {
		
		$filename = $request->id . '_invoices.pdf';
		$url      = UrlSignerFacade::sign( url( 'file/' . $filename ), Carbon::now()->addMinutes( 5 ) );
		
		return response()->json( [
			'message' => 'Successfully retrived file url.',
			'entity'  => $url,
			'code'    => 200,
		], 200 );
	}
	
	/**
	 * get file url with time limit for corporation
	 *
	 * @param \App\Http\Requests\Invoice\GetInvoicePDF $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function signerCorporation( GetInvoicePDF $request ) {
		
		$filename = 'corporation/' . $request->id . '_invoices.pdf';
		$url      = UrlSignerFacade::sign( url( 'file/' . $filename ), Carbon::now()->addMinutes( 5 ) );
		
		return response()->json( [
			'message' => 'Successfully retrived file url.',
			'entity'  => $url,
			'code'    => 200,
		], 200 );
	}
}
