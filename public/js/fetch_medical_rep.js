$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN':$('meta[name="csrf_token"]').attr('content')
	}
});
$(document).ready(function () {


	$('#bonus_pst').on('keyup change',function (e) {

		var total =  $('#total_price').val();
		if(total) {
			var pst = ($(this).val() / 100 ) * total;
		    $('#bonus').val(pst);
		}else {
			alert('please inter total price first');
		}
		
		
	});


	$("#count_per_unit_edit").on('keyup', function () {
		var count_per_unit = $("#count_per_unit_edit").val();
		var quantity = $('#stock_quantity').val();
		var pst_db_value = $("#pst_db_value").val();
		var stock_total_price = parseFloat($('#total_price').val());
		var old_count_per_unit = $('#old_count_per_unit').val();
        
        var calc =  quantity * old_count_per_unit;

        var stock_quantity_per_unit = $('#quantity_per_unit').val();

        var old_stock_quantity_per_unit = $('#old_stock_quantity_per_unit').val();

        var reduce = calc - old_stock_quantity_per_unit;

        var new_quantity_per_unit = (count_per_unit * quantity) - reduce;


        $('#quantity_per_unit').val(new_quantity_per_unit);

        var price = stock_total_price / quantity;
        var pst_value = (pst_db_value/100) * price;

        var selling_price = (price + pst_value) / count_per_unit;
        var purchasing_price = parseFloat(price / count_per_unit);

        $('#selling_price').val(selling_price);
        $('#purchasing_price').val(purchasing_price);
         

	})

	$('#quantity').on('keyup change',function () {
		var quantity = $('#quantity').val();
		var count_per_unit = $('#count_per_unit').val(); 
		
		
        
		if (count_per_unit) {
			$('#quantity_per_unit').val(quantity * count_per_unit);
		}

		if (quantity == '') {
			$('#quantity_per_unit').val('');
		}
	});



	$('#stock_total_price_edit').on('keyup change',function () {
		var quantity = parseInt($('#quantity').val());
		var total_price = parseFloat($('#stock_total_price_edit').val()) ;
		var drug_id = $('#drug_id').val();
		var count_per_unit = parseInt($('#count_per_unit_edit').val()); 
		var pst_db_value = parseInt($('#pst_db_value').val());

		var price = 0.0;

		var fix_pst = pst_db_value;
		var pst_value = 0.0;
		var final = 0.0;
		var pp = 0.0;

		if (quantity && drug_id && count_per_unit) {
			 price = total_price/quantity;
             pst_value = (fix_pst/100) * price;
             final = parseFloat((price + pst_value)/count_per_unit);
             pp = price/count_per_unit;
             console.log(final);
         	 
             $('#selling_price').val(final);
             $('#purchasing_price').val(pp);
		}else {
			alert("Please enter quantity and choose drug and count per unit")
		}
	});



	$('#total_price').on('keyup change',function () {
		var quantity = $('#quantity').val();
		var total_price = parseFloat($('#total_price').val()) ;
		var drug_id = $('#drug_id').val();
		var _token = $('input[name="_token"]').val();
		var count_per_unit = $('#count_per_unit').val(); 
		

		var price = 0.0;

		var fix_pst = parseInt($('#profit_margin').val());
		var pst_value = 0.0;
		var final = 0.0;
		var pp = 0.0;

		if (quantity  && count_per_unit) {
			calulate_prices(total_price,count_per_unit,quantity,fix_pst);
		}else {
			alert("Please enter quantity and choose drug and count per unit")
		}
	});


	$('#trade_name').blur(function(){
		
		var trade_name = $('#trade_name').val();
		var _token = $('input[name="_token"]').val();

		if (trade_name) {
		$.ajax({
			url : '/drugs/check',
			method : 'post',
			data : {trade_name:trade_name,_token:_token},
			success:function(result){
				if (result == 'unique') {
					$('#trade_name_error').html('<label class="text-success">Trade Name is Available</label>');
					$('#trade_name').removeClass('has-error');
					$('#submitBtn').attr('disabled',false);
				}else {
					$('#trade_name_error').html('<label class="text-danger">Trade Name is not Available</label>');
					$('#trade_name').addClass('has-error');
					$('#submitBtn').attr('disabled','disabled');
				}
			}
		})
		}
	});

	$('#company_id').change(function () {
		if ($(this).val() != '') {
			var company_id = $(this).val();
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url:"/drugs/fetch",
				method:"post",
				data:{company_id:company_id,_token:_token},
				success:function(result){
					$('#md_rep_id').html(result);
				}
			})
		}
	});


	$('#unit_price').on('change keyup',function () {
		var unit_price = $('#unit_price').val();
		var quantity = $('#quantity').val();
		var stock_quantity_per_unit = $('#quantity_per_unit').val();
		var count_per_unit = $('#count_per_unit').val(); 
		var fix_pst = parseInt($('#profit_margin').val());
			

 		var total = 0.0;
 		
		if (quantity && stock_quantity_per_unit) {
			 total = unit_price * stock_quantity_per_unit;
			$('#total_price').val(total);
			
			calulate_prices(total,count_per_unit,quantity,fix_pst);
		}


	});


	
	$('#profit_margin').on('change',function () {
    
         var quantity = parseInt($('#quantity').val());
         var count_per_unit = parseInt($('#count_per_unit_edit').val()); 
         var fix_pst = parseInt($('#profit_margin').val());
         var purchasing_price = parseFloat($('#purchasing_price').val());

         var price = 0.0;
         var total = 0.0;
          
          
         total = (quantity * count_per_unit) * purchasing_price ;
         $('#stock_total_price_edit').val(total);
         
         price = parseFloat(total) /quantity;
         pst_value = (fix_pst/100) * price;
         final = (price + pst_value)/count_per_unit;

         $('#selling_price').val(final);

    });

	

	

	
});


function calulate_prices(total_price,count_per_unit,quantity,fix_pst) {
     price = parseFloat(total_price) /quantity;
     pst_value = (fix_pst/100) * price;
     final = (price + pst_value)/count_per_unit;
     pp = price/count_per_unit;

 	 
     $('#selling_price').val(final.toFixed(2));
     $('#purchasing_price').val(pp);
}


