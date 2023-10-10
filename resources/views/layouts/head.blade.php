<!-- Title -->
<title>@yield("title")</title>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::asset('assets/images/bus-travel.jpg') }}" type="image/x-icon" style="border-radius:50%"/>

<!-- Font -->


<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Cairo">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

@yield('css')
<!--- Style css -->
<link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">

<!--- Style css -->
@if (App::getLocale() == 'ar')
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
@else
    <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
@endif

@yield('style')

<style>
    .button , .btn-success , input[type='submit'] , #head
    {
        background-color: <?php echo main_color_class_button_background(); ?>;
        border-color: <?php echo main_color_class_button_border(); ?>;
        color: <?php echo main_color_class_button_text_color(); ?>;
    }
    .button:hover, .button:focus,
    .btn-success:hover, .btn-success:focus,
    .btn-success:active,
    .btn-success:not(:disabled):not(.disabled).active,
    .btn-success:not(:disabled):not(.disabled):active,
    .show > .btn-success.dropdown-toggle
    {
        background-color: <?php echo hover_and_focus_color_class_button_background(); ?>;
        border-color: <?php echo main_color_class_button_border(); ?>;
    }

    .btn-success:not(:disabled):not(.disabled).active:focus, .btn-success:not(:disabled):not(.disabled):active:focus, .show > .btn-success.dropdown-toggle:focus {
        box-shadow: none;
    }

    .ti_ticket_print, h5
    {
        color: <?php echo main_color_class_button_background(); ?> !important;
    }
    .separator
    {
        border-bottom: 5px solid <?php echo main_color_class_button_background(); ?>;
    }





   .dataTables_paginate,
   .dataTables_info
   {display:none}



   .pagination {justify-content:center}
   .modal-body .row{margin-top:13px;}


    body,h1,h2,h3,h4,h5,h6{font-family: Cairo,'tahoma','sans-serif' !important;}
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button{
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number]{
        -moz-appearance: textfield;
    }

    .dataTables_length{display: none}
    .messages , .alert-danger {width:30%}

   .dropdown-toggle::after{
       display: none;
   }

   .top_nav_new{
       color: black;
       margin-top: 17px !important;
       font-size: 14px;
       font-weight: bold;
   }

   .admin-header .dropdown .dropdown-menu
   {
       left: initial;
       min-width: 220px;
   }

   .admin-header .dropdown-item {
       padding: 4px 18px 4px 0;
   }


   .dropdown-item-sub{
        position: relative;
   }

  .dropdown-menu-sub{
      /*display: block !important;*/
      position: absolute !important;
      left: -220px !important;
      top: 0 !important;
   }


  .arrow_left::after{
      margin: -4px 1px;
      display: inline-block;
      width: 0;
      height: 0;
      vertical-align: 0.255em;
      content: "";
      border-right: 0.3em solid;
      border-top: 0.3em solid transparent;
      border-left: 0;
      border-bottom: 0.3em solid transparent;
  }

   .content-wrapper {
       margin-right: 0;
   }


   .admin-header .navbar-nav {
       margin-bottom: 10px;
   }

   .admin-header.navbar ul.navbar-nav li {
        margin-right: 0;
   }

   .dropdown-notifications
   {
       position: absolute !important;
       left: 5px !important;
       min-width: 350px !important;
       padding: 15px 8px !important;
   }



</style>
