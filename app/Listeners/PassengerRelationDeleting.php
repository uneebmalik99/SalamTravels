<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PassengerDeleted;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Customer;

class PassengerRelationDeleting
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PassengerDeleted $e)
    {
        //
        $passenger = $e->passenger;

        //$customer  = DB::table('customer')->where('email', $passenger->tabinfo->user->email)->get();
        $customer = Customer::where('email', $passenger->tabinfo->user->email)->first();

        if ($passenger->tabinfo->status_id == 6) {


            $customer->balance = (int)$customer->balance + (int)$passenger->price->value;

            $customer->save();
        }

        $passenger->price()->delete();
        $passenger->vendor()->delete();
        $passenger->paymentHistory()->delete();
        return true;
    }
}
