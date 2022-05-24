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
                    <li>
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
                    <li class="active">
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
                        <a class="navbar-brand" href="#pablo">Customers</a>
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
                <div class="row">
                    <div class="col-md-12">
                        <!-- contact-form -->
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
                        {{-- request manual form start here --}}
                        <form action="{{ url('admin/manual_request') }}" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Agency
                                                    Name</label>
                                                <select name="agency_name" id="agency_name" class="form-control"
                                                    required>
                                                    <option selected disabled>---Select Agency----</option>
                                                    @if (isset($customers))
                                                        @foreach ($customers as $cust)
                                                            @if ($cust)
                                                                <option value="{{ $cust->agency_name }}">
                                                                    {{ $cust->agency_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="control-label" for="subject">Sector </label>
                                                <input id="tab_sector" name="sector" type="text" placeholder="Sector"
                                                    class="form-control" required>
                                            </div>
                                        </div> --}}
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 d-none">
                                            <div class="form-group">
                                                <label class="control-label" for="textarea">Passenger Name</label>
                                                <input type="hidden" class="form-control" name="passenger_name"
                                                    id="tab_passenger_name"
                                                    placeholder="Any Passenger name from booking" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Travel Date</label>
                                                <input type="date" name="date" id="date" class="form-control"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Transaction</label>
                                                <select name="transaction" id="transaction" class="form-control"
                                                    required>
                                                    <option selected disabled>---Select Transaction
                                                        ----</option>
                                                    <option value="1">TICKET</option>
                                                    <option value="4">DATE CHANGE</option>
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
                                                    <option value="2">REFUND</option>
                                                    <option value="3">VOID</option>
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
                                                <input type="text" name="pnr" id="pnr" class="form-control"
                                                    required />
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">From</label>
                                                <input type="text" name="from" id="from" class="form-control"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">To</label>
                                                <input type="text" name="to" id="to" class="form-control" required />
                                            </div>
                                        </div> --}}
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Dep Date</label>
                                                <input type="date" name="dep_date" id="dep_date" class="form-control"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold label">Arrival Date</label>
                                                <input type="date" name="arr_date" id="arr_date" class="form-control"
                                                    required />
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <div class="text-center">
                                        <button class="btn btn-primary">Submit</button>
                                    </div> --}}
                                </div>
                            </div>
                        </form>
                        {{-- request manual form End here --}}

                        {{-- PASSENGER FORM START HERE --}}
                        <div class="horizontal-scrollable bg-white p-3">
                            <div class="row d-flex">
                                <div class="col-md-4">
                                    <select name="total_passenger" id="total_passenger"
                                        class="form-control total_passenger">
                                        <option selected disabled>Select # of Passenger</option>
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
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        lass="text-center">
                                        <button class="btn btn-primary">Submit</button>
                                </div>
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
                        <div class="row text-center">
                            <div class="col-8">
                                <div class="row d-flex">
                                    <div class="col-1">
                                        <p>Sr.#</p>
                                    </div>
                                    <div class="col-3">
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
                                    <div class="col-5">
                                        <p>Paid Amount</p>
                                    </div>
                                    {{-- <div class="col-5">
                                        <p>P.Type</p>
                                    </div>
                                    <div class="col-3">
                                        <p>Basic</p>
                                    </div>
                                    <div class="col-3">
                                        <p>Tax</p>
                                    </div> --}}
                                </div>
                            </div>
                            {{-- <div class="col-4 ">
                                <div class="row d-flex">
                                    <div class="col-4">
                                        <p>%age</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Value</p>
                                    </div>
                                    <div class="col-4" style="background: #E5E7E9;">
                                        <p>Vendor</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-4" style="background: #E5E7E9;">
                                <div class="row d-flex">
                                    <div class="col-4">
                                        <p>P.Type</p>
                                    </div>
                                    <div class="col-3">
                                        <p>Basic</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Tax</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 " style="background: #E5E7E9; margin-left:-5px">
                                <div class="row d-flex">
                                    <div class="col-4">
                                        <p>%age</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Value</p>
                                    </div>
                                    <div class="col-4">
                                        <p>Vendor</p>
                                    </div>
                                </div>
                            </div> --}}


                            {{-- <div class="col-4 ">   // third form
                                    <div class="row d-flex ">
                                        <div class="col-3">
                                            <p>P.Type</p>
                                        </div>
                                        <div class="col-2">
                                            <p>Basic</p>
                                        </div>
                                        <div class="col-2">
                                            <p>Tax</p>
                                        </div>
                                        <div class="col-2">
                                            <p>Discount</p>
                                        </div>
                                        <div class="col-2 ml-3">
                                            <p>Value</p>
                                        </div>
                                    </div>
                                </div> --}}

                        </div>
                        <div id="passenger-form-container"></div>

                    </div>

                    {{-- PASSENGER FORM END HERE --}}


                    <button class="btn btn-primary updatepassenger" type="button">Submit</button>

                    {{-- <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center">Add Request Manual</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('admin/manual_request') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-11 col-md-6 mb-2">
                                            <div class="row">
                                                <div class="col-10 col-md-4">
                                                    <label>Date</label>
                                                </div>
                                                <div class="col-10 col-md-8">
                                                    <input type="date" class="form-control" name="date" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-11 col-md-6 mb-2">
                                            <div class="row">
                                                <div class="col-10 col-md-4">
                                                    <label>Transaction</label>
                                                </div>
                                                <div class="col-10 col-md-8">
                                                    <input type="text" class="form-control" name="transaction" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-11 col-md-6">
                                            <div class="row">
                                                <div class="col-10 col-md-4">
                                                    <label>Agency Name</label>
                                                </div>
                                                <div class="col-10 col-md-8">
                                                    <input type="text" class="form-control" name="agency_name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-11 col-md-6">
                                            <div class="row">
                                                <div class="col-10 col-md-4">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-10 col-md-8">
                                                    <textarea class="form-control border" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary ml-4">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div> --}}
                    <!-- contact-form -->
                </div>
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

    {{-- passenger javascript start here --}}
    <script>
        $(document).ready(function() {
            freezeStatus();
        })

        function freezeStatus() {
            let statusValue = $('#tab_status').children(":selected").attr("id");
            if (statusValue === 'Completed') {
                $('#submitted').attr("disabled", true);
                $('#Rejected').attr("disabled", true);
                $('#posted').attr("disabled", true);
                $('#Processing').attr("disabled", true);
            } else if (statusValue === 'Rejected') {
                $('#submitted').attr("disabled", true);
                $('#Completed').attr("disabled", true);
                $('#posted').attr("disabled", true);
                $('#Processing').attr("disabled", true);
            } else if (statusValue === 'posted') {
                $('#submitted').attr("disabled", true);
                $('#Completed').attr("disabled", true);
                $('#Rejected').attr("disabled", true);
                $('#Processing').attr("disabled", true);
            } else {

                $('#submitted').attr("disabled", false);
                $('#Completed').attr("disabled", false);
                $('#Rejected').attr("disabled", false);
                $('#Processing').attr("disabled", false);
            }
        }
        $(document).on('change', '#total_passenger', function(e) {
            var container = $('#passenger-form-container').empty();

            const count = $(this).val();
            $('#nopas').html($('#total_passenger').val())
            console.log(count);
            for (var i = 0; i < count; i++) {
                addPassengerForm();
            }
            //add sr number in passenger form
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
                    //  console.log("7777_"+JSON.stringify(e));

                }
            });
        });

        $(document).on('click', '.updatepassenger', function() {
            savePassengerForm()
        });

        function addPassengerForm() {
            var tempalte = $('#template-row-passenger-info').html();
            var container = $('#passenger-form-container');

            container.append(tempalte);
        }

        function savePassengerForm(e) {
            var id = $('#tabinfo_id').val();
            {{-- e.preventDefault(); --}}
            var passenger = getPassengerData();
            var ledger = getLedgerData();
            var data = {
                ledger: ledger,
                passenger: passenger,
            };
            console.log(data)
            $.ajax({
                url: `/admin/manual_request`,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'data': {
                        ledger,
                        passenger
                    }
                },
                method: 'POST',
                success: function(e) {
                    console.log(e);
                    if (e.status == 200) {
                        alert('manual request proceded successfully')
                        location.reload();
                    } else {
                        alert('all feild required')
                    }
                }
            });


        }

        function getLedgerData() {
            var arr = []
            var obj = {}
            obj.date = $('#date').val();
            obj.transaction = $('#transaction').val();
            obj.agency_name = $('#agency_name').val();
            obj.booking_id = $('#booking_id').val();
            obj.airline_id = $('#airline_id').val();
            obj.ticket_type = $('#ticket_type').val();
            obj.pnr = $('#pnr').val();
            {{-- obj.to = $('#to').val();
            obj.from = $('#from').val(); --}}
            obj.dep_date = $('#dep_date').val();
            obj.arr_date = $('#arr_date').val();
            obj.passenger_name = $('#tab_passenger_name').val();
            {{-- obj.sector = $('#tab_sector').val(); --}}
            arr.push(obj)
            return arr;
        }

        function getPassengerData() {
            var arr = [];
            var passengerEl = $('.passenger-info-form');

            passengerEl.each(function(i, v) {
                var obj = {};
                console.log(v)

                console.log(i)
                obj.title = $(v).find('.title').val();
                obj.type = $(v).find('.type').val();
                obj.ticket = $(v).find('.ticket').val();
                obj.passenger_name = $(v).find('.passenger_name').val();
                obj.payment_type = $(v).find('.payment_type').val();
                obj.p_basic = $(v).find('.p_basic').val();
                obj.p_tax = $(v).find('.p_tax').val();
                obj.p_discount = $(v).find('.p_discount').val();
                obj.p_value = $(v).find('.p_value').val();
                obj.v_payment_type = $(v).find('.v_payment_type').val();
                obj.v_basic = $(v).find('.v_basic').val();
                obj.v_tax = $(v).find('.v_tax').val();
                obj.v_discount = $(v).find('.v_discount').val();
                obj.v_value = $(v).find('.v_value').val();
                obj.remarks = $(v).find('.remarks').val();
                obj.vendor_id = $(v).find('.vendor_id').val();
                arr.push(obj);
            });

            return arr;
        }
    </script>


    <script type="text/html" id="template-row-passenger-info">
        <div class='passenger-info-form'>
            <div class="row text-center main_content">
                <div class="col-8">
                    <div class="row d-flex">
                        <div class="col-1">
                            <p class="srNum"></p>
                        </div>
                        <div class="col-3">
                            <select class="form-control type" name="type" required>
                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select class="form-control title" name="title" required>
                                <option value="mr">MR</option>
                                <option value="mrs">Mrs</option>
                                <option value="miss">Miss</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control passenger_name" name="passenger_name" required />
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control ticket" name="ticket" required />
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="row d-flex">
                        <div class="col-4">
                            <input type="text" class="form-control p_value" name="p_value" />
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control v_value" name="v_value" />
                        </div>
                        <div class="col-4" style="background: #E5E7E9;">
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
                        <div class="col-4" style="background: #E5E7E9;">
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
                    <textarea class="form-control border remarks"></textarea>
                </div>

            </div>
        </div>
    </script>

</body>

</html>
