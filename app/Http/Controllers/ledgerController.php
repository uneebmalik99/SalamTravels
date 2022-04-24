<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ledger;
use App\Models\Passenger;
use App\Models\Price;
use App\Models\Tabinfo;
use App\Models\Tabtype;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ledgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::find(Auth::user()->id);
        $customer = Customer::where('email', $data->email)->get();
        return view('customer.ledger')->with(['data' => $customer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showLedger()
    {
        $tabinfo = Tabinfo::where('user_id', Auth::user()->id)->latest()->get();
        foreach ($tabinfo as $info) {
            $info->ledger = Ledger::where('tabinfo_id', $info->id)->first();
            if ($info->ledger) {
                $ledger = Ledger::find($info->ledger->id);
                $info->ticket_type = TicketType::find($ledger->ticketType_id);
            }

            // dd($info->ticket_type);
            $info->passenger = Passenger::where('tabinfo_id', $info->id)->first();
            if ($info->passenger) {
                $info->balance = Price::where('passenger_id', $info->passenger->id)->first();
            } else {
                $info->balance = NULL;
            }
        }
        $data = User::find(Auth::user()->id);
        $customer = Customer::where('email', $data->email)->first();
        // $ledger = Ledger::whereIn('tabinfo_id', $tabinfo->id)->get();
        return view('customer.new_ledger')->with(['data' => $tabinfo, 'customer' => $customer]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
