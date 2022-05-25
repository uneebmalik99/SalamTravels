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
                        <div class="card">
                            @if ($ledger && isset($ledger))
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Date
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->date }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Transaction
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->transaction }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Agency Name
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ 'asfdsfds' }}
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Booking Source
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->booking->booking_source }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Airline
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->airline->airline_name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Ticket Type
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->ticket_type_id }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        PNR
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->pnr }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        To
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->to }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        From
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->from }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Dep Date
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->dep_date }}
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="label">
                                                        Arrival Date
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="label">
                                                        {{ $ledger->arr_date }}
                                                    </label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row pb-2">
                                    <div class="col-5">
                                        <h3>Action</h3>
                                    </div>
                                    <div class="col-7">
                                        {{-- <select class="form-control" onchange="location = this.value;">
                                            @foreach ($links as $link)
                                                <option value="{{ url($link->link, ['id' => $tabinfo->id]) }}"
                                                    @if ($tabinfo->status_id === $link->status_id) selected @endif>
                                                    {{ $link->status->name }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Agency Name</h6>
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
                                        <h6>Booking Source</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->booking_source->booking_source }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>PNR</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->pnr }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Sector</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->sector }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Airline</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->airline->airline_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Passenger Name</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->passenger_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Travel Date</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->date }}
                                        </p>
                                        {{-- <p>{{ $tabinfo->created_at }}</p> --}}
                                    </div>
                                </div>
                                <div class="row pb-lg-2">
                                    <div class="col-5">
                                        <h6>Remarks</h6>
                                    </div>
                                    <div class="col-7">
                                        <p>{{ $tabinfo->remarks }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="horizontal-scrollable bg-white p-3">
                    <div class="row text-center">
                        <div class="col-8">
                            <div class="row d-flex">
                                <div class="col-1">
                                    <p>Sr.#</p>
                                </div>
                                <div class="col-2">
                                    <p>Type</p>
                                </div>
                                <div class="col-2">
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
                        <div class="col-4">
                            <div class="row d-flex">
                                <div class="col-5">
                                    <p>Amount</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if ($passenger && isset($passenger))
                        <?php $i = 1; ?>

                        @foreach ($passenger as $psng)
                            <div class="row text-center">
                                <div class="col-8">
                                    <div class="row d-flex">
                                        <div class="col-1">
                                            <p>{{ $i }}</p>
                                            <?php $i = i + 1; ?>
                                        </div>
                                        <div class="col-2">
                                            <p>{{ $psng->type }}</p>
                                        </div>
                                        <div class="col-2">
                                            <p>{{ $psng->title }}</p>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $psng->passenger_name }}</p>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $psng->ticket }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row d-flex">
                                        <div class="col-5">
                                            <p>{{ $psng->price->value }}</p>
                                        </div>
                                        {{-- <div class="col-5">
                                        <p>{{ $psng->vendor->value }}</p>
                                    </div> --}}
                                        {{-- <div class="col-5">
                                        <p>{{ $psng->payment_type }}</p>
                                    </div>
                                    <div class="col-3">
                                        <p>{{ $psng->price->basic }}</p>
                                    </div>
                                    <div class="col-3">
                                        <p>{{ $psng->price->tax }}</p>
                                    </div> --}}
                                    </div>
                                </div>
                                {{-- <div class="col-4">
                                <div class="row d-flex">
                                    <div class="col-4">
                                        <p>{{ $psng->price->discount }}</p>
                                    </div>
                                    <div class="col-4">
                                        <p>{{ $psng->price->value }}</p>
                                    </div>
                                </div>
                            </div> --}}
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label class="label">Remarks</label>
                                    <p>{{ $psng->remarks }}</p>
                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>

            </div>
            <footer class="footer">
                <div class=" container-fluid ">
                    <div class="copyright" id="copyright">
                        <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>, Developed by <a href="https://therevolutiontechnologies.com"
                            target="_blank">The
                            Revolution Technologies</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
