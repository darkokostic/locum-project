<?php

namespace App\Http\Controllers;

use App\Corporation;
use App\CorporationInvoice;
use App\Http\Requests\Corporation\CreateCorporationRequest;
use App\Mail\CorporationMail;
use App\Practice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class CorporationController extends Controller
{
    public function loginCorporation(Request $request){
        $user = User::where('email',$request->email)->where('role','ROLE_ADMIN')->first();

        $corporation = Corporation::where('email',$request->email)->first();
        if ($user && Hash::check($request->password,$user->getPassword())){
            Session::put('user',$user );
            return redirect('corporation/home');
        }else if($corporation && Hash::check($request->password,$corporation->getPassword())){
            Session::put('user',$corporation );
            return redirect('corporation/home');
        }
        return redirect('login');


    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect('login');

    }
    public function getCorporation(){
        if (!session('user')) {
            return redirect('login');
        } else if (session('user')->role) {
            $corporations = Corporation::all();
            $practices = Practice::where('corporation_id',null)->get();
            return view('corporations')->with('corporations', $corporations)->with('freePractices', $practices);
        } else {
            $corporation = Corporation::find(session('user')->id);
            return view('corporations')->with('practices', $corporation->practices);
        }

    }
    public function store (CreateCorporationRequest $request){
        $corporation = new Corporation();
        $corporation->fill($request->all());
        $corporation->password = str_replace(" ","",$request->name)."123";
        if($corporation->save()){

            Mail::to($corporation->email)->send(new CorporationMail($corporation));
        }

        return redirect('corporation/home');

    }
    public function edit(Request $request){
        $corporation = Corporation::find(session('user')->id);
        if ($corporation && Hash::check($request->current,$corporation->getPassword())){
            $corporation->password = $request->new;
            $corporation->save();
            return redirect('corporation/home');
        }
        //Add error
        return redirect()->back()->withInput();


    }
    public function getLinkCorporation(){
        if (!session('user')){
            return redirect('login');
        }else if (session('user')->role){
            $practices = Practice::where('corporation_id',null)->get();
            $corporations = Corporation::all();
            return view('link_corporation')->with('practices',$practices)->with('corporations',$corporations);

        }else{
            return redirect('login');
        }

    }
    public function linkCorporation(Request $request){
        if (!session('user')){
            return redirect('login');
        }else if (session('user')->role){
            $practice = Practice::find($request->practice);
            $practice->corporation_id = $request->corporation;
            $practice->save();
            $practices = Practice::where('corporation_id',null)->get();
            $corporations = Corporation::all();
            return redirect('corporation/home');

        }else{
            return redirect('login');
        }


    }
    public function getCorporationInvoice(){
        $invoices = CorporationInvoice::where('corporation_id',session('user')->id)->get();
        return view('corporation_invoice')->with('invoices',$invoices);
    }


}
