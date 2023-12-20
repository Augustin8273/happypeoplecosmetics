<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Depenses</title>
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
            <i class="bi bi-list toggle-sidebar-btn"></i>
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
                            if ($QResta < 2) {
                                $countW++;
                            }
                        @endphp
                    @endforeach

                    @if ($countW)
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"
                            title="low stock">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-danger badge-number">{{ $countW }}</span>
                        </a>
                    @else
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown"
                            title="low stock">
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
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Ibirangurwa">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge bg-success badge-number">{{ $countKurangura }}</span>
                        </a>
                    @else
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Ibirangurwa">
                            <i class="bi bi-chat-left-text"></i>
                            <span class="badge bg-success badge-number"></span>
                        </a>
                    @endif
                    <!-- End Messages Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            <span class="badge bg-success">{{ $countKurangura }}</span> Produits a acheter dans l'avenir
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
                        <img src="{{asset('hpc/assets/img/user.png')}}"alt="Profile" class="rounded-circle">
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
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Deperte-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-exclamation-octagon-fill"></i><span>Depenses et Pertes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Deperte-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('depense_create') }}">
                        <i class="bi bi-circle"></i><span>Depenses</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('perte_create') }}">
                        <i class="bi bi-circle"></i><span>Pertes</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->


        <li class="nav-heading">Configurations</li>

        @if ($userRole->roles->name == 'Manager')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('addUserCreate') }}">
                    <i class="bi bi-person-add"></i>
                    <span>Ajouter utilisateur</span>
                </a>
            </li>
            @endif
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('category_create') }}">
                <i class="bi bi-diagram-3"></i>
                <span>Category</span>
            </a>
        </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('type_perte_create') }}">
            <i class="bi bi-exclamation-octagon-fill"></i>
            <span>Type de perte</span>
        </a>
    </li>
    </ul>

