<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="author" content="ahmed essam">
    <meta name="description" content="description content">
    <meta name="keywords" content="content">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Fav icon-->
    <link rel="shortcut icon" href="{{ asset('resources/assets/site') }}/assets/images/logo.png">

    <!-- style CSS-->
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/validation.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/rtl.css">
    <link rel="stylesheet" href="{{ asset('resources/assets/site') }}/assets/css/responsive.css">

    <title> Homes Station </title>
    <style>
        /* Style inputs with type="text", select elements and textareas */
        input[type=text], select, textarea {
        width: 100%; /* Full width */
        padding: 12px; /* Some padding */
        border: 1px solid #ccc; /* Gray border */
        border-radius: 4px; /* Rounded borders */
        box-sizing: border-box; /* Make sure that padding and width stays in place */
        margin-top: 6px; /* Add a top margin */
        margin-bottom: 16px; /* Bottom margin */
        resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
        }

        /* Style the submit button with a specific background color etc */
        input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

        /* When moving the mouse over the submit button, add a darker green color */
        input[type=submit]:hover {
        background-color: #45a049;
        }

        /* Add a background color and some padding around the form */
        .container {
        border-radius: 5px;
        padding: 20px;
        }
    </style>
</head>

<body class="home-style three rtl" data-spy="scroll" data-target=".navbar" data-offset="80">

    <div class="social-picker">
        <a href="#" class="handle">
            <i class="fa fa-rss"></i>
        </a>
        <div class="sec-position">
            <div class="settings-header">
                <h3>تواصل معنا</h3>
            </div>
            <div class="section">
                <div class="colors o-auto">
                    <a href="tel:966504156617+">966504156617+
                        <i class="fa fa-phone"></i>
                    </a>
                    <br>
                    <a href="mailto:CC@homesstation.com">CC@homesstation.com
                        <i class="fa fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Preloader-->
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- Preloader end-->

    <!-- Nav Start-->
    <nav class="navbar navbar-expand-lg navbar-light theme-nav fixed-top navbar-page">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="{{ asset('resources/assets/site') }}/assets/images/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse default-nav" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" id="mymenu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">المميزات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">الشاشات</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.settings.privacy') }}">الخصوصية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.settings.terms') }}">اتفاقية الاستخدام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('website.settings.contact') }}">تواصل معنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('website.home') }}">تحميل</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Nav end-->


    <!-- privacy Section start-->
    <section class="privacy-page">
        <div class="container">
            <h3 class="main-title">تواصل معنا</h3>
            <div class="all-content">
                <div class="container">
                    <form action="action_page.php">

                      <label for="fname">الاسم الأول</label>
                      <input type="text" id="fname" name="firstname" placeholder="الاسم الأول..">

                      <label for="lname">الاسم الأخير</label>
                      <input type="text" id="lname" name="lastname" placeholder="الاسم الأخير..">

                      <label for="subject">الرسالة</label>
                      <textarea id="subject" name="subject" placeholder="الرسالة.." style="height:200px"></textarea>

                      <input type="submit" value="Submit">

                    </form>


            </div>
        </div>
    </section>
    <!-- privacy Section End-->

    <!-- Tap on Top-->
    <div class="tap-top">
        <div>
            <i class="fa fa-angle-double-up"></i>
        </div>
    </div>
    <!-- Tap on Ends-->

    <!-- Footer Section start-->
    <div class="copyright-section index-footer">
        <p>جميع الحقوق محفوظة لسنه 2019</p>
    </div>
    <!-- Footer Section End-->

    <!-- js files-->
    <script src="{{ asset('resources/assets/site') }}/assets/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/popper.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/tilt.jquery.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/jquery.validate.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/additional-methods.min.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/contact.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/scroll.js"></script>
    <script src="{{ asset('resources/assets/site') }}/assets/js/script.js"></script>
</body>

</html>
