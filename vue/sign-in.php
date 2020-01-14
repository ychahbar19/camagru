<section>
    <?php
        if (isset($_SESSION["user-created"]))
            echo "<p>".$_SESSION["user-created"]."</p>";
    ?>
    <!-- <div class="sign-div"> -->
      <article>
        <form action="" method="POST" style="margin-top: 100px">
          <div class="form-div--signin">
            <input type="text" class="form-control" name="pseudoconnect" placeholder="pseudo">
          </div>
          <div class="form-div--signin">
            <input type="password" class="form-control" name="passwordconnect" placeholder="Password">
            <small class="form-text text-muted">forgot your password ? <a href="./index.php?action=sign-in&sub_action=forgot_passwd" style="text-decoration: none;">click here</a></small>
          </div>
          <button type="submit" class="btn btn-primary" name="formconnexion">Submit</button>
        </form>
        <article>
          <p>you doesn't have an account ? <a href="./index.php?action=sign-up">Sign up</a></p>
        </article>
      </article>
    <!-- </div> -->
</section>
