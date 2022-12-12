<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Payment as ModelsPayment;
use App\Models\Status;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class paymentController extends Controller
{
    public function index()
    {
        $data['payment'] = ModelsPayment::where('user_id', Auth::user()->id)->latest('payment_date')->get();
        foreach ($data['payment'] as $record) {
            $record->status = Status::find($record->status);
            $record->bank = Bank::where('id', $record->bank)->get();
            $record->processed_by = User::find($record->processed_by);
        }
        $user = User::find(Auth::user()->id);

        $data['customer'] = Customer::where('email', $user->email)->get();
        return view('customer.payment')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $data['customer'] = Customer::where('email', $user->email)->get();
        $data['bank'] = Bank::where('enable', 1)->get();
        return view('customer.addPayment')->with(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'bank' => 'required',
            'payment_date' => 'required'
        ]);
        $name = null;
        if ($request->hasfile('payment_proof')) {
            $image = $request->file('payment_proof');
            if ($image != null) {
                $name = Str::random(5) . $image->getClientOriginalName();
                $image->move('public/images/', $name);
                $request['payment_proof'] = $name;
            }
        }
        $data = [
            'amount' => $request['amount'],
            'bank' => $request['bank'],
            'payment_date' => $request['payment_date'],
            'payment_proof' => $name,
            'remarks' => $request['remarks'],
            'user_id' => Auth::user()->id
        ];

        $payment = new ModelsPayment();
        $payment->create($data);
        return back()->with(['success' => 'Payment Added Successfully']);
    }
    public function deletePayment($id)
    {
        $payment = ModelsPayment::find($id);
        if ($payment) {
            $payment->delete();
        }
        return back()->with(['success' => 'Payment deleted successfully']);
    }
}
