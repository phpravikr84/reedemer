<!DOCTYPE html>
<html lang="en" ng-app="redeemar-app">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Material Lite Angular Admin Theme">
  <meta name="author" content="Theme Guys - The Netherlands">

  <title>Redeemar</title>

  <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/vendors.min.cc72de2f21cf6e67f523.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/demo.min.a2f360834fafcc0ef2d1.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/jquery.rateyo.css') }}">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!-- IE Compatibility shims -->
  <!--[if lt IE 9]>
  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js""></script>
  <![endif]-->
  <!--[if IE]>
  <script src="//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.1.7/es5-shim.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/classlist/2014.01.31/classList.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/flexie/1.0.3/flexie.min.js"></script>
  <![endif]-->
  <!-- end shims -->
  @yield('style')
</head>

<body ng-controller="MainController" > 
  <!-- <div id="app" class="app" ng-include="'{{ asset('/tpl/demo/app.html') }}'"></div> -->
  <div class="demo-layout mdl-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <ml-header></ml-header><!-- This directive uses the partial: src/tpl/demo/partials/header.html -->

    <ml-sidebar></ml-sidebar><!-- This directive uses the partial: src/tpl/demo/partials/sidebar.html -->
    <main class="mdl-layout__content mdl-color--grey-100 page" ng-view></main>   
    
  </div>
  <input type="hidden" name="main_site_url" id="main_site_url" value="{{ url() }}" />
  <input type="hidden" name="site_path" id="site_path" value="{{getenv('SITE_PATH')}}"  />
  @yield('content')
 
  <script src="{{ asset('/user/js/vendors.min.c95e87841078c8095acf.js') }}"></script>
  <script src="{{ asset('/user/js/demo.min.9506beb44f2c95b2945c.js') }}"></script>
  <script src="{{ asset('/user/js/campaign.js') }}"></script>
  <script src="{{ asset('/user/js/inventory.js') }}"></script>
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.0.1/jquery.rateyo.min.js"></script>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <link rel="stylesheet" href="{{ asset('/css/rating.css') }}">
    <script src="{{ asset('/user/js/rating.js') }}"></script>


  <script>
 //  $(document).ready(function(){  
 //  $(function () {
 // alert("m");
 //    $("#rateYo").rateYo({
 //      rating: 3.6
 //    });
   
 //  });
 //  });

  </script>
  <script type="text/javascript">
    // $(document).ready(function(){  
     //alert("a")     ;
       // $("#rateYo").rateYo({
       //      rating: 3
       // });      
    // });


  </script>
  @yield('scripts')
</body>
</html>
