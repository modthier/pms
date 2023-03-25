@if(session('success'))
<section class="col-lg-12">

		
	<div class="alert alert-success" role="alert">
		{{ session('success') }}
 	</div>
	

</section>
@endif