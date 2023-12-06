<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Error</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <base href="/public">

  <!-- Favicons -->
  <link href="hpc/assets/img/bcrlogo.png" rel="logo">
  <link href="hpc/assets/img/bcrlogo.png" rel="logo">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('hpc/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- main CSS File -->
  <link href="{{asset('hpc/assets/css/style.css')}}" rel="stylesheet">


</head>

<body>

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>Desole, un probleme est survenu en ouvrant cette page,veuillez reesayer plus tard.</h2>
        <h2>Merci</h2>
        <a class="btn" href="{{ route('dashboard') }}">Retourner a l'accueil</a>
        <img src="hpc/assets/img/not-found.svg" alt="Page Not Found" height="100">

      </section>

    </div>
  </main><!-- End #main -->



 <!-- Vendor JS Files -->
 <script src="{{asset('HPC/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

 <!-- Template Main JS File -->
 <script src="{{asset('HPC/assets/js/main.js')}}"></script>

</body>

</html>
