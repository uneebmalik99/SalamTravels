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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet" />
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
                <a href="{{ url('/home') }}" class="simple-text logo-mini">
                    <img src="{{ asset('public/images/') . '/' . $customer->agency_picture }}" class="navbar-brand"
                        width="30" height="30" alt="">
                </a>
                <a href="{{ url('/home') }}" class="simple-text logo-normal text-dark">
                    {{ $customer->agency_name }}

                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="active ">
                        <a href="{{ url('home') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('offlineticket') }}">
                            <i class="fas fa-ticket-alt"></i>
                            <p>Offline Ticket</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('refund') }}">
                            <i class="fas fa-funnel-dollar"></i>
                            <p>Refund</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('void') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Void</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('datechange') }}">
                            <i class="fas fa-calendar-week"></i>
                            <p>Date Change</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('payment') }}">
                            <i class="fas fa-money-bill-wave"></i>
                            <p>Payment</p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('ledger') }}">
                            <i class="now-ui-icons users_single-02"></i>
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
                                        <a href="{{ url('UserProfile') }}" class="dropdown-item">Profile</a>
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

            <div class="content pt-4">
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
                                                        {{ $customer->agency_name }}
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
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class=" m-0 p-0">Action</h3>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->status->name }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Agency Name</p>
                                    </div>
                                    <div class="col-6">
                                        <p>
                                            @if ($customer)
                                                {{ $customer->agency_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Booking Source</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->booking_source->booking_source }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>PNR</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->pnr }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Sector</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->sector }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Airline</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->airline->airline_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Passenger Name</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->passenger_name }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Travel Date</p>
                                    </div>
                                    <div class="col-6">
                                        <p>{{ $tabinfo->date }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Remarks</p>
                                    </div>
                                    <div class="col-6">
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
                                <div class="col-4">
                                    <p>Amount</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if ($passengers && isset($passengers))
                        <?php $i = 1; ?>
                        @foreach ($passengers as $psng)
                            <div class="row text-center">
                                <div class="col-8">
                                    <div class="row d-flex">
                                        <div class="col-1">
                                            <p>{{ $i }}</p>
                                            <?php $i = $i + 1; ?>
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
                                        <div class="col-4">
                                            <p>{{ $psng->price->value }}</p>
                                        </div>
                                    </div>
                                </div>
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
                            target="_blank">The Revolution Technology</a>
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
