$('#service_id').select2({
    width: "100%",
     ajax : {
        url: "/service/getService",
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
  });
 
 $('#addItem').on('click',function(e){
 
  e.preventDefault();
  var service_id = $('#service_id').val();
  var name = $('#service_id').find(':selected').text();
 
 
  if(service_id){
 
 
  var html = `
      <tr>
          <td>${name}</td>
          <td><input type="number" class='price form-control'  id="price-${service_id}"
              data-id="${service_id}" 
              class="form-control purchase_price">
          </td>
          <td>
              <button type="button" data-id="${service_id}"
                class="btn btn-danger delete-service">
                <i class="bx bxs-trash"></i>
              </button>
          </td>
          
      </tr>
    `;
 
    
    if($('#price-'+service_id).length == 0){
       
       $('.service-area').append(html);
      
    }
 
   }
 
   calc();
 
    
 });
 
 
 
 $('body').on('click','.delete-service',function(e){
 
  e.preventDefault();		
  $(this).closest('tr').remove();
  calc();
 
 });
 
 
 $('body').on('change','.price',function(e){
 
    var id = $(this).data('id');
    var price = parseFloat($(this).val());
    $('#subtotal-'+id).val(price);
 
    calc();
 });
 
 
 function calc(){
    var price = 0.0;
     $('.service-area .price').each(function(index){
         
         price += parseFloat($(this).val());
         
     });
 
     $('#serviceTotal').val(price);
     $('#serviceDisplayTotal').html(price);
 
     if (price > 0) {
         $('#service-btn').attr('disabled',false);
     }else {
         $('#service-btn').attr('disabled','disabled');
     }
 }