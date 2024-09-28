<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <link href="{{ asset('img/logo-dishub.png') }}" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome-free-6/css/all.css') }}">
    <!-- SweetAlert 2 -->
    <script src="{{ asset('assets/dist/sweetalert2/sweetalert2.all.min.js') }}">
    </script>
    <link rel="{{ asset('assets/dist/sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
    <nav id="main_nav" class="navbar navbar-expand-lg navbar-light bg-white shadow">
        <div class="container">
            <a class="navbar-brand h1" href="{{url('/')}}">
                <img src="{{ asset('img/logo-dishub.png') }}" style="position:absolute; width: 50px; height:50px; z-index:1;" alt="">
                <div class="d-flex flex-column" style="margin-left: 5rem;">
                    <span class="text-primary h5 mb-0">Sistem Informasi Geografis</span>
                    <span class="text-primary h5 mb-0">Halte Bus Trans Metro Deli Kota Medan</span>
                </div>
            </a>
        </div>
    </nav>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="<?= url('/') ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('halte')) ? 'active' : '' }}{{ (request()->is('halte/*')) ? 'active' : '' }}" href="<?= url('halte') ?>">Halte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('bus')) ? 'active' : '' }}{{ (request()->is('bus/*')) ? 'active' : '' }}" href="<?= url('bus') ?>">Bus</a>
                    </li>
                    <?php if(isset($page)) { ?>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle btn btn-success text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <i class="fa fa-filter"></i> Filter
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" id="myDIV" style="overflow-y: auto;">
                            <a class="dropdown-item" href="#">
                                Pilih Koridor
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" data-id="0" onclick="reMarkerKoridor(this)">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Semua Koridor
                            </a>
                            @foreach($koridor as $row)
                            <a class="dropdown-item" data-id="{{$row->id}}" onclick="reMarkerKoridor(this)">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{$row->nama}}{{$row->kode}}
                            </a>
                            @endforeach
                        </div>
                    </li>
                    <?php } ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset(Auth::user()->id)) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('/admin/dashboard') ?>">Dashboard</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('login') ?>">Login</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- <form class="d-flex mt-3 mt-md-0" role="search">
                <input class="form-control me-2" type="search" placeholder="cari" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form> -->
        </div>
    </nav>
    @yield('main')
    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        var header = document.getElementById("myDIV");
        var btns = header.getElementsByClassName("dropdown-item");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('js')
</body>

</html>