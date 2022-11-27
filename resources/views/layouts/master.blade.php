<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>E-Libary</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
        <script src="{{ asset('js/feather.min.js') }}"></script>
        <style>
            .select2-container .select2-selection--multiple {
                min-height: 40px !important;
                padding: 5px !important;
            }
            .select2-container .select2-search--inline .select2-search__field {
                vertical-align: top !important;
            }
            #spinner{
                position: fixed;
                z-index: 9999999;
                height: 100vh;
                background: rgb(255, 255, 255);
                width: 100vw !important;
                padding-top: 40vh
            }
        </style>
    </head>
    <body>
        <div id="spinner">
            <center>
                <div class="spinner-border text-primary" role="status"></div>
            </center>
        </div>
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
            <div class="container justify-content-center">
                <a class="navbar-brand fw-bold" href="#">E-Libary</a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item px-4">
                            <a class="nav-link" aria-current="page" href="{{ route('books.index') }}">
                                <i data-feather="book" class="me-2 pb-1" style="width: 14px"></i>Buku
                            </a>
                        </li>
                        <li class="nav-item dropdown px-4">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i data-feather="database" class="me-2 pb-1" style="width: 14px"></i>Master
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('category.index') }}">Kategori</a></li>
                                <li><a class="dropdown-item" href="{{ route('keyword.index') }}">Kata Kunci</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container py-4">
            @yield('content')
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('js/mask.min.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script>
            $('#spinner').fadeOut();
            feather.replace()
        </script>
        @yield('script')
    </body>
</html>
