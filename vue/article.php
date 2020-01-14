<section>
        <article>
            <div class="user-info">
                <img src="./public/images/pdp.png" alt="user-logo" width="40" height="40" class="user-logo">
                <p>username</p>
            </div>
                <img src="./public/images/kaneki.png" alt="kaneki-pdp" width="250" height="340" class="">
            <ul>
                <li><i class="medium material-icons like">favorite_border</i></li>
                <li><i class="medium material-icons comment">chat_bubble_outline</i></li>
            </ul>
            <form action="minichat_post.php" method="post">
                    <?php
                        //Connexion à la base de données
                        try
                        {
                            $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', '');
                        }
                        catch(Exception $e)
                        {
                                die('Erreur : '.$e->getMessage());
                        }

                        $messagesParPage=5; //Nous allons afficher 5 messages par page.

                        //Une connexion SQL doit être ouverte avant cette ligne...
                        $retour_total=$bdd->query('SELECT COUNT(*) AS total FROM chat'); //Nous récupérons le contenu de la requête dans $retour_total
                        $donnees_total= $retour_total->fetch(PDO::FETCH_ASSOC); //On range retour sous la forme d'un tableau.
                        $total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

                        $retour_total->closeCursor();
                        //Nous allons maintenant compter le nombre de pages.
                        $nombreDePages=ceil($total/$messagesParPage);

                        if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                        {
                            $pageActuelle=intval($_GET['page']);

                            if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
                            {
                                $pageActuelle=$nombreDePages;
                            }
                        }
                        else // Sinon
                        {
                            $pageActuelle=1; // La page actuelle est la n°1
                        }

                        $premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire

                        // La requête sql pour récupérer les messages de la page actuelle.
                        $retour_messages=$bdd->query('SELECT * FROM chat ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');

                        while($donnees_messages= $retour_messages->fetch(PDO::FETCH_ASSOC)) // On lit les entrées une à une grâce à une boucle
                        {
                            //Je vais afficher les messages dans des petits tableaux. C'est à vous d'adapter pour votre design...
                            //De plus j'ajoute aussi un nl2br pour prendre en compte les sauts à la ligne dans le message.
                            echo '
                                <a href="#" style="text-decoration:none;"><p><img src="./images/pdp.png" width="20" height="20" class="user-logo--commentary"> '.stripslashes($donnees_messages['pseudo']).' : '.nl2br(stripslashes($donnees_messages['message'])).'</p></a>';
                            //J'ai rajouté des sauts à la ligne pour espacer les messages.
                        }
                        $retour_messages->closeCursor();
                        echo '<p align="center" style="margin-top: 20px;">'; //Pour l'affichage, on centre la liste des pages
                        for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
                        {
                            //On va faire notre condition
                            if($i==$pageActuelle) //Si il s'agit de la page actuelle...
                            {
                                echo "$i";
                            }
                            else //Sinon...
                            {
                                echo ' <a href="public-gallery.php?page='.$i.'" style="text-decoration:none; font-weight: 600;">'.$i.'</a> ';
                            }
                        }
                        echo '</p>';
                    ?>
                    <!-- <input type="text" name="pseudo" id="pseudo" value="yassine"/><br/> -->
                    <!-- <input type="text" name="message" id="message"/>
                    <input type="submit" value="Envoyer" />  -->
            </form>
            <p id="publication-date">date de publication</p>
        </article>
      </section>
