<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passenger;
use App\Models\Tabinfo;
use App\Models\Customer;
use App\Models\PaymentHistory;
use App\Models\Price;
use App\Models\Vendor;

class PassengerController extends Controller
{
    //
    public function passengerUpdate(Request $request, $id)
    {

        $passenger = $request->data['passenger'][0];
        if (empty($passenger)) {
            return response()->json(
                [
                    'data' => 'Not Updated',
                    'status' => 501
                ]
            );
        }
        $passengerID = $passenger['id'];
        $tabinfo = Tabinfo::find($id);
        $customer = Customer::where('email', $tabinfo->user->email)->first();
        $cust_balance = $customer->temp_balance;
        $cust_credit_limit = $customer->credit_limit;
        $passengerdata = [
            'type' => $passenger['type'],
            'title' => $passenger['title'],
            'ticket' => $passenger['ticket'],
            'passenger_name' => $passenger['passenger_name'],
            'remarks' => $passenger['remarks'],
            'processed_by' => Auth()->user()->id,
            'tabinfo_id' => $id
        ];
        $price = [
            'value' => $passenger['p_value'],
        ];
        $vendor = [
            'value' => $passenger['v_value'],
            'vendor_id'  => $passenger['vendor_id']
        ];

        $is_passenger_updated = Passenger::where('id', $passengerID)->update($passengerdata);
        $is_price_updated = Price::where('passenger_id', $passengerID)->update($price);
        $is_vendor_updated = Vendor::where('passenger_id', $passengerID)->update($vendor);
        if (($tabinfo->tabtype_id == 2 || $tabinfo->tabtype_id == 3)) {
            $passengerHistory = [
                'credit' => $passenger['p_value'],
                'debit' => null,
                'balance' => (int)($cust_balance + (int)$passenger['p_value']),
                'user_id' => $tabinfo->user_id,
            ];

            $is_customer_updated = Customer::where('email', $tabinfo->user->email)->update(['temp_balance' => $passengerHistory['balance']]);

            $is_paymenthistory_updated = PaymentHistory::where('passenger_id', $passengerID)->update($passengerHistory);
        } else {
            $passengerHistory = [
                'credit' => null,
                'debit' => $passenger['p_value'],
                'balance' => (int)($cust_balance - (int)$passenger['p_value']),
                'user_id' => $tabinfo->user_id,
            ];

            $is_customer_updated = Customer::where('email', $tabinfo->user->email)->update(['temp_balance' => $passengerHistory['balance']]);

            $is_paymenthistory_updated = PaymentHistory::where('passenger_id', $passengerID)->update($passengerHistory);
        }
        if ($is_paymenthistory_updated && $is_price_updated && $is_passenger_updated && $is_vendor_updated) {
            return response()->json([
                'message' => 'Data updated successfully',
                'status' => 200
            ]);
        }
    }
    public function customerTabStatusPosted(Request $request)
    {
        $customer_tabs = Tabinfo::with('user', 'passenger', 'ledger', 'tabtype')
            ->where('status_id', '=', 6)
            ->where('user_id', '=', auth()->user()->id)
            ->get();
        $passenger_no = $customer_tabs->map(function ($customer_tab, $key) {
            return  [
                'payment_histories' => $customer_tab->passenger->map(function ($passenger) {
                    return [
                        'credit' => ($passenger->paymentHistory->credit) ?? NULL,
                        'debit' => ($passenger->paymentHistory->debit) ?? NULL,
                        'balance' => ($passenger->paymentHistory->balance) ?? NULL,
                        'passenger' => $passenger->passenger_name,
                        'passenger_id'  => $passenger->id
                    ];
                }),
            ];
        });

        $temp = 0;
        foreach ($passenger_no as  $payment_history) {
            foreach ($payment_history['payment_histories'] as $ph) {
                if ($ph['credit'] != 0) {
                    $temp += $ph['credit'];
                }
                if ($ph['debit'] != 0) {
                    $temp -= $ph['debit'];
                }
            }
        }
        dump($temp);

        $customer_tabs = $customer_tabs->map(function ($customer_tab, $key) {
            return [
                'passengers' => $customer_tab->passenger->map(function ($passenger) {
                    return [
                        'credit' => ($passenger->paymentHistory->credit) ?? NULL,
                        'debit' => ($passenger->paymentHistory->debit) ?? NULL,
                        'balance' => ($passenger->paymentHistory->balance) ?? NULL,
                        'passenger' => $passenger->passenger_name,
                        'passenger_id' => $passenger->id
                    ];
                }),
                //
                'user' => $customer_tab->user->email,
                'ledger' => $customer_tab->ledger,
                'id' => $customer_tab->id,
                'tab_type' => $customer_tab->tabtype->tab_name,
                'airline' => $customer_tab->airline->airline_name,
            ];
        });

        // dump($passenger_no);
        // dump($customer_tabs);
    }
}
