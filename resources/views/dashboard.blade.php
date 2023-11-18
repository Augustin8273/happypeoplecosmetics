<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <base href="/public">

    <title>Dashboard</title>
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
                <img src="{{asset('hpc/assets/img/hpc.png')}}" alt="logo">
                <span class="d-none d-lg-block" style="color: #390101;">HPC</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li><a class="nav-link nav-icon" href="{{route('productSortir')}}" data-bs-toggle="modal"
                    data-bs-target="#basicModal"
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

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Accueil</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('productListShow') }}">
                    <i class="bi bi-list"></i>
                    <span>Produits</span>
                </a>
            </li><!-- End list Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Articles</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('produit_article') }}">
                            <i class="bi bi-circle"></i><span>Entrer nouveau article</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('produit_list') }}">
                            <i class="bi bi-circle"></i><span>Liste des articles</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gem"></i><span>Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('productCreate') }}">
                            <i class="bi bi-circle"></i><span>Approvisonner stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stock') }}">
                            <i class="bi bi-circle"></i><span>Stock actuel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('histoEntrees') }}">
                            <i class="bi bi-circle"></i><span>Historic des entrees</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rangura') }}">
                            <i class="bi bi-circle"></i><span>Kurangura</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Icons Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Sorties</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('productSortir') }}">
                            <i class="bi bi-circle"></i><span>Creer nouveau</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sortiList') }}">
                            <i class="bi bi-circle"></i><span>Liste</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav -->


            <li class="nav-heading">Configurations</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('addUserCreate') }}">
                    <i class="bi bi-person-add"></i>
                    <span>Ajouter utilisateur</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('category_create') }}">
                    <i class="bi bi-diagram-3"></i>
                    <span>Category</span>
                </a>
            </li>
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Produits <span>| En stock</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $countStore }}</h6>
                                            <span class="text-success small pt-1 fw-bold">Mis à jour</span> <span
                                                class="text-muted small pt-2 ps-1">Today</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card revenue-card">

                                <div class="card-body">
                                    <h5 class="card-title">A acheter <span>| Bientot</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-journal-text"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $countKurangura }}</h6>
                                            <span class="text-success small pt-1 fw-bold">Mis à jour</span> <span
                                                class="text-muted small pt-2 ps-1">Today</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-3 col-md-3">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Sorties<span> | facture</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $numberBillCount }}</h6>
                                            <span class="text-danger small pt-1 fw-bold">Mis à jour</span> <span
                                                class="text-muted small pt-2 ps-1">Today</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Daily income Card -->
                        <div class="col-xxl-3 col-md-3">

                            <div class="card info-card revenue-hpc">
                                <div class="card-body">
                                    <h5 class="card-title">Ventes<span> | en caisse</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($sorti as $items)
                                            @php
                                                $total += $items->totalPrice;
                                            @endphp
                                        @endforeach
                                        <div class="ps-3">
                                            <span
                                                style="font-size:20px;color:#390101;font-weight:bold;">{{ number_format($total, 1) }}
                                                Fbu</span>
                                            <span class="text-danger small pt-1 fw-bold"><i
                                                    class="bi bi-clock"></i></span> <span
                                                class="text-muted small pt-2 ps-1">Aujourd'hui</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Daily income Card -->
                    </div>

                    <!-- Start sortir Modal-->
                    <div class="card">
                        <div class="card-body">
                            <div class="modal fade modal-lg" id="basicModal" tabindex="-1">
                                <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color:#390101;">Ajout du nouveau produit a acheter bientot
                                            </h5>
                                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Multi Columns Form -->
                                        <form class="row g-3" name="myform" action="{{route('productSortirStore')}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <table class="table table-bordeless">
                                            <thead style="background: #390101;color:white;">
                                                <tr>
                                                    <th>Produit</th>
                                                    <th>Quantite</th>
                                                    <th><a href="javascript:void(0)"
                                                            class="btn  btn-sm addRow" style="background: #7a6161;color:white;">+</a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="col-md-12">

                                                            <select class="form-control" id=""
                                                                name="product_id[]">

                                                                @foreach ($product as $articles)
                                                                    <option value="{{ $articles->Produitname->id }}">{{$articles->Produitname->nameProduct}}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-md-12">

                                                            <input type="number" class="form-control"
                                                                id="inputName5" min="1"
                                                                placeholder="Quantite" name="quantite[]"
                                                                 required>

                                                        </div>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn w-5" style="background: #390101;color:white;">Enregistrer</button>
                                        </div>
                                    </form>
                                    <!-- End Multi Columns Form -->
                                        </div>
                                    </div>
                                </div><!-- End sortir Modal-->

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright"> <strong><span style="color: #390101;">HAPPY PEOPLE COSMETICS GESTION
                    STOCK</span></strong></div>
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

    <script>
        var i = 0;
        $('thead').on('click', '.addRow', function() {

            var tr = `<tr>
                <td>
                        <div class="col-md-12">
                            <select class="form-control" id=""
                                name="product_id[]">

                                @foreach ($product as $articles)
                                    <option value="{{ $articles->id }}">{{$articles->Produitname->nameProduct}}</option>
                                @endforeach

                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-12">

                            <input type="number" class="form-control"
                                id="inputName5" min="1"
                                placeholder="Quantite" name="quantite[]"
                                onkeyup="calculate(this.value)" required>

                        </div>
                    </td>
                <td><a href="javascript:void(0)" class="btn btn-danger btn-sm deleteRow">-</a></td>

                 </tr>`;

            $('tbody').append(tr);

        });

        $('tbody').on('click', '.deleteRow', function() {

            $(this).parent().parent().remove();
        });
    </script>

</body>

</html>
