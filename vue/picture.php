<section class="d-flex justify-content-center align-items-start">
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
            <input type="file" name="new_img" accept="img/png" required>
          </div>
          <button type="button" class="btn btn-lg btn-secondary open_webcam_btn" name="open_webcam_btn">Open the webcam</button>
        </div>

        <div class="webcam_div d-none flex-column align-items-center">
          <video class="webcam_video"></video>
            <div class="d-flex justify-content-around">
              <button type="button" name="close_webcam_btn" class="btn btn-danger close_webcam_btn">Mix the images</button>
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

<div class='alert alert-danger d-none' role='alert'>"LOLOLOL"</div>


<!-- <div class="picture-div"> -->
  <!-- <nav>
    <h2>Filtres</h2>
    <form action="./index.php" method="post">
      <input type="radio" name="filter" value="filter-00">
      <img src="http://placekitten.com/g/320/261" alt="">
      <br>
      <input type="radio" name="filter" value="filter-01">
      <img src="http://placekitten.com/g/320/261" alt="">
      <br>
      <input type="radio" name="filter" value="filter-02">
      <img src="http://placekitten.com/g/320/261" alt="">
      <br>
      <input type="radio" name="filter" value="filter-03">
      <img src="http://placekitten.com/g/320/261" alt="">
      <br>
      <input type="radio" name="filter" value="filter-04">
      <img src="http://placekitten.com/g/320/261" alt="">
      <button type="submit" name="filter-button" class="form-button">choose</button></a>
    </form>
  </nav> -->
  <!-- <section class="webcam-section"> -->


  <!-- </section> -->
  <!-- <nav> -->
    <!-- <form class="local-picture--form" action="./index.php?action=new_picture" method="post" enctype="multipart/form-data">
        <div class="">
            <label>Please choose a picture to post :</label>
            <input type="file"  name="local-picture" accept=".png, .jpg, .jpeg, .gif">
        </div>
        <?php
        // if (isset($message))
        //     echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
        ?>
        <button type="submit" class="btn btn-primary" name="local-picture--button">select</button>
    </form> -->
    <!-- <form class="webcam-picture--form" action="./index.php" method="post">
        <p>Or select one of your personnal gallery :</p> -->
      <!-- EXEMPLE DE CODE A GENERER EN PHP POUR LES NOUVELLES PHOTOS  -->
        <!-- <input type="radio" name="picture" value="picture-00">
        <img src="http://placekitten.com/g/320/261" alt="">
        <br>
        <input type="radio" name="picture" value="picture-01">
        <img src="http://placekitten.com/g/320/261" alt="">
        <br>
        <input type="radio" name="picture" value="picture-02">
        <img src="http://placekitten.com/g/320/261" alt="">
        <br>
        <input type="radio" name="picture" value="picture-03">
        <img src="http://placekitten.com/g/320/261" alt="">
        <br>
        <input type="radio" name="picture" value="picture-04">
        <img src="http://placekitten.com/g/320/261" alt="">
        <br>
        <input type="radio" name="picture" value="picture-05">
        <img src="http://placekitten.com/g/320/261" alt="">
    </form> -->
  <!-- </nav> -->
<!-- </div> -->
<!-- <script type="text/javascript" src="./public/js/webcam.js"></script> -->
