$(document).ready(function () {

	

	$('body').on('click','.delete-item',function(e){

		e.preventDefault();		

		var id = $(this).data('stock-id');
		
		$(this).closest('tr').remove();
		$("#com_insurance_price_"+id).remove();
		$("#purchasing_price_"+id).remove();

		calulate_total_deduct();
		calc();
	});

	$('#barcode').on('change',function (e) {

		e.preventDefault();
		var scanner = $('#barcode').val();
		var _token = $('input[name="_token"]').val();
		var pst = parseFloat($('#company').find(':selected').data('pst'));
		var insurance_id = $('#company').val();

		
        
        if (pst || (pst == 0.0)) {
			if (scanner) {
				$.ajax({
					url: "/pos/getItemByScanner",
					method:"post",
					data:{scanner:scanner,pst:pst,insurance_id:insurance_id,_token:_token},
					success:function (result) {
						
						if (result) {
							if (result.count == 1) { // if result has one row
								if($('#price'+result.id).length == 0) { // when item is not in the list
									$('.order_list').append(result.data);
									calulate_total_deduct();
									calc();
									$('#barcode').val('');
							   }else { // when the item already in the list
									var quantity = parseFloat($('#qu'+result.id).val());
									var new_q = quantity + 1;
									$('#qu'+result.id).val(new_q);

									var total = result.price * new_q;
									var insuranceTotal = result.insurance_selling_price * new_q;
									if(result.price_value == 1) {
										var added_value = total - insuranceTotal;
										if(added_value > 0) {
											var deduction_value =  added_value + ( insuranceTotal * (pst/100));
										}else {
											var deduction_value = insuranceTotal * (pst/100);
										}
										
									}else {
										var deduction_value = total * (pst/100);
									}
									
									$("#deduction_value_"+result.id).val(deduction_value.toFixed(2));
									$("#sub_total_"+result.id).val(total.toFixed(2));

									calulate_total_deduct();
									calc();
									
									$("#sub_total_"+result.id).val(total.toFixed(2));
									$('#barcode').val('');
							   }
								
							}else { // when result have more one rwo
								$('#incModal').modal('show');
								$('.drug_list_modal').html(result.data);
								$('#barcode').val('');
							}
							
						}else {
							alert('No Item Found Matching This Barcode');
							$('#barcode').val('');
							return false;
							
						}
						
					}

				});
			}
		}

		else {
			alert('Please Chose an Insurance Company');
		}
        
        
		
	});

	$('#ItemByName').on('click',function (e) {

		e.preventDefault();
		var stockId = $('#stockId').val();
		var _token = $('input[name="_token"]').val();
        var pst = parseFloat($('#company').find(':selected').data('pst'));
        var insurance_id = $('#company').val();
        
        if (pst || (pst == 0.0)) {
		if (stockId) {
			$.ajax({
				url: "/pos/getItemById",
				method:"post",
				data:{stockId:stockId,pst:pst,insurance_id:insurance_id,_token:_token},
				success:function (result) {
					console.log(result.added_value);
					$('.order_list').append(result.data);

					calulate_total_deduct();
					calc();
				}

			});
		}else {
			alert('Please chose a drug');
		}

		}else {
			alert('Please Chose an Insurance Company');
		}
		
	});

	$('body').on('click','.add-item-inc',function (e) {

		e.preventDefault();
		var exp = $(this).data('exp');
		var trade_name = $(this).data('trade_name');
		var selling_price = $(this).data('selling_price');
		var quantity_per_unit = $(this).data('quantity_per_unit');
		var barcode = $(this).data('barcode');
		var insurance_selling_price = $(this).data('isp');
		var pst = $(this).data('pst');
		var purchasing_price = $(this).data('pp');
		var id = $(this).data('id');
		var value = $(this).data('fv');
		var price_value = $(this).data('pv');
		
		var html = 
		`<tr>
			<td>${trade_name} - ${exp}</td>
			<td>
				<input name="items[${id}][quantity]" type="number" class="form-control quantity_ins" min-value="1" value="1"
				data-id="${id}" data-incp ="${insurance_selling_price}" 
				data-incpv="${price_value}" 
				data-price="${selling_price}" id="qu${id}" data-avl="${quantity_per_unit}">
		    </td>
			<td>
				<input type="number" class="form-control price_ins" 
				data-id="${id}" data-avl="${quantity_per_unit}" id="price${id}" name="price${id}" 
				value="${selling_price}">
			</td>
			
			<td>
				<input type="text" class="form-control deduction_value"
					id="deduction_value_${id}" name="deduction_value_${id}" 
					value="${value}">
			</td>
			<td>
				<input type="number" class="form-control deduction_rate" 
				name="deduction_rate_${id}" 
				value="${pst}" disabled>
			</td>
		<td>
			  <input type="number" class="form-control sub_total" id="sub_total_${id}" 
			  name="sub_total_${id}" 
			  value="${selling_price}">
		</td>
		<td>
		  <button data-stock-id="${id}" class="btn btn-danger delete-item"><span class="fas fa-trash-alt"></span></button>
		</td>
	  </tr>
		  <input type="hidden" class="form-control" id="com_insurance_price_${id}" name="com_insurance_price_${id}"
		  value="${insurance_selling_price}">
		  <input type="hidden" class="form-control" id="purchasing_price_${id}" name="purchasing_price_${id}"
		  value="${purchasing_price}">
			

		</tr>`;

		$('.order_list').append(html);
		
		calulate_total();
		
	});


	$('body').on('change','.quantity_ins',function (e) {

		
		var id = $(this).data('id');
		var avl = $(this).data('avl');
		var price = parseFloat($('#price'+id).val());
		var price_value = $(this).data('incpv');
		var insurance_selling_price = $(this).data('incp');
        var quantity = parseFloat($(this).val());
        var pst = $('#company').find(':selected').data('pst');
        
        if(quantity <= avl)
        {
        	var total = price * quantity;
        	var insuranceTotal = insurance_selling_price * quantity;
        	if(price_value == 1) {
				var added_value = total - insuranceTotal;
				if(added_value > 0) {
					var deduction_value =  added_value + ( insuranceTotal * (pst/100));
				}else {
					var deduction_value = insuranceTotal * (pst/100);
				}
        		
        	}else {
        		var deduction_value = total * (pst/100);
        	}
            
        	$("#deduction_value_"+id).val(deduction_value.toFixed(2));
            $("#sub_total_"+id).val(total.toFixed(2));

            calulate_total_deduct();
            calc();
        }else {
        	alert('quantity is not avilable');
        	quantity = avl;
        	$('#qu'+id).val(quantity);
        }
	});

	$('body').on('change','.price_ins',function (e) {

		
		var id = $(this).data('id');
		var price = parseFloat($(this).val());
        var quantity = parseFloat($('#qu'+id).val());
        var pst = $('#patient').find(':selected').data('pst');
      
    	var total = price * quantity;
        var deduction_value =  total * (pst/100);

    	$("#deduction_value_"+id).val(deduction_value.toFixed(2));
        $("#sub_total_"+id).val(total.toFixed(2));

        calulate_total_deduct();
        calc();
        
	});
	

});

function calulate_total_deduct() {
	var price_deduction_value = 0.0;
	$('.order_list .deduction_value').each(function(index){
		
		price_deduction_value += parseFloat($(this).val());
		
	});

	$('.total_dedcut').html(price_deduction_value);
    $('#total_dedcut').val(price_deduction_value);
}

function calc() {
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