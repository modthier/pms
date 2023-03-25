<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PMS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img  src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image rounded" style="background: #000000;">
  </div>
 
  @yield('content')

 </div>
<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js')}}"></script>
<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

</body>
</html>