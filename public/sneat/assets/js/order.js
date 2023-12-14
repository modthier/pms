$('#product_id').select2({
   width: "100%",
    ajax : {
       url: "/product/getProduct",
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
       'data-quantity':data["data-quantity"]
      }
   );
});


$('#addItem').on('click',function(e){

 e.preventDefault();
 var product_id = $('#product_id').val();
 var name = $('#product_id').find(':selected').text();
 var quantity = $('#product_id').find(':selected').data('quantity');
 
 if(product_id){


 var html = `
     <tr>
         <td>${name}</td>
         <td><input type="number"  min="1" value="1"   name="products[${product_id}][quantity]" 
             data-id="${product_id}"  
             id="quantity-${product_id}" 
             class="form-control quantity">
         </td>

         <td><input type="number" id="purchase_price-${product_id}"  
            name="purchase_price-${product_id}" 
            class="form-control purchase_price">
         </td>

         <td><input type="number" name="selling_price-${product_id}" 
            class="form-control selling_price">
         </td>

         <td>
             <input type="number" name="subtotal-${product_id}"  data-id="${product_id}" 
             class="form-control subtotal" id="subtotal-${product_id}">
         </td>
         <td>
               <button type="button" data-id="${product_id}"
                  class="btn btn-danger delete-product">
                 <i class="bx bxs-trash"></i>
               </button>
         </td>
         
     </tr>
   `;

   
   if($('#quantity-'+product_id).length == 0){
      
      $('.item-area').append(html);
      calc();
   }
}

   
});



$('body').on('click','.delete-product',function(e){

 e.preventDefault();		
 var id = $(this).data('stock-id');

 $(this).closest('tr').remove();
 calc();

});



$('body').on('change','.subtotal',function(e){
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

function purchase_price_calculate (subtotal,quantity) { 
   var purchase_price = (parseFloat(subtotal) / parseFloat(quantity)) ;
   return purchase_price;
 }