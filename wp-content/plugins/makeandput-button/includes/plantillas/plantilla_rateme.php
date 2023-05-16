<?php
echo '<div class="container mt-5" id="mi-rateme">
	<div class="d-inline-block">
		<div class="card border rounded">
			<h5 class="card-header text-center">Rate me</h5>
			<div class="card-body">
				<div class="rating">
				  <input type="radio" id="star5" name="rating" value="5" />
				  <label for="star5"></label>
				  <input type="radio" id="star4" name="rating" value="4" />
				  <label for="star4"></label>
				  <input type="radio" id="star3" name="rating" value="3" />
				  <label for="star3"></label>
				  <input type="radio" id="star2" name="rating" value="2" />
				  <label for="star2"></label>
				  <input type="radio" id="star1" name="rating" value="1" />
				  <label for="star1"></label>
				</div>
				
			</div>
			<div class="card-footer d-flex justify-content-between">
				<small class="text-left small-font">Average rate:</small>
				<small class="text-right">Your rate:</small>
			</div>
		</div>
	</div>
</div>';