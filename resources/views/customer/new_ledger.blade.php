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
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
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
                    <img src="{{ asset('public/images/') . '/' . $customer->agency_picture }}" class="navbar-brand"
                        width="30" height="30" alt="">

                </a>
                <a href="{{ url('/home') }}" class="simple-text logo-normal text-dark">
                    {{ $customer->agency_name }}
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
                    <li class="active">
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
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success mt-5">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ledger</h4>
                                <br />
                                <a href="/downloadPdf" style="color:blue; padding:10px;">Download PDF</a>
                                <a href="/exportLedger" style="color:blue; padding:10px;">Download Excel</a>
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

                                                <th>Date</th>
                                                <th>Transaction</th>
                                                <th>Description</th>
                                                <th>Dep. Date</th>
                                                <th>Arrival Date</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($data && isset($data))
                                                @php
                                                    $initailbalance = 0;

                                                @endphp
                                                @foreach ($data as $record)
                                                    @if ($record->ledger && $record->passengers)
                                                        @foreach ($record->passengers as $passenger)
                                                            <tr>

                                                                <td>{{ $record->ledger->date }}</td>
                                                                <td>
                                                                    @if ($record->ledger)
                                                                        {{ $record->tabtype->tab_name }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger)
                                                                        {{ \Illuminate\Support\Str::upper($passenger->title) }}
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
                                                                @php
                                                                    $dt = \Carbon\Carbon::today()->toDateString();
                                                                @endphp
                                                                <td
                                                                    {{ $dt > $record->ledger->dep_date
                                                                        ? 'style=background-color:red;color:white;'
                                                                        : 'style=color:#000000
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ;' }}>
                                                                    @if ($record->ledger->dep_date)
                                                                        <span> {{ $record->ledger->dep_date }} </span>
                                                                    @endif
                                                                </td>
                                                                <td
                                                                    {{ $dt > $record->ledger->arr_date
                                                                        ? 'style=background-color:red;color:white;'
                                                                        : 'style=color:#000000
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ;' }}>
                                                                    @if ($record->ledger->arr_date)
                                                                        <span>{{ $record->ledger->arr_date }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->debit) ?? 0 }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($passenger->payment_history)
                                                                        {{ round($passenger->payment_history->credit) ?? 0 }}
                                                                    @endif
                                                                </td>
                                                                <td>

                                                                    @php

                                                                        if ($passenger->payment_history->debit !== 0) {
                                                                            $initailbalance = (int) ($initailbalance - (int) $passenger->payment_history->debit ?? 0);
                                                                        }
                                                                        if ($passenger->payment_history->credit !== 0) {
                                                                            $initailbalance = (int) ($initailbalance + (int) $passenger->payment_history->credit ?? 0);
                                                                        }
                                                                    @endphp




                                                                    {{ round($initailbalance) }}

                                                                </td>
                                                                <td>
                                                                    <a href="#" class="viewDetails">view <div
                                                                            style="display: none;" class="remarks">

                                                                            @if ($passenger && $passenger->remarks && isset($passenger->remarks))
                                                                                {{ $passenger->remarks }}
                                                                            @else
                                                                                No Remarks
                                                                            @endif
                                                                        </div></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @elseif ($record->tabtype_id == 5 && $record->payment)
                                                        <tr>

                                                            <td>{{ $record->payment->payment_date }}</td>
                                                            <td>
                                                                Credit

                                                            </td>
                                                            <td>
                                                                ONLINE RECIEVED IN SALAM TRAVEL
                                                                {{ $record->payment->bank->bank_name }}
                                                            </td>
                                                            <td>
                                                                -
                                                            </td>
                                                            <td>
                                                                -
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
                                                                    @php
                                                                        $initailbalance = (int) ($initailbalance + (int) $record->payment->payment_history->credit ?? 0);
                                                                    @endphp

                                                                    {{ round($initailbalance) }}
                                                                @endif
                                                            </td>
                                                            <td>


                                                                <a href="#" class="viewDetails">view <div
                                                                        style="display: none;" class="remarks">

                                                                        @if ($record->payment && $record->payment->remarks && isset($record->payment->remarks))
                                                                            {{ $record->payment->remarks }}
                                                                        @else
                                                                            No Remarks
                                                                        @endif
                                                                    </div></a>


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
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">View
                                        Remarks</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="viewremark"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal-->
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



    <script>
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[1]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            // DataTables initialisation
            var table = $('#ledgerTable').DataTable();

            // Refilter the table
            $('#min, #max').on('change', function() {
                table.draw();
            });
        });
    </script>
    <script>
        $(document).on('click', '.viewDetails', function() {

            $('#exampleModal').modal('show');
            var data = $(this).children('.remarks').text();
            $('#viewremark').text(data);
        });
    </script>
</body>

</html>
