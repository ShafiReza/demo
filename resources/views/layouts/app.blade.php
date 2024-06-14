<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('bootstrap-5.3.3-dist/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.3-dist/css/all.min.css') }}">

    <!-- Custom styles -->
    <style>
        /* Custom styles */
        .menutitle {
            font-size: 18px;
            font-weight: bold;
            color: #004D40;
        }

        .large {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #FF5733; margin-bottom: 0;">
        <div class="container">
            <a class="navbar-brand" href="#" style="color: white;">Payment Management System</a>
        </div>
    </nav>
    <div class="container-fluid" style="height: 100vh;">
        <div class="row" style="height: 100%;">
            <!-- Sidebar -->
            <div class="col-sm-3 col-md-2 sidebar" style="background-color: #f2f2f2; margin-top: 0; height: 117vh;">
                <ul class="nav flex-column flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}" style="color: #FF5733;">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sales') }}" style="color: #FF5733;">
                            Sales
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="menutitle">Clients -></span>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.index') }}" style="color: #FF5733;">Clients list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.create') }}" style="color: #FF5733;">Clients Add</a>
                    </li>
                    <li class="nav-item">
                        <span class="menutitle">Providers -></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('provider.index') }}" style="color: #FF5733;">Provider
                            list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('provider.create') }}" style="color: #FF5733;">Provider
                            Add</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('provider.report') }}" style="color: #FF5733;">Provider
                            Report</a>
                    </li> --}}

                    <li class="nav-item">
                        <span class="menutitle">Payments -></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payments.payment_receive') }}"
                            style="color: #FF5733;">ledger</a>
                    </li>


                    <li class="nav-item">
                        <span class="menutitle">Others -></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('change-password') }}" style="color: #FF5733;">Change
                            Password</a>

                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('DELETE') <!-- Keep as DELETE -->
                            <button type="submit" class="nav-link"
                                style="color: #FF5733; border: none; background: none;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
            @yield('content')
        </div>
        <!-- Bootstrap JS -->
        <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.js') }}"></script>

        <script src="{{ asset('bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"
            integrity="sha384-2eZyrKQPn7M6wll0F0Pgy5mKfTKUnUpjZbhpnbz7ZOglH+lV+p4y4zobI5+0zj5O" crossorigin="anonymous">
        </script>



</body>

</html>
