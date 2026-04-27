<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ShopEase</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href=" {{ asset('user/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href=" {{ asset('user/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('user/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('user/css/style.css') }}" rel="stylesheet">

    {{-- Custom Css Link --}}
    <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">

    <link rel="stylesheet" href="css/custom.css">

</head>

<body>

    <!-- Navbar start -->
    <div class="container-fluid fixed-top">

        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary display-6">ShopEase</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ route('userHome') }}" class="nav-item nav-link ">Shop</a>
                        <a href="{{ route('userCartPage') }}" class="nav-item nav-link">Cart</a>
                        <a href="{{ route('userContactPage') }}" class="nav-item nav-link">Contact</a>

                    </div>
                    <div class="d-flex m-3 me-0">

                        <a href="{{ route('userCartPage') }}" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                        </a>
                        <a href="{{ route('userOrderList') }}" class="position-relative me-4 my-auto">
                            <i class="fa-solid fa-list-check fa-2x"></i>
                        </a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle my-auto mt-2" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->profile == null ? asset('default/default-profile.jpeg') : asset('profile/' . Auth::user()->profile) }}"
                                    style="width: 50px" class="img-profile  rounded-circle" alt="">
                                <span>{{ Auth::user()->name ?? Auth::user()->nickname }}</span>
                            </a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ route('userProfileEdit') }}" class="dropdown-item my-2">Edit Profile</a>
                                @if (Auth::user()->password != null)
                                    <a href="{{ route('userChangePasswordPage') }}" class="dropdown-item my-2">Change
                                        Password</a>
                                @endif
                                <a href="#" class="dropdown-item my-2">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" value="Logout"
                                            class="btn btn-outline-success rounded w-100 mb-3">
                                    </form>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    @yield('content')
    @include('sweetalert::alert')




    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col text-center mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>ShopEase</a>, All right reserved.</span>
                </div>

            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    {{-- <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a> --}}

    <!-- JavaScript Libraries -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('user/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('user/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('user/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>

    {{-- sweet alert link --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('js-script')

    <script>
        function loadFile(event) {
            var output = document.getElementById('output');

            var reader = new FileReader();
            reader.onload = function() {
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>



</html>
