
@if(session('success'))
	
	<script>
		
		new Noty({
		    
		    text: "{{ session('success') }}",

		    type: "success",

		    layout: "topRight",

		    timeout: 2000,

		    killer: true,

		}).show();

	</script>

@endif

@if(session('warning'))
	
	<script>
		
		new Noty({
		    
		    text: "{{ session('warning') }}",

		    type: "warning",

		    layout: "topRight",

		    timeout: 8000,

		    killer: true,

		}).show();

	</script>

@endif