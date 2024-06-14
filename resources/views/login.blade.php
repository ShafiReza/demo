<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- Bootstrap Icons CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 450px;
            margin: 0 auto;
            margin-top: 100px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .colorgraph {
            height: 5px;
            border: 0;
            background: linear-gradient(to right, #ff0000, #ffa500, #ffff00, #008000, #0000ff, #4b0082, #800080);
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .form-error {
            color: #d9534f;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .btn-login {
            font-size: 16px;
            font-weight: bold;
            padding: 10px 16px;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h2 class="form-heading">PMS</h2>
        <h3 class="form-heading">Administrator Login Here</h3>
        <hr class="colorgraph">
        @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="{{ route('loginPost') }}" method="post">
        @csrf
        
            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input id="email" type="email" class="form-control" name="email" placeholder="username or email">
            </div>

    <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
            </div>
            <button class="btn btn-lg btn-primary btn-block" name="Submit" value="Login" type="Submit">Login</button>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>
</html>
