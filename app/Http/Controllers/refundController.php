<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Airline;
use App\Models\Booking;
use App\Models\Tabinfo;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class refundController extends Controller
{
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $data['airline'] = Airline::where('enable', 1)->get();
        $data['booking'] = Booking::where('enable', 1)->get();
        $data['customer'] = Customer::where('email', $user->email)->get();
        return view('customer.refund')->with(['data'=>$data]);
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
            'airline_name'=>'required',
            'pnr'=>'required',
            'booking_source'=>'required',
            'date'=>'required',
            'sector'=>'required',
            'passenger_name'=>'required'
        ]);
        $data = [
            'airline_id'=>$request['airline_name'],
            'pnr'=>$request['pnr'],
            'booking_source_id'=>$request['booking_source'],
            'date'=>$request['date'],
            'sector'=>$request['sector'],
            'passenger_name'=>$request['passenger_name'],
            'remarks'=>$request['remarks'],
            'user_id'=>Auth::user()->id,
            'tabtype_id'=>2
        ];
        $airline = Airline::find($request->airline_name);
        $booking = Booking::find($request->booking_source);
        $refund = new Tabinfo();
        $refund->create($data);
        $user = User::find(Auth::user()->id);
        $customer = Customer::where('email', $user->email)->get();
        require base_path('/vendor/autoload.php');
        //require ('../vendor/autoload.php');
        $mail = new PHPMailer(true);
    
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'mail.salamtravels.com.pk';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@salamtravels.com.pk';
        $mail->Password = 'Salam7879';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('admin@salamtravels.com.pk', 'Salam Travels and Tours');
        $mail->isHTML(true);

        $mail->Subject = 'SALAM WEB PORTAL Refund REQUEST';
        $mail->Body = '<p>Dear Trade Partner</p><br>
            '.$customer[0]->agency_name.'<br>
            <p>YOUR NEW “Refund” REQUEST IS RECEIVED & FORWARD TO OUR TEAM FOR PROCESSING.</p><br><br>
            <p>PLEASE SEE ITS DETAILS</p><br>
            PNR:\t'.$request->pnr.'<br> 
            BOOKING SOURCE:\t'.$booking->booking_source.'<br>
            AIRLINE:\t'. $airline->airline_name.'<br>
            SECTOR:\t'. $request->sector.'<br>
            TRAVEL DATE:\t'. $request->date.'<br>
            PESSENGER NAME:\t'. $request->passenger_name.'<br><br>
            KINDLY VIEW ITS CURRENT STATUS IN PORTAL.<br><br>
            REGARDS<br>
            TEAM <br>
            SALAM TRAVEL & TOURS';
            $data = [$customer[0]->email, 'salamair7879@gmail.com'];
        for($i=0;$i<2;$i++){
            try{
                $mail->addAddress($data[$i]);
                $mail->send();
                $mail->clearAddresses();
            }
            catch(Exception $x){
                return back()->with(['success'=>'email could not sent']);
            }

        }
        return back()->with(['success'=>'Refund Request Submitted Successfully']);
    }

}
