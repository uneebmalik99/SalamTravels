<?php

namespace App\Http\Controllers;

use App\Exports\LedgerExport;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Ledger;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\PaymentHistory;
use App\Models\Price;
use App\Models\Tabinfo;
use App\Models\Tabtype;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Vendor;
use PDF;

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
        $tabinfo = Tabinfo::where(['user_id' => Auth::user()->id, 'status_id' => 6])->get();
        foreach ($tabinfo as $info) {
            if ($info->tabtype_id == 5) {
                $info->payment = Payment::where('tabinfo_id', $info->id)->first();
                if ($info->payment) {
                    $info->payment->payment_history = PaymentHistory::where('payment_id', $info->payment->id)->first();
                    $info->payment->bank = Bank::find($info->payment->bank);
                }
            } else {
                $info->ledger = Ledger::where('tabinfo_id', $info->id)->first();
                if ($info->ledger) {
                    $ledger = Ledger::find($info->ledger->id);
                    $info->ticket_type = TicketType::find($ledger->ticketType_id);
                }


                // dd($info->ticket_type);
                $info->passengers = Passenger::where('tabinfo_id', $info->id)->get();
                if ($info->passengers) {
                    foreach ($info->passengers as $passenger) {
                        $passenger->payment_history = PaymentHistory::where('passenger_id', $passenger->id)->first();
                        $passenger->balance = Price::where('passenger_id', $passenger->id)->first();
                        if ($info->tabtype_id === 2) {
                            $info->credit = $passenger->balance->value;
                            $info->debit = '';
                        } else {
                            $info->debit = $passenger->balance->value;
                            $info->credit = '';
                        }
                    }
                } else {
                    $info->balance = NULL;
                }
            }
        }
        $data = User::find(Auth::user()->id);
        $customer = Customer::where('email', $data->email)->first();
        // dd($tabinfo[0]->passenger->payment_history);
        // $ledger = Ledger::whereIn('tabinfo_id', $tabinfo->id)->get();
        // foreach ($tabinfo as $info) {
        //     if ($info->passenger->payment_history) {
        //         print_r($info->passenger->payment_history->credit);
        //     }
        // }
        // dd($tabinfo);
        return view('customer.new_ledger')->with(['data' => $tabinfo, 'customer' => $customer]);
    }
    public function showPdf()
    {
        $tabinfo = Tabinfo::where(['user_id' => Auth::user()->id, 'status_id' => 6])->get();
        foreach ($tabinfo as $info) {
            if ($info->tabtype_id == 5) {
                $info->payment = Payment::where('tabinfo_id', $info->id)->first();
                if ($info->payment) {
                    $info->payment->payment_history = PaymentHistory::where('payment_id', $info->payment->id)->first();
                    $info->payment->bank = Bank::find($info->payment->bank);
                }
            } else {
                $info->ledger = Ledger::where('tabinfo_id', $info->id)->first();
                if ($info->ledger) {
                    $ledger = Ledger::find($info->ledger->id);
                    $info->ticket_type = TicketType::find($ledger->ticketType_id);
                }


                // dd($info->ticket_type);
                $info->passengers = Passenger::where('tabinfo_id', $info->id)->get();
                if ($info->passengers) {
                    foreach ($info->passengers as $passenger) {
                        $passenger->payment_history = PaymentHistory::where('passenger_id', $passenger->id)->first();
                        $passenger->balance = Price::where('passenger_id', $passenger->id)->first();
                        if ($info->tabtype_id === 2) {
                            $info->credit = $passenger->balance->value;
                            $info->debit = '';
                        } else {
                            $info->debit = $passenger->balance->value;
                            $info->credit = '';
                        }
                    }
                } else {
                    $info->balance = NULL;
                }
            }
        }
        $data = User::find(Auth::user()->id);
        $customer = Customer::where('email', $data->email)->first();
        // dd($tabinfo[0]->passenger->payment_history);
        // $ledger = Ledger::whereIn('tabinfo_id', $tabinfo->id)->get();
        // foreach ($tabinfo as $info) {
        //     if ($info->passenger->payment_history) {
        //         print_r($info->passenger->payment_history->credit);
        //     }
        // }
        // dd($tabinfo);
        $customPaper = array(0, 0, 1567.00, 1283.80);
        $pdf = PDF::loadView('customer.showPdf', ['data' => $tabinfo, 'customer' => $customer])->setPaper($customPaper, 'landscape');
      // return $pdf->download('ledger.pdf');
     return view('customer.showPdf')->with(['data' => $tabinfo, 'customer' => $customer]);
    }

    public function ExportLedger()
    {
        return Excel::download(new LedgerExport, 'Ledger.xlsx');
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
    public function showAdminPdf(){
        $tabinfo = Tabinfo::where(['status_id' => 6])->get();
        foreach ($tabinfo as $info) {
            $user = User::withTrashed()->find($info->user_id);
            $info->customer = Customer::withTrashed()->where('email', $user->email)->first();
            if ($info->tabtype_id == 5) {
                $info->payment = Payment::where('tabinfo_id', $info->id)->first();
                if ($info->payment) {
                    $info->payment->payment_history = PaymentHistory::where('payment_id', $info->payment->id)->first();
                    $info->payment->bank = Bank::find($info->payment->bank);
                }
            } else {
                $info->ledger = Ledger::where('tabinfo_id', $info->id)->first();
                if ($info->ledger) {
                    $ledger = Ledger::find($info->ledger->id);
                    $info->ticket_type = TicketType::find($ledger->ticketType_id);
                }


                // dd($info->ticket_type);
                $info->passengers = Passenger::where('tabinfo_id', $info->id)->get();
                if ($info->passengers) {
                    foreach ($info->passengers as $passenger) {
                        $passenger->payment_history = PaymentHistory::where('passenger_id', $passenger->id)->first();
                        $passenger->balance = Price::where('passenger_id', $passenger->id)->first();
                        if ($info->tabtype_id === 2) {
                            $info->credit = $passenger->balance->value;
                            $info->debit = '';
                        } else {
                            $info->debit = $passenger->balance->value;
                            $info->credit = '';
                        }
                        $passenger->vendor = Vendor::where('passenger_id', $passenger->id)->first();
                    }
                } else {
                    $info->balance = NULL;
                }
            }
        }
        $customPaper = array(0, 0, 1567.00, 1283.80);
        $pdf = PDF::loadView('admin.showPdf', ['data' => $tabinfo])->setPaper($customPaper, 'landscape');
        return view('admin.showPdf')->with(['data' => $tabinfo,]);


    }
    public function exportAdminLedger(){
        return Excel::download(new LedgerExport, 'Ledger.xlsx');

    }
}
