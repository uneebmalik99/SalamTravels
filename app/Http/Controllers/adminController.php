<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use App\Models\Bank;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\OfflineTicket;
use App\Models\Refund;
use App\Models\Status;
use App\Models\Voidtab;
use App\Models\DateChange;
use App\Models\Payment;
use App\Models\Tabinfo;
use App\Models\Tabtypelink;
use App\Models\User;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        /*$data['offlineticket'] = OfflineTicket::latest()->get();
        foreach($data['offlineticket'] as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }
        $data['refund'] = Refund::latest()->get();
        foreach($data['refund'] as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }
        $data['void'] = Voidtab::latest()->get();
        foreach($data['void'] as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }
        $data['datechange'] = DateChange::latest()->get();
        foreach($data['datechange'] as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }
        $data = collect($data)->sortBy('created_at')->all();
        */
        $data = Tabinfo::latest('created_at')->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->customer = Customer::where('email', $record->user->email)->first();
        }
        return view('admin.dashboard')->with(['data' => $data]);
    }
    public function create()
    {
        return view('admin.newcust');
    }
    public function store(Request $request)
    {
        $request->validate([
            'contact' => 'required',
            'email' => 'required|unique:customer,email',
            'phone' => 'required',
            'mobile' => 'required',
            'agency_name' => 'required',
            'ledger_link' => 'required',
            'password' => 'required',
            'visiting_card' => 'required'
        ]);
        $agency_name = $request['agency_picture'];
        if ($request->hasfile('visiting_card')) {
            $image = $request->file('visiting_card');
            if ($image != null) {
                $name = Str::random(10) . $image->getClientOriginalName();
                $path = 'public/images';
                $image->move($path, $name);
            }
        }
        if ($request->hasfile('agency_picture')) {
            $image = $request->file('agency_picture');
            if ($image != null) {
                $agency_name = Str::random(10) . $image->getClientOriginalName();
                $path = 'public/images';
                $image->move($path, $agency_name);
            }
        }
        $data = [
            'contact' => $request['contact'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'mobile' => $request['mobile'],
            'agency_name' => $request['agency_name'],
            'ledger_link' => $request['ledger_link'],
            'password' => $request['password'],
            'visiting_card' => $name,
            'agency_picture' => $agency_name
        ];
        $customer = new Customer();
        $customer->create($data);
        /* $data = [
            'name'=>$request['contact'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])
        ];
        User::create($data);*/
        return back()->with(['success' => 'customer added Successfully']);
    }
    public function editCustomer($id)
    {
        $data = Customer::find($id);
        return view('admin.updateCustomer')->with(['data' => $data]);
    }
    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->contact = $request['contact'];
        $customer->phone = $request['phone'];
        $customer->agency_name = $request['agency_name'];
        $customer->mobile = $request['mobile'];
        $customer->ledger_link = $request['ledger_link'];
        $customer->update();
        return back()->with(['success' => 'customer updated successfully']);
    }
    public function custUpdate($id)
    {
        $customer = Customer::find($id);
        $customer->status = 1;
        $customer->update();
        return back()->with(['success' => 'customer status updated']);
    }
    public function custApprove($id)
    {
        $customer = Customer::find($id);
        $data = [
            'name' => $customer->contact,
            'email' => $customer->email,
            'password' => Hash::make($customer->password)
        ];
        $user = User::where('email', $customer->email)->first();
        if ($user) {
            $user->is_active = 0;
            $user->update();
        } else {
            User::create($data);
        }
        $customer->status = 2;
        $customer->update();
        return back()->with(['success' => 'customer status approved']);
    }
    public function custDisapprove($id)
    {
        $customer = Customer::find($id);
        $customer->status = 4;
        $customer->update();
        $user = User::where('email', $customer->email)->update(['is_active' => 1]);
        return back()->with(['success' => 'customer status Disapproved']);
    }
    public function custDelete($id)
    {
        $user = Customer::find($id);
        $customer = Customer::find($id)->delete();
        User::where('email', $user->email)->delete();

        return back()->with(['success' => 'customer status deleted']);
    }
    public function ticketingList()
    {
        /* $data = OfflineTicket::orderBy('id', 'DESC')->get();
        foreach($data as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }*/
        $data = Tabinfo::where('tabtype_id', 1)->latest()->get();
        foreach ($data as $record) {
            $record->customer = Customer::where('email', $record->user->email)->first();
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
        }
        return view('admin.ticketing')->with(['data' => $data]);
    }
    public function customerList()
    {
        $data = Customer::latest()->get();
        foreach ($data as $record) {
            $record->statuses = Status::find($record->status);
        }
        return view('admin.customer')->with(['data' => $data]);
    }
    public function refundList()
    {
        /*$data = Refund::orderBy('id', 'DESC')->get();
        foreach($data as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }*/
        $data = Tabinfo::where('tabtype_id', 2)->latest()->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->customer = Customer::where('email', $record->user->email)->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
        }
        return view('admin.refund')->with(['data' => $data]);
    }

    public function voidList()
    {
        /*$data = Voidtab::orderBy('id', 'DESC')->get();
        foreach($data as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }*/
        $data = Tabinfo::where('tabtype_id', 3)->latest()->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->customer = Customer::where('email', $record->user->email)->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
        }
        return view('admin.voidtab')->with(['data' => $data]);
    }

    public function dateChangeList()
    {
        /*$data = DateChange::orderBy('id', 'DESC')->get();
        foreach($data as $record){
            $record->status = Status::find($record->status);
            $record->user = User::find($record->user_id);
            $record->customer = Customer::where('email',$record->user->email)->get();
            $record->airline = Airline::where('id', $record->airline_name)->get();
            $record->booking = Booking::where('id', $record->booking_source)->get();
        }*/
        $data = Tabinfo::where('tabtype_id', 4)->latest()->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->customer = Customer::where('email', $record->user->email)->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
        }
        return view('admin.dateChange')->with(['data' => $data]);
    }
    public function paymentList()
    {
        $data = Payment::orderBy('id', 'DESC')->get();
        foreach ($data as $record) {
            $record->status = Status::find($record->status);
            $record->ticket = Tabinfo::find($record->ticket_id);
            $record->bank = Bank::where('id', $record->bank)->get();
            $record->link = Tabtypelink::where('tabtype_id', 5)->get();
        }

        return view('admin.payment')->with(['data' => $data]);
    }
    public function ticketingSubmitted($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 5;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is submitted']);
    }
    public function ticketingPosted($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 6;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is Posted']);
    }
    public function ticketingProcessing($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 1;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is Processing']);
    }
    public function ticketingCompleted($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 7;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is Completed']);
    }
    public function ticketingRejected($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 4;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is Rejected']);
    }
    public function refundSubmitted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 5;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is submitted']);
    }
    public function refundPosted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 6;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is Posted']);
    }
    public function refundProcessing($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 1;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is Processing']);
    }
    public function refundCompleted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 7;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is Completed']);
    }
    public function refundRejected($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 4;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is Rejected']);
    }
    public function voidSubmitted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 5;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is submitted']);
    }
    public function voidPosted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 6;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is Posted']);
    }
    public function voidProcessing($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 1;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is Processing']);
    }
    public function voidCompleted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 7;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is Completed']);
    }
    public function voidRejected($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 4;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is Rejected']);
    }
    public function dateChangeSubmitted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 5;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is submitted']);
    }
    public function dateChangePosted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 6;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is Posted']);
    }
    public function dateChangeProcessing($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 1;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is Processing']);
    }
    public function dateChangeCompleted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 7;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is Completed']);
    }
    public function dateChangeRejected($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 4;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is Rejected']);
    }
    public function paymentSubmitted($id)
    {
        $payment = Payment::find($id);
        $payment->status = 5;
        $payment->update();
        return back()->with(['success' => 'Payment status is submitted']);
    }
    public function paymentPosted($id)
    {
        $payment = Payment::find($id);
        $payment->status = 6;
        $payment->update();
        return back()->with(['success' => 'Payment status is Posted']);
    }
    public function paymentProcessing($id)
    {
        $payment = Payment::find($id);
        $payment->status = 1;
        $payment->update();
        return back()->with(['success' => 'Payment status is Processing']);
    }
    public function paymentCompleted($id)
    {
        $payment = Payment::find($id);
        $payment->status = 7;
        $payment->update();
        return back()->with(['success' => 'Payment status is Completed']);
    }
    public function paymentRejected($id)
    {
        $payment = Payment::find($id);
        $payment->status = 4;
        $payment->update();
        return back()->with(['success' => 'Payment status is Rejected']);
    }
    public function adminTicketingStatus(Request $request, $id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->admin_remarks = $request['admin_remarks'];
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->update();
        echo 'admin Ticketing remarks added successfully';
    }
    public function adminRefundStatus(Request $request, $id)
    {
        /*$refund = Refund::find($id);
        $refund->admin_remarks = $request['admin_remarks'];
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->update();
        echo 'admin refund remarks added successfully';
    }
    public function adminVoidStatus(Request $request, $id)
    {
        /*$void = Voidtab::find($id);
        $void->admin_remarks = $request['admin_remarks'];
        $void->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->update();
        echo 'admin void remarks added successfully';
    }
    public function adminDateChangeStatus(Request $request, $id)
    {
        /*$datechange = DateChange::find($id);
        $datechange->admin_remarks = $request['admin_remarks'];
        $datechange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->update();
        echo 'admin datechange remarks added successfully';
    }
    public function adminPaymentStatus(Request $request, $id)
    {
        /*$payment = Payment::find($id);
        $payment->admin_remarks = $request['admin_remarks'];
        $payment->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->update();
        echo 'admin payment remarks added successfully';
    }
    public function add_airline()
    {
        $data = Airline::all();
        return view('admin.add_airline')->with(['data' => $data]);
    }
    public function airline_name(Request $request)
    {
        $request->validate([
            'airline_name' => 'required|unique:airline,airline_name'
        ]);
        $airline = new Airline();
        $airline->airline_name = $request['airline_name'];
        $airline->save();
        return back()->with(['success' => 'airline name added successfully']);
    }
    public function booking_source()
    {
        $data = Booking::all();
        return view('admin.booking_source')->with(['data' => $data]);
    }
    public function add_booking_source(Request $request)
    {
        $request->validate([
            'booking_source' => 'required|unique:bookings,booking_source'
        ]);
        $booking = new Booking();
        $booking->booking_source = $request['booking_source'];
        $booking->save();
        return back()->with(['success' => 'booking source added successfully']);
    }
    public function bank()
    {
        $data = Bank::all();
        return view('admin.bank')->with(['data' => $data]);
    }
    public function add_bank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|unique:banks,bank_name'
        ]);
        $bank = new Bank();
        $bank->bank_name = $request['bank_name'];
        $bank->save();
        return back()->with(['success' => 'Bank Name added successfully']);
    }
    public function delete_airline($id)
    {
        Airline::where('id', $id)->delete();
        return back()->with(['success' => 'Airline name deleted successfully']);
    }
    public function delete_bank($id)
    {
        Bank::where('id', $id)->delete();
        return back()->with(['success' => 'Bank name deleted Successfully']);
    }
    public function delete_booking_source($id)
    {
        Booking::where('id', $id)->delete();
        return back()->with(['success' => 'Bank name deleted Successfully']);
    }
    public function delete_record($id)
    {
        Tabinfo::where('id', $id)->delete();
        return back()->with(['success' => 'Record Deleted Successfully']);
    }
    public function enableAirline($id)
    {
        $airline = Airline::find($id);
        $airline->enable = 1;
        $airline->update();
        return back()->with(['success' => 'Airline Enabled']);
    }
    public function disableAirline($id)
    {
        $airline = Airline::find($id);
        $airline->enable = 0;
        $airline->update();
        return back()->with(['success' => 'Airline Disabled']);
    }
    public function enableBooking($id)
    {
        $Booking = Booking::find($id);
        $Booking->enable = 1;
        $Booking->update();
        return back()->with(['success' => 'Booking Enabled']);
    }
    public function disableBooking($id)
    {
        $Booking = Booking::find($id);
        $Booking->enable = 0;
        $Booking->update();
        return back()->with(['success' => 'Booking Disabled']);
    }
    public function enableBank($id)
    {
        $Bank = Bank::find($id);
        $Bank->enable = 1;
        $Bank->update();
        return back()->with(['success' => 'Bank Enabled']);
    }
    public function disableBank($id)
    {
        $Bank = Bank::find($id);
        $Bank->enable = 0;
        $Bank->update();
        return back()->with(['success' => 'Bank Disabled']);
    }
}
