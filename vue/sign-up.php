<section>
    <article>
        <form action="" method="post" style="margin-top: 100px">
            <div class="form-div--signup">
                <input type="text" class="form-control" placeholder="name" name="name" value="<?php if(isset($name)){echo $name;}?>">
            </div>
            <div class="form-div--signup">
                <input type="text" class="form-control" placeholder="firstname" name="firstname" value="<?php if(isset($firstname)){echo $firstname;}?>">
            </div>
            <div class="form-div--signup">
                <input type="text" class="form-control" placeholder="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;}?>">
            </div>
            <div class="form-div--signup">
                <input type="email" class="form-control" placeholder="name@example.com" name="email" value="<?php if(isset($email)){echo $email;}?>">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-div--signup">
                <input type="password" class="form-control" placeholder="Password (min 6 caracters)" name="password">
            </div>
            <div class="form-div--signup">
                <input type="password" class="form-control" placeholder="Confirm password" name="password2">
            </div>
            <button type="submit" class="btn btn-primary" name="form_signup--submission">Submit</button>
        </form>
    </article>
    <article>
        <p>you already have an account ? <a href="./index.php?action=sign-in">Sign in</a></p>
    </article>
</section>
