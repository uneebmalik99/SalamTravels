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
                    <li class=" ">
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

                    <li class="active">
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
                    <div class="col-md-12 p-0 m-0">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ledger</h4>
                                <br />
                                {{-- <a href="/downloadPdf" style="color:blue; padding:10px;">Download PDF</a>
                                <a href="/exportLedger" style="color:blue; padding:10px;">Download Excel</a> --}}
                            </div>
                            <div class="card-body">
                                <table border="0" cellspacing="5" cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>Start date:</td>
                                            <td><input type="text" id="min" name="min"></td>
                                        </tr>
                                        <tr>
                                            <td>End date:</td>
                                            <td><input type="text" id="max" name="max"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="table-responsive">
                                    <table class="table" id="ledgerTable">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Date</th>
                                                <th>Transaction</th>
                                                <th>Agency Name</th>
                                                <th>Description</th>
                                                <th>Dep. Date</th>
                                                <th>Arrival Date</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                                <th>Remarks</th>
                                                <th>Paid Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data && isset($data))
                                                <?php $i = 1; ?>
                                                @foreach ($data as $record)
                                                    @if ($record->ledger && $record->passengers)
                                                        @foreach ($record->passengers as $passenger)
                                                            <tr>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ $passenger->payment_history->id }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $record->date }}</td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->tabtype->tab_name }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $record->customer->agency_name }}</td>
                                                                <td>
                                                                    @if ($passenger)
                                                                        {{ $passenger->title }}
                                                                        <span>{{ $passenger->passenger_name }}</span>
                                                                        ~
                                                                        <span>{{ $record->ledger->from }}</span> ~
                                                                        <span>{{ $record->ledger->to }}</span>~
                                                                        <span>{{ $record->pnr }}</span>~
                                                                        @if ($record->ticket_type && isset($record->ticket_type))
                                                                            <span>{{ $record->ticket_type->name }}</span>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->ledger->dep_date }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->ledger->arr_date }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->debit) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->credit) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->balance) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger && $passenger->remarks && isset($passenger->remarks))
                                                                        {{ $passenger->remarks }}
                                                                    @else
                                                                        No Remarks
                                                                    @endif
                                                                </td>
                                                                <td>{{ $passenger ? ($passenger->vendor ? $passenger->vendor->value : '') : '' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($record->tabtype_id == 5 && $record->payment)
                                                        <tr>
                                                            <td>{{ $record->payment->payment_history->id }}</td>
                                                            <td>{{ $record->payment->payment_date }}</td>
                                                            <td>
                                                                Credit
                                                            </td>
                                                            <td>
                                                                ONLINE REDCIEVED IN SALAM TRAVEL
                                                                {{ $record->payment->bank->bank_name }}
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->debit) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->credit) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment->payment_history)
                                                                    {{ round($record->payment->payment_history->balance) }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($record->payment && $record->payment->remarks && isset($record->payment->remarks))
                                                                    {{ $record->payment->remarks }}
                                                                @else
                                                                    No Remarks
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>No Date Found</tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                            target="_blank">The
                            Revolution Technologies</a>
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
    <script>
        $(document).on('click', '.viewDetails', function() {
            $('#exampleModal').modal('show');
            var data = $(this).children('.remarks').text();
            $('#viewremark').text(data);
        });
        $('#filter').change(function(e) {
            e.preventDefault();
            var id = $(this).val();
            if (id == 1 || id == '1') {
                console.log(id);
                $('.refundList').show();
                $(".ticketingList").hide();
                $(".dateChangeList").hide();
                $(".voidList").hide();
            }
            if (id == 2 || id == '2') {
                console.log(id);
                $('.refundList').hide();
                $(".ticketingList").hide();
                $(".dateChangeList").hide();
                $(".voidList").show();
            }
            if (id == 3 || id == '3') {
                console.log(id);
                $('.refundList').hide();
                $(".ticketingList").hide();
                $(".dateChangeList").show();
                $(".voidList").hide();
            }
            if (id == 4 || id == '4') {
                console.log(id);
                $('.refundList').hide();
                $(".ticketingList").show();
                $(".dateChangeList").hide();
                $(".voidList").hide();
            }
            if (id == 0) {
                $('.refundList').show();
                $(".ticketingList").show();
                $(".dateChangeList").show();
                $(".voidList").show();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').dataTable({
                "order": [
                    [0, 'asc']
                ]
            });
        });

        jQuery(document).ready(function($) {

            $(".clickable-row").click(function() {

                window.location = $(this).data("href");

            });
            addBgColor();

        });

        {{-- function addBgColor() {
            var clickable = $(document).find('.clickable-row');

            clickable.each(function(i, v) {
                let status = $(v).find('.status').val();
                if (status === 'submitted') {
                    $(v).addClass('bg-primary')
                }
            });
        } --}}
    </script>
</body>

</html>
