
<script>


	$(function() {

		$(document).on("click", ".delete", function(e) {

			e.preventDefault();

			var button = $(this);

			var n = new Noty({

			  text: 'Are you sure ?',

			  type: "success",

		      layout: "topRight",

			  buttons: [

			    Noty.button('YES', 'btn btn-success btn-sm', function () {

			        button.closest('form').submit();

			    }, {id: 'button1', 'data-status': 'ok'}),

			    Noty.button('NO', 'btn btn-danger btn-sm', function () {

			        n.close();

			    })

			  ]
			  
			});

			n.show();

		})
	})

</script>