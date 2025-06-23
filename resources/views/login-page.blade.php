<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Piter @section('name')
        
    @endsection | Login</title>
    <link href="assets/css/customize.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">Piter SEO</h1>

            </div>
            <h3>Welcome to Piter SEO</h3>
            <p>Chưa biết ghi gì chắc khỏi ghi
            </p>
            <form method="post" class="m-t" role="form" action="{{ route('auth.login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="user" class="form-control" placeholder="Username">
                    @if ($errors->has('user'))
                        <span class="error-msg">{{ $errors->first('user') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="error-msg">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>
