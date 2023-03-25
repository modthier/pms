$(document).ready(function () {


	$('body').on('click','.delete-item',function(e){

		e.preventDefault();		
		var id = $(this).data('stock-id');
		
		$(this).closest('tr').remove();
		$("#purchasing_price_"+id).remove();
		


		
		calulate_total();
	});

	$('#addItem').on('click',function (e) {

		e.preventDefault();
		var barcode = $('#barcode').val();
		var _token = $('input[name="_token"]').val();
        
		if (barcode) {
			$.ajax({
				url: "/order/getItem",
				method:"post",
				data:{barcode:barcode,_token:_token},
				success:function (result) {
					if (result) {
						$('.order_list').append(result);
					    calulate_total();
					}else {
						alert('No Item Found Matching This Barcode');
					}
					
				}

			});
		}
		
	});


	$('#scanner').on('change',function (e) {

		e.preventDefault();
		var scanner = $('#scanner').val();
		var _token = $('input[name="_token"]').val();
        
		if (scanner) {
			$.ajax({
				url: "/order/getItemByScanner",
				method:"post",
				dataType: 'json',
				data:{scanner:scanner,_token:_token},
				success:function (result) {
					if (result.count > 0) {
						if (result.count == 1) {

							if($('#price'+result.id).length == 0) {
					             $('.order_list').append(result.data);
				            }else {
				               var quantity = parseFloat($('#qu'+result.id).val());
				               var new_q = quantity + 1;
				               if(new_q <= result.avl) {
								   
								   var discount = $('#discount_'+result.id).val();
								   
								   $('#qu'+result.id).val(new_q);

						           var total = parseFloat(result.price) * new_q;
			                       total = total - discount;
			        			   
			                       $("#sub_total_"+result.id).val(total.toFixed(2));
		                       } else {
		                       	   alert('quantity is not avilable');
						           $('#qu'+result.id).val(result.avl);
		                       }
		                      
				            }
							calulate_total();
						}else {
							$('#myModal').modal('show');
							$('.drug_list').html(result.data);
						}
						
					    
					    $('#scanner').val('');
					}else {
						alert('No Item Found Matching This Barcode');
						$('#scanner').val('');
						return false;
						
					}
					
				}

			});
		}
        
        
		
	});

	


	$('#addItemByName').on('click',function (e) {

		e.preventDefault();
		var stockId = $('#stockId').val();
		var _token = $('input[name="_token"]').val();
		
        
        
		if (stockId) {
			$.ajax({
				url: "/order/getItemById",
				method:"post",
				dataType: 'json',
				data:{stockId:stockId,_token:_token},
				success:function (result) {
				
					if($('#price'+stockId).length == 0) {
			           $('.order_list').append(result.data);
		            }else {

		               var quantity = parseFloat($('#qu'+stockId).val());
					   var new_q = quantity + 1;
					   if(new_q <= result.avl) {
						   var discount = $('#discount_'+stockId).val();
						   
						   $('#qu'+stockId).val(new_q);

				           var total = parseFloat(result.price) * new_q;
	                       total = total - discount;
	        			   
	                       $("#sub_total_"+stockId).val(total.toFixed(2));
                       }else {
                           alert('quantity is not avilable');
						   $('#qu'+result.id).val(result.avl);
                       }
                      
		            }
			
					calulate_total();
				}

			});
		}
		
	});



	$('body').on('click','.add-item',function (e) {

		e.preventDefault();
		var exp = $(this).data('exp');
		var trade_name = $(this).data('trade_name');
		var selling_price = $(this).data('selling_price');
		var quantity_per_unit = $(this).data('quantity_per_unit');
		var barcode = $(this).data('barcode');
		var id = $(this).data('id');
		
		var html = 
		`<tr>
			<td>${trade_name} - ${exp}</td>
			<td>
				<input name="items[${id}][quantity]" type="number" 
				class="form-control quantity" min-value="1" value="1"
				data-id="${id}" data-price="${selling_price}" id="qu${id}"
				data-avl="${quantity_per_unit}">
			</td>
			<td>
				<input type="number" class="form-control order_selling_price"
				 id="price${id}" name="price${id}" value="${selling_price}">
			</td>
			
			<td>
				<input type="number" min-value="0" value="0" id="discount${id}"
				   class="discount form-control" name="discount_${id}" data-id="${id}"
				   data-price="${selling_price}">
			</td>
			<td><input type="number" class="form-control sub_total" id="sub_total_${id}" 
              name="sub_total_${id}" value="${selling_price}">
            </td>
			<td>
				<button data-stock-id="${id}" class="btn btn-danger delete-item">
					<span class="fas fa-trash-alt"></span>
				</button>
			</td>
			

		</tr>`;

		$('.order_list').append(html);
		
		calulate_total();
		
	});


	$('body').on('change','.quantity',function (e) {

		
		var id = $(this).data('id');
		var avl = $(this).data('avl');
		var price = parseFloat($('#price'+id).val());
        var quantity = parseFloat($(this).val());
        var discount = $('#discount_'+id).val();
		

        if(quantity <= avl)
        {
        	var total = price * quantity;
        	total = total - discount;
            $("#sub_total_"+id).val(total.toFixed(2));
            calulate_total();
        }else {
        	alert('quantity is not avilable');
        	quantity = avl;
        	$('#qu'+id).val(quantity);
        }
	});


	$('body').on('change','.order_selling_price',function (e) {

		
		var id = $(this).data('id');
		var price = parseFloat($(this).val());
        var quantity = parseFloat($('#qu'+id).val());
      
    	var total = price * quantity;
       
        $("#sub_total_"+id).val(total.toFixed(2));

        
        calulate_total();
        
	});

	$('body').on('change','.discount',function (e) {

		var id = $(this).data('id');
		var price = parseFloat($('#price'+id).val());
		var quantity = $('#qu'+id).val();
        var discount = $('#discount_'+id).val();
        var finalPrice = (price * quantity) - discount;
        
        
        $("#sub_total_"+id).val(finalPrice.toFixed(2));
         calulate_total();

	});

	




	

	

});

function calulate_total() {
	var price = 0.0;
	$('.order_list .sub_total').each(function(index){
		
		price += parseFloat($(this).val());
		
	});

	$('.total').html(price);
	$('#total_all').val(price);

	if (price > 0) {
		$('#orderBtn').attr('disabled',false);
	}else {
		$('#orderBtn').attr('disabled','disabled');
	}
}
