<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="/public">

    <title>Stock</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="icon" type="image/png"href="HPC/assets/img/hpc.png" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
   <link href="{{asset('hpc/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
   <link href="{{asset('hpc/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

   <!-- main CSS File -->
   <link href="{{asset('hpc/assets/css/style.css')}}" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
       integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
       crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <img src="hpc/assets/img/hpc.png" alt="logo">
                <span class="d-none d-lg-block" style="color: #390101;">HPC</span>
            </a>
            <a href="{{ route('dashboard') }}" ><span class="d-none d-lg-block fw-bold" style="color: #390101;">
                <i class="bi bi-arrow-return-left"></i>  RETOUR</span></a>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li><a class="nav-link nav-icon" href="{{route('productSortir')}}"
                    title="Sortir du stock">
                    <i class="bi bi-currency-dollar"
                    style="background: #ccaa93;color:#390101;border-radius:50%;padding:5px;"></i>
                </a></li>
                <li class="nav-item dropdown">
                    @php
                        $countW = 0;
                    @endphp
                    @foreach ($warnCount as $items)
                        @php
                            $QResta = $items->quantity;
                            $QTot = $items->status;
                            $QPourc = $QResta / $QTot;
                            $QPourcRest = $QPourc * 100;
                            if ($QPourcRest < 30) {
                                $countW++;
                            }
                        @endphp
                    @endforeach

                    @if ($countW)
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"
                            title="Stock dessous de 30 %">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger badge-number">{{ $countW }}</span>
                        </a>
                    @else
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"
                            title="Stock dessous de 30 %">
                            <i class="bi bi-bell"></i>

                        </a>
                    @endif
                    <!-- End Notification Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            <span class="badge bg-danger">{{ $countW }} </span> Produit a approvisionner
                            <a href="{{ route('runningLow') }}"><span
                                    class="badge rounded-pill bg-primary p-2 ms-2">Voir tout</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->
                <li class="nav-item dropdown">

                    @if ($countKurangura)
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Nouvelle commande">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge bg-success badge-number">{{ $countKurangura }}</span>
                        </a>
                    @else
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Nouvelle commande">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge bg-success badge-number"></span>
                        </a>
                    @endif
                    <!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            Vous avez <span class="badge bg-success">{{ $countKurangura }}</span> produits a acheter a
                            venir !
                            <a href="{{ route('rangura') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">Voir
                                    tout</span></a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav -->
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="hpc/assets/img/user.png"alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ $userRole->fname }} {{ $userRole->lname }}</h6>
                            <span>{{ $userRole->roles->name }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('Profile', $userRole->id) }}">
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Deconnexion</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <main class="main">
        <section class="section dashboard">
            <div class="row" style="margin-top: 80px;">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="row">

                        <div class="col-12">
                            <div class="card top-selling">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Stock actuel</h5>
                                    <table class="table table-bordeless datatable" id="example">
                                        <thead>
                                            <tr>
                                                <th scope="col">Produit</th>
                                                <th scope="col">Quantite</th>
                                                <th scope="col">Prix unitaire</th>
                                                <th scope="col">Prix total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total=0;
                                            @endphp
                                            @foreach ($product as $products)
                                                <tr>
                                                    <td><span style="font-weight: bold;font-size:17px;">{{$products->Produitname->nameProduct}}</span></td>
                                                    <td>[ {{$products->quantity}} ] <span style="font-size: 7px;">Category : {{$products->Category->nameCategory}}</span></td>
                                                    <td><span  style="font-weight: bold;background:#e6dada;padding:5px;font-size:20px;">{{number_format($products->unitPrice, 0, ',', '.')}} <span style="font-size: 10px;">Fbu</span></span></td>
                                                    <td>{{$products->totalPrice}}</td>
                                                    @php
                                                        $total+=$products->totalPrice;
                                                    @endphp
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-8">
                                        <p class="ms-3"></p>

                                    </div>
                                    <div class="col-xl-3">
                                        <p class="text-black float-end fw-bold" style="background: #390101;padding:6px;color:#ffffff;"><span class="text-white me-3" style="font-size: 10px;">
                                                Valeur du stock:</span><span
                                                style="font-size: 12px;color:#ffffff;">{{number_format($total, 0, ',', '.')}}
                                                Fbu</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="" class="footer">
        <div class="copyright"> <strong><span style="color: #390101;">HAPPY PEOPLE COSMETICS GESTION STOCK</span></strong></div>
    </footer><!-- End Footer -->


    <!-- Vendor JS Files -->
    <script src="{{asset('HPC/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('HPC/assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Toastr-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('HPC/assets/js/main.js')}}"></script>

</body>

</html>
