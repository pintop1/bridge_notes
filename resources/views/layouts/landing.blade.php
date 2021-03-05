@php
use App\Http\Controllers\Globals as Utils;
Utils::matureInvestment();
@endphp
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bride Credit Limited - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="shortcut icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
    <link rel="icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
  </head>
  <body>
    <!-- preloader start -->
    <div class="preloader">
      <div class="preloader-box">
        <div>L</div>
        <div>O</div>
        <div>A</div>
        <div>D</div>
        <div>I</div>
        <div>N</div>
        <div>G</div>
      </div>
    </div>
    <!-- preloader end -->
    <!--  header-section start  -->
    <header class="header-section transparent--header header--fixed">
      <div class="header-top">
        <div class="container">
          <div class="row justify-content-between">
            <div class="col-lg-6 col-md-6">
              <div class="header-top-left d-flex">
                <div class="support-part">
                  <a href="tel:+2348115838889"><i class="fa fa-headphones"></i>Support</a>
                </div>
                <div class="email-part">
                  <a href="mailto:info@bridgecredit.com"><i class="fa fa-envelope"></i>info@bridgecredit.com</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header-bottom">
        <div class="container">
          <nav class="navbar navbar-expand-xl">
            <a class="site-logo site-title" href="/"><img src="{{ asset('logo.png') }}" alt="site-logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="menu-toggle"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav main-menu ml-auto">
                <li><a href="https://bridgecredit.com.ng/">Home</a></li>
                <li class="active"><a href="/">investments</a></li>
                <li class="menu_has_children">
                  <a href="#0">About Us</a>
                  <ul class="sub-menu">
                    <li><a href="https://bridgecredit.com.ng/aboutus/">Our Company</a></li>
                    <li><a href="https://bridgecredit.com.ng/aboutus/vision-mission-values/">Vision, Mission & Values</a></li>
                  </ul>
                </li>
                <li class="menu_has_children">
                  <a href="#0">Loans</a>
                  <ul class="sub-menu">
                    <li><a href="https://bridgecredit.com.ng/loans/bridge-salary-advance-salad/">Bridge Salary Advanced (Salad)</a></li>
                    <li><a href="https://bridgecredit.com.ng/loans/bridge-salary-loan/">Bridge Salary Loan</a></li>
                    <li><a href="https://bridgecredit.com.ng/loans/bridge-loan/">Bridge Loan</a></li>
                    <li><a href="https://bridgecredit.com.ng/loans/back-to-school-loan/">Back to School Loan</a></li>
                    <li><a href="https://bridgecredit.com.ng/loans/bridge-acquire/">Bridge Acquire</a></li>
                  </ul>
                </li>
                <li class="menu_has_children">
                  <a href="#0">FAQs</a>
                  <ul class="sub-menu">
                    <li><a href="https://bridgecredit.com.ng/loan-faqs/">Loan FAQs</a></li>
                    <li><a href="https://bridgecredit.com.ng/bridgecoop-faq-the-savers-club/">BridgeCoop FAQs</a></li>
                  </ul>
                </li>
                <li><a href="https://bridgecredit.com.ng/contact-us/">contact us</a></li>
              </ul>
              <div class="header-join-part">
                <button type="button" class="btn btn-primary" onclick="return window.location = '{{ url("/register") }}';">join us</button>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </header>
    @yield('content')
    <footer class="footer-section anim">
      <div class="footer-bottom">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <p class="copy-right-text">Copyright © 2020 BRIDGE CREDIT LTD. Developed by <a href="//pintoptechnologies.com">PTL</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <div class="scroll-to-top">
      <span class="scroll-icon">
      <i class="fa fa-rocket"></i>
      </span>
    </div>
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/lightcase.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.paroller.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
  </body>
</html>