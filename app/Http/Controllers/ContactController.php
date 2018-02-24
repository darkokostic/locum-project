<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendContactForm(Request $request) {
    	try {
	    	Mail::to([
				$request->user['mail'],
				'nikola.gavric94@gmail.com',
				'locum.admin@locumod.com',
			])->send(new ContactMail($request->user['message']));

			return response()->myJson( 200, 'Mail successfully sent.', NULL );
		} catch(Exception $e) {
			return response()->myJson( 500, $e->getMessage(), NULL );
		}
    }
}
