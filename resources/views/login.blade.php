<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="/public">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/png"href="Hpc/assets/img/hpc.png"  />
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="Hpc/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="Hpc/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--Main CSS File -->
    <link href="Hpc/assets/css/style.css" rel="stylesheet">

</head>

<body>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <img src="Hpc/assets/img/hpc.png" height="130" rel="logo" alt="logo">
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4" style="color: #390101;">Happy People Cosmetics</h5>
                                    </div>
                                   <form class="row g-3 needs-validation" novalidate method="POST" action="{{route('login')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">
                                                Email ou Nom d'utilisateur</label>
                                            <div class="input-group has-validation">

                                                <input type="text" name="email" class="form-control"
                                                    id="yourUsername" required >
                                                <div class="invalid-feedback">Veuillez entrer votre email ou nom d'utilisateur.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Mot de passe</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            <div class="invalid-feedback">Veuillez entre le mot de passe!</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn- w-100" style="background: #390101;color:white;" type="submit">Se connecter</button>
                                        </div>
                                        <div class="col-12">

                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="Hpc/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="Hpc/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="Hpc/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="Hpc/assets/vendor/echarts/echarts.min.js"></script>
    <script src="Hpc/assets/vendor/quill/quill.min.js"></script>
    <script src="Hpc/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="Hpc/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="Hpc/assets/vendor/php-email-form/validate.js"></script>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  @if(Session::has('message'))

  <script>
    toastr.options = {
        "progressBar":true,
        "closeButton":true,
        "positionClass": "toast-top-center",
    }

    toastr.error("{{Session::get('message')}}");
  </script>

  @endif
    <!-- Template Main JS File -->
    <script src="Hpc/assets/js/main.js"></script>


</body>

</html>
