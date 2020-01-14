<article class="post-article" id="<?=$donnees_publications['id_post'];?>">
    <div class="writer-div">
        <a href="#" class="writer-link">
            <img src="<?php echo $post_user['avatar'];?>" alt="user-logo" width="50" height="50"> <!-- PAS LA BONNE IMAGE ! -->
            <p><?php echo $post_user['pseudo'];?></p>
        </a>
    </div>
    <div class="post-img--div">
        <img src="<?php echo $donnees_publications['image'];?>" alt="kaneki-pdp" width="95%" height="280" class="post-img">
    </div>
    <ul>
      <div class="ul-div">
        <div>
          <li><i class="medium material-icons like" <?php if ($is_liked == 0){echo 'style="color: black;"';}else{echo 'style="color: red;"';} ?>>favorite_border</i></li>
          <?php echo $donnees_publications['like_count']; ?>
        </div>
      </div>
        <a href="./index.php?action=delete-post&post=<?php echo $donnees_publications['id_post']; ?>"><?php if ($donnees_publications['id_user'] == $_SESSION['id']){echo '<li><i class='.'"medium material-icons comment"'.'>delete</i></li>';}?></a>
    </ul>
    <form action='./index.php?action=add-comment&id_post=<?php echo $donnees_publications['id_post']?>' method="post" class="commentary-space--form">
