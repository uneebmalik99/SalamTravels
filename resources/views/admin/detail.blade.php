<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="blue">
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->
            <div class="logo">
                <a href="{{ url('admin') }}" class="simple-text logo-mini">
                    <img src="{{ asset('images/Salamtravels.jpeg') }}" class="navbar-brand" width="30" height="30"
                        alt="">
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
                                        <a class="nav-link"
                                            href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
            <div class="content bg-white pt-4">
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
                    <div class="col-lg-8 col-sm-10 d-block mx-auto">
                        @if ($ledger && isset($ledger))
                            <form action="{{ url('admin/update_ledger/' . $tabinfo->id) }}" method="POST">
                                @csrf

                                <input type="hidden" name="ledger_id" value="{{ $ledger->id }}" />
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Date</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="date" name="date" required
                                                    value="{{ $ledger->date }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Transaction</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="transaction" autocomplete="off" required
                                                    value="{{ $ledger->transaction }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Agency Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="agency_name" autocomplete="off" required
                                                    value="{{ $ledger->agency_name }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Booking Source</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="booking_id" required>
                                                    <option disabled>-Select Booking Source-</option>
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Airline</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="airline_id" required>
                                                    <option disabled>-Select Airline-</option>
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
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Ticket Type</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="ticket_type" required>
                                                    <option disabled>-Select Ticket Type-</option>
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
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>PNR</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="pnr" autocomplete="off" required value="{{ $ledger->pnr }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label>Sector</label>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>To</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" autocomplete="off" name="to" required
                                                            value="{{ $ledger->to }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>From</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" autocomplete="off" name="from" required
                                                            value="{{ $ledger->from }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Dep Date</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="date" name="dep_date" required
                                                    value="{{ $ledger->dep_date }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Arr Date</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="date" name="arr_date" required
                                                    value="{{ $ledger->arr_date }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        @else
                            <form action="{{ url('admin/ledger/' . $tabinfo->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Date</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="date" name="date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Transaction</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="transaction" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Agency Name</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" autocomplete="off"  name="agency_name" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Booking Source</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="booking_id" required>
                                                    <option selected disabled>-Select Booking Source-</option>
                                                    @if (isset($booking))
                                                        @foreach ($booking as $book)
                                                            <option value="{{ $book->id }}">
                                                                {{ $book->booking_source }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Airline</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="airline_id" required>
                                                    <option selected disabled>-Select Airline-</option>
                                                    @if (isset($airline))
                                                        @foreach ($airline as $air)
                                                            <option value="{{ $air->id }}">
                                                                {{ $air->airline_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Ticket Type</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="ticket_type" required>
                                                    <option disabled>-Select Ticket Type-</option>
                                                    @if (isset($ticket_type))
                                                        @foreach ($ticket_type as $tk)
                                                            <option value="{{ $tk->id }}">
                                                                {{ $tk->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>PNR</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" name="pnr"  autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label>Sector</label>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>To</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" autocomplete="off" name="to" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>From</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" autocomplete="off" name="from" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Dep Date</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="date" name="dep_date" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-5">
                                                <label>Arr Date</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="date" name="arr_date" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="col-lg-4 col-sm-10 d-block mx-auto border border-right-0 border-top-0">
                        <div class="row">
                            <div class="col-6">
                                <label>Action</label>
                            </div>
                            <div class="col-6">
                                <select onchange="location = this.value;">
                                    @foreach ($links as $link)
                                        <option value="{{ url($link->link, ['id' => $tabinfo->id]) }}"
                                            @if ($tabinfo->status_id === $link->status_id) selected @endif>
                                            {{ $link->status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Agency Name</label>
                            </div>
                            <div class="col-6">
                                @if ($customer)
                                    <label>{{ $customer->agency_name }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Booking Source</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->booking_source)
                                    <label>{{ $tabinfo->booking_source->booking_source }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>PNR</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->pnr)
                                    <label>{{ $tabinfo->pnr }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Sector</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->sector)
                                    <label>{{ $tabinfo->sector }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Airline</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->airline)
                                    <label>{{ $tabinfo->airline->airline_name }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Passenger Name</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->passenger_name)
                                    <label>{{ $tabinfo->passenger_name }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Travel Date</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->date)
                                    <label>{{ $tabinfo->date }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label>Remarks</label>
                            </div>
                            <div class="col-6">
                                @if ($tabinfo && $tabinfo->remarks)
                                    <label>{{ $tabinfo->remarks }}</label>
                                @else
                                    <label>--</label>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row table-responsive">

                    {{-- When updating data --}}
                    @if ($passenger && isset($passenger))
                        <form action="{{ url('admin/update_passenger_info/' . $tabinfo->id) }}" method="POST">
                            @csrf

                            <input type="hidden" name="passenger_id" value="{{ $passenger->id }}" />
                            <table class="table">
                                <tr>
                                    <th style="width: 5%;">Sr.#</th>
                                    <th style="width: 10%;">Type</th>
                                    <th style="width: 5%;">Title</th>
                                    <th style="width: 10%;">Passenger Name</th>
                                    <th style="width: 10%;">Ticket</th>
                                    <th style="width: 10%;">P.Type</th>
                                    <td nowrap="nowrap" style="width: 25%;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-3">
                                                <label>Basic</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label>Tax</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3 p-0">
                                                <label>Discount</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label>value</label>
                                            </div>
                                        </div>
                                    </td>
                                    <th style="width: 25%;">Vendor</th>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td style="width: 5%;">1</td>
                                        <td style="width: 10%;">
                                            <select name="type" class="">
                                                <option value="adult"
                                                    @if ($passenger->type === 'adult') selected="selected" @endif>Adult
                                                </option>
                                                <option value="child"
                                                    @if ($passenger->type === 'child') selected="selected" @endif>Child
                                                </option>
                                            </select>
                                        </td>
                                        <td style="width: 5%;">
                                            <select name="title">
                                                <option value="mr"
                                                    @if ($passenger->title === 'mr') selected="selected" @endif>MR
                                                </option>
                                                <option value="mrs"
                                                    @if ($passenger->title === 'mrs') selected="selected" @endif>Mrs
                                                </option>
                                                <option value="miss"
                                                    @if ($passenger->title === 'miss') selected="selected" @endif>Miss
                                                </option>
                                            </select>
                                        </td>
                                        <td style="width: 10%;">
                                            <input style="width: 100%;" name="passenger_name"
                                                value="{{ $passenger->passenger_name }}" />
                                        </td>
                                        <td style="width: 10%;">
                                            <input style="width: 100%;" name="ticket"
                                                value="{{ $passenger->ticket }}" />
                                        </td>
                                        <td style="width:10%;">
                                            <select name="payment_type">
                                                <option value="fixed"
                                                    @if ($passenger->payment_type === 'fixed') selected="selected" @endif>Fixed
                                                </option>
                                                <option value="commision"
                                                    @if ($passenger->payment_type === 'commision') selected="selected" @endif>
                                                    Commision</option>
                                                <option value="discount"
                                                    @if ($passenger->payment_type === 'discount') selected="selected" @endif>
                                                    Discount</option>
                                            </select>
                                        </td>
                                        <td style="width: 500px;">
                                            <div class="row w-100">
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_basic"
                                                        value="{{ $passenger->price->basic }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_tax"
                                                        value="{{ $passenger->price->tax }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_discount"
                                                        value="{{ $passenger->price->discount }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_value"
                                                        value="{{ $passenger->price->value }}" />
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="row w-100">
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_basic"
                                                        value="{{ isset($passenger->vendor->basic) ? $passenger->vendor->basic : '' }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_tax"
                                                        value="{{ isset($passenger->vendor->tax) ? $passenger->vendor->tax : '' }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_discount"
                                                        value="{{ isset($passenger->vendor->discount) ? $passenger->vendor->discount : '' }}" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_value"
                                                        value="{{ isset($passenger->vendor->value) ? $passenger->vendor->value : '' }}" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- {{ $passenger }} --}}
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea class="form-control border" name="remarks"
                                                value="{{ $passenger->remarks }}">{{ $passenger->remarks }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    @else
                        <form action="{{ url('admin/add_passenger_info/' . $tabinfo->id) }}" method="POST">
                            @csrf
                            <table class="table">
                                <tr>
                                    <th style="width: 5%;">Sr.#</th>
                                    <th style="width: 10%;">Type</th>
                                    <th style="width: 5%;">Title</th>
                                    <th style="width: 10%;">Passenger Name</th>
                                    <th style="width: 10%;">Ticket</th>
                                    <th style="width: 10%;">P.Type</th>
                                    <td nowrap="nowrap" style="width: 25%;">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-3">
                                                <label>Basic</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label>Tax</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3 p-0">
                                                <label>Discount</label>
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <label>value</label>
                                            </div>
                                        </div>
                                    </td>
                                    <th style="width: 25%;">Vendor</th>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td style="width: 5%;">1</td>
                                        <td style="width: 10%;">
                                            <select name="type" class="">
                                                <option value="adult">Adult</option>
                                                <option value="child">Child</option>
                                            </select>
                                        </td>
                                        <td style="width: 5%;">
                                            <select name="title">
                                                <option value="mr">MR</option>
                                                <option value="mrs">Mrs</option>
                                                <option value="miss">Miss</option>
                                            </select>
                                        </td>
                                        <td style="width: 10%;">
                                            <input style="width: 100%;" name="passenger_name" />
                                        </td>
                                        <td style="width: 10%;">
                                            <input style="width: 100%;" name="ticket" />
                                        </td>
                                        <td style="width:10%;">
                                            <select name="payment_type">
                                                <option value="fixed">Fixed</option>
                                                <option value="commision">Commision</option>
                                                <option value="discount">Discount</option>
                                            </select>
                                        </td>
                                        <td style="width: 500px;">
                                            <div class="row w-100">
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_basic" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_tax" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_discount" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="p_value" />
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 25%;">
                                            <div class="row w-100">
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_basic" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_tax" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;"  autocomplete="off" name="v_discount" />
                                                </div>
                                                <div class="col-sm-6 col-md-3">
                                                    <input type="text" style="width:50px;" autocomplete="off" name="v_value" />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea class="form-control border" name="remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
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
</body>

</html>
