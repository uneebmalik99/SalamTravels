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
                    <li class="active">
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
                        <a class="navbar-brand" href="#pablo">Payment</a>
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
                                <h4 class="card-title">Payment</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">

                                        <tbody>
                                            @if ($data != null)
                                                <thead>
                                                    <tr>
                                                        <th>Sr.#</th>
                                                        <th scope="col">Agency Name</th>
                                                        <th scope="col">Payment Prooof</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Bank</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col" class="text-center">Actions</th>
                                                        <th scope="col">Remarks</th>
                                                        <th scope="col">Admin Remarks</th>
                                                        <th scope="col">Processed By</th>
                                                        @if (Auth::user()->hasRole('Super Admin'))
                                                            <th scope="col">Delete</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <?php $i = 1; ?>
                                                @foreach ($data as $record)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <?php $i++; ?>
                                                        <td>{{ $record->customer->agency_name }}</td>
                                                        <td><a href="#" class="viewImage">View <div
                                                                    style="display: none;" class="payment_proof">
                                                                    {{ asset('public/images/' . $record->payment_proof) }}
                                                                </div></a></td>
                                                        <td>{{ $record->payment_date }}</td>
                                                        <td>{{ $record->bank[0]->bank_name }}</td>
                                                        <td>{{ $record->amount }}</td>
                                                        <td style="width: 15%;">
                                                            <select name="adminStatus" id="adminStatus"
                                                                class="form-control"
                                                                onchange="location = this.value;">
                                                                @foreach ($record->link as $link)
                                                                    <option
                                                                        value="{{ url($link->link, ['id' => $record->id]) }}"
                                                                        @if ($record->status->id === $link->status_id) selected @endif>
                                                                        {{ $link->status->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <!--<td class="text-center"><div class="mb-2"><a href="{{ url('admin/paymentStatusSubmitted', ['id' => $record->id]) }}" class="bg-warning p-1 mb-1">Submitted</a>&nbsp;<a href="{{ url('admin/paymentStatusProcessing', ['id' => $record->id]) }}" class="bg-secondary p-1 text-white mb-1">Processing</a>&nbsp;<a href="{{ url('admin/paymentStatusCompleted', ['id' => $record->id]) }}" class="bg-success p-1 text-white">Completed</a></div><a href="{{ url('admin/paymentStatusRejected', ['id' => $record->id]) }}" class="bg-danger p-1 text-white">Rejected</a> &nbsp; <a href="{{ url('admin/paymentStatusPosted', ['id' => $record->id]) }}" class="bg-info p-1 text-white mb-1">Posted</a></td>
                                    -->
                                                        <td><a href="#" class="viewDetails">view <div
                                                                    style="display: none;" class="remarks">
                                                                    {{ $record->remarks }}</div></a>
                                                        </td>
                                                        <td><a href="#" class="addAdminStatus"
                                                                id="{{ $record->id }}">Add
                                                                <div style="display: none;" class="adremarks">
                                                                    {{ $record->admin_remarks }}</div>
                                                            </a></td>
                                                        <td>
                                                            @if (isset($record->processed_by))
                                                                {{ $record->processed_by->name }}
                                                            @endif
                                                        </td>
                                                        @if (Auth::user()->hasRole('Super Admin'))
                                                            <td><a href="{{ url('admin/delete_payment', ['id' => $record->id]) }}"
                                                                    class="text-blue"><i
                                                                        class="far fa-trash-alt"></i></a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @else
                                                <p class="text-center">No Data found</p>

                                            @endif



                                        </tbody>
                                    </table>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">View Customer
                                                        Remarks</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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


                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add Admin Remarks
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form name="form12" id="form12">
                                                    <div class="modal-body">

                                                        @csrf
                                                        <input type="hidden" name="remarks_id" id="remarks_id">
                                                        <div class="form-group">
                                                            <label for="">Admin remarks</label>
                                                            <textarea type="text" name="admin_remarks" rows="4" id="admin_remarks" class="form-control"></textarea>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-primary add_admin_remarks">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Modal-->

                                    <!-- Modal -->
                                    <div class="modal fade" id="ImageModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Payment Proof</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="showImg" class="text-center"></div>
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

    <script>
        $(document).on('click', '.viewDetails', function() {
            $('#exampleModal').modal('show');
            var data = $(this).children('.remarks').text();
            $('#viewremark').text(data);
        });
        $(document).on('click', '.addAdminStatus', function() {
            $('#exampleModal12').modal('show');
            var remarks = $(this).children('.adremarks').text();
            var data = $(this).attr('id');
            $("textarea#admin_remarks").val(remarks);
            $('#remarks_id').val(data);
        });

        $(document).on('click', '.add_admin_remarks', function(e) {
            e.preventDefault();
            var id = $('#remarks_id').val();
            var admin_remarks = $('#admin_remarks').val();
            if (admin_remarks.length > 0) {
                $.ajax({
                    url: "{{ url('admin/paymentStatus') }}/" + id,
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "admin_remarks": admin_remarks
                    },
                    success: function(success) {

                        alert(success);
                        $('#exampleModal12').modal('hide');
                        $('#form12').trigger("reset");
                    }
                });
            }
        });

        $(document).on('click', '.viewImage', function() {
            $('#ImageModal').modal('show');
            var data = $(this).children('.payment_proof').text();
            $('#showImg').empty();
            $('#showImg').append('<img src="' + data + '" class="img-fluid w-100 h-100" />');
        });
    </script>
</body>

</html>
