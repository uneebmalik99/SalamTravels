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
                <a href="{{ url('/home') }}" class="simple-text logo-mini">
                    <img src="{{ asset('public/images/') . '/' . $data[0]->agency_picture }}" class="navbar-brand"
                        width="30" height="30" alt="">

                </a>
                <a href="{{ url('/home') }}" class="simple-text logo-normal text-dark">
                    {{ $data[0]->agency_name }}
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li>
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
                        <a class="navbar-brand" href="#pablo">User Profile</a>
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
                        @if (session('updated'))
                            <div class="alert alert-success mt-5">
                                {{ session('updated') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User Profile</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('updateUserProfile', ['id' => $data[0]->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Contact Person</label>
                                                <input id="contact" name="contact" type="text" autocomplete="off"
                                                    placeholder="Contact Person" value="{{ $data[0]->contact }}"
                                                    class="form-control" required>
                                                @error('contact')
                                                    <div class="alert alert-warning alert-dismissible fade show mt-2"
                                                        role="alert">
                                                        <span>{{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Phone</label>
                                                <input id="phone" name="phone" type="text" placeholder="Phone" autocomplete="off"
                                                    class="form-control" value="{{ $data[0]->phone }}" required>
                                                @error('phone')
                                                    <div class="alert alert-warning alert-dismissible fade show mt-2"
                                                        role="alert">
                                                        <span>{{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="phone">Agency Name</label>
                                                <input name="agency_name" id="agency_name" type="text" autocomplete="off"
                                                    placeholder="Agency Name" class="form-control"
                                                    value="{{ $data[0]->agency_name }}" required>
                                                @error('agency_name')
                                                    <div class="alert alert-warning alert-dismissible fade show mt-2"
                                                        role="alert">
                                                        <span>{{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="name">Mobile</label>
                                                <input id="mobile" name="mobile" type="text" placeholder="Mobile" autocomplete="off"
                                                    class="form-control" value="{{ $data[0]->mobile }}" required>
                                                @error('mobile')
                                                    <div class="alert alert-warning alert-dismissible fade show mt-2"
                                                        role="alert">
                                                        <span>{{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="phone">Password</label>
                                                <input name="password" id="password" type="password" autocomplete="off"
                                                    placeholder="Password" class="form-control"
                                                    value="{{ $data[0]->password }}" required>
                                                @error('password')
                                                    <div class="alert alert-warning alert-dismissible fade show mt-2"
                                                        role="alert">
                                                        <span>{{ $message }}</span>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="subject">Visiting Card</label>
                                                <input name="visiting_card" id="visiting_card" type="file"
                                                    class="form-control border-0"
                                                    value="{{ $data[0]->visiting_card }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="subject">Agency Picture</label>
                                                <input name="agency_picture" id="agency_picture" type="file" autocomplete="off"
                                                    class="form-control border-0" 
                                                    value="{{ $data[0]->agency_picture }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <button type="submit" name="singlebutton"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