</aside><!-- End Sidebar-->

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">

                    <div class="card top-selling overflow-auto">
                        <div class="card-body pb-2">
                            <h5 class="card-title">Depenses</h5>
                            <form action="{{ route('DepenseListSortedByDate') }}" method="GET"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-8 d-flex align-items-baseline">
                                    <span style="margin-right:5px;">De:</span> <input type="date"
                                        name="fromDate" class="form-control" style="margin-right: 5px;"
                                        value="{{ Request::get('fromDate') }}" required>
                                    <span style="margin-right:5px;">Jusqu'a:</span> <input type="date"
                                        name="endDate" class="form-control" style="margin-right: 5px;"
                                        value="{{ Request::get('endDate') }}" required>
                                    <input type="submit" value="Rechercher" class="form-control"
                                        style="background: #390101;color:white;">
                                </div>
                            </form>
                            <h5>
                                <a href="{{ route('depense_create') }}"><button
                                class="m-2 btn btn-success">Actualiser</button></a>
                            </h5>
                        </div>
                    </div>

                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="row">
                        <div class="col-lg-6">
                            <div class="card top-selling overflow-auto">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Depenses</h5>
                                    @if (session('savePerte'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('savePerte') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('updateDepense'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('updateDepense') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('saveErrorPerte'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('saveErrorPerte') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <h5 class="card-title"><button class="btn btn-"
                                            style="background:#390101;color:white;" data-bs-toggle="modal"
                                            data-bs-target="#basicModal"><i
                                            class="bi bi-plus"></i>Nouvelle depense</button></h5>
                                    <table class="table datatable" id="example" >
                                        <thead style="background: #7a6161;color:white;">
                                            <tr>
                                                <th>Date</th>
                                                <th>Quantite</th>
                                                <th>Destination</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalDep=0;
                                            @endphp
                                            @foreach ($depenses as $articles)
                                            <tr>
                                                <td>{{date('d-m-Y', strtotime($articles->date))}}</td>
                                                <td>{{$articles->amount}}</td>
                                                <td>{{$articles->Destination}}</td>
                                                <td>{{$articles->Description}}</td>
                                                <td><a href="{{route('depense_edit',$articles->id)}}"><i class="bi bi-pencil-square"></i></a></td>
                                                @php
                                                $totalDep+=$articles->amount;
                                                @endphp
                                        </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p class="ms-3"></p>

                                    </div>
                                        <div class="col-lg-6">
                                            <p class="text-black float-end fw-bold" style="background: #390101;padding:6px;color:#ffffff;margin-right:25px;"><span class="text-white me-3" style="font-size: 10px;">
                                            Depenses:</span><span style="font-size: 10px;color:#ffffff;">{{number_format($totalDep, 0, ',', '.')}} Fbu</span></p>
                                        </div>
                                </div>
                            </div>
                        </div>

                        {{-- SORTIS RECORD STARTS--}}

                        <div class="col-lg-6">
                            <div class="card top-selling overflow-auto">
                                <div class="card-body pb-2">
                                    <h5 class="card-title">Historique d'entree en caisse</h5>
                                <div class="row">
                                    <table class="table table-bordeless datatable" id="example">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Facture</th>
                                                <th scope="col">Produit</th>
                                                <th scope="col">Quantite</th>
                                                <th scope="col">Prix total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalSor=0;
                                            @endphp
                                            @foreach ($sortis as $products)
                                                <tr>
                                                    <td>{{date('d-m-Y', strtotime($products->date))}}</td>
                                                    <td>{{str_pad($products->numeroSorti , 4, '0', STR_PAD_LEFT)}}</td>
                                                    <td>{{$products->Produitname->nameProduct}}</td>
                                                    <td>{{$products->quantity}}</td>
                                                    <td>{{$products->totalPrice}}</td>
                                                    @php
                                                        $totalSor+=$products->totalPrice;
                                                    @endphp
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <p class="ms-3"></p>

                                    </div>

                                        <div class="col-xl-6">
                                            <p class="text-black float-end fw-bold" style="background: #390101;padding:6px;color:#ffffff;"><span class="text-white me-3" style="font-size: 10px;">
                                            Sortis:</span><span
                                                    style="font-size: 10px;color:#ffffff;">{{number_format($totalSor, 0, ',', '.')}}
                                                    Fbu</span></p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- SORTIS RECORD ENDS--}}

            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Comparaison Depenses et Ventes</h5>
                            <table class="table table-bordeless">
                                <thead style="background: green;color:#ffffff;">
                                    <tr>
                                    <th>DEPENSE</th>
                                    <th>VENTE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">{{number_format($totalDep, 0, ',', '.')}} Fbu</td>
                                        <td class="fw-bold">{{number_format($totalSor, 0, ',', '.')}} Fbu</td>
                                        @php
                                            $resteEnCaisse=$totalSor-$totalDep;
                                        @endphp
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                    <div class="col-lg-8">
                                        <p class="text-black float-end fw-bold" style="background: green;padding:6px;color:#ffffff;"><span class="text-white me-3" style="font-size: 12px;">
                                        Reste en caisse:</span><span
                                                style="font-size: 12px;color:#ffffff;">{{number_format($resteEnCaisse, 0, ',', '.')}}
                                                Fbu</span></p>
                                    </div>
                                    <div class="col-lg-2"></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
                <div class="col-lg-12">

                    <!-- Start depense Modal-->
                    <div class="card">
                        <div class="card-body">
                            <div class="modal fade modal-lg" id="basicModal" tabindex="-1">
                                <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color:#390101;">Ajout de depense
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Multi Columns Form -->
                                            <form class="row g-3" action="{{route('depense_store')}}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Montant</label>
                                                    <input type="number" class="form-control" id="inputName5"
                                                        placeholder="Montant" name="quantite" min="1" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Destination</label>
                                                    <input type="text" class="form-control" id="inputName5"
                                                        placeholder="Destination" name="Destination" required>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="inputName5" class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="inputName5"
                                                        placeholder="Description" name="Description" required>
                                                </div>
                                                <!-- End Multi Columns Form -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-"
                                                        style="background:#390101;color:white;">Enregistrer</button>&nbsp&nbsp
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Fermer</button>


                                                </div>
                                            </form><!-- End Multi Columns Form -->
                                        </div>
                                    </div>
                                </div><!-- End depense Modal-->
                            </div>
                        </div>
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

</body>

</html>
