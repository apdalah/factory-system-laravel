<script>
	
	$(function() {

		$(document).on("click", "#addToCart", function(event) {

			event.preventDefault();

			var id = $(this).attr('data-id');

			$.ajax({

	            url: "",
	            type: "POST",
	            data: { id : id },
	            cache: false,
	            dataType: "json",
	            success:function(data)
	            {

					console.log(data.success)

					var html = '';
					html += '<tr>';
					html += '<td><img src="img/' + data.image + '" style="width: 50px" alt=""></td>';
					html += '<td>1</td>';
					html += '<td>data.price</td>';
					html += '<td>total</td>';
					html += '</tr>';

					$("#cartContent").append(html);

	            },

        	});

			
		});
	});

</script>