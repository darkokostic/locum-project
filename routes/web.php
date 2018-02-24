<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Helpers\Constant;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('pay-pal/payment', array(
    'as' => 'payment',
    'uses' => 'PayPalController@postPayment',
));
// this is after make the payment, PayPal redirect back to your site
Route::get('pay-pal/payment/status/done/{job_id}/{user_id}/{logedIn}', array(
    'as' => 'payment.status.done',
    'uses' => 'JobController@getDone',
));
Route::get('pay-pal/payment/status/cancled', array(
    'as' => 'payment.status.cancled',
    'uses' => 'PayPalController@getCancel',
));
Route::post('storage/invoice/', 'FilesController@signerCorporation')->where('filename', '^[^/]+$');


Route::get('paypal', 'InvoiceController@create');

Route::get('login', function () {
    if (session('user')) {
        return redirect('corporation/home');
    }
    return view('auth/login');
})->name('login');
Route::post('corporation/login', 'CorporationController@loginCorporation')->name('corporation/login');
Route::post('corporation/logout', 'CorporationController@logout')->name('corporation/logout');
Route::get('corporation/home', 'CorporationController@getCorporation')->name('corporation/home');
Route::get('a', 'CorporationController@getCorporation');
Route::get('corporation/create', function () {
    return view('create_corporation');
})->name('create_corporation');
Route::get('corporation/link', 'CorporationController@getLinkCorporation')->name('link_corporation');
Route::post('corporation/link', 'CorporationController@linkCorporation')->name('corporation/link');
Route::post('corporation/store', 'CorporationController@store')->name('corporation/store');
Route::get('corporation/password', function () {
    return view('password');
})->name('corporation/password');
Route::post('corporation/password/edit', 'CorporationController@edit')->name('corporation/password/edit');
Route::get('file/{filename}', ['middleware' => ['signedurl'], function ($filename) {
	
	if(Illuminate\Support\Facades\File::exists(storage_path('app/' . $filename))){
    return Response::make(file_get_contents(storage_path('app/' . $filename)), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; ' . $filename,
    ]);
	}else{
		return response()->myJson( 404, 'No invoice', NULL);
		
	}
}]);
Route::get('file/corporation/{filename}',  function ($filename) {
	$invoice_id = str_replace('_invoices.pdf','',$filename);
	$corporation = \App\CorporationInvoice::where('invoice_id',$invoice_id)->first();
	if(session('user') && $corporation){
		if((session( 'user' )->id != $corporation->corporation_id)) {
			return redirect( 'corporation/home' );
		}
		return Response::make(file_get_contents(storage_path('app/corporation/' . $filename)), 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' => 'inline; ' . $filename,
		]);
	}
 
	return redirect( 'corporation/home' );
	
});

Route::get('news_list', function () {
    if (session('user') && isset(session('user')->role) && session('user')->role == Constant::ROLE_ADMIN) {
        return view('news_list');
    }
    return redirect('login');
})->name('news_list');
Route::get('create_news', function () {
    if (session('user') && isset(session('user')->role) && session('user')->role == Constant::ROLE_ADMIN) {
        return view('create_news');
    }
    return redirect('login');
})->name('create_news');

Route::get('corporation_invoices','CorporationController@getCorporationInvoice')->name('corporation_invoices');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
