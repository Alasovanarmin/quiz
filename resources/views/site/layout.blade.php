<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Container wrapper -->
    <div class="container">
        <!-- Navbar brand -->
        <a class="navbar-brand me-2" href="https://mdbgo.com/">
            <img
                src=""
                height="50"
                alt=""
                loading="lazy"
                style="margin-top: -1px;"
            />
        </a>

        <!-- Toggle button -->
        <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarButtonsExample"
            aria-controls="navbarButtonsExample"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Quiz Page</a>
                </li>
            </ul>
            <!-- Left links -->

            <div class="d-flex align-items-center">
                @if (auth()->guard('site')->check())
                <a href='{{route("logout")}}' class="btn btn-primary me-4">
                    Logout
                </a>
                <a
                    class="btn btn-dark px-3"
                    href="https://github.com/mdbootstrap/mdb-ui-kit"
                    role="button"
                > Narmin Alasova </i> </a>
                @endif

            </div>
        </div>
        <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
<br>
<body>
<div class="container">
    @if (session()->get('success'))
        <div class="alert alert-success">
            <ul>
                {{ session()->get('success') }}
            </ul>
        </div>
    @endif

    @if (session()->get('fail'))
        <div class="alert alert-danger">
            <ul>
                {{ session()->get('fail') }}
            </ul>
        </div>
    @endif

    @yield("content")
</div>
</body>

