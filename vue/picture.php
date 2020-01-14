<section class="d-flex flex-column">
	<section class="d-flex justify-content-center align-items-start mt-3">
	  <form class="d-flex flex-column justify-content-between" action="" method="post" enctype="multipart/form-data">
	    <div class="">
	      <div class="img_superposable_div">
	        <h2>Select your filter</h2>
	        <div class="d-flex">
	          <div class="option">
	              <input type="radio" name="img_superposable" id="1" value="" checked>
	              <label for="1">
	                <img src="./public/images/filters/rabbit.png" alt="filter" height="60" width="60">
	              </label>
	          </div>
	          <div class="option">
	              <input type="radio" name="img_superposable" id="2" value="">
	              <label for="2">
	                <img src="./public/images/filters/rated.png" alt="filter" height="60" width="60">
	              </label>
	          </div>
	          <div class="option">
	              <input type="radio" name="img_superposable" id="3" value="">
	              <label for="3">
	                <img src="./public/images/filters/crown-1.png" alt="filter" height="60" width="60">
	              </label>
	          </div>
	          <div class="option">
	              <input type="radio" name="img_superposable" id="2" value="">
	              <label for="4">
	                <img src="./public/images/filters/crown-2.png" alt="filter" height="60" width="60">
	              </label>
	          </div>
	        </div>
	      </div>
	      <div class="img_setting_div">
	        <div class="d-flex justify-content-around type_img_btn">
	          <div class="file btn btn-lg btn-secondary">
	            <span>Import an image</span>
	            <input type="file" name="new_img" accept=".png" required>
	          </div>
	          <button type="button" class="btn btn-lg btn-secondary open_webcam_btn" name="open_webcam_btn">Open the webcam</button>
	        </div>

	        <div class="webcam_div d-none flex-column align-items-center">
	          <video class="webcam_video"></video>
	            <div class="d-flex justify-content-around">
	              <button type="button" name="close_webcam_btn" class="btn btn-danger close_webcam_btn">close webcam</button>
	              <button type="button" name="take_picture_btn" class="btn btn-success take_picture_btn">Take a pic !</button>
	            </div>
	        </div>
	        <img src="" id="file_save" class="d-none" alt="">
	        <canvas id="canvas" class="d-none"></canvas>
	        <img src="" id="photo"  class="d-none" alt="">
	      </div>
	    </div>
	    <div class="d-flex justify-content-end" style="margin-bottom: 50px;">
	      <button type="button" name="add_new_img" class="btn btn-outline-info btn-lg apply_calc_btn">Mix the images</button>
	      <button type="button" name="publicate_img" class="btn btn-outline-success btn-lg send_picture_btn">Publish !</button>
	    </div>
	  </form>
	</section>
	<section class="gallery-view--section centered">
	</section>
</section>

<div class='alert alert-danger d-none' role='alert'>"please follow the rules :("</div>
