<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $metaTitle ?? config('app.name','PMS') }}</title>

  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
  
  <link rel="stylesheet" type="text/css" href="{{ asset('js/dist/css/select2.min.css') }}">

  
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
  <script type="text/javascript" src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
  @livewireStyles

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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  @include('admin/parts/navbar')  

  @include('admin/parts/main_sidebar')  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
  @yield('starter')
   
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          @include('admin.parts.alerts')

          <section class="col-lg-12">
          @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
          @endif
          </section>
          
          @yield('content')
        
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('admin/parts/control_sidebar')  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="http://khadamatico.com/" target="_blank">Khadamati Company</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 - <?php echo date('Y'); ?></strong>  Developed By Muddathir Samir 

  </footer>
</div>
<!-- ./wrapper -->


<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/fetch_medical_rep.js') }}"></script>
<script src="{{ asset('js/order.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/insurance.js') }}"></script>
<script src="{{ asset('js/printThis.js') }}"></script>
<script src="{{ asset('js/print.js') }}"></script>
@livewireScripts
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

  
</body>
</html>
