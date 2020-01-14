    <section class="col-xs-12 col-md-8">
            <form method="post" enctype="multipart/form-data">
                <div class="avatar-logo--div"><img  src="<?php echo $_SESSION['avatar'];?>" alt width="150" height="140"></div>
                <br><br>
                <div>
                    <label>veuillez choisir une photo de profil :</label>
                    <input type="file"  name="avatar" accept=".png, .jpg, .jpeg, .gif">
                </div>
                <br>
                <input type="text" class="form-control" name="newFirstname" value="<?php echo $_SESSION['firstname'];?>" placeholder="new firstname">
                <br>
                <input type="text" class="form-control" name="newName" value="<?php echo $_SESSION['name'];?>" placeholder="new name">
                <br>
                <input type="text" class="form-control" name="newPseudo" value="<?php echo $_SESSION['pseudo'];?>" placeholder="new pseudo">
                <br>
                <input type="email" class="form-control" name="newEmail" value="<?php echo $_SESSION['mail'];?>" placeholder="new email">
                <br>
                <label for="password">change your password ?</label>
                <input type="password" class="form-control" name="newPassword1" placeholder="new password">
                <label for="password-confirm">confirm your new password</label>
                <input type="password" class="form-control" name="newPassword2" placeholder="confirm new password">
                <br>
                <div class="button-edition--div">
                    <button type="submit" class="btn btn-primary" name="edit-connexion">save</button>
                </div>
            </form>
            <?php
                if(isset($message))
                    {
                        echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
                    }
                // if(isset($message))
                // {
                //     echo '<p style="color:green;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
                // }
            ?>
    </section>
</div>
