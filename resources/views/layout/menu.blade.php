<!-- Palette URL: http://paletton.com/#uid=13e0u0kw0FrjOKWpwHkEQtFGen2 -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    {{-- <meta http-equiv="refresh" content="10"> --}}
    <title>
        DashTenta | {{ $title }}
    </title>
    <link rel="icon" href="/images/signpost-split.svg" type="image/x-icon" style="color:antiquewhite">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>



    <!-- <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="/css/dashboard.css">
    <link rel="stylesheet" href="/css/dashboard.rtl.css">
    <link rel="stylesheet" href="/css/sidebars.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <header class="navbar sticky-top flex-md-nowrap p-0 shadow" style="background-color: #00BFA6;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-4" style="color:#FFFFFF" href="/admin/dashboard"><strong>Tenta
                Tour</strong></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn btn-link mt-3" type="submit" style="color:#FFFFFF">Sign out</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse"
                style="background-color: #007363;">
                <div class="position-sticky pt-3 px-3 sidebar-sticky">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item align-text-center">
                            <a class="nav-link" href="/admin/dashboard">
                                <h5 class="text-White align-text-center mt-4"><strong>Dashboard</strong></h5>
                            </a>
                        </li>
                        <hr>
                        <li class="nav-item ">
                            <a class="nav-link" href="/admin/reservasi/index">
                                <h6 class="text-White align-text-center"><i
                                        class="bi bi-calendar2-week"></i>&nbsp;&nbsp;Reservasi</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/paket/index">
                                <h6 class="text-White align-text-center"><i
                                        class="bi bi-collection"></i>&nbsp;&nbsp;Paket Wisata</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/objek/index">
                                <h6 class="text-White align-text-center"><i class="bi bi-compass"></i>&nbsp;&nbsp;Objek
                                    Wisata</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/transportasi/index">
                                <h6 class="text-White align-text-center"><i
                                        class="bi bi-bus-front-fill"></i>&nbsp;&nbsp;Transportasi</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/customer/index">
                                <h6 class="text-White align-text-center"><i
                                        class="bi bi-person-rolodex"></i>&nbsp;&nbsp;Customers</h6>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="green-text"><strong>{{ $title }}</strong></h1>
                </div>

                <div class="container">
                    <div class="row my-4">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input class="form-control border rounded" type="search" id="searchBar"
                                    placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text py-sm-3 rounded-right"><i
                                            class="bi bi-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            @yield('button')
                        </div>
                    </div>
                </div>

                <div class="container">
                    @yield('container')
                </div>
            </main>
        </div>
    </div>


    <!-- <script src="../assets/dist/js/bootstrap.bundle.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script> -->
    <!-- <script src="js/dashboard.js"></script> -->
    <script src="/js/sidebars.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchBar").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#indexTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        
    </script>
    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("example");
            switching = true;
            // Set the sorting direction to ascending:
            dir = "asc";
            /* Make a loop that will continue until
            no switching has been done: */
            while (switching) {
                // Start by saying: no switching is done:
                switching = false;
                rows = table.rows;
                /* Loop through all table rows (except the
                first, which contains table headers): */
                for (i = 1; i < (rows.length - 1); i++) {
                    // Start by saying there should be no switching:
                    shouldSwitch = false;
                    /* Get the two elements you want to compare,
                    one from current row and one from the next: */
                    x = rows[i].getElementsByTagName("TD")[n];
                    console.log(x.innerHTML.toLowerCase(), isNaN(x))
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    /* Check if the two rows should switch place,
                    based on the direction, asc or desc: */
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            // If so, mark as a switch and break the loop:
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    /* If a switch has been marked, make the switch
                    and mark that a switch has been done: */
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    // Each time a switch is done, increase this count by 1:
                    switchcount++;
                } else {
                    /* If no switching has been done AND the direction is "asc",
                    set the direction to "desc" and run the while loop again. */
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>

</html>
