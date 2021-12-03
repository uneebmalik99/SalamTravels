<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\DateChange;
use App\Models\OfflineTicket;
use App\Models\Refund;
use App\Models\Status;
use App\Models\Tabinfo;
use App\Models\User;
use App\Models\Voidtab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $data = Tabinfo::where('user_id', Auth::user()->id)->latest()->get();
       foreach($data as $record){
           $record->all_airline = Airline::find($record->airline_id);
           $record->all_booking = Booking::find($record->booking_source_id);
       }
       $email = User::find(Auth::user()->id);
       $data->customer = Customer::where('email', $email->email)->first();
        return view('customer.home')->with(['data'=>$data]);
    }
}
