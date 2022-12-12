<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>
        Travel
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .horizontal-scrollable {
            overflow-x: auto;
        }

        .horizontal-scrollable .row {
            overflow-x: auto;
            white-space: nowrap;
            display: inline;
        }

        .horizontal-scrollable .row .col-8,
        .horizontal-scrollable .row .col-4 {
            display: inline-block;
            float: none;
        }
    </style>
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="blue">
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->
            <div class="logo">
                <a href="{{ url('admin') }}" class="simple-text logo-mini">
                    <img src="{{ asset('images/Salamtravels.jpeg') }}" class="navbar-brand" width="30"
                        height="30" alt="">
                </a>
                <a href="{{ url('admin') }}" class="simple-text logo-normal text-dark">
                    Salam Travels
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/customers') }}">
                            <i class="fas fa-user"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/ticketing') }}">
                            <i class="fas fa-ticket-alt"></i>
                            <p>Ticketing</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/refund') }}">
                            <i class="fas fa-funnel-dollar"></i>
                            <p>Refund</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/void') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Void</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/datechange') }}">
                            <i class="fas fa-calendar-week"></i>
                            <p>Date Change</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/payment') }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Payment</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/manual_request') }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Request Manual</p>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('admin/ledger') }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Ledger</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">

                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ url('admin/airline') }}" class="nav-link">Add Airline</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/vendor_source') }}" class="nav-link">Add Vendor
                                    Source</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/booking_source') }}" class="nav-link">Booking Source</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/bank') }}" class="nav-link">Bank</a>
                            </li>
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                @if (session('success'))
                    <div class="alert alert-success mt-5">
                        {{ session('success') }}
                    </div>
                @endif
                {{-- If Error --}}
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <input type="hidden" name="tabinfo_id" id="tabinfo_id" value="{{ $tabinfo->id }}">
                        <input type="hidden" name="agency_name" id="agency_name" class="form-control"
                            value="@if (isset($customer) && $customer) {{ $customer->agency_name }}
                            @else ABC @endif"
                            required />
                            
                    <label class="font-weight-bold label">Transaction  : <?php 
                    if ($tabinfo->tabtype_id == '1' ){
                     echo 'TICKET' ;   
                    } 
                    else if ($tabinfo->tabtype_id == '2' ){
                        echo 'REFUND' ; 
                    }
                    else if ($tabinfo->tabtype_id == '3' ){
                        echo 'VOID' ; 
                    }
                    else if ($tabinfo->tabtype_id == '4' ){
                        echo 'DATE CHANGED' ; 
                    }else if ($tabinfo->tabtype_id == '5' ){
                        echo 'Payment' ; 
                    }
                    else if ($tabinfo->tabtype_id == '6' ){
                        echo 'Approval' ; 
                    }
                    else if ($tabinfo->tabtype_id == '7' ){
                        echo 'Baggage' ; 
                    }
                    else if ($tabinfo->tabtype_id == '8' ){
                        echo 'Credit' ; 
                    }
                    else if ($tabinfo->tabtype_id == '9' ){
                        echo 'Debit' ; 
                    }
                     else if ($tabinfo->tabtype_id == '10' ){
                        echo 'Ok To Board' ; 
                    }
                     else if ($tabinfo->tabtype_id == '11' ){
                        echo 'Insurance' ; 
                    } else if ($tabinfo->tabtype_id == '12' ){
                        echo 'PL UK Form' ; 
                    }
                     else if ($tabinfo->tabtype_id == '13' ){
                        echo 'Hotel Res' ; 
                    }
                     else if ($tabinfo->tabtype_id == '14' ){
                        echo 'Visa' ; 
                    }
                     else if ($tabinfo->tabtype_id == '15' ){
                        echo 'Covid-19' ; 
                    }
                     else if ($tabinfo->tabtype_id == '16' ){
                        echo 'Adjustment' ; 
                    }
                     else if ($tabinfo->tabtype_id == '17' ){
                        echo 'Ummrah' ; 
                    } else if ($tabinfo->tabtype_id == '18' ){
                        echo 'Others' ; 
                    }else {
                        echo 'No Transaction' ; 
                    }
                    
                    
                    
                    ?></label>
                    
                    
                    

                        <div class="card">
                            @if ($ledger && isset($ledger))
                                <input type="hidden" name="ledger_id" id="ledger_id"
                                    value="{{ $ledger->id }}" />

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Date</label>
                                                @php
                                                    $dt = \Carbon\Carbon::now();
                                                @endphp
                                                <input type="date" name="date" id="date"
                                                    value="{{ $dt->toDateString() }}" class="form-control"
                                                    disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <input type="hidden" class="form-control" name="transaction_type"
                                                id="transaction_type" value={{ $ledger->transaction }} />
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Transaction</label>
                                                @if ($ledger->transaction == 'TICKET')
                                                    <p class="lead">TICKET</p>
                                                @endif
                                                @if ($ledger->transaction == 'DATE-CHANGE')
                                                    <p class="lead">DATE-CHANGE</p>
                                                @endif
                                                @if ($ledger->transaction == 6)
                                                    <p class="lead">APPROVAL</p>
                                                @endif
                                                @if ($ledger->transaction == 7)
                                                    <p class="lead">BAGGAGE</p>
                                                @endif
                                                @if ($ledger->transaction == 8)
                                                    <p class="lead">CREDIT</p>
                                                @endif
                                                @if ($ledger->transaction == 9)
                                                    <p class="lead">DEBIT</p>
                                                @endif
                                                @if ($ledger->transaction == 10)
                                                    <p class="lead">
                                                        TO
                                                        BOARD</p>
                                                @endif
                                                @if ($ledger->transaction == 11)
                                                    <p class="lead">INSURANCE</p>
                                                @endif
                                                @if ($ledger->transaction == 12)
                                                    <p class="lead">
                                                        UK
                                                        FORM
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 13)
                                                    <p class="lead">
                                                        HOTEL RES
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 14)
                                                    <p class="lead">
                                                        VISA
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 15)
                                                    <p class="lead">
                                                        COVID-19
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 'REFUND')
                                                    <p class="lead">
                                                        REFUND
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 'VOID')
                                                    <p class="lead">
                                                        VOID
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 16)
                                                    <p class="lead">
                                                        ADJUSTMENT
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 18)
                                                    <p class="lead">
                                                        OTHERS
                                                    </p>
                                                @endif
                                                @if ($ledger->transaction == 17)
                                                    <p class="lead">
                                                        UMRAH
                                                    </p>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Booking
                                                    Source</label>
                                                <select name="booking_id" id="booking_id" class="form-control"
                                                    required>
                                                    <option disabled>---Select booking
                                                        source----</option>
                                                    @if (isset($booking))
                                                        @foreach ($booking as $book)
                                                            <option value="{{ $book->id }}"
                                                                @if ($ledger->booking_id === $book->id) selected="selected" @endif>
                                                                {{ $book->booking_source }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Airline</label>
                                                <select name="airline_id" id="airline_id" class="form-control"
                                                    required>
                                                    <option disabled>---Select Airline----</option>
                                                    @if (isset($airline))
                                                        @foreach ($airline as $air)
                                                            <option value="{{ $air->id }}"
                                                                @if ($ledger->airline_id === $air->id) selected="selected" @endif>
                                                                {{ $air->airline_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Ticket Type</label>
                                                <select name="ticket_type" id="ticket_type" class="form-control"
                                                    required>
                                                    <option disabled>---Select Ticket Type----</option>
                                                    @if (isset($ticket_type))
                                                        @foreach ($ticket_type as $tk)
                                                            <option value="{{ $tk->id }}"
                                                                @if ($ledger->ticket_type_id === $tk->id) selected="selected" @endif>
                                                                {{ $tk->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Pnr</label>
                                                <input type="text" name="pnr" id="pnr"
                                                    class="form-control" value="{{ $ledger->pnr }}" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">From</label>
                                                <input type="text" name="from" id="from"
                                                    class="form-control" value="{{ $ledger->from }}" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">To</label>
                                                <input type="text" name="to" id="to"
                                                    class="form-control" value="{{ $ledger->to }}" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Dep Date</label>
                                                <input type="date" name="dep_date" id="dep_date"
                                                    class="form-control" value="{{ $ledger->dep_date }}" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Arrival Date</label>
                                                <input type="date" name="arr_date" id="arr_date"
                                                    class="form-control" value="{{ $ledger->arr_date }}" required />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary updateLedger">Update</button>
                            @else
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Date</label>
                                                <input type="date" name="date" id="date"
                                                    value="{{ $tabinfo->created_at->todateString() }}"
                                                    class="form-control" required />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Transaction</label>
                                                <select name="transaction" id="transaction" class="form-control"
                                                    required>
                                                        <option value="" disabled selected hidden>---Select Transaction----</option>
                                                    <option disabled>---Select Transaction----</option>

                                                    <option value="TICKET">TICKET</option>
                                                    <option value="DATE-CHANGE">DATE CHANGE</option>
                                                    <option value="REFUND">REFUND</option>
                                                    <option value="VOID">VOID</option>
                                                    <option value="6">APPROVAL</option>
                                                    <option value="7">BAGGAGE</option>
                                                    <option value="8">CREDIT</option>
                                                    <option value="9">DEBIT</option>
                                                    <option value="10">OK TO BOARD</option>
                                                    <option value="11">INSURANCE</option>
                                                    <option value="12">PL UK FORM</option>
                                                    <option value="13">HOTEL RES</option>
                                                    <option value="14">VISA</option>
                                                    <option value="15">COVID-19</option>
                                                    <option value="16">ADJUSTMENT</option>
                                                    <option value="18">OTHERS</option>
                                                    <option value="17">UMRAH</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Booking
                                                    Source</label>
                                                <select name="booking_id" id="booking_id" class="form-control"
                                                    required>
                                                    <option selected disabled>---Select booking
                                                        source----</option>
                                                    @if (isset($booking))
                                                        @foreach ($booking as $book)
                                                            <option value="{{ $book->id }}">
                                                                {{ $book->booking_source }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Airline</label>
                                                <select name="airline_id" id="airline_id" class="form-control"
                                                    required>
                                                    <option selected disabled>---Select Airline----</option>
                                                    @if (isset($airline))
                                                        @foreach ($airline as $air)
                                                            <option value="{{ $air->id }}">
                                                                {{ $air->airline_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Ticket Type</label>
                                                <select name="ticket_type" id="ticket_type" class="form-control"
                                                    required>
                                                    <option selected disabled>---Select Ticket Type----</option>
                                                    @if (isset($ticket_type))
                                                        @foreach ($ticket_type as $tk)
                                                            <option value="{{ $tk->id }}">
                                                                {{ $tk->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Pnr</label>
                                                <input type="text" name="pnr" id="pnr"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">From</label>
                                                <input type="text" name="from" id="from"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">To</label>
                                                <input type="text" name="to" id="to"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Dep Date</label>
                                                <input type="date" name="dep_date" id="dep_date"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Arrival Date</label>
                                                <input type="date" name="arr_date" id="arr_date"
                                                    class="form-control" required />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Check ledger or passenger info is empty or not --}}

                    <input type="hidden" id="checkData" value="{{ $ledger && $passengers ? true : false }}" />
                    {{-- Check ledger or passenger info is empty or not --}}


                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row pb-2">
                                    <div class="col-5">
                                        <h3>Action</h3>

                                    </div>
                                    <div class="col-7">

                                        <select id="tab_status" class="form-control"
                                            onchange="location = this.value;">

                                            <!--@foreach ($links as $link)
-->
                                            <!--    <option id="{{ $link->status->name }}"-->
                                            <!--        value="{{ url($link->link, ['id' => $tabinfo->id]) }}"-->
                                            <!--        @if ($tabinfo->status_id === $link->status_id)
selected
@endif-->
                                            <!--        @if (Auth::user()->hasRole('Admin') && !Auth::user()->can($link->status->name))
disabled
@endif>-->

                                            <!--        {{ $link->status->name }}-->
                                            <!--    </option>-->
                                            <!--
@endforeach-->
                                            <option id="Submitted"
                                                value="{{ url('admin/TabRequestSubmitted', ['id' => $tabinfo->id]) }}"
                                                @if ($tabinfo->status_id === 5) selected @endif
                                                @if (Auth::user()->hasRole('Admin') && !Auth::user()->can('Submitted')) disabled @endif>Submitted
                                            </option>
                                            <option id="Processing"
                                                value="{{ url('admin/TabRequestProcessing', ['id' => $tabinfo->id]) }}"
                                                @if ($tabinfo->status_id === 1) selected @endif
                                                @if (Auth::user()->hasRole('Admin') && !Auth::user()->can('Processing')) disabled @endif>Processing
                                            </option>
                                            <option id="Completed"
                                                value="{{ url('admin/TabRequestCompleted', ['id' => $tabinfo->id]) }}"
                                                @if ($tabinfo->status_id === 7) selected @endif
                                                @if (Auth::user()->hasRole('Admin') && !Auth::user()->can('Completed')) disabled @endif>Completed
                                            </option>
                                            <option id="Rejected"
                                                value="{{ url('admin/TabRequestRejected', ['id' => $tabinfo->id]) }}"
                                                @if ($tabinfo->status_id === 4) selected @endif
                                                @if (!Auth::user()->hasRole('Admin') && !Auth::user()->can('Rejected')) disabled @endif>Rejected
                                            </option>
                                            <option id="Posted"
                                                value="{{ url('admin/TabRequestPosted', ['id' => $tabinfo->id]) }}"
                                                @if ($tabinfo->status_id === 6) selected @endif
                                                @if (Auth::user()->hasRole('Admin') && !Auth::user()->can('Posted')) disabled @endif>Posted
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Agency Name</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>
                                            @if ($customer)
                                                {{ $customer->agency_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Booking Source</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->booking_source->booking_source }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>PNR</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->pnr }}
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Sector</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->sector }}
                                        </p>
                                    </div>
                                </div> --}}
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Airline</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->airline->airline_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Passenger Name</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->passenger_name }}
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Travel Date</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->date }}
                                        </p>

                                    </div>
                                </div> --}}
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Phone#</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $customer->phone }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Contact Name</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $customer->contact }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h5>Mobile</h5>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $customer->mobile }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="horizontal-scrollable bg-white p-3">
                    {{-- {{ count($passengers) }} --}}
                    @if ($passengers && isset($passengers) && count($passengers) > 0)
                        <div class="d-flex"></div>
                    @else
                        <div class="row d-flex">
                            <div class="col-md-4">
                                <select name="total_passenger" id="total_passenger"
                                    class="form-control total_passenger">
                                    <option selected disabled>Select # of passengers</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <div class="col-md-5 d-flex">
                                <p id="nopas">0</p>
                                <p> &nbsp; of 20</p>
                            </div>

                            <div class="col-md-3">

                            </div>
                        </div>
                    @endif
                    <div class="row text-center">
                        <div class="col-8">
                            <div class="row d-flex">

                                <div class="col-3">
                                    <p>Type</p>
                                </div>
                                <div class="col-3">
                                    <p>Title</p>
                                </div>
                                <div class="col-3">
                                    <p>Passenger Name</p>
                                </div>
                                <div class="col-3">
                                    <p>Ticket</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-8">
                            <div class="row d-flex mt-2">
                                <div class="col-2">
                                    <p>Amount</p>
                                </div>
                                <div class="col-2">
                                    <p>Paid Amount</p>
                                </div>
                                <div class="col-2">
                                    <p>Vendor</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if ($passengers && isset($passengers) && count($passengers) > 0)
                        @foreach ($passengers as $passenger)
                            <div class='passenger-info-update-form'>
                                <div class="row text-center main_content">
                                    <div class="col-8">
                                        <div class="row d-flex">
                                            <div class="col-1">

                                                <input type="hidden" name="passenger_id" class="passenger_id"
                                                    value="{{ $passenger->id }}" />
                                                {{-- <?php $i = $i + 1; ?> --}}
                                            </div>
                                            <div class="col-3">
                                                <select class="form-control type" name="type" required>
                                                    <option value="adult"
                                                        @if ($passenger->type == 'adult') selected @endif>
                                                        Adult
                                                    </option>
                                                    <option value="child"
                                                        @if ($passenger->type == 'child') selected @endif>
                                                        Child
                                                    </option>
                                                    <option value="infant"
                                                        @if ($passenger->type == 'infant') selected @endif>
                                                        Infant
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <select class="form-control title" name="title" required>
                                                    <option value="mr"
                                                        @if ($passenger->title == 'mr') selected @endif>MR
                                                    </option>
                                                    <option value="mrs"
                                                        @if ($passenger->title == 'mrs') selected @endif>MSTR
                                                    </option>
                                                    <option value="miss"
                                                        @if ($passenger->title == 'miss') selected @endif>
                                                        MISS
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <input type="text" class="form-control passenger_name"
                                                    name="passenger_name" value="{{ $passenger->passenger_name }}"
                                                    required />
                                            </div>
                                            <div class="col-3">
                                                <input type="text" class="form-control ticket" name="ticket"
                                                    maxlength="14" value="{{ $passenger->ticket }}" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="row d-flex">
                                            <div class="col-2">
                                                <input type="text" class="form-control p_value" name="p_value"
                                                    maxlength="7"value="{{ $passenger->price->value }}" />
                                            </div>

                                            <div class="col-2">
                                                <input type="text" class="form-control v_value" name="v_value"
                                                    maxlength="7"
                                                    value="@if ($passenger->vendor) {{ $passenger->vendor->value }} @endif" />
                                            </div>

                                            <div class="col-2">

                                                <select class="form-control vendor_id" name="vendor_id">
                                                    <option disabled>Select Vendor </option>
                                                    @if ($vendor && isset($vendor))
                                                        @foreach ($vendor as $vend)
                                                            <option value="{{ $vend->id }}"
                                                                @if ($passenger->vendor->vendor_id == $vend->id) selected @endif>
                                                                {{ $vend->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="label">Remarks</label>
                                        @if ($passenger->remarks)
                                            <textarea class="form-control border remarks" required>
                                                    {{ $passenger->remarks }}
                                        </textarea>
                                        @endif
                                    </div>


                                </div>
                                <div class="container-fluid">
                                    <button class="btn btn-primary updatepassenger float-right" type="button"
                                        style="z-index: 999 !important;">Update</button>
                                    <button class="btn btn-danger deletepassenger float-right" type="button"
                                        style="z-index: 999 !important;">Delete</button>
                                </div>

                            </div>
                        @endforeach
                        <div class='container-fluid'>
                            <div class='container-fluid card bg-light mb-3" style="max-width: 18rem;'>
                                <div class="card-header">
                                    Add Passenger
                                </div>
                                <div class="card-body">
                                    <div class='passenger-info-form-on-update'>
                                        <div class="row text-center main_content">
                                            <div class="col-sm">
                                                <div class="row d-flex">
                                                    <div class="col-3">
                                                        <label class="font-weight-bold label">Type</label>

                                                        <select class="form-control type" name="type" required>
                                                            <option value="adult">Adult</option>
                                                            <option value="child">Child</option>
                                                            <option value="infant">Infant</option>

                                                        </select>
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="font-weight-bold label">Title</label>

                                                        <select class="form-control title" name="title" required>
                                                            <option value="mr">MR</option>
                                                            <option value="mrs">MSTR</option>
                                                            <option value="miss">MISS</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="font-weight-bold label">Passenger Name</label>

                                                        <input type="text" class="form-control passenger_name"
                                                            name="passenger_name" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="font-weight-bold label">Ticket</label>

                                                        <input type="text" class="form-control ticket"
                                                            name="ticket" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="row d-flex">
                                                    <div class="col-2">
                                                        <label class="font-weight-bold label">Amount</label>

                                                        <input type="text" class="form-control p_value"
                                                            name="p_value" />
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="font-weight-bold label">Paid Amount</label>

                                                        <input type="text" class="form-control v_value"
                                                            name="v_value" />
                                                    </div>
                                                    <div class="col-2">
                                                        <label class="font-weight-bold label">Vendor</label>

                                                        <select class="form-control vendor_id" name="vendor_id">
                                                            <option disabled>Select Vendor </option>
                                                            @if ($vendor && isset($vendor))
                                                                @foreach ($vendor as $vend)
                                                                    <option value="{{ $vend->id }}"
                                                                        @if ($passenger->vendor->vendor_id == $vend->id) selected @endif>
                                                                        {{ $vend->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="label">Remarks</label>
                                                <textarea class="form-control border remarks" required></textarea>
                                            </div>

                                        </div>

                                        <input type="hidden" value="{{ $tabinfo->id }}" id="tabid_add" />
                                        <div class="content">
                                            <button type="button" class="btn btn-success pull-right"
                                                id="addPassengerOnUpdate" href="#right-panel">Add</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="button" class="btn btn-primary passenger_information">Update</button> --}}
                    @else
                        <div id="passenger-form-container"></div>

                        <form id='passenger-form-c' action="{{ url('admin/update_passenger_info/' . $tabinfo->id) }}"
                            method="PUT">
                            @csrf

                            <button class="btn btn-primary save" type="button">Submit</button>
                        </form>
                    @endif
                </div>

            </div>
            <footer class="footer">
                <div class=" container-fluid ">
                    <div class="copyright" id="copyright">
                        @
                        <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Developed by <a href="https://therevolutiontechnologies.com"
                            target="_blank">The Revolution Technologies</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('js/core/popper.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <!-- Chart JS -->
    <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/now-ui-dashboard.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            previousDateFreeze();
            freezeStatus();
        })

        function previousDateFreeze() {
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            // alert(maxDate);
            $('#date').attr('min', maxDate);
        }

        function freezeStatus() {
            let statusValue = $('#tab_status').children(":selected").attr("id");
            //console.log(statusValue);
            switch (statusValue) {
                case 'Rejected':
                    $('#Submitted').attr("disabled", true);
                    $('#Completed').attr("disabled", true);
                    $('#Posted').attr("disabled", true);
                    $('#Processing').attr("disabled", true);
                    break;
                case 'Posted':
                    $('#Rejected').attr("disabled", true);
                    break;
                case 'Completed':
                    $('#Completed').attr("disabled", true);
                    break;
                case 'Processing':
                    $('#Posted').attr("disabled", true);
                    $('#Rejected').attr("disabled", false);
                    break;
                default:
                    $('#Rejected').attr("disabled", true);
                    $('#Posted').attr("disabled", true);



            }
            // if (statusValue === 'Rejected') {
            //     $('#Submitted').attr("disabled", true);
            //     $('#Completed').attr("disabled", true);
            //     $('#Posted').attr("disabled", true);
            //     $('#Processing').attr("disabled", true);
            // } else if (statusValue === 'Posted') {
            //     $('#Submitted').attr("disabled", true);
            //     $('#Completed').attr("disabled", true);
            //     $('#Rejected').attr("disabled", true);
            //     $('#Processing').attr("disabled", true);
            // } else if (statusValue == "Submitted") {
            //     $('#Rejected').attr("disabled", true);
            //     $('#Posted').attr("disabled", true);

            // } else if (statusValue == "Completed") {

            // }
            /**
             * statusValue == 'Submitted'
             *  or statusValue == 'Rejected'
             *  or statusValue == 'Posted'
             *  or statusValue == 'Processing'
             *  or statusValue == 'Approved'
             * or statusValue == 'Pending'
             * or statusValue == 'Completed'
             *
             *
             */
            //if ledger or passenger does not exist then disabled posted and rejected action
            if (!$('#checkData').val()) {
                console.log('here==')
                $('#Posted').attr('disabled', true);
                $('#Rejected').attr('disabled', true);
            }
            console.log('ledger and passengers exists : ', $('#checkData').val());



        }
        // $(document).on('change', '#tab_status', function(e) {
        //     let statusValue = $(this).children(":selected").attr("id");
        //     if (statusValue === 'Processing') {
        //         $('#Submitted').attr("disabled", true);
        //         $('#Completed').attr("disabled", true);
        //         $('#Rejected').attr("disabled", false);

        //     }
        // });
        $(document).on('change', '#total_passenger', function(e) {
            var i = 1;
            var container = $('#passenger-form-container').empty();
            $('#nopas').html($('#total_passenger').val())
            console.log($('#total_passenger').val())
            const count = $(this).val();
            for (var i = 0; i < count; i++) {
                addPassengerForm();
            }

            var srNum = $('.srNum')
            srNum.each(function(i, ele) {
                console.log('element', ele)
                $(ele).html(i + 1);
                console.log('index', i)
            })
            $.ajax({
                url: '/admin/getVendor',
                method: 'get',
                success: function(e) {
                    var option = '';
                    for (var i = 0; i < e.length; i++) {
                        option += `<option value=${e[i].id}>${e[i].name}</option>`
                    }
                    $('.vendor_id').append(option)
                    {{-- console.log(e); --}}
                }
            });
        });
        $(document).on('change', '.payment_type', function() {
            var value = $(this).val();
            if (value === 'fixed') {
                var main_content = $(this).closest('.main_content');
                {{-- console.log(main_content) --}}
                $(main_content).find('.p_basic').prop('disabled', true);
                $(main_content).find('.p_tax').prop('disabled', true);
                $(main_content).find('.p_discount').prop('disabled', true);
                $(main_content).find('.p_value').prop('disabled', false);
            } else if (value === 'commision' || value === 'discount') {
                var main_content = $(this).closest('.main_content');
                console.log(main_content)
                $(main_content).find('.p_basic').prop('disabled', false);
                $(main_content).find('.p_tax').prop('disabled', false);
                $(main_content).find('.p_discount').prop('disabled', false);
                $(main_content).find('.p_value').prop('disabled', true);
            } else {
                var main_content = $(this).closest('.main_content');
                console.log(main_content)
                $(main_content).find('.p_basic').prop('disabled', false);
                $(main_content).find('.p_tax').prop('disabled', false);
                $(main_content).find('.p_discount').prop('disabled', false);
            }

        });
        $(document).on('change', '.p_tax', function() {

            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).val());
                basic = parseInt($(this).closest('.main_content').find('.p_basic').val());
                price = basic;
                let total_price = 0;
                dis_percentage = parseInt($(this).closest('.main_content').find('.p_discount').val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.p_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.p_value').val(0);
                    console.log($(this))
                }
            }

        });
        $(document).on('change', '.p_basic', function() {
            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).closest('.main_content').find('.p_tax').val());
                basic = parseInt($(this).val());
                price = basic;
                let total_price = 0;
                dis_percentage = parseInt($(this).closest('.main_content').find('.p_discount').val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.p_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.p_value').val(0);
                    console.log($(this))
                }
            }

        });
        $(document).on('change', '.p_discount', function() {
            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).closest('.main_content').find('.p_tax').val());
                basic = parseInt($(this).closest('.main_content').find('.p_basic').val());
                price = basic;
                let total_price = 0;
                let dis_percentage = parseInt($(this).val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.p_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.p_value').val(0);
                    console.log($(this))
                }
            }

        });

        // last passenger dropdowm freez coding start here

        $(document).on('change', '.v_payment_type', function() {
            var value = $(this).val();
            if (value === 'fixed') {
                var main_content = $(this).closest('.main_content');
                {{-- console.log(main_content) --}}
                $(main_content).find('.v_basic').prop('disabled', true);
                $(main_content).find('.v_tax').prop('disabled', true);
                $(main_content).find('.v_discount').prop('disabled', true);
                $(main_content).find('.v_value').prop('disabled', false);
            } else if (value === 'commision' || value === 'discount') {
                var main_content = $(this).closest('.main_content');
                console.log(main_content)
                $(main_content).find('.v_basic').prop('disabled', false);
                $(main_content).find('.v_tax').prop('disabled', false);
                $(main_content).find('.v_discount').prop('disabled', false);
                $(main_content).find('.v_value').prop('disabled', true);
            } else {
                var main_content = $(this).closest('.main_content');
                console.log(main_content)
                $(main_content).find('.v_basic').prop('disabled', false);
                $(main_content).find('.v_tax').prop('disabled', false);
                $(main_content).find('.v_discount').prop('disabled', false);
            }

        });
        $(document).on('change', '.v_tax', function() {

            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.v_payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).val());
                basic = parseInt($(this).closest('.main_content').find('.v_basic').val());
                price = basic;
                let total_price = 0;
                dis_percentage = parseInt($(this).closest('.main_content').find('.v_discount').val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.v_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.v_value').val(0);
                    console.log($(this))
                }
            }

        });


        $(document).on('change', '.v_basic', function() {
            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.v_payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).closest('.main_content').find('.v_tax').val());
                basic = parseInt($(this).val());
                price = basic;
                let total_price = 0;
                dis_percentage = parseInt($(this).closest('.main_content').find('.v_discount').val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.v_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.v_value').val(0);
                    console.log($(this))
                }
            }

        });
        $(document).on('change', '.v_discount', function() {
            let tax, basic, price = 0;
            let dis_percentage = 0;
            var type = $(this).closest('.main_content').find('.v_payment_type').val();
            if (type === 'commision' || type === 'discount') {
                tax = parseInt($(this).closest('.main_content').find('.v_tax').val());
                basic = parseInt($(this).closest('.main_content').find('.v_basic').val());
                price = basic;
                let total_price = 0;
                let dis_percentage = parseInt($(this).val());
                const finalPrice = dis_percentage * price;
                const discount = finalPrice / 100;
                if (type === 'commision') {
                    total_price = price + discount + tax;

                } else {
                    total_price = price - discount + tax;

                }
                console.log('tex', dis_percentage, price, finalPrice, discount, basic, tax)
                if (total_price > 0) {
                    $(this).parents('.main_content').find('.v_value').val(total_price);
                    console.log($(this))
                } else {
                    $(this).parents('.main_content').find('.v_value').val(0);
                    console.log($(this))
                }
            }

        });



        // last passenger dropdowm freez coding end here

        $(document).on('click', '.save', function() {
            savePassengerForm()


        });



        $(document).on('click', '.updateLedger', function() {

            UpdateLedgerForm();
        });
        $(document).on('click', '.updatepassenger', function() {
            var passenger = $(this).closest('.passenger-info-update-form');
            // console.log(passenger.find('.passenger_id').val());
            updatePassengerForm(passenger);

        });
        $(document).on('change', '.type', function() {
            if (this.value === 'infant') {
                $(".title option[value='mr']").hide();
            } else if (this.value === 'child') {
                $(".title option[value='mr']").hide();
                $(".title option[value='mrs']").text('MISTR');

            } else {
                $(".title option[value='mr']").show();

            }


        });

        function addPassengerForm() {
            var tempalte = $('#template-row-passenger-info').html();
            var container = $('#passenger-form-container');

            container.append(tempalte);

        }
        $(document).click(function() {
            $('.deleteTemplate').on('click', function() {
                $(this).closest('.passenger-info-form').remove();
                var srNum = $('.srNum')
                srNum.each(function(i, ele) {
                    console.log('element', ele)
                    i++;
                    $(ele).html(i--);
                    console.log('index', i)

                })
            });
        });

        function savePassengerForm(e) {
            var id = $('#tabinfo_id').val();
            {{-- e.preventDefault(); --}}

            var data = getPassengerData();
            var ledger = getLedgerData();

            if (!data || !ledger) {
                alert("Some Fields are empty");
            } else {
                $.ajax({
                    url: `/admin/add_passenger_info/${id}`,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'data': {
                            passenger: data,
                            ledger
                        }
                    },
                    {{-- headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }, --}}
                    method: 'POST',
                    success: function(e) {
                        console.log(e);
                        if (e.status == 200) {
                            alert('TabInfo information proceeded successfully');
                            setInterval(window.location.reload(true), 1000);
                        }

                    }
                });
            }



        }

        function updatePassengerForm(passenger) {
            var id = $('#tabinfo_id').val();
            {{-- e.preventDefault(); --}}

            var passenger = getPassengerUpdatedData(passenger);
            console.log(passenger);
            var url = "{{ route('passengerUpdate', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        passenger
                    }
                },
                {{-- headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }, --}}
                method: 'GET',
                success: function(e) {

                    if (e.status == 200) {
                        alert('Passenger information Updated successfully');
                        //window.location.reload()
                    }

                }
            });
        }

        // function UpdatePassengerForm(e) {
        //     var id = $('#tabinfo_id').val();
        //     {{-- e.preventDefault(); --}}
        //     var data = getPassengerUpdatedData();
        //     var ledger = getUpdatedeLedgerData();
        //     console.log(
        //         ledger
        //     );
        //     if (!data || !ledger) {

        //         alert("Field is Empty");
        //     } else {
        //         $.ajax({
        //             url: `/admin/update_passenger_info/${id}`,
        //             data: {
        //                 '_token': '{{ csrf_token() }}',
        //                 'data': {
        //                     passenger: data,
        //                     ledger: ledger
        //                 }
        //             },
        //             method: 'POST',
        //             success: function(e) {
        //                 console.log(e.status);
        //                 if (e.status == 200) {
        //                     alert('Passenger information updated successfully');
        //                     window.location.reload()

        //                 } else {
        //                     alert('All field required')
        //                 }
        //             }
        //         });
        //     }

        //     {{-- console.log(data); --}}

        // }
        function UpdateLedgerForm(e) {
            var id = $('#tabinfo_id').val();
            var ledger = getUpdatedeLedgerData();
            console.log(JSON.stringify(ledger));
            var url = "{{ route('ledgerUpdate', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        ledger
                    }
                },
                method: 'GET',
                success: function(e) {
                    console.log(e.status);
                    if (e.status == 200) {
                        alert('Ledger information updated successfully');
                        //window.location.reload()

                    } else {
                        alert('All field required')
                    }
                }
            });
        }



        function getPassengerUpdatedData(passenger) {
            var arr = [];
            //var passengerEl = $('.passenger-info-update-form');


            var obj = {};
            obj.id = passenger.find('.passenger_id').val();


            obj.title = passenger.find('.title').val();

            obj.type = passenger.find('.type').val();

            obj.ticket = passenger.find('.ticket').val();

            obj.passenger_name = passenger.find('.passenger_name').val();

            obj.payment_type = passenger.find('.payment_type').val();



            obj.p_basic = passenger.find('.p_basic').val();

            obj.p_tax = passenger.find('.p_tax').val();

            obj.p_discount = passenger.find('.p_discount').val();

            obj.p_value = passenger.find('.p_value').val();

            obj.v_payment_type = passenger.find('.v_payment_type').val();

            obj.v_basic = passenger.find('.v_basic').val();

            obj.v_tax = passenger.find('.v_tax').val();

            obj.v_discount = passenger.find('.v_discount').val();

            obj.v_value = $.trim(passenger.find('.v_value').val());

            obj.remarks = passenger.find('.remarks').val();

            obj.vendor_id = passenger.find('.vendor_id').val();


            arr.push(obj);


            return arr;
        }

        function getPassengerData() {
            var arr = [];

            var passengerEl = $('.passenger-info-form');

            passengerEl.each(function(i, v) {
                var obj = {};


                //obj.title = $(v).find('.title').val();
                if ($(v).find('.title').val() == "" || $(v).find('.title').val() == null) {
                    $(this).find('.title').css("border-color", "red");
                    return false;

                } else {
                    obj.title = $(v).find('.title').val();
                }
                //obj.type = $(v).find('.type').val();
                if ($(v).find('.type').val() == "" || $(v).find('.type').val() == null) {
                    $(this).find('.type').css('border-color', 'red');
                    return false;
                } else {
                    obj.type = $(v).find('.type').val();
                }
                //obj.ticket = $(v).find('.ticket').val();
                if ($(v).find('.ticket').val() == "" || $(v).find('.ticket').val() == null) {
                    $(this).find('.ticket').css("border-color", "red");
                    return false;

                } else {
                    obj.ticket = $(v).find('.ticket').val();
                }
                //obj.passenger_name = $(v).find('.passenger_name').val();
                if ($(v).find('.passenger_name').val() == "" || $(v).find('.passenger_name').val() == null) {
                    $(this).find('.passenger_name').css("border-color", "red");
                    return false;

                } else {
                    obj.passenger_name = $(v).find('.passenger_name').val();
                }
                //obj.p_value = $(v).find('.p_value').val();
                if ($(v).find('.p_value').val() == "" || $(v).find('.p_value').val() == null) {
                    $(this).find('.p_value').css("border-color", "red");
                    return false;

                } else {
                    obj.p_value = $(v).find('.p_value').val();
                }
                //obj.v_value = $(v).find('.v_value').val();
                if ($(v).find('.v_value').val() == "" || $(v).find('.v_value').val() == null) {
                    $(this).find('.v_value').css("border-color", "red");
                    return false;

                } else {
                    obj.v_value = $(v).find('.v_value').val();
                }
                //obj.remarks = $(v).find('.remarks').val();
                if ($(v).find('.remarks').val() == "" || $(v).find('.remarks').val() == null) {
                    $(this).find('.remarks').css("border-color", "red");
                    return false;

                } else {
                    obj.remarks = $.trim($(v).find('.remarks').val());
                }
                //obj.vendor_id = $(v).find('.vendor_id').val();
                if ($(v).find('.vendor_id').val() == "" || $(v).find('.vendor_id').val() == null) {
                    $(this).find('.vendor_id').css("border-color", "red");
                    return false;

                } else {
                    obj.vendor_id = $(v).find('.vendor_id').val();
                }

                arr.push(obj);
            });

            return arr;
        }


        function getLedgerData() {
            var arr = []
            var obj = {}
            //obj.date = $('#date').val();
            if ($('#date').val() == "" || $('#date').val() == null) {
                $('#date').css("border-color", "red");
                return false;

            } else {
                obj.date = $('#date').val();

            }
            //obj.transaction = $('#transaction').val();
            if ($('#transaction').val() == "" || $('#transaction').val() == null) {
                $('#transaction').css("border-color", "red");
                return false;

            } else {
                obj.transaction = $('#transaction').val();

            }
            //obj.agency_name = $('#agency_name').val();
            if ($('#agency_name').val() == "" || $('#agency_name').val() == null) {
                $('#agency_name').css("border-color", "red");
                return false;

            } else {
                obj.agency_name = $('#agency_name').val();

            }
            //obj.booking_id = $('#booking_id').val();
            if ($('#booking_id').val() == "" || $('#booking_id').val() == null) {
                $('#booking_id').css("border-color", "red");
                return false;

            } else {
                obj.booking_id = $('#booking_id').val();

            }
            //obj.airline_id = $('#airline_id').val();
            if ($("#airline_id").val() == "" || $("#airline_id").val() == null) {
                $("#airline_id").css("border-color", "red");
                return false;

            } else {
                obj.airline_id = $('#airline_id').val();

            }
            //obj.ticket_type = $('#ticket_type').val();
            if ($('#ticket_type').val() == "" || $('#ticket_type').val() == null) {
                $('#ticket_type').css("border-color", "red");
                return false;

            } else {
                obj.ticket_type = $('#ticket_type').val();

            }
            //obj.pnr = $('#pnr').val();
            if ($('#pnr').val() == "" || $('#pnr').val() == null) {
                $('#pnr').css("border-color", "red");
                return false;

            } else {
                obj.pnr = $('#pnr').val();

            }
            //obj.to = $('#to').val();
            if ($('#to').val() == "" || $('#to').val() == null) {
                $('#to').css("border-color", "red");
                return false;

            } else {
                obj.to = $('#to').val();

            }
            //obj.from = $('#from').val();
            if ($('#from').val() == "" || $('#from').val() == null) {
                $('#from').css("border-color", "red");

                return false;

            } else {
                obj.from = $('#from').val();

            }
            //obj.dep_date = $('#dep_date').val();
            if ($('#dep_date').val() == "" || $('#dep_date').val() == null) {
                $('#dep_date').css("border-color", "red");
                return false;

            } else {
                obj.dep_date = $('#dep_date').val();

            }
            //obj.arr_date = $('#arr_date').val();
            if ($('#arr_date').val() == "" || $('#arr_date').val() == null) {
                $('#arr_date').css("border-color", "red");
                return false;

            } else {
                obj.arr_date = $('#arr_date').val();

            }
            arr.push(obj)
            return arr;
        }

        function getUpdatedeLedgerData() {
            var arr = []
            var obj = {}
            obj.date = $('#date').val();


            obj.ledger_id = $('#ledger_id').val();


            obj.transaction = $('#transaction_type').val();


            //obj.agency_name = $('#agency_name').val();

            obj.agency_name = $.trim($('#agency_name').val());



            obj.booking_id = $('#booking_id').val();



            obj.airline_id = $('#airline_id').val();



            obj.ticket_type = $('#ticket_type').val();



            obj.pnr = $('#pnr').val();



            obj.to = $('#to').val();



            obj.from = $('#from').val();



            obj.dep_date = $('#dep_date').val();


            obj.arr_date = $('#arr_date').val();

            arr.push(obj)
            return arr;
        }

        $(document).on('click', '#addPassengerOnUpdate', function() {




            let obj = {};
            obj.title = $('.passenger-info-form-on-update').find('.title').val();

            obj.type = $('.passenger-info-form-on-update').find('.type').val();

            obj.ticket = $('.passenger-info-form-on-update').find('.ticket').val();

            obj.passenger_name = $('.passenger-info-form-on-update').find('.passenger_name').val();

            obj.p_value = $('.passenger-info-form-on-update').find('.p_value').val();

            obj.v_value = $('.passenger-info-form-on-update').find('.v_value').val();

            obj.remarks = $('.passenger-info-form-on-update').find('.remarks').val();


            obj.vendor_id = $('.passenger-info-form-on-update').find('.vendor_id').val();


            obj.tab_id = $('.passenger-info-form-on-update').find('#tabid_add').val();






            $.ajax({
                url: `/admin/add_passenger_on_update`,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        passenger: obj,

                    }
                },
                {{-- headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }, --}}
                method: 'GET',
                success: function(e) {
                    console.log(e);
                    if (e.status == 200) {
                        alert('Passenger added for this tab sucessfully');
                        window.location.reload()
                    }

                }
            });

        });
        $('.deletepassenger').on('click', function() {
            let passenger_id = $('.passenger_id').val();
            console.log(passenger_id);
            $.ajax({
                url: `/admin/delete_passenger`,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        passenger: passenger_id,

                    }
                },
                {{-- headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }, --}}
                method: 'GET',
                success: function(e) {
                    console.log(e);
                    if (e.status == 200) {
                        alert('Passenger Deleted for this tab sucessfully');
                        window.location.reload()
                    }

                }
            });
        });
    </script>


    <script type="text/html" id="template-row-passenger-info">
        <div class='passenger-info-form'>
            <div class="row text-center main_content">
                <div class="col-8">
                    <div class="row d-flex">
                        <div class="col-1">
                            <p class="srNum"></p>
                        </div>
                        <div class="col-2">
                            <select class="form-control type" name="type" required>
                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                                <option value="infant">Infant</option>

                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control title" name="title" required>
                                <option value="mr">MR</option>
                                <option value="mrs">MSTR</option>
                                <option value="miss">MISS</option>
                            </select>
                        </div>
                        <div class="col-3" >
                            <input type="text" class="form-control passenger_name" name="passenger_name" required />
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control ticket" maxlength="14" name="ticket" required />
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row d-flex">
                        <div class="col-2">
                            <input type="text" class="form-control p_value" maxlength="7" name="p_value" />
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control v_value" maxlength="7" name="v_value" />
                        </div>
                        <div class="col-4">
                            <select class="form-control vendor_id" name="vendor_id">
                                <option disabled selected>Select Vendor </option>

                            </select>
                        </div>
                        {{-- <div class="col-4">
                            <select class="form-control payment_type" name="payment_type" required>
                                <option disabled selected> Select payment type</option>
                                <option value="fixed">Fixed</option>
                                <option value="commision">Commision</option>
                                <option value="discount">Discount</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control p_basic" name="p_basic" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control p_tax" name="p_tax" />
                        </div> --}}
                    </div>
                </div>
                {{-- <div class="col-4">
                    <div class="row d-flex">
                        <div class="col-4">
                            <input type="text" class="form-control p_discount" name="p_discount" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control p_value" name="p_value" />
                        </div>
                        <div class="col-4">
                            <select class="form-control vendor_id" name="vendor_id">
                                <option disabled selected>Select Vendor </option>

                            </select>
                        </div>
                    </div>
                </div> --}}
                {{-- lasst form start --}}
                {{-- <div class="col-4" style="background: #E5E7E9;">
                    <div class="row d-flex">
                        <div class="col-4">
                            <select class="form-control v_payment_type" name="v_payment_type" required>
                                <option disabled selected> Select payment type</option>
                                <option value="fixed">Fixed</option>
                                <option value="commision">Commision</option>
                                <option value="discount">Discount</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control v_basic" name="v_basic" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control v_tax" name="v_tax" />
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-4" style="background: #E5E7E9; margin-left:-5px">
                    <div class="row d-flex">
                        <div class="col-5">
                            <input type="text" class="form-control v_discount" name="v_discount" />
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control v_value" name="v_value" />
                        </div>

                    </div>
                </div> --}}
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="label">Remarks</label>
                    <textarea class="form-control border remarks" required></textarea>
                </div>

            </div>
            <div class="content">
                <button type="button" class="btn btn-danger pull-right deleteTemplate"  href="#right-panel">-</button>

            </div>
        </div>
    </script>
</body>

</html>
