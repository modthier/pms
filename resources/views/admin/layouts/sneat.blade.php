<!DOCTYPE html>

<html
  lang="ar"
  class="light-style layout-menu-fixed"
  @if(app()->getLocale() == 'ar') dir="rtl" @endif
  data-theme="theme-default"
  data-assets-path="sneat/assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Control Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

   
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
  

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
    <link href="{{ asset('sneat/assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('sneat/assets/css/toastr.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="{{ asset('js/JsBarcode.all.min.js') }}"></script>

    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('sneat/assets/css/custom.css') }}" /> -->
    
    
    
    <style>
      .input-error{
         outline: 1px solid red;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          margin-top: 10px;
      }

      .card-header {
         padding-top:7px;
         padding-bottom:0px;
      }
      
  
      .select2-container--default .select2-selection--single{
          border-radius: 0.25em;
          width: 100%;
          height: calc(2.25rem + 2px);
          padding: 0.375rem 0.75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
         
      }

      

      .select2-container--default .select2-selection--multiple {
        border-radius: 0.25em;
        width: 100%;
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
      }
  </style>
  <style type="text/css">
    
    .info {
      display: none;
    }

    @media (min-width:910px) {
      .info {
         display: block;
      }
    }

    .filters {
      display: none;
    }

    .lang li a:first-child {
      border-right: 1px solid white;
    }

    .lang li a:last-child {
      border-left: 1px solid white;
      padding-left: 5px;
    }

    .table-bordered td, .table-bordered th {
      border: 2px solid #000000;
    }

    .barcode{
      font-weight: bold;
      height: 140px;
      width: 198px;
    }

    .order_list input {
        width:100px;
    }

</style>
  </head>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        @include('admin.layouts.aside')
        <div class="layout-page">
            @include('admin.layouts.nav')
           
            <!-- Content wrapper -->
          <div class="content-wrapper">
          @yield('starter')
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              @if($errors->any())
              <section class="col-lg-12">
              
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger d-flex justify-content-between align-items-center">
                        {{$error}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
             
              </section>
              @endif
                <div class="row">
                    @yield('content')
                </div>
            </div>

            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>

       <!-- Overlay -->
       <div class="layout-overlay layout-menu-toggle"></div>
    </div>


     <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('sneat/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/filter.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="{{ asset('sneat/assets/js/buttons.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/parsley.min.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/next.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/toastr.js') }}"></script>
    <script src="{{ asset('js/fetch_medical_rep.js') }}"></script>
    <script src="{{ asset('js/order.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/insurance.js') }}"></script>
    <script src="{{ asset('js/printThis.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>

        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 10000;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif(Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @elseif(Session::has('warning'))
                    toastr.warning('{{ Session::get('warning') }}');
                @endif

                
            });
    
        </script>

    <script type="text/javascript">

    $(document).ready(function () {
        var price = 0.0;
        $('.order_list .sub_total').each(function(index){
          
          price += parseFloat($(this).val());
          
        });

        $('.total').html(price.toFixed(2));
        $('#total_all').val(price.toFixed(2));

        var price_deduction_value = 0.0;
        $('.order_list .deduction_value').each(function(index){
            
            price_deduction_value += parseFloat($(this).val());
            
        });

        $('.total_dedcut').html(price_deduction_value.toFixed(2));
        $('#total_dedcut').val(price_deduction_value.toFixed(2));

        $('#scanner').focus();
        $('.sel').select2();
        

        
    });
    </script>
    <script type="text/javascript">
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
    $('#stockId').select2({
    ajax : {
      url: "{{ route('drugOrder.getStock') }}",
      type : "post" ,
      dataType : "json",
      data : function (params) {
        return {
            _token : CSRF_TOKEN ,
            search : params.term
        };
      } ,
      processResults: function (response) {
        
        return{
          results : response
        };
      },
      cache: true
    }
    });

    $('#avlDrugId').select2({
    ajax : {
      url: "{{ route('sales.getDrugs') }}",
      type : "post" ,
      dataType : "json",
      data : function (params) {
        return {
            _token : CSRF_TOKEN ,
            search : params.term
        };
      } ,
      processResults: function (response) {
        
        return{
          results : response
        };
      },
      cache: true
    }
    });

    });




</script>
        @stack('js')
  </body>
</html>


