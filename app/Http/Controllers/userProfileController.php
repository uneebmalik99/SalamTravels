<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class userProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        $customer = Customer::where('email', $user->email)->get();
        return view('customer.userProfile')->with(['data'=>$customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'contact'=>'required|min:8|string',
            'phone'=>'required|min:11',
            'mobile'=>'required|min:11',
            'agency_name'=>'required|string',
            'password'=>'required'
        ]);
        $customer = Customer::find($id);
        if($request->hasFile('visiting_card')){
            $image = $request->file('visiting_card');
                if($image != null){
                    $name= Str::random(10).$image->getClientOriginalName();
                    $path = 'public/images';
                    $image->move($path, $name);
                    if($customer->visiting_card != null){
                        $file_path = 'public/images/'.$customer->visiting_card;
                        @unlink($file_path);
                    }
                    $customer->visiting_card = $name;
            } 
        }
        if($request->hasFile('agency_picture')){
            $image = $request->file('agency_picture');
                if($image != null){
                    $name= Str::random(10).$image->getClientOriginalName();
                    $path = 'public/images';
                    $image->move($path, $name);
                    if($customer->agency_picture != null){
                        $file_path = 'public/images/'.$customer->agency_picture;
                        @unlink($file_path);
                    }
                    $customer->agency_picture = $name;
            } 
        }
        $customer->contact = $request['contact'];
        $customer->phone = $request['phone'];
        $customer->mobile = $request['mobile'];
        $customer->agency_name = $request['agency_name'];
        $customer->password = $request['password'];
        $customer->update();
        
        $user = User::where('email', $customer->email)->update([
            'name'=>$request['contact'],
            'password'=>Hash::make($request['password'])
        ]);
        
        return back()->with(['updated'=>'User Profile updated Successfully']);
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
