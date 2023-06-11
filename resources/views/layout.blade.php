<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/short.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets//vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets//vendors/css/vendor.bundle.base.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>Hotel_Century - Your Favourite Foods</title>

    <script src="https://kit.fontawesome.com/af0bf27c44.js" crossorigin="anonymous"></script>
    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/css-library.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">

    <script src="{{ asset('assets/js/angular.min.js') }}"></script>
    <script src="{{ asset('assets/js/instamojo-checkout.js') }}"></script>
    <script src="{{ asset('assets/js/instamojo-checkout-sandbox.js') }}"></script>

</head>

<body ng-app="" id="body ">

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->


    <!-- ***** Header Area Start ***** -->
    <header class="header-area" style="z-index:1000;position:fixed; ">
        <div class="container">
            <nav class="main-nav">
                <!-- ***** Logo Start ***** -->
                <a href="{{ url('/') }}" class="logo">
                    <img class="img" width="100px" src="{{ asset('assets/images/logo.png') }}"> </a>
                <div class="-mr-2 flex items-center sm:hidden" onclick="openmenu()" id="open">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500  hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100  focus:text-gray-500 transition"
                        style="background-color:#f7f7f7;">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" id="open"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>


                <!-- ***** Logo End ***** -->
                <!-- ***** Menu Start ***** -->
                <ul class="nav" id="sidemenu" style="top:-50%;">
                    <div class="-mr-2 flex items-center sm:hidden" onclick="closemenu()" id="close">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" id="close"
                                    onclick="closemenu()" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <li id="sidemenu-1">
                        @if (Route::has('login'))
                            <div id="sidemenu-1" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                @auth
                        <li id="sidemenu-1" style="margin-top:-13px;">
                            <x-app-layout> </x-app-layout>
                        </li>
                    @else
                        <li id="sidemenu-1">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li id="sidemenu-1"><a href="{{ route('register') }}"
                                    class="ml-4 text-sm text-gray-700 underline">Register</a>
                            </li>
                        @endif
                    @endauth


                    <li class="scroll-to-section"><a href="/">Home</a></li>
                    <li class="scroll-to-section"><a href="/#about">About</a></li>

                    <li class="scroll-to-section"><a href="/menu">Menu</a></li>

                    <li class="scroll-to-section"><a href="/trace-my-order">Trace Order</a></li>

                    <li class="scroll-to-section"><a href="/my-order">My Order</a></li>

                    <li class="scroll-to-section"><a href="/#chefs">Chefs</a></li>
                    <li class="scroll-to-section"><a href="/#reservation">Contact Us</a></li>
                    <?php
                    
                    if (Auth::user()) {
                        $cart_amount = DB::table('carts')
                            ->where('user_id', Auth::user()->id)
                            ->where('product_order', 'no')
                            ->count();
                    } else {
                        $cart_amount = 0;
                    }
                    
                    ?>
                    <li><a href="/cart"><i class="fa fa-shopping-cart"></i><span class='badge badge-warning'
                                id='lblCartCount'> {{ $cart_amount }} </span></a></li>






                    <style>
                        #open {
                            margin-top: 5%;
                            margin-left: 90%;
                            display: block;

                        }





                        .badge {
                            padding-left: 9px;
                            padding-right: 9px;
                            padding-top: 10px;
                            -webkit-border-radius: 9px;
                            -moz-border-radius: 9px;
                            border-radius: 9px;
                            height: 16px;
                            text-align: center;
                        }

                        .label-warning[href],
                        .badge-warning[href] {
                            background-color: #c67605;
                        }

                        #lblCartCount {
                            font-size: 12px;
                            background: #ff0000;
                            color: #fff;
                            padding: 0 5px;
                            vertical-align: top;
                            margin-left: -10px;
                        }
                    </style>
                    <li>
                        @if (Route::has('login'))
                            <div id="sidemenu-2" class="hidden fixed top-0 right-0 px-6 py-4 sm:block ">
                                @auth
                        <li style="margin-top:-13px;" id="sidemenu-2">
                            <x-app-layout> </x-app-layout>
                        </li>
                    @else
                        <li id="sidemenu-2">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                        </li>
                        @if (Route::has('register'))
                            <li id="sidemenu-2"><a href="{{ route('register') }}"
                                    class="ml-4 text-sm text-gray-700 underline">Register</a>
                            </li>
                        @endif
                    @endauth


        </div>
        @endif
        @endif
        </li>

        </ul>



        <!-- ***** Menu End ***** -->
        </nav>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div style="min-height:750px">
        @yield('page-content')
    </div>

    <!-- ***** Footer Start ***** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-xs-12">
                    <div class="right-text-content">
                        <ul class="social-icons">
                            <li><a href="https://web.facebook.com/rahathosenmanik/"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://twitter.com/rahathosenmanik"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/rahathossenmanik/"><i
                                        class="fa fa-linkedin"></i></a></li>
                            <li><a href="https://www.instagram.com/rahathossenmanik/?hl=en"><i
                                        class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="logo">
                        <a href="{{ url('/') }}"><img class="img"
                                src="{{ asset('assets/images/logo.png') }}"></a>

                    </div>
                </div>
                <div class="col-lg-4 col-xs-12">
                    <div class="left-text-content">
                        <p>© Copyright Hotel_Century<br>Gujarat,India-383450
                            <br>Since 2023
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>


    {{-- plugin --}}
    <script src="{{ asset('admin/assets//vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/accordions.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/imgfix.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <script src="{{ asset('assets/js/lightbox.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>

    <!-- Global Init -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        $(function() {
            var selectedClass = "";
            $("p").click(function() {
                selectedClass = $(this).attr("data-rel");
                $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("." + selectedClass).fadeOut();
                setTimeout(function() {
                    $("." + selectedClass).fadeIn();
                    $("#portfolio").fadeTo(50, 1);
                }, 500);

            });
        });
    </script>



    <style>
        .header-area .container .main-nav #open,
        #close {
            display: none;
        }

        #sidemenu-1 {
            display: none;
        }





        @media only screen and (max-width:650px) {

            .header-area .container .main-nav #open,
            #close {
                display: block;
            }

            #close {
                margin-right: 100%;
            }

            #sidemenu {
                top: -50%;
            }

            #sidemenu-1 {
                display: block;
            }

            #sidemenu-2 {
                display: none;
            }










            .header-area .container .main-nav ul {
                position: absolute;
                right: -230px;
                width: 200px;
                top: -11%;
                border-top-left-radius: 20px;
                border-top-right-radius: 20px;
                padding-top: 50px;
                display: flex;
                flex-direction: row-reverse;
                z-index: 2;
                transition: right 0.8s;


            }

            #lblCartCount {
                margin-bottom: 6%;
                border-radius: 0px;
                margin-left: 0px;
            }
        }
    </style>
    <script>
        var sidemenu = document.getElementById("sidemenu");
        var open = document.getElementById("open");
        var close = document.getElementById("close");
        close.style.visibility = "hidden";







        function openmenu() {
            sidemenu.style.right = "0";
            setTimeout(closemenu, 5000);
            open.style.visibility = "hidden";
            setTimeout("close.style.visibility = 'visible'", 550);

        }


        function closemenu() {
            sidemenu.style.right = "-210px";
            setTimeout("open.style.visibility = 'visible'", 200);
            sidemenu.style.display = "block";
            close.style.visibility = "hidden";
        }
    </script>
    <script>
        $(document).ready(function() {

            $('ul.navbar-nav > li')
                .click(function(e) {
                    $('ul.navbar-nav > li')
                        .removeClass('active');
                    $(this).addClass('active');
                });
        });
    </script>
</body>

</html>
