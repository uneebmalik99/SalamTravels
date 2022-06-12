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
use App\Models\PaymentHistory;
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
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
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
                'role_type' => 'required|string',
                'cnic_front' => 'required|mimes:jpeg,png,jpg,gif',
                'cnic_back' =>  'required|mimes:jpeg,png,jpg,gif',
                'profile_pic' =>  'required|mimes:jpeg,png,jpg,gif'

            ]);
            // dd($request->all());
            if ($request->hasfile('cnic_front')) {
                $cnic_front = $request->file('cnic_front');
                if ($cnic_front != null) {
                    $cnic_frontimg = Str::random(10) . $cnic_front->getClientOriginalName();
                    $path = 'public/images';
                    $cnic_front->move($path, $cnic_frontimg);
                }
            }
            if ($request->hasfile('cnic_back')) {
                $cnic_back = $request->file('cnic_back');
                if ($cnic_front != null) {
                    $cnic_backimg = Str::random(10) . $cnic_back->getClientOriginalName();
                    $path = 'public/images';
                    $cnic_back->move($path, $cnic_backimg);
                }
            }
            if ($request->hasfile('profile_pic')) {
                $profile_pic = $request->file('profile_pic');
                if ($cnic_front != null) {
                    $profile_picimg = Str::random(10) . $profile_pic->getClientOriginalName();
                    $path = 'public/images';
                    $profile_pic->move($path, $profile_picimg);
                }
            }


            $user = new User();
            $user->name = $request->contact;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->cnic_front = $cnic_frontimg;
            $user->cnic_back = $cnic_backimg;
            $user->profile_pic = $profile_picimg;
            $user->role = 1;
            $user->role_type = $request->role_type;

            $user->save();
            $user->assignRole('Admin');
            $user->givePermissionTo($request->permission);
            return back()->with(['success' => 'Sub admin added Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to create customer']);
        }
    }
    public function editAdmin($id)
    { //test edit
        $user = User::Find($id);
        return view('admin.edit_admin', compact('user'));
    }
    public function updateAdmi(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Admin') || $user->hasRole('Super Admin')) {
            // $request->validate([
            //     'contact' => 'required',
            //     'email' => 'required',
            //     'role_type' => 'required|string'
            // ]);
            if ($request->hasfile('cnic_front')) {
                $cnic_front = $request->file('cnic_front');
                if ($cnic_front != null) {
                    $destination = 'public/images'.$user->cnic_front;
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $cnic_frontimg = Str::random(10) . $cnic_front->getClientOriginalName();
                    $path = 'public/images';
                    $cnic_front->move($path, $cnic_frontimg);
                }
            }
            if ($request->hasfile('cnic_back')) {
                $cnic_back = $request->file('cnic_back');
                if ($cnic_back != null) {
                    $destination = 'public/images'.$user->cnic_back;

                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $cnic_backimg = Str::random(10) . $cnic_back->getClientOriginalName();
                    $path = 'public/images';
                    $cnic_back->move($path, $cnic_backimg);
                }
            }
            if ($request->hasfile('profile_pic')) {
                $profile_pic = $request->file('profile_pic');
                if ($profile_pic != null) {
                    $destination = 'public/images'.$user->profile_pic;

                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $profile_picimg = Str::random(10) . $profile_pic->getClientOriginalName();
                    $path = 'public/images';
                    $profile_pic->move($path, $profile_picimg);
                }
            }

            $id = $request->post('newid');
            $user =  User::find($id);
            $user->name = $request['name'];
            $user->role_type = $request['role_type'];
            $user->email = $request->email;
            $user->cnic_front = isset($cnic_frontimg)?$cnic_frontimg:$user->cnic_front;
            $user->cnic_back = isset($cnic_backimg)?$cnic_backimg:$user->cnic_back;
            $user->profile_pic = isset($profile_picimg)?$profile_picimg:$user->profile_pic;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            FacadesDB::table('model_has_permissions')->where('model_id', $user->id)->delete();
            $user->givePermissionTo($request->permission);
            return back()->with(['success' => 'Sub admin updated Successfully']);
        } else {
            return back()->with(['error' => 'You do not have permission to create customer']);
        }
    }
    public function edit(Request $request, $id)
    {
        $name = $request->input('stud_name');
        DB::update('update student set name = ? where id = ?', [$name, $id]);
        echo "Record updated successfully.<br/>";
        echo '<a href = "/edit-records">Click Here</a> to go back.';
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
        // if (getimagesize('/images/' . $data->visiting_card)) {
        $data->filesize = file_exists('/images/' . $data->visiting_card);
        // }
        return view('admin.updateCustomer')->with(['data' => $data]);
    }
    public function updateCustomer(Request $request, $id)
    {
        $user = User::find(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            $customer = Customer::find($id);
            $customer->contact = $request['contact'];
            $customer->email = $request['email'];
            $customer->phone = $request['phone'];
            $customer->agency_name = $request['agency_name'];
            $customer->mobile = $request['mobile'];
            $customer->visiting_card = $request['visiting_card'];
            $customer->agency_picture = $request['agency_picture'];
            $customer->card_size = $request['filesize'];
            $customer->credit_limit = $request['credit_limit'];
            $customer->processed_by = auth()->user()->id;
            $customer->update();
            $user->email = $request['email'];
            $user->save();
            // dd($request->all());
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
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
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
        $data = Payment::latest()->get();
        foreach ($data as $record) {
            $record->status = Status::find($record->status);
            $record->ticket = Tabinfo::find($record->ticket_id);
            $record->bank = Bank::where('id', $record->bank)->get();
            $record->link = Tabtypelink::where('tabtype_id', 5)->get();
            if (isset($record->processed_by)) {
                $record->processed_by = User::find($record->processed_by);
            }
            $record->user = User::where('id', $record->user_id)->withTrashed()->first();
            $record->customer = Customer::where('email', $record->user->email)->withTrashed()->first();
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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 1;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'ticket status is Processing']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function ticketingCompleted($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 7;
        $ticket->update();*/

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Completed')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 7;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'ticket status is Completed']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function ticketingRejected($id)
    {
        /*$ticket = OfflineTicket::find($id);
        $ticket->status = 4;
        $ticket->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Rejected')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 4;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'ticket status is Rejected']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
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

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 1;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Refund status is Processing']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function refundCompleted($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 7;
        $refund->update();*/

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 7;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Refund status is Completed']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function refundRejected($id)
    {
        /*$refund = Refund::find($id);
        $refund->status = 4;
        $refund->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Rejected')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 4;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Refund status is Rejected']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 1;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Void status is Processing']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function voidCompleted($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 7;
        $voidtab->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Completed')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 7;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Void status is Completed']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function voidRejected($id)
    {
        /*$voidtab = Voidtab::find($id);
        $voidtab->status = 4;
        $voidtab->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Rejected')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 4;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'Void status is Rejected']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
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

        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 1;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'DateChange status is Processing']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function dateChangeCompleted($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 7;
        $DateChange->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Completed')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 7;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'DateChange status is Completed']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function dateChangeRejected($id)
    {
        /*$DateChange = DateChange::find($id);
        $DateChange->status = 4;
        $DateChange->update();*/
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Rejected')) {
            $tabinfo = Tabinfo::find($id);
            $tabinfo->status_id = 4;
            $tabinfo->processed_by = auth()->user()->id;
            $tabinfo->update();
            $this->SendStatusMail($tabinfo);
            return back()->with(['success' => 'DateChange status is Rejected']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
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
                $customer->balance = $customer->balance + $payment->amount;
                $customer->credit_limit = $customer->credit_limit + $payment->amount;
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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Processing')) {
            $payment = Payment::find($id);
            $payment->status = 1;
            $payment->processed_by = auth()->user()->id;
            $payment->update();
            $this->SendpaymentStatus($payment);
            return back()->with(['success' => 'Payment status is Processing']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function paymentCompleted($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Completed')) {
            $payment = Payment::find($id);
            $payment->status = 7;
            $payment->processed_by = auth()->user()->id;
            $payment->update();
            $this->SendpaymentStatus($payment);
            return back()->with(['success' => 'Payment status is Completed']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
    }
    public function paymentRejected($id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin') || $user->hasPermissionTo('Rejected')) {
            $payment = Payment::find($id);
            $payment->status = 4;
            $payment->processed_by = auth()->user()->id;
            $payment->update();
            $this->SendpaymentStatus($payment);
            return back()->with(['success' => 'Payment status is Rejected']);
        } else {
            return back()->with(['error' => 'You do not have permission to update Status']);
        }
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
            $tab=Tabinfo::where('id', $id)->first();
            $customer_tab = Customer::where('email',$tab->user->email)->first();
            if($tab->tabtype->id===2||$tab->tabtype->id===3|| $tab->tabtype->id===8 || $tab->tabtype->id===16){
            foreach ($tab->passenger as $passenger) {
                # code...
                $customer_tab->balance = floatval($customer_tab->balance)-floatval($passenger->price->value);
                $passenger->paymentHistory->credit = $passenger->price->value;
                $passenger->paymentHistory->balance = $customer_tab->balance;
                $customer_tab->credit_limit = floatval($customer_tab->credit_limit)-floatval($passenger->price->value);
                $passenger->push();
                $customer_tab->save();
            }
        }

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
        foreach ($links as $link) {

            if ($link->status->name == 'posted' && $ledger && $passengers) {
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
        // dd($passengers);
        return view('admin.det')->with(['airline' => $airline, 'booking' => $booking, 'links' => $links, 'tabinfo' => $tabinfo, 'customer' => $customer, 'passengers' => $passengers, 'ledger' => $ledger, 'ticket_type' => $ticket_type, 'vendor' => $vendor]);
    }

    public function addLedger($request, $id)
    {
        $ledger = new Ledger();
        $ledger->date = $request['date'];
        $ledger->transaction = $request['transaction'];
        $ledger->agency_name = $request['agency_name'];
        $ledger->booking_id = $request['booking_id'];
        $ledger->airline_id = $request['airline_id'];
        $ledger->ticketType_id = $request['ticket_type'];
        $ledger->pnr = $request['pnr'];
        $ledger->to = $request['to'];
        $ledger->from = $request['from'];
        $ledger->dep_date = $request['dep_date'];
        $ledger->arr_date = $request['arr_date'];
        $ledger->processed_by = auth()->user()->id;
        $ledger->tabinfo_id = $id;
        $ledger->save();
    }

    public function updateLedger($request, $id)
    {
        $ledger = Ledger::find($request['ledger_id']);
        $ledger->date = $request['date'];
        $ledger->transaction = $request['transaction'];
        $ledger->agency_name = $request['agency_name'];
        $ledger->booking_id = $request['booking_id'];
        $ledger->airline_id = $request['airline_id'];
        $ledger->ticketType_id = $request['ticket_type'];
        $ledger->pnr = $request['pnr'];
        $ledger->to = $request['to'];
        $ledger->from = $request['from'];
        $ledger->dep_date = $request['dep_date'];
        $ledger->arr_date = $request['arr_date'];
        $ledger->processed_by = auth()->user()->id;
        $ledger->tabinfo_id = $id;
        $ledger->save();
    }

    public function SavePassengerInfo(Request $request, $id)
    {
        $i = 0;
        $data = $request->data['passenger'];
        $ledger = $request->data['ledger'][0];
        $this->addLedger($ledger, $id);
        foreach ($data as $record) {

            $passenger = new Passenger();
            $passenger->type = $record['type'];
            $passenger->title = $record['title'];
            $passenger->passenger_name = $record['passenger_name'];
            $passenger->ticket = $record['ticket'];
            $passenger->payment_type = null;
            $passenger->remarks = $record['remarks'];
            $passenger->processed_by = Auth::user()->id;
            $passenger->tabinfo_id = $id;
            $passenger->save();

            $price = new Price();
            $price->basic = null;
            $price->tax = null;
            $price->discount = null;
            $price->value = $record['p_value'];
            $price->passenger_id = $passenger->id;
            $price->save();



            $pay_history = new PaymentHistory;
            $tabinfo = Tabinfo::find($id);
            $customer = Customer::where('email', $tabinfo->user->email)->first();
            if ($tabinfo) {
                $paid = 0;
                if ($tabinfo->tabtype_id == 2 || $tabinfo->tabtype_id == 3) {
                    $pay_history->credit = $price->value;
                    $customer->credit_limit = $customer->credit_limit + $price->value;
                    $customer->balance = $customer->balance + $price->value;
                    $pay_history->balance = $customer->balance + $price->value;
                    $customer->save();
                } else {
                    $pay_history->debit = $price->value;
                    $customer->credit_limit = $customer->credit_limit - $price->value;
                    $paid = $customer->balance - $price->value;
                    $customer->balance = $paid;
                    $pay_history->balance = $paid;
                    $customer->save();
                }
                $pay_history->user_id = $tabinfo->user_id;
            }
            $pay_history->passenger_id = $passenger->id;
            $pay_history->save();

            $vendor = new Vendor();
            $vendor->basic = null;
            $vendor->v_payment_type = null;
            $vendor->tax = null;
            $vendor->discount = null;
            $vendor->value = $record['v_value'];
            $vendor->passenger_id = $passenger->id;
            $vendor->vendor_id = null;
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
        $psngs = $request->data['passenger'];
        $ledger = $request->data['ledger'][0];
        $this->updateLedger($ledger, $id);
        foreach ($psngs as $psng) {
            $passenger = Passenger::find($psng['id']);
            if ($passenger) {
                $passenger->type = $psng['type'];
                $passenger->title = $psng['title'];
                $passenger->passenger_name = $psng['passenger_name'];
                $passenger->ticket = $psng['ticket'];
                $passenger->payment_type = null;
                $passenger->remarks = $psng['remarks'];
                $passenger->processed_by = Auth::user()->id;
                $passenger->tabinfo_id = $id;
                $passenger->save();

                $price = Price::where('passenger_id', $passenger->id)->first();
                if ($price) {
                    $price->basic = null;
                    $price->tax = null;
                    $price->discount = null;
                    $price->value = $psng['p_value'];
                    $price->passenger_id = $passenger->id;
                    $price->save();


                    $pay_history = PaymentHistory::where('passenger_id', $passenger->id)->first();
                    $tabinfo = Tabinfo::find($id);
                    $customer = Customer::where('email', $tabinfo->user->email)->first();
                    if ($tabinfo) {
                        $paid = 0;
                        if ($tabinfo->tabtype_id == 2 || $tabinfo->tabtype_id == 3) {
                            $paid = $pay_history->credit - $price->value;
                            $pay_history->credit = $price->value;
                            $customer->credit_limit = $customer->credit_limit + $paid;
                            $customer->balance = $customer->balance + $paid;
                            $pay_history->balance = $customer->balance + $paid;
                            $customer->save();
                        } else {
                            $paid = $pay_history->debit - $price->value;
                            $pay_history->debit = $price->value;
                            $customer->credit_limit = $customer->credit_limit + $paid;
                            $balance = $customer->balance + $paid;
                            $customer->balance = $balance;
                            $pay_history->balance = $balance;
                            $customer->save();
                        }
                        $pay_history->user_id = $tabinfo->user_id;
                    }
                    $pay_history->passenger_id = $passenger->id;
                    $pay_history->save();
                }
                $vendor = Vendor::where('passenger_id', $passenger->id)->first();
                if ($vendor) {
                    $vendor->basic = null;
                    $vendor->v_payment_type = null;
                    $vendor->tax = null;
                    $vendor->discount = null;
                    $vendor->value = $psng['v_value'];
                    $vendor->passenger_id = $passenger->id;
                    $vendor->vendor_id = null;
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
        $users = User::where('role', 0)->get();
        $customers = [];
        if ($users) {
            $i = 0;
            foreach ($users as $user) {
                $customers[$i] = Customer::where('email', $user->email)->first();
                $i++;
            }
        }
        $ledgers = Ledger::all();
        // dd($customers);
        $users = User::where('role', 0)->get();
        return view('admin.request_manual')->with(['booking' => $booking, 'airline' => $airline, 'ticket_type' => $ticket_type, 'customers' => $customers, 'legers' => $ledgers, 'users' => $users]);
    }

    public function saveManualRequest(Request $request)
    {
        $tabinfo = $request->data['ledger'];
        if ($tabinfo) {
            $tabinfo = $tabinfo[0];
            // dd($tabinfo[0]['airline_id']);
            $tab = new Tabinfo();
            $customer = Customer::where('agency_name', $tabinfo['agency_name'])->first();
            $user = User::where('email', $customer->email)->first();
            $tab->airline_id = $tabinfo['airline_id'];
            $tab->booking_source_id = $tabinfo['booking_id'];
            // $tab->sector = $tabinfo['sector'];
            $tab->date = $tabinfo['dep_date'];
            $tab->passenger_name = $tabinfo['passenger_name'];
            $tab->pnr = $tabinfo['pnr'];
            $tab->user_id = $user->id;
            $tab->processed_by = auth()->user()->id;
            $tab->tabtype_id = $tabinfo['transaction'];
            $result = $tab->save();
            if ($result) {
                $lg = new Ledger();
                $lg->date = $tabinfo['date'];
                $lg->transaction = $tabinfo['transaction'];
                $lg->agency_name = $tabinfo['agency_name'];
                $lg->booking_id = $tabinfo['booking_id'];
                $lg->airline_id = $tabinfo['airline_id'];
                $lg->ticketType_id = $tabinfo['ticket_type'];
                $lg->pnr = $tabinfo['pnr'];
                // $lg->to = $tabinfo['to'];
                // $lg->from = $tabinfo['from'];
                $lg->dep_date = $tabinfo['dep_date'];
                $lg->arr_date = $tabinfo['arr_date'];
                $lg->processed_by = auth()->user()->id;
                $lg->tabinfo_id = $tab->id;
                $lg->save();

                $passengers = $request->data['passenger'];
                foreach ($passengers as $passenger) {
                    $psng = new Passenger();
                    $psng->type = $passenger['type'];
                    $psng->title = $passenger['title'];
                    $psng->passenger_name = $passenger['passenger_name'];
                    $psng->ticket = $passenger['ticket'];
                    $psng->payment_type = null;
                    $psng->remarks = $passenger['remarks'];
                    $psng->processed_by = Auth::user()->id;
                    $psng->tabinfo_id = $tab->id;
                    $psng->save();

                    $price = new Price();
                    $price->basic = null;
                    $price->tax = null;
                    $price->discount = null;
                    $price->value = $passenger['p_value'];
                    $price->passenger_id = $psng->id;
                    // $price->passenger_id = 10;
                    $price->save();



                    $pay_history = new PaymentHistory;
                    // $customer = Customer::where('email', $tabinfo->user->email)->first();
                    if ($tab) {
                        $paid = 0;
                        if ($tab->tabtype_id == 2 || $tab->tabtype_id == 3 || $tab->tabtype_id == 8 || $tab->tabtype_id == 16) {
                            $pay_history->credit = $price->value;
                            $customer->credit_limit = floatval($customer->credit_limit) + floatval($price->value);
                            $paid = floatval($customer->balance) + floatval($price->value);
                            $customer->balance = $paid;
                            $pay_history->balance = $paid;
                            $customer->save();
                        } else {
                            $pay_history->debit = $price->value;
                            $customer->credit_limit = floatval($customer->credit_limit) - floatval($price->value);
                            $paid = floatval($customer->balance) - floatval($price->value);
                            $customer->balance = $paid;
                            $pay_history->balance = $paid;
                            $customer->save();
                        }
                        $pay_history->user_id = $tab->user_id;
                    }
                    $pay_history->passenger_id = $psng->id;
                    $pay_history->save();

                    $vendor = new Vendor();
                    $vendor->basic = null;
                    $vendor->v_payment_type = null;
                    $vendor->tax = null;
                    $vendor->discount = null;
                    $vendor->value = $passenger['v_value'];
                    $vendor->passenger_id = $psng->id;
                    // $vendor->passenger_id = 12;
                    $vendor->vendor_id = $passenger['vendor_id'];
                    $vendor->save();
                }
            }
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



    public function upload_visiting_image(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $filesize = filesize(public_path('images/' . $imageName));
        return response()->json([
            'image' => $imageName,
            'filesize' => $filesize
        ]);
    }

    public function delete_visiting_image($filename)
    {
        File::delete(public_path('/images/' . $filename));
        $customer = Customer::where('visiting_card', $filename)->first();
        $customer->visiting_card = NULL;
        $customer->save();
        return response()->json('image deleted');
    }
    public function upload_agency_image(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $filesize = filesize(public_path('images/' . $imageName));
        return response()->json([
            'image' => $imageName,
            'filesize' => $filesize
        ]);
    }
    public function delete_agency_image($filename)
    {
        File::delete(public_path('/images/' . $filename));
        $customer = Customer::where('agency_picture', $filename)->first();
        $customer->agency_picture = NULL;
        $customer->save();
        return response()->json('image deleted');
    }


    public function adminLedger()
    {
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
        // $data = User::find(Auth::user()->id);
        // $customer = Customer::where('email', $data->email)->first();
        // dd($tabinfo[0]->passenger->payment_history);
        // $ledger = Ledger::whereIn('tabinfo_id', $tabinfo->id)->get();
        // foreach ($tabinfo as $info) {
        //     if ($info->passenger->payment_history) {
        //         print_r($info->passenger->payment_history->credit);
        //     }
        // }
        // dd($tabinfo);

        return view('admin.ledger')->with(['data' => $tabinfo]);
    }



    public function deleteCustomer()
    {
        $user = User::where('email', 'uneeb@gmail.com')->get();
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
