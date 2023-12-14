$('#stock_id').select2({
   width: "100%",
    ajax : {
       url: "/stock/getStock",
       type : "get" ,
       dataType : "json",
       data : function (params) {
          return {
             search : params.term
          };
       } ,
       processResults: function (response) {
        
         return{
           results : response
         };
       },
       cache: false
     }
 }).on('select2:select', function (e) {
   var data = e.params.data;  

   $(this).children('[value="'+data['id']+'"]').attr(
      {
       'data-quantity':data["data-quantity"],
       'data-selling_price' : data["data-selling_price"],
       'data-purchase_price' : data["data-purchase_price"],
       'data-currency' : data["data-currency"]
      }
   );

 
});


$('#addItem').on('click',function(e){

 e.preventDefault();
 var stock_id = $('#stock_id').val();
 var name = $('#stock_id').find(':selected').text();
 var quantity = $('#stock_id').find(':selected').data('quantity');
 var price = $('#stock_id').find(':selected').data('selling_price');
 var currency = $('#stock_id').find(':selected').data('currency');
 var purchase_price = $('#stock_id').find(':selected').data('purchase_price');
 var sdg_price = parseFloat(price * currency);


 if(stock_id){


 var html = `
     <tr>
         <td>${name}</td>
         <td><input type="number"  min="1" value="1" name="stocks[${stock_id}][quantity]" 
             data-id="${stock_id}"  
             id="quantity-${stock_id}"
             data-avl="${quantity}"
             class="form-control quantity">
         </td>
          <td><input type="number" readonly value="${purchase_price}" id="purchase_price-${stock_id}"
             data-id="${stock_id}" 
             name="purchase_price-${stock_id}"
             class="form-control purchase_price">
         </td>
       
         <td><input type="number"  value="${price}" id="price-${stock_id}"
         data-id="${stock_id}" 
         data-currency = "${currency}"
         name="selling_price-${stock_id}"
         class="form-control price">
         
         <td><input type="number"  value="${sdg_price}" id="sdg_price-${stock_id}"
         data-id="${stock_id}" 
         name="sdg_price-${stock_id}"
         class="form-control price">
     </td>
     </td>
         <td><input type="number"  name="subtotal-${stock_id}" value="${price}" class="form-control subtotal" id="subtotal-${stock_id}" value="0"></td>
         <td><button type="button" data-id="${stock_id}" class="btn btn-danger delete-stock"><i class="bx bxs-trash"></button></td>
         
     </tr>
   `;

   
   if($('#quantity-'+stock_id).length == 0){
      
      $('.item-area').append(html);
     
   }else {
      var price = parseFloat($('#price-'+stock_id).val());
      var new_q = parseFloat($('#quantity-'+stock_id).val()) + 1;
      if(new_q <= parseFloat(quantity)){
         $('#quantity-'+stock_id).val(new_q);
         var total = price * new_q;
         $('#subtotal-'+stock_id).val(total);

      }else {
         $('#quantity-'+stock_id).val(parseFloat(quantity));
         alert('الكمية المطلوبة اكبر من المتوفرة');
      }
   }

  }

  calc();

   
});



$('body').on('click','.delete-stock',function(e){

 e.preventDefault();		
 $(this).closest('tr').remove();
 calc();

});


$('body').on('change','.price',function(e){

   var id = $(this).data('id');
   var currency = $(this).data('currency');
   var quantity = parseFloat($('#quantity-'+id).val());
   var avl = parseFloat($(this).data('avl'));
   var price = parseFloat($(this).val());
   var total = price * quantity;
   var sdg_price = parseFloat(price * currency);
   $('#subtotal-'+id).val(total);
   $('#sdg_price-'+id).val(sdg_price);

   calc();
});

$('body').on('change','.quantity',function(e){

   var id = $(this).data('id');
   var quantity = parseFloat($(this).val());
   var avl = parseFloat($(this).data('avl'));
   var price = parseFloat($('#price-'+id).val());
   if(quantity <= avl){
      var total = price * quantity;
      $('#subtotal-'+id).val(total);
   }else {
      $(this).val(avl);
      alert('الكمية المطلوبة اكبر من المتوفرة');
   }
  

   calc();
});



function calc(){
   var price = 0.0;
	$('.item-area .subtotal').each(function(index){
		
		price += parseFloat($(this).val());
		
	});

	$('#total').val(price);
	$('#displayTotal').html(price);

	if (price > 0) {
		$('#order-btn').attr('disabled',false);
	}else {
		$('#order-btn').attr('disabled','disabled');
	}
}