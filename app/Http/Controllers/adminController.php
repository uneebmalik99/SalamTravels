<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveLedgerRequest;
use App\Http\Requests\SaveManualRequest;
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
use App\Models\RequestManual;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Spatie\Permission\Models\Role;
use DB;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Tabinfo::latest()->get();
        foreach ($data as $record) {
            $cls = '';
            switch ($record->status->name) {
                case 'submitted':
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
            $record->customer = Customer::where('email', $record->user->email)->first();
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
                'credit_limit' => 'required',
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
                'credit_limit' => $request['credit_limit'],
                'password' => $request['password'],
                'visiting_card' => $name,
                'agency_picture' => $agency_name,
                'processed_by' => auth()->user()->id
            ];
            $customer = new Customer();
            $customer->create($data);
            return back()->with(['success' => 'customer added Successfully']);
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
                'role_type' => 'required|string'
            ]);

            $user = new User();
            $user->name = $request->contact;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->role_type = $request->role_type;
            $user->save();
            $user->assignRole('Admin');

            return back()->with(['success' => 'Sub admin added Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to create customer']);
        }
    }
    public function editAdmin($id)
    { //test edit
        $user = User::Find($id);
        return view('admin/edit_admin', compact('user'));
    }
    public function updateAdmi(Request $request)
    {

        $id = $request->post('newid');
        $user =  User::find($id);
        $user->name = $request['name'];
        $user->role = $request['role'];

        $user->save();
        return redirect('admin/customers');
    }
    public function edit(Request $request, $id)
    {
        $name = $request->input('stud_name');
        DB::update('update student set name = ? where id = ?', [$name, $id]);
        echo "Record updated successfully.<br/>";
        echo '<a href = "/edit-records">Click Here</a> to go back.';
    }




    public function updateAdmin(Request $request, $id)
    { // test
        // $user = User::Find($id);
        return 'helo = ' . $id;
    }
    public function removeAdmin($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
            $admin = User::find($id);
            if ($admin) {
                $admin->delete();
            }
            return back()->with(['success' => 'Sub Admin Deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete Sub Admin']);
        }
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
            $customer->credit_limit = $request['credit_limit'];
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
                case 'submitted':
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
            $record->customer = Customer::where('email', $record->user->email)->first();
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
            $cls = '';
            switch ($record->status->name) {
                case 'submitted':
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
                case 'submitted':
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
            $record->customer = Customer::where('email', $record->user->email)->first();
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
                case 'submitted':
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
            $record->customer = Customer::where('email', $record->user->email)->first();
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
            $record->customer = Customer::where('email', $record->user->email)->first();
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
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'ticket status is Posted']);
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
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Refund status is Posted']);
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
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'Void status is Posted']);
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
        $tabinfo = Tabinfo::find($id);
        $tabinfo->status_id = 6;
        $tabinfo->processed_by = auth()->user()->id;
        $tabinfo->update();
        $this->SendStatusMail($tabinfo);
        return back()->with(['success' => 'DateChange status is Posted']);
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
        $payment = Payment::find($id);
        $payment->status = 6;
        $payment->processed_by = auth()->user()->id;
        $payment->update();
        $this->SendpaymentStatus($payment);
        return back()->with(['success' => 'Payment status is Posted']);
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
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin')) {
            Tabinfo::where('id', $id)->delete();
            return back()->with(['success' => 'Record Deleted Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to delete']);
        }
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
        foreach ($passengers as $passenger) {
            if ($passenger && isset($passenger)) {
                $passenger->price = Price::where('passenger_id', $passenger->id)->first();
                $passenger->vendor = Vendor::where('passenger_id', $passenger->id)->first();
            }
        }
        // dd($passengers);
        return view('admin.det')->with(['airline' => $airline, 'booking' => $booking, 'links' => $links, 'tabinfo' => $tabinfo, 'customer' => $customer, 'passengers' => $passengers, 'ledger' => $ledger, 'ticket_type' => $ticket_type, 'vendor' => $vendor]);
    }

    public function addLedger(Request $request, $id)
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

    public function updateLedger(Request $request, $id)
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

    public function SavePassengerInfo(Request $request, $id)
    {
        $i = 0;
        $data = $request->data;
        foreach ($data as $record) {

            $passenger = new Passenger();
            $passenger->type = $record['type'];
            $passenger->title = $record['title'];
            $passenger->passenger_name = $record['passenger_name'];
            $passenger->ticket = $record['ticket'];
            $passenger->payment_type = $record['payment_type'];
            $passenger->remarks = $record['remarks'];
            $passenger->processed_by = Auth::user()->id;
            $passenger->tabinfo_id = $id;
            $passenger->save();

            $price = new Price();
            $price->basic = $record['p_basic'];
            $price->tax = $record['p_tax'];
            $price->discount = $record['p_discount'];
            $price->value = $record['p_value'];
            $price->passenger_id = $passenger->id;
            $price->save();

            $vendor = new Vendor();
            $vendor->basic = $record['v_basic'];
            $vendor->v_payment_type = $record['v_payment_type'];
            $vendor->tax = $record['v_tax'];
            $vendor->discount = $record['v_discount'];
            $vendor->value = $record['v_value'];
            $vendor->passenger_id = $passenger->id;
            $vendor->vendor_id = $record['vendor_id'];
            $vendor->save();
            $i = $i + 1;
            // return back()->with(['success', 'Passenger info added successfully']);
        }
        if ($i > 0) {
            return response()->json([
                'status' => 200,
                'message' => 'Passenger info added successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Passenger info could not added'
            ]);
        }
    }
    public function UpdatePassengerInfo(Request $request, $id)
    {
        $psngs = $request->data;
        foreach ($psngs as $psng) {
            $passenger = Passenger::find($psng['id']);
            if ($passenger) {
                $passenger->type = $psng['type'];
                $passenger->title = $psng['title'];
                $passenger->passenger_name = $psng['passenger_name'];
                $passenger->ticket = $psng['ticket'];
                $passenger->payment_type = $psng['payment_type'];
                $passenger->remarks = $psng['remarks'];
                $passenger->processed_by = Auth::user()->id;
                $passenger->tabinfo_id = $id;
                $passenger->save();

                $price = Price::where('passenger_id', $passenger->id)->first();
                if ($price) {
                    $price->basic = $psng['p_basic'];
                    $price->tax = $psng['p_tax'];
                    $price->discount = $psng['p_discount'];
                    $price->value = $psng['p_value'];
                    $price->passenger_id = $passenger->id;
                    $price->save();
                }
                $vendor = Vendor::where('passenger_id', $passenger->id)->first();
                if ($vendor) {
                    $vendor->basic = $psng['v_basic'];
                    $vendor->v_payment_type = $psng['v_payment_type'];
                    $vendor->tax = $psng['v_tax'];
                    $vendor->discount = $psng['v_discount'];
                    $vendor->value = $psng['v_value'];
                    $vendor->passenger_id = $passenger->id;
                    $vendor->vendor_id = $psng['vendor_id'];
                    $vendor->save();
                }
            }
            return response()->json(['success', 'Passenger info added successfully', 'status' => 200]);
        }
    }

    public function loadManualRequestForm()
    {
        $booking = Booking::all();
        $airline = Airline::all();
        $ticket_type = TicketType::all();
        $customer = Customer::all();
        $ledgers = Ledger::all();
        return view('admin.request_manual')->with(['booking' => $booking, 'airline' => $airline, 'ticket_type' => $ticket_type,'customer' => $customer,'legers' => $ledgers]);
    }

    public function saveManualRequest(Request $request)
    {
        
        $ledgers = $request->data['ledger'];
        foreach ($ledgers as $ledger) {
            $lg = new Ledger();
            $lg->date = $ledger['date'];
            $lg->transaction = $ledger['transaction'];
            $lg->agency_name = $ledger['agency_name'];
            $lg->booking_id = $ledger['booking_id'];
            $lg->airline_id = $ledger['airline_id'];
            $lg->ticketType_id = $ledger['ticket_type'];
            $lg->pnr = $ledger['pnr'];
            $lg->to = $ledger['to'];
            $lg->from = $ledger['from'];
            $lg->dep_date = $ledger['dep_date'];
            $lg->arr_date = $ledger['arr_date'];
            $lg->processed_by = auth()->user()->id;
            $lg->tabinfo_id = 0;
            $lg->save();
        }

        $passengers = $request->data['passenger']; 
        foreach ($passengers as $passenger) {
            $psng = new Passenger();
            $psng->type = $passenger['type'];
            $psng->title = $passenger['title'];
            $psng->passenger_name = $passenger['passenger_name'];
            $psng->ticket = $passenger['ticket'];
            $psng->payment_type = $passenger['payment_type'];
            $psng->remarks = $passenger['remarks'];
            $psng->processed_by = Auth::user()->id;
            $psng->tabinfo_id = 0;
            $psng->save();

            $price = new Price();
            $price->basic = $passenger['p_basic'];
            $price->tax = $passenger['p_tax'];
            $price->discount = $passenger['p_discount'];
            $price->value = $passenger['p_value'];
            $price->passenger_id = $psng->id;
            // $price->passenger_id = 10;
            $price->save();

            $vendor = new Vendor();
            $vendor->basic = $passenger['v_basic'];
            $vendor->v_payment_type = $passenger['v_payment_type'];
            $vendor->tax = $passenger['v_tax'];
            $vendor->discount = $passenger['v_discount'];
            $vendor->value = $passenger['v_value'];
            $vendor->passenger_id = $psng->id;
            // $vendor->passenger_id = 12;
            $vendor->vendor_id = $passenger['vendor_id'];
            $vendor->save();
            
        }
       
        return response()->json([
            'status' => 200,
            'message' => 'data saved successfully'
        ]);
    }


    public function getVendor()
    {
        $vendor = SourceVendor::all();
        return response()->json($vendor);
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
        try {
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
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
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
        try {
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

                $mail->addAddress($data[$i]);
                $mail->send();
                $mail->clearAddresses();
            }
        } catch (Exception $x) {
            return back()->with(['success' => 'email could not sent']);
        }
    }
}
