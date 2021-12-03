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
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CSS Files -->
  <link href="{{asset('css/app.css')}}" rel="stylesheet" />
  <link href="{{asset('css/style.css')}}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('css/demo.css')}}" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar"  data-color="blue">
          <!--
            Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->
          <div class="logo">
            <a href="{{url('admin')}}" class="simple-text logo-mini">
              <img src="{{asset('images/Salamtravels.jpeg')}}" class="navbar-brand" width="30" height="30" alt="">
            </a>
            <a href="{{url('admin')}}" class="simple-text logo-normal text-dark">
              Salam Travels
            </a>
          </div>
          <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav">
              <li>
                <a href="{{url('admin/dashboard')}}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="active">
                <a href="{{url('admin/customers')}}">
                  <i class="fas fa-user"></i>
                  <p>Customers</p>
                </a>
              </li>
              <li>
                <a href="{{url('admin/ticketing')}}">
                  <i class="fas fa-ticket-alt"></i>
                  <p>Ticketing</p>
                </a>
              </li>
              <li>
                <a href="{{url('admin/refund')}}">
                  <i class="fas fa-funnel-dollar"></i>
                  <p>Refund</p>
                </a>
              </li>
              <li>
                <a href="{{url('admin/void')}}">
                  <i class="now-ui-icons design_app"></i>
                  <p>Void</p>
                </a>
              </li>
              <li>
                <a href="{{url('admin/datechange')}}">
                  <i class="fas fa-calendar-week"></i>
                  <p>Date Change</p>
                </a>
              </li>
              <li>
                <a href="{{url('admin/payment')}}">
                  <i class="fas fa-money-bill-wave"></i>
                  <p>Payment</p>
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
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
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
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                              {{ Auth::user()->name }}
                          </a>

                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                  {{ __('Logout') }}
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
                @if(session('success'))
                <div class="alert alert-success mt-5">
                  {{ session('success') }}
                </div>
                @endif
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Customers</h4>
                  </div>
                  <div class="card-body">
                                                        <!-- contact-form -->
                                    <form method="POST" action="{{url('admin/editCustomer', ['id'=>$data->id])}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                         
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="phone">Customer Name</label>
                                                    <input name="contact" id="contact" type="text" class="form-control" value="{{$data->contact}}" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="name">Phone</label>
                                                    <input id="phone" name="phone" type="text" value="{{$data->phone}}" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="phone">Agency Name</label>
                                                    <input name="agency_name" id="agency_name" type="text" value="{{$data->agency_name}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="name">Mobile</label>
                                                    <input id="mobile" name="mobile" type="text" value="{{$data->mobile}}" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="phone">Ledger Link</label>
                                                    <input name="ledger_link" id="ledger_link" type="text" value="{{$data->ledger_link}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                <button type="submit" name="singlebutton" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- contact-form --
                  </div>
                </div>
              </div>
            </div>
          </div>
          <footer class="footer">
            <div class=" container-fluid ">
              <div class="copyright" id="copyright">
                &copy; <script>
                  document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                </script>, Devolope by <a href="#" target="_blank">Uneeb</a>
              </div>
            </div>
          </footer>
        </div>
      </div>
  <!--   Core JS Files   -->
  <script src="{{asset('js/core/jquery.min.js')}}"></script>
  <script src="{{asset('js/core/popper.min.js')}}"></script>
  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('js/demo.js')}}"></script>
  <script src="{{asset('js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  <!-- Chart JS -->
  <script src="{{asset('js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('js/now-ui-dashboard.min.js')}}"></script>

  <script>
    $(document).on('click', '.viewDetails', function(){
        $('#exampleModal').modal('show');
        var data = $(this).children('.remarks').text();
        $('#showImg').empty();
        $('#showImg').append('<img src="' + data + '" class="img-fluid w-100 h-100" />');
    });
</script>
</body>

</html>