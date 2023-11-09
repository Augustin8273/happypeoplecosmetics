<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <base href="/public">

  <title>Profile</title>
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
  <link href="hpc/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="hpc/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="hpc/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="hpc/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="hpc/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="hpc/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="hpc/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- main CSS File -->
  <link href="hpc/assets/css/style.css" rel="stylesheet">
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

            <li class="nav-item dropdown">
                {{-- @php
            $countW = 0;
        @endphp
        @foreach ($warnCount as $items)
            @php
                $QResta = $items->quantite;
                $QTot = $items->etat;
                $QPourc = $QResta / $QTot;
                $QPourcRest = $QPourc * 100;
                if ($QPourcRest < 30) {
                    $countW++;
                }
            @endphp
        @endforeach --}}

                {{-- @if ($countW)
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Stock dessous de 30 %">
            <i class="bi bi-bell"></i>
             <span class="badge bg-danger badge-number">{{$countW}}</span>
         </a>
         @else --}}
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Stock dessous de 30 %">
                    <i class="bi bi-bell"></i>

                </a>
                {{-- @endif<!-- End Notification Icon --> --}}

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        <span class="badge bg-danger">0</span> Article a approvisionner
                        <a href=""><span class="badge rounded-pill bg-primary p-2 ms-2">Voir tout</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>


                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->
            <li class="nav-item dropdown">

                {{-- @if ($numberMessage)
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Nouvelle commande">
          <i class="bi bi-chat-left-text"></i>
          <span class="badge bg-success badge-number">{{$numberMessage}}</span>
        </a>@else --}}
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" title="Nouvelle commande">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number"></span>
                </a>
                {{-- @endif<!-- End Messages Icon --> --}}

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        Vous avez <span class="badge bg-success">0</span> nouvelle(s) commandes
                        <a href=""><span class="badge rounded-pill bg-primary p-2 ms-2">Voir tout</span></a>
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
                        <h6>{{$userRole->fname}} {{$userRole->lname}}</h6>
          <span>{{$userRole->roles->name}}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('Profile',$userRole->id)}}">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    {{-- @if ($userRole->roles->nameRole == 'Admin' || $userRole->roles->nameRole == 'DG') --}}
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="">
                            <i class="bi bi-gear"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}">
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
            <a class="nav-link collapsed" href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Accueil</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('productListShow')}}">
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
                    <a href="{{route('produit_article')}}">
                        <i class="bi bi-circle"></i><span>Entrer nouveau article</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('produit_list')}}">
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
                    <a href="{{route('productCreate')}}">
                        <i class="bi bi-circle"></i><span>Approvisonner stock</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('stock')}}">
                        <i class="bi bi-circle"></i><span>Stock actuel</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('histoEntrees')}}">
                        <i class="bi bi-circle"></i><span>Historic des entrees</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('rangura')}}">
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
                    <a href="">
                        <i class="bi bi-circle"></i><span>Creer nouveau</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="bi bi-circle"></i><span>Liste</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="bi bi-circle"></i><span>Historic des sorties</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        {{-- @if ($userRole->roles->nameRole == 'Admin' || $userRole->roles->nameRole == 'DG') --}}
        <li class="nav-heading">Configurations</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-person-add"></i>
                <span>Ajouter utilisateur</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-gear"></i>
                <span>Paramètres</span>
            </a>
        </li><!-- End Register Page Nav -->
        {{-- @endif --}}

    </ul>

</aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route("dashboard")}}">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
          <div class="col-xl-4">

            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h2>{{$userRole->fname}} {{$userRole->lname}}</h2>
                <h3>{{$userRole->roles->name}}</h3>
              </div>
            </div>

          </div>

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">

                  @if (session('messageEditUser'))
                      <div class="alert alert-success" role="alert">
                          {{ session('messageEditUser') }}
                      </div>
                  @endif
                   @if (session('messPassChange'))
                      <div class="alert alert-success" role="alert">
                          {{ session('messPassChange') }}
                      </div>
                  @endif
                  @if (session('messPassNotMatch'))
                      <div class="alert alert-danger" role="alert">
                          {{ session('messPassNotMatch') }}
                      </div>
                  @endif
                  @if (session('messPassIncorrect'))
                      <div class="alert alert-danger" role="alert">
                          {{ session('messPassIncorrect') }}
                      </div>
                  @endif
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer mot de passe</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Nom </div>
                      <div class="col-lg-9 col-md-8">{{$userRole->fname}} {{$userRole->lname}}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Nom d'utilisateur</div>
                      <div class="col-lg-9 col-md-8">{{$userRole->username}}</div>
                    </div>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Company</div>
                      <div class="col-lg-9 col-md-8">Happy People Cosmetics</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Telephone</div>
                      <div class="col-lg-9 col-md-8">{{$userRole->telephone}}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8">{{$userRole->email}}</div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Role</div>
                      <div class="col-lg-9 col-md-8">{{$userRole->roles->name}}</div>
                    </div>

                  </div>

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <!-- Profile Edit Form -->
                    <form action="{{route('editerUser',$userRole->id)}}" method="POST" enctype="multipart/form-data">
                      @csrf

                      <div class="row mb-3">
                        <label for="Nom" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="fname" type="text" class="form-control" id="nom" value="{{$userRole->fname}}">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="Prenom" class="col-md-4 col-lg-3 col-form-label">Prenom</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="lname" type="text" class="form-control" id="prenom" value="{{$userRole->lname}}">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="Username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="username" type="text" class="form-control" id="username" value="{{$userRole->username}}">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Telephone" class="col-md-4 col-lg-3 col-form-label">Telephone</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="telephone" type="text" class="form-control" id="telephone" value="{{$userRole->telephone}}">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="email" type="email" class="form-control" id="Email" value="{{$userRole->email}}">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="Role" class="col-md-4 col-lg-3 col-form-label">Role</label>
                        <div class="col-md-4 col-lg-4">
                            <select name="role" class="form-control">
                                <option value="{{ $userRole->roles->id }}">{{ $userRole->roles->name }}</option>
                                @foreach ($role as $roles)
                                    <option value="{{ $roles->id }}">
                                        {{ $roles->name }}</option>
                                @endforeach

                            </select>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                      </div>
                    </form><!-- End Profile Edit Form -->

                  </div>


                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form action="{{route('changePassword',$userRole->id)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe recent</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="password" type="password" class="form-control" id="currentPassword" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmer nouveau mot de passe</label>
                        <div class="col-md-4 col-lg-4">
                          <input name="confpassword" type="password" class="form-control" id="renewPassword" required>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                      </div>
                    </form><!-- End Change Password Form -->

                  </div>

                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
        </div>
      </section>

  </main><!-- End #main -->

   <!-- ======= Footer ======= -->
   <footer id="footer" class="footer">
    <div class="copyright"> <strong><span style="color: #390101;">HAPPY PEOPLE COSMETICS GESTION STOCK</span></strong></div>
</footer><!-- End Footer -->


  <!-- Vendor JS Files -->
  <script src="HPC/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="HPC/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="HPC/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="HPC/assets/vendor/echarts/echarts.min.js"></script>
  <script src="HPC/assets/vendor/quill/quill.min.js"></script>
  <script src="HPC/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="HPC/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="HPC/assets/vendor/php-email-form/validate.js"></script>

  <!-- Toastr-->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"
      integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
      integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Template Main JS File -->
  <script src="HPC/assets/js/main.js"></script>

  {{-- @if (Session::has('StockMisAjmessage'))
  <script>
      toastr.options = {
          "progressBar": true,
          "closeButton": true,
          "positionClass": "toast-top-center",
      }
      toastr.success("{{ Session::get('StockMisAjmessage') }}");
  </script>
@endif --}}

@if(Session::has('messaget'))
<script>
    Swal("Message","{{Session::get('messaget')}}",'success',{
        button:true,
        button:"OK"
    });
</script>
@endif


</body>

</html>
