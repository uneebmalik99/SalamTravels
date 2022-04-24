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

                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        {{-- If Error --}}
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Booking Source</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('admin/add_booking_source') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="">Add Booking Source</label>
                                                <input type="text" name="booking_source" class="form-control"
                                                    required>
                                                @error('booking_source')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </form>
                            </div>

                        </div>
                        <!--Booking Source-->
                        <div class="card mt-5">
                            <div class="card-header">
                                <h4 class="card-title">Booking Source</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Booking Source</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    @if ($data != null)
                                        <?php $i = 1; ?>
                                        @foreach ($data as $record)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $record->booking_source }}</td>
                                                <td>
                                                    @if ($record->enable == 1)
                                                        Enabled
                                                    @else
                                                        Disabled
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($record->enable == 1)
                                                        <a href="{{ url('admin/disableBooking', ['id' => $record->id]) }}"
                                                            class="text-blue"><i
                                                                class="far fa-times-circle"></i></a>
                                                    @else
                                                        <a href="{{ url('admin/enableBooking', ['id' => $record->id]) }}"
                                                            class="text-blue"><i
                                                                class="far fa-check-circle"></i></a>
                                                    @endif
                                                </td>
                                                <?php $i++; ?>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>

                            <!--Booking Source-->
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class=" container-fluid ">
                        <div class="copyright" id="copyright">
                            @<script>
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
