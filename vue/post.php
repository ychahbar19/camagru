<article class="post-article">
    <div class="writer-div">
        <a href="#" class="writer-link">
            <img src="./public/images/pdp.png" alt="user-logo" width="40" height="40">
            <p><?php echo $writer_info['pseudo'];?></p>
            <?php var_dump($writer_info); ?>
        </a>
    </div>
    <div class="post-img--div">
        <img src="<?php echo $post_array[$i]['image'];?>" alt="kaneki-pdp" width="250" height="340" class="post-img">
    </div>
    <ul>
        <li><i class="medium material-icons like">favorite_border</i></li>
        <li><i class="medium material-icons comment">chat_bubble_outline</i></li>
    </ul>
    <form action='./index.php?comment=<?php echo $post_array[$i]['id_post']?>' method="post">
        <p align="center" style="margin-top: 20px;"> <!-- Pour l'affichage, on centre la liste des pages -->
        <input type="hidden" name="pseudo" id="pseudo" value="<?php echo $_SESSION['pseudo']; ?>"/><br/>
        <input type="text" name="message" id="message"/><br/>
        <button type="submit" name="comment-button" value="Envoyer"></button>
    </form>
    <p><?php echo $post_array[$i]['creation_date'];?></p>
</article>
