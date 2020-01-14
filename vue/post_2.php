<?php if (!empty($_SESSION)){
  echo '<input type="hidden" name="pseudo" class="pseudo" value="'.$_SESSION['pseudo'].'"/><br/>
        <input type="text" name="message" class="message"/><br/>
        <button type="submit" name="comment-button" value="Envoyer">Comment</button>
        </div>';
}?>
</form>
<p><?php echo $donnees_publications['creation_date'];?></p>
</article>
