<?php
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::group(['prefix' => 'v1'], function () {
    Route::get('token', function () {
        $user = [
            'email' => 'locum@dev.com',
            'password' => 'locum',
        ];
        $token = JWTAuth::attempt($user);

        return $token;

    });
	Route::get('token/check', 'UserController@tokenCheck');
    Route::post('locum/login', 'UserController@authenticate');
    Route::post('locum/{locum}', 'UserController@update');
    Route::resource('locum', 'UserController', [
        'except' => [
            'index',
            'create',
            'destroy',
			'update',
        ],
    ]);

    Route::post('practice/my_jobs', 'PracticeController@allPracticeJobs');
	Route::post('practice/login', 'PracticeController@authenticate');

    Route::get('practice/dashboard', 'PracticeController@dashboard');
    Route::get('practice/nearestLocum', 'PracticeController@nearestLocum');
//    Route::post('practice/myLocum', 'PracticeController@myLocum');
//    Route::post('practice/search/myLocum', 'PracticeController@myLocumSearch');
  
	Route::post('practice/{practice}', 'PracticeController@update');
	
    Route::resource('practice', 'PracticeController', [
        'except' => [
            'index',
            'create',
            'edit',
			'update',
        ],
    ]);
	
	Route::post('percentages', 'PercentagesController@update');
	Route::get('percentages/{id}', 'PercentagesController@approveAmount');
	Route::get('percentages/decline/{id}', 'PercentagesController@declineAmount');
	
	Route::get('job/job-with-my-applications/{id}', 'JobController@jobWithMyApplications');
    Route::post('job/search-by-city', 'JobController@searchByCity');
    Route::post('job/search-by-practice-name', 'JobController@searchByPracticeName');
    Route::get('job/completed', 'JobController@getCompletedJobs');
    Route::get('job/with-applications/{id}', 'JobController@jobWithAllApplications');
    Route::get('job/vacancies', 'JobController@vacancies');
    Route::get('job/locumVacancies', 'JobController@locumVacancies');
    Route::get('job/practiceVacancies', 'JobController@practiceVacancies');
    Route::get('pay-pal-job/{id}/{userID}','JobController@payPalUpdate');
    Route::resource('job', 'JobController', [
        'except' => [
            'create',
            'edit',
        ],
    ]);
    Route::resource('application', 'ApplicationController', [
        'except' => [
            'create',
            'edit',
        ],
    ]);
    // Route::resource('payment', 'PaymentsController', [
    //     'except' => [
    //         'create',
    //         'edit',
    //     ],
    // ]);
    Route::get('calendar/locum/{locum}', function (App\User $locum) {
        return App\Calendar::where('user_id', '=', $locum->id)->with('user.jobs')->get();
    });
    Route::post('calendar/locum/filter', 'CalendarController@locumFilter');
    Route::post('calendar/practice/filter', 'CalendarController@practiceFilter');
    Route::resource('calendar', 'CalendarController', [
        'except' => [
            'create',
            'edit',
        ],
    ]);
    
    Route::get('news/lastSix', 'NewsController@lastSix');
    Route::get('news/locum/last_six','NewsController@lastSixLocum');
    Route::get('news/practice/last_six','NewsController@lastSixPractice');
    Route::resource('news', 'NewsController', [
        'except' => [
            'create',
            'edit',
        ],
    ]);
    Route::post('news/avatar/{id}','NewsController@updateAvatar');
    Route::post('feedback/create/{id}', 'FeedbackController@create');
    Route::get('feedback/locum/show/{id}', 'FeedbackController@showLocumFeedback');
    Route::get('feedback/practice/show/{id}', 'FeedbackController@showPracticeFeedback');

    Route::post('user/invoice', 'InvoiceController@getLocumInvoices');
    Route::post('user/invoice/{invoice_id}', 'InvoiceController@confirmPayment');

    Route::post('mail/send', 'PracticeController@send');
    Route::post('mail/contract/send', 'PracticeController@sendContracts');
    Route::post('storage/invoice/', 'FilesController@signer')->where('filename', '^[^/]+$');
	
    Route::get('search/locum/{name}' , 'LiveSearchController@getLocumName');
    Route::get('search/practice/{name}' , 'LiveSearchController@getPracticeName');
    
    Route::get('app/{user_id}' , 'ApplicationController@getByUserId');
    
    Route::post('search/jobs/booked','JobController@bookedJobs');
    Route::post('search/jobs/completed','JobController@completedJobs');
    Route::post('search/jobs/findJob','JobController@findJob');
    Route::post('session/practice','PracticeController@practiceSession');
	Route::post('invoice/practice', 'InvoiceController@getPracticeInvoices');

    /**
     * Contact Form
     */
    Route::post('contact/mail', 'ContactController@sendContactForm');
});