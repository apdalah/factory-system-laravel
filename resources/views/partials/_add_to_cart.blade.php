<script>
	
	$(function() {

		$(document).on("submit", ".add_to_cart", function(event) {

			event.preventDefault();

			$.ajax({

				url: "{{ route('shop.addToCart') }}",

				type: "POST",

				dataType: "json",

				data: new FormData(this),

				cache: false, 

				processData: false, // prevent jquery to modify data that you sent so it will pass the same way you sent (object or string) encoded

				contentType: false, // for multipart/form-data if not set to false it will convert formData to string and it will not pass the file the same way u sent also send the header with the request if you want it

				success: function(data)
				{
					html = '';
					html += '<div class="row">';
					html += '<div class="col-lg-3">' + data.name + '</div>';
					html += '<div class="col-lg-3">1</div>';
					html += '<div class="col-lg-3">' + data.price + '</div>';
					html += '<div class="col-lg-3">' + data.price + '</div>';
					html += '</div><hr>';

					var cart_count = $('.cart-count').html();


					$('.cart_content').append(html);
					$('.message').text(data.message)
					$('.cart-count').html(parseInt(cart_count) + 1);

					console.log(data.message)

					if(data.error){

						window.location.href = data.location;
					}
				},

				error: function(error)
				{
					console.log(error);
				}

			});
			

		});
	});

</script>