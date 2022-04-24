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
use App\Models\Bank;
use App\Models\Ledger;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Price;
use App\Models\SourceVendor;
use App\Models\Tabtypelink;
use App\Models\TicketType;
use App\Models\Vendor;
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
        $data = Tabinfo::where('user_id', Auth::user()->id)->latest('date')->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking = Booking::find($record->booking_source_id);
            $record->payment = Payment::find($record->amount);
            
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        $email = User::find(Auth::user()->id);
        $data->customer = Customer::where('email', $email->email)->first();
        return view('customer.home')->with(['data' => $data]);
    }
    public function showDetailPage($id)
    {
        $airline = Airline::all();
        $booking = Booking::all();
        $tabinfo = Tabinfo::find($id);
        $customer = Customer::where('email', $tabinfo->user->email)->first();
        $passenger = Passenger::where('tabinfo_id', $tabinfo->id)->first();
        $ledger = Ledger::where('tabinfo_id', $tabinfo->id)->first();
        $ticket_type = TicketType::all();
        $links = Tabtypelink::where('tabtype_id', $tabinfo->tabtype_id)->get();
        if ($passenger && isset($passenger)) {
            $passenger->price = Price::where('passenger_id', $passenger->id)->first();
            $passenger->vendor = Vendor::where('passenger_id', $passenger->id)->first();
            $passenger->source = SourceVendor::find($passenger->vendor->vendor_id);
        }
        return view('customer.details')->with(['airline' => $airline, 'booking' => $booking, 'links' => $links, 'tabinfo' => $tabinfo, 'customer' => $customer, 'passenger' => $passenger, 'ledger' => $ledger, 'ticket_type' => $ticket_type]);
    }
}
