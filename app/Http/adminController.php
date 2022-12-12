<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveLedgerRequest;
use App\Http\Requests\SavePassengerInfoRequest;
use App\Models\Airline;
use App\Models\Bank;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\OfflineTicket;
use App\Models\Refund;
use App\Models\Status;
use App\Models\Voidtab;
use App\Models\DateChange;
use App\Models\Ledger;
use App\Models\Passenger;
use App\Models\Payment;
use App\Models\Price;
use App\Models\SourceVendor;
use App\Models\Tabinfo;
use App\Models\Tabtypelink;
use App\Models\TicketType;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Spatie\Permission\Models\Role;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Tabinfo::where('tabtype_id', '!=', 5)->latest()->get();
        foreach ($data as $record) {
            $cls = '';
            switch ($record->status->name) {
                case 'Submitted':
                    $cls = 'bg-primary text-white';
                    break;

                case 'Completed':
                    $cls = 'bg-success text-white';
                    break;

                case 'Rejected':
                    $cls = 'bg-danger text-white';
                    break;

                default:
                    $cls = 'bg-light';
            }
            $record->bgColor = $cls;
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
            $record->date = $record->created_at->toDateString();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        return view('admin.dashboard')->with(['data' => $data]);
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.newcust', ['data' => $roles]);
    }
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
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
                'agency_picture' => $agency_name,
                'processed_by' => auth()->user()->id
            ];
            $customer = new Customer();
            $customer->create($data);
            return back()->with(['success' => 'Customer added Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to create customer']);
        }
    }

    public function addAdmin(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
            $request->validate([
                'contact' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
            ]);

            $user = new User();
            $user->name = $request->contact;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->save();
            $user->assignRole('Admin');

            return back()->with(['success' => 'Sub admin added Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to create customer']);
        }
    }
    public function removeAdmin($id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->delete();
        }
        return back()->with(['success' => 'Sub Admin Deleted Successfully']);
    }
    public function editCustomer($id)
    {
        $data = Customer::find($id);
        return view('admin.updateCustomer')->with(['data' => $data]);
    }
    public function updateCustomer(Request $request, $id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            $customer = Customer::find($id);
            $customer->contact = $request['contact'];
            $customer->phone = $request['phone'];
            $customer->agency_name = $request['agency_name'];
            $customer->mobile = $request['mobile'];
            $customer->ledger_link = $request['ledger_link'];
            $customer->processed_by = auth()->user()->id;
            $customer->update();
            return back()->with(['success' => 'customer updated successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to update customer']);
        }
    }
    public function custUpdate($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
            $customer = Customer::find($id);
            $customer->status = 1;
            $customer->processed_by = auth()->user()->id;
            $customer->update();
            return back()->with(['success' => 'customer status updated']);
        } else {
            return back()->with(['error' => 'You do not have permission to update customer']);
        }
    }
    public function custApprove($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
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
            $customer->processed_by = auth()->user()->id;
            $customer->update();
            return back()->with(['success' => 'customer status approved']);
        } else {
            return back()->with(['error' => 'You do not have permission to update customer']);
        }
    }
    public function custDisapprove($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            $customer = Customer::find($id);
            $customer->status = 4;
            $customer->processed_by = auth()->user()->id;
            $customer->update();
            $user = User::where('email', $customer->email)->update(['is_active' => 1]);
            return back()->with(['success' => 'customer status Disapproved']);
        } else {
            return back()->with(['error' => 'You do not have permission to update customer']);
        }
    }
    public function custDelete($id)
    {

        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            $user = Customer::find($id);
            $customer = Customer::find($id)->delete();
            User::where('email', $user->email)->delete();
            return back()->with(['success' => 'customer status deleted']);
        } else {
            return back()->with(['error' => 'You do not have permission to Delete customer']);
        }
    }
    public function ticketingList()
    {
        $data = Tabinfo::where('tabtype_id', 1)->latest()->get();
        foreach ($data as $record) {
            $cls = '';
            switch ($record->status->name) {
                case 'Submitted':
                    $cls = 'bg-primary text-white';
                    break;

                case 'Completed':
                    $cls = 'bg-success text-white';
                    break;

                case 'Rejected':
                    $cls = 'bg-danger text-white';
                    break;

                default:
                    $cls = 'bg-light';
            }
            $record->bgColor = $cls;
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        return view('admin.ticketing')->with(['data' => $data]);
    }
    public function customerList()
    {
        $data = Customer::latest()->get();
        foreach ($data as $record) {
            $record->statuses = Status::find($record->status);
        }
        $admin = User::role('Admin')->with('roles')->get();
        return view('admin.customer')->with(['data' => $data, 'admin' => $admin]);
    }
    public function refundList()
    {
        $data = Tabinfo::where('tabtype_id', 2)->latest()->get();
        foreach ($data as $record) {
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->customer = Customer::where('email', $record->user->email)->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        return view('admin.refund')->with(['data' => $data]);
    }

    public function voidList()
    {
        $data = Tabinfo::where('tabtype_id', 3)->latest()->get();
        foreach ($data as $record) {
            $cls = '';
            switch ($record->status->name) {
                case 'Submitted':
                    $cls = 'bg-primary text-white';
                    break;

                case 'Completed':
                    $cls = 'bg-success text-white';
                    break;

                case 'Rejected':
                    $cls = 'bg-danger text-white';
                    break;

                default:
                    $cls = 'bg-light';
            }
            $record->bgColor = $cls;
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        return view('admin.voidtab')->with(['data' => $data]);
    }

    public function dateChangeList()
    {
        $data = Tabinfo::where('tabtype_id', 4)->latest()->get();
        foreach ($data as $record) {
            $cls = '';
            switch ($record->status->name) {
                case 'Submitted':
                    $cls = 'bg-primary text-white';
                    break;

                case 'Completed':
                    $cls = 'bg-success text-white';
                    break;

                case 'Rejected':
                    $cls = 'bg-danger text-white';
                    break;

                default:
                    $cls = 'bg-light';
            }
            $record->bgColor = $cls;
            $record->all_airline = Airline::find($record->airline_id);
            $record->all_booking_source = Booking::find($record->booking_source_id);
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
            $record->link = Tabtypelink::where('tabtype_id', $record->tabtype_id)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
        }
        return view('admin.dateChange')->with(['data' => $data]);
    }
    public function paymentList()
    {
        $data = Payment::orderBy('payment_date', 'DESC')->get();
        foreach ($data as $record) {
            $record->status = Status::find($record->status);
            $record->ticket = Tabinfo::find($record->ticket_id);
            $record->bank = Bank::where('id', $record->bank)->get();
            $record->link = Tabtypelink::where('tabtype_id', 5)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
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
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        return back()->with(['success' => 'ticket status is submitted']);
    }
    public function ticketingPosted($id)
    {

        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 6;
        $ticket->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Posted')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 6;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'ticket status is Posted']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function ticketingProcessing($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 1;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'ticket status is Processing']);
    }
    public function ticketingCompleted($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 7;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'ticket status is Completed']);
    }
    public function ticketingRejected($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 4;
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'ticket status is Rejected']);
    }
    public function refundSubmitted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 5;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        return back()->with(['success' => 'Refund status is submitted']);
    }
    public function refundPosted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 6;
        $refund->update();*/

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Posted')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 6;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Refund status is Posted']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function refundProcessing($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 1;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Refund status is Processing']);
    }
    public function refundCompleted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 7;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Refund status is Completed']);
    }
    public function refundRejected($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 4;
        $refund->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Refund status is Rejected']);
    }
    public function voidSubmitted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 5;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        return back()->with(['success' => 'Void status is submitted']);
    }
    public function voidPosted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 6;
        $voidtab->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Posted')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 6;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Void status is Posted']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function voidProcessing($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 1;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Void status is Processing']);
    }
    public function voidCompleted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 7;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Void status is Completed']);
    }
    public function voidRejected($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 4;
        $voidtab->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Void status is Rejected']);
    }
    public function dateChangeSubmitted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 5;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 5;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        return back()->with(['success' => 'DateChange status is submitted']);
    }
    public function dateChangePosted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 6;
        $DateChange->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Posted')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 6;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'DateChange status is Posted']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function dateChangeProcessing($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 1;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 1;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'DateChange status is Processing']);
    }
    public function dateChangeCompleted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 7;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 7;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'DateChange status is Completed']);
    }
    public function dateChangeRejected($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 4;
        $DateChange->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 4;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'DateChange status is Rejected']);
    }
    public function paymentSubmitted($id)
    {
        $payment = Payment::find($id);
        $payment->status = 5;
        $payment->update();
        //$this->SendpaymentStatus($payment);
        return back()->with(['success' => 'Payment status is submitted']);
    }
    public function paymentPosted($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Posted')) {
            $payment = Payment::find($id);
            $payment->status = 6;
            $payment->processed_by = auth()->user()->id;
            $payment->update();
            $tabinfo = new Tabinfo();
            $tabinfo->user_id = $payment->user_id;
            $tabinfo->tabtype_id = 5;
            $tabinfo->status_id = 6;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->save();
            $payment->tabinfo_id = $tabinfo->id;
            $payment->save();
            $customer = Customer::where('email', $payment->user->email)->first();
            if ($customer) {
                $customer->balance = ((int)$customer->balance) + ((int)$payment->amount);
                $customer->credit_limit = ((int)$customer->credit_limit) + ((int)$payment->amount);
                $customer->save();
                $pay_history = new PaymentHistory();
                $pay_history->credit = $payment->amount;
                $pay_history->balance = $customer->balance;
                $pay_history->user_id = $tabinfo->user_id;
                $pay_history->payment_id = $payment->id;
                $pay_history->save();
            }

            $this->SendpaymentStatus($payment);
            return back()->with(['success' => 'Payment status is Posted']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function paymentProcessing($id)
    {
        $payment = Payment::find($id);
        $payment->status = 1;
        $payment->processed_by = auth()->user()->id;
        $payment->update();
        $this->SendpaymentStatus($payment);
        return back()->with(['success' => 'Payment status is Processing']);
    }
    public function paymentCompleted($id)
    {
        $payment = Payment::find($id);
        $payment->status = 7;
        $payment->processed_by = auth()->user()->id;
        $payment->update();
        $this->SendpaymentStatus($payment);
        return back()->with(['success' => 'Payment status is Completed']);
    }
    public function paymentRejected($id)
    {
        $payment = Payment::find($id);
        $payment->status = 4;
        $payment->processed_by = auth()->user()->id;
        $payment->update();
        $this->SendpaymentStatus($payment);
        return back()->with(['success' => 'Payment status is Rejected']);
    }
    public function adminTicketingStatus(Request $request, $id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->admin_remarks = $request['admin_remarks'];
        $ticket->update();*/
        $tabinfo = Tabinfo::find($id);
        $tabinfo->admin_remarks = $request['admin_remarks'];
        $tabinfo->processed_by = auth()->user()->id;
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
        $tabinfo->processed_by = auth()->user()->id;
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
        $tabinfo->processed_by = auth()->user()->id;
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
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        echo 'admin datechange remarks added successfully';
    }
    public function adminPaymentStatus(Request $request, $id)
    {
        /*$payment = Payment::find($id);
        $payment->admin_remarks = $request['admin_remarks'];
        $payment->update();*/
        $payment = Tabinfo::find($id);
        $payment->admin_remarks = $request['admin_remarks'];
        $payment->processed_by = auth()->user()->id;
        $payment->update();
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
        return back()->with(['success' => 'Booking Source Added Successfully']);
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
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            Airline::where('id', $id)->delete();
            return back()->with(['success' => 'Airline name deleted successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
    }
    public function delete_bank($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            Bank::where('id', $id)->delete();
            return back()->with(['success' => 'Bank name deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
    }

    public function vendorSource()
    {
        $data = SourceVendor::all();
        return view('admin.add_source_vendor')->with(['data' => $data]);
    }
    public function addVendorSource(Request $request)
    {
        $request->validate([
            'vendor_name' => 'required|unique:banks,bank_name'
        ]);
        $source = new SourceVendor();
        $source->name = $request['vendor_name'];
        $source->user_id = Auth::user()->id;
        $source->save();
        return back()->with(['success' => 'Vendor Source added successfully']);
    }
    public function deleteVendorSource($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            SourceVendor::where('id', $id)->delete();
            return back()->with(['success' => 'Vendor Source deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
    }

    public function enableVendorSource($id)
    {
        $source = SourceVendor::find($id);
        $source->enable = 1;
        $source->update();
        return back()->with(['success' => 'Vendor Source Enabled']);
    }
    public function disableVendorSource($id)
    {
        $source = SourceVendor::find($id);
        $source->enable = 0;
        $source->update();
        return back()->with(['success' => 'Vendor Source Disabled']);
    }


    public function delete_booking_source($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            Booking::where('id', $id)->delete();
            return back()->with(['success' => 'Bank name deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
    }
    public function delete_record($id)
    {
        dd($id);
        // $user = User::find(auth()->user()->id);
        // if ($user->hasRole('Super Admin')) {
        //     Tabinfo::where('id', $id)->delete();
        //     return back()->with(['success' => 'Record Deleted Successfully']);
        // } else {
        //     return back()->with(['error' => 'You do not have permission to delete']);
        // }
    }

    public function delete_payment($id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            Payment::find($id)->delete();
            return back()->with(['success' => 'Record Deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
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






    //For Ledger
    public function showDetailPage($id)
    {
        $airline = Airline::all();
        $booking = Booking::all();
        $tabinfo = Tabinfo::find($id);
        $customer = Customer::where('email', $tabinfo->user->email)->first();
        $passengers = Passenger::where('tabinfo_id', $tabinfo->id)->get();
        $ledger = Ledger::where('tabinfo_id', $tabinfo->id)->first();

        $ticket_type = TicketType::all();
        $links = Tabtypelink::where('tabtype_id', $tabinfo->tabtype_id)->get();
        $vendor = SourceVendor::all();
        foreach ($links as $link) {

            if ($link->status->name == 'Posted' && $ledger && $passengers) {
                $link->enablePosted = false;
            } else {
                $link->enablePosted = false;
            }
        }
        foreach ($passengers as $passenger) {
            if ($passenger && isset($passenger)) {
                $passenger->price = Price::where('passenger_id', $passenger->id)->first();
                $passenger->vendor = Vendor::where('passenger_id', $passenger->id)->first();
            }
        }

        return view('admin.det')->with(['airline' => $airline, 'booking' => $booking, 'links' => $links, 'tabinfo' => $tabinfo, 'customer' => $customer, 'passengers' => $passengers, 'ledger' => $ledger, 'ticket_type' => $ticket_type, 'vendor' => $vendor]);
    }

    public function addLedger(SaveLedgerRequest $request, $id)
    {

        $ledger = new Ledger();
        $ledger->date = $request->date;
        $ledger->transaction = $request->transaction;
        $ledger->agency_name = $request->agency_name;
        $ledger->booking_id = $request->booking_id;
        $ledger->airline_id = $request->airline_id;
        $ledger->ticketType_id = $request->ticket_type;
        $ledger->pnr = $request->pnr;
        $ledger->to = $request->to;
        $ledger->from = $request->from;
        $ledger->dep_date = $request->dep_date;
        $ledger->arr_date = $request->arr_date;
        $ledger->processed_by = auth()->user()->id;
        $ledger->tabinfo_id = $id;
        $ledger->save();
        return back()->with(['success' => 'Ledger Added Successfully']);
    }

    public function updateLedger(SaveLedgerRequest $request, $id)
    {
        $ledger = Ledger::find($request->ledger_id);
        $ledger->date = $request->date;
        $ledger->transaction = $request->transaction;
        $ledger->agency_name = $request->agency_name;
        $ledger->booking_id = $request->booking_id;
        $ledger->airline_id = $request->airline_id;
        $ledger->ticketType_id = $request->ticket_type;
        $ledger->pnr = $request->pnr;
        $ledger->to = $request->to;
        $ledger->from = $request->from;
        $ledger->dep_date = $request->dep_date;
        $ledger->arr_date = $request->arr_date;
        $ledger->processed_by = auth()->user()->id;
        $ledger->tabinfo_id = $id;
        $ledger->save();
        return back()->with(['success' => 'Ledger Added Successfully']);
    }

    public function SavePassengerInfo(SavePassengerInfoRequest $request, $id)
    {
        // dd($request->all());
        $passenger = new Passenger();
        $passenger->type = $request->type;
        $passenger->title = $request->title;
        $passenger->passenger_name = $request->passenger_name;
        $passenger->ticket = $request->ticket;
        $passenger->payment_type = $request->payment_type;
        $passenger->remarks = $request->remarks;
        $passenger->processed_by = Auth::user()->id;
        $passenger->tabinfo_id = $id;
        $passenger->save();

        $price = new Price();
        $price->basic = $request->p_basic;
        $price->tax = $request->p_tax;
        $price->discount = $request->p_discount;
        $price->value = $request->p_value;
        $price->passenger_id = $passenger->id;
        $price->save();

        $vendor = new Vendor();
        $vendor->basic = $request->v_basic;
        $vendor->tax = $request->v_tax;
        $vendor->discount = $request->v_discount;
        $vendor->value = $request->v_value;
        $vendor->passenger_id = $passenger->id;
        $vendor->vendor_id = 1;
        $vendor->save();
        return back()->with(['success', 'Passenger info added successfully']);
    }
    public function UpdatePassengerInfo(SavePassengerInfoRequest $request, $id)
    {

        $passenger = Passenger::find($request->passenger_id);
        if ($passenger) {
            $passenger->type = $request->type;
            $passenger->title = $request->title;
            $passenger->passenger_name = $request->passenger_name;
            $passenger->ticket = $request->ticket;
            $passenger->payment_type = $request->payment_type;
            $passenger->remarks = $request->remarks;
            $passenger->processed_by = Auth::user()->id;
            $passenger->tabinfo_id = $id;
            $passenger->save();

            $price = Price::where('passenger_id', $passenger->id)->first();
            if ($price) {
                $price->basic = $request->p_basic;
                $price->tax = $request->p_tax;
                $price->discount = $request->p_discount;
                $price->value = $request->p_value;
                $price->passenger_id = $passenger->id;
                $price->save();
            }


            $vendor = Vendor::where('passenger_id', $passenger->id)->first();
            if ($vendor) {
                $vendor->basic = $request->v_basic;
                $vendor->tax = $request->v_tax;
                $vendor->discount = $request->v_discount;
                $vendor->value = $request->v_value;
                $vendor->passenger_id = $passenger->id;
                $vendor->vendor_id = 1;
                $vendor->save();
            }
            return back()->with(['success', 'Passenger info added successfully']);
        }
    }



















    public function SendStatusMail(Tabinfo $tabinfo)
    {
        $user = $tabinfo->user()->first();
        $customer = Customer::where('email', $user->email)->first();
        $booking_source = Booking::find($tabinfo->booking_source_id);
        $airline = Airline::find($tabinfo->airline_id);
        $msg = '';
        $subject = '';
        if ($tabinfo->tabtype_id == 1) {
            $subject = 'TICKETING';
            if ($tabinfo->status_id == 1) {
                $msg = 'YOUR ' . '"' . 'TICKETING' . '"' . ' REQUEST IS PROCESSING BY OUR TEAM.';
            } else if ($tabinfo->status_id == 7) {
                $msg = 'YOUR ' . '"' . 'TICKETING' . '"' . ' REQUEST IS COMPLETED.';
            } else if ($tabinfo->status_id == 4) {
                $msg = 'YOUR ' . '"' . 'TICKETING' . '"' . ' REQUEST IS REJECTED BY OUR TEAM.';
            } else if ($tabinfo->status_id == 6) {
                $msg = 'YOUR ' . '"' . 'TICKETING' . '"' . ' REQUEST IS POSTED.';
            }
        } else if ($tabinfo->tabtype_id == 2) {
            $subject = 'REFUND';
            if ($tabinfo->status_id == 1) {
                $msg = 'YOUR ' . '"' . 'REFUND' . '"' . ' REQUEST IS PROCESSING BY OUR TEAM.';
            } else if ($tabinfo->status_id == 7) {
                $msg = 'YOUR ' . '"' . 'REFUND' . '"' . ' REQUEST IS COMPLETED.';
            } else if ($tabinfo->status_id == 4) {
                $msg = 'YOUR ' . '"' . 'REFUND' . '"' . ' REQUEST IS REJECTED BY OUR TEAM.';
            } else if ($tabinfo->status_id == 6) {
                $msg = 'YOUR ' . '"' . 'REFUND' . '"' . ' REQUEST IS POSTED.';
            }
        } else if ($tabinfo->tabtype_id == 3) {
            $subject = 'VOID';
            if ($tabinfo->status_id == 1) {
                $msg = 'YOUR ' . '"' . 'VOID' . '"' . ' REQUEST IS PROCESSING BY OUR TEAM.';
            } else if ($tabinfo->status_id == 7) {
                $msg = 'YOUR ' . '"' . 'VOID' . '"' . ' REQUEST IS COMPLETED.';
            } else if ($tabinfo->status_id == 4) {
                $msg = 'YOUR ' . '"' . 'VOID' . '"' . ' REQUEST IS REJECTED BY OUR TEAM.';
            } else if ($tabinfo->status_id == 6) {
                $msg = 'YOUR ' . '"' . 'VOID' . '"' . ' REQUEST IS POSTED.';
            }
        } else if ($tabinfo->tabtype_id == 4) {
            $subject = 'DATE CHANGE';
            if ($tabinfo->status_id == 1) {
                $msg = 'YOUR ' . '"' . 'DATE CHANGE' . '"' . ' REQUEST IS PROCESSING BY OUR TEAM.';
            } else if ($tabinfo->status_id == 7) {
                $msg = 'YOUR ' . '"' . 'DATE CHANGE' . '"' . ' REQUEST IS COMPLETED.';
            } else if ($tabinfo->status_id == 4) {
                $msg = 'YOUR ' . '"' . 'DATE CHANGE' . '"' . ' REQUEST IS REJECTED BY OUR TEAM.';
            } else if ($tabinfo->status_id == 6) {
                $msg = 'YOUR ' . '"' . 'DATE CHANGE' . '"' . ' REQUEST IS POSTED.';
            }
        }
        // dd($msg);
        require base_path('vendor/autoload.php');
        //require ('../vendor/autoload.php');
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.salamtravels.com.pk';
        // $mail->Host = 'awanwoodworkshop.store';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@salamtravels.com.pk';
        $mail->Password = 'Salam7879';
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->setFrom('admin@salamtravels.com.pk', 'Salam Travels and Tours');
        $mail->isHTML(true);

        $mail->Subject = 'SALAM WEB PORTAL ' . $subject . ' REQUEST';
        $mail->Body = '<p>Dear Trade Partner</p><br>
            ' . $customer->agency_name . '<br>
            <p>' . $msg . '</p><br><br>
            <p>PLEASE SEE ITS DETAILS</p><br>
            PNR:&nbsp;&nbsp;' . $tabinfo->pnr . '<br>
            BOOKING SOURCE:&nbsp;&nbsp;' . $tabinfo->booking_source->booking_source . '<br>
            AIRLINE:&nbsp;&nbsp;' . $tabinfo->airline->airline_name . '<br>
            SECTOR:&nbsp;&nbsp;' . $tabinfo->sector . '<br>
            TRAVEL DATE:&nbsp;&nbsp;' . $tabinfo->date . '<br>
            PESSENGER NAME:&nbsp;&nbsp;' . $tabinfo->passenger_name . '<br><br>
            KINDLY VIEW ITS CURRENT STATUS IN PORTAL.<br><br>

            REGARDS<br>
            TEAM <br>
            SALAM TRAVEL & TOURS';
        $data = [$customer->email, 'salamair7879@gmail.com'];
        for ($i = 0; $i < 2; $i++) {
            try {
                $mail->addAddress($data[$i]);
                $mail->send();
                $mail->clearAddresses();
            } catch (Exception $x) {
                return back()->with(['success' => 'email could not sent']);
            }
        }
    }
    public function SendpaymentStatus(Payment $payment)
    {
        $msg = '';
        $subject = 'PAYMENT';
        if ($payment->status == 1) {
            $msg = 'YOUR ' . '"' . 'PAYMENT' . '"' . ' REQUEST IS PROCESSING BY OUR TEAM.';
        } else if ($payment->status == 7) {
            $msg = 'YOUR ' . '"' . 'PAYMENT' . '"' . ' REQUEST IS COMPLETED.';
        } else if ($payment->status == 4) {
            $msg = 'YOUR ' . '"' . 'PAYMENT' . '"' . ' REQUEST IS REJECTED BY OUR TEAM.';
        } else if ($payment->status == 6) {
            $msg = 'YOUR ' . '"' . 'PAYMENT' . '"' . ' REQUEST IS POSTED.';
        } else {
            return back();
        }
        $customer = $payment->user()->first();
        $bank = $payment->bank()->first();
        // dd($customer);
        require base_path('vendor/autoload.php');
        //require ('../vendor/autoload.php');
        $mail = new PHPMailer(true);

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.salamtravels.com.pk';
        // $mail->Host = 'awanwoodworkshop.store';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@salamtravels.com.pk';
        $mail->Password = 'Salam7879';
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->setFrom('admin@salamtravels.com.pk', 'Salam Travels and Tours');
        $mail->isHTML(true);

        $mail->Subject = 'SALAM WEB PORTAL ' . $subject . ' REQUEST';
        $mail->Body = '<p>Dear Trade Partner</p><br>
            ' . $customer->agency_name . '<br>
            <p>' . $msg . '</p><br><br>
            <p>PLEASE SEE ITS DETAILS</p><br>
            AMOUNT:&nbsp;&nbsp;' . $payment->amount . '<br>
            BANK NAME SOURCE:&nbsp;&nbsp;' . $bank->bank_name . '<br>
            PAYMENT DATE:&nbsp;&nbsp;' . $payment->payment_date . '<br>
            KINDLY VIEW ITS CURRENT STATUS IN PORTAL.<br><br>

            REGARDS<br>
            TEAM <br>
            SALAM TRAVEL & TOURS';
        $data = [$customer->email, 'salamair7879@gmail.com'];
        for ($i = 0; $i < 2; $i++) {
            try {
                $mail->addAddress($data[$i]);
                $mail->send();
                $mail->clearAddresses();
            } catch (Exception $x) {
                return back()->with(['success' => 'email could not sent']);
            }
        }
    }
}
