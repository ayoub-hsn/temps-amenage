<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Université UH1</title>
  <!-- General CSS Files -->
    @include('admin-filiere.layouts.head')

</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      @include('admin-filiere.layouts.navbar')

      @include('admin-filiere.layouts.sidebar')

      <!-- Main Content -->
      
      @yield('content')

      <footer class="main-footer">
        <div class="footer-left">
          <a href="#"></a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->

  @include('admin-filiere.layouts.footer')

  
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>