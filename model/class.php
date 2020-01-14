<?php
/**
 * parent class that connect to DB(PDO connexion)
 */

class Manager
{
  public $bdd;
  function __construct()
  {
    try
    {
        $this->bdd = new PDO('mysql:host=localhost;dbname=db_camagru;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
  }
}

/**
 * user class that treat all users DB requests
 */

class User extends Manager
{
    function __construct()
    {
        parent::__construct();
    }
    public function getByPost($id_post)
    {
      $reqpost = $this->bdd->prepare('SELECT * FROM posts WHERE id_post = ? LIMIT 1');
      $reqpost->execute(array($id_post));

      $postData = $reqpost->fetch(PDO::FETCH_ASSOC);
      $reqpost->closeCursor();
      $id_poster = $postData['id_user'];
      $requser = $this->bdd->prepare("SELECT * FROM users WHERE id_user = ?");
      $requser->execute(array($id_poster));
      $userData = $requser->fetch(PDO::FETCH_ASSOC);

      return($userData);
    }
    public function sign_in()
    {
        $notification = "";
        $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
        $passwordconnect = $_POST['passwordconnect'];
        if (!empty($pseudoconnect) AND !empty($passwordconnect))
        {
            $requser = $this->bdd->prepare("SELECT * FROM users WHERE pseudo = ? AND password = ?");
            $requser->execute(array($pseudoconnect, $passwordconnect));
            $userexist = $requser->rowCount();
            if ($userexist == 1)
            {
                $userinfo = $requser->fetch();
                if ( $userinfo['user_status'] == 1)
                {
                    $_SESSION['id'] = $userinfo['id_user'];
                    $_SESSION['pseudo'] = $userinfo['pseudo'];
                    $_SESSION['name'] = $userinfo['name'];
                    $_SESSION['mail'] = $userinfo['mail'];
                    $_SESSION['firstname'] = $userinfo['firstname'];
                    $_SESSION['avatar'] = $userinfo['avatar'];
                    $_SESSION['notification_bool'] = $userinfo['notification_bool'];
                    header("Location: index.php?id=".$_SESSION['id']);
                }
            }
            else
                $notification = "this user or this password are wrong, please verify your account !";
        }
        else
            $notification = "you must fill all the empty fields !";
        $requser->closeCursor();
        return ($notification);
    }
    public function password_mailer($header)
    {
      $error = NULL;
      if (!empty($_POST['pseudo']))
      {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $requser = $this->bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $requser->execute(array($pseudo));
        $user_exist = $requser->rowCount();
        $user = $requser->fetch();
        $id_user = $user['id_user'];
        $email = $user['mail'];
        $requser->closeCursor();
        if ($user_exist == 1)
        {
           $key_lenght = 12;
           $key = "";
           for ($i = 1; $i < $key_lenght; $i++) {
              $key .= mt_rand(0, 9);
          }
          $message = '
          <!DOCTYPE html>
          <html>
              <body>
                  <div align="center">
                      <a href="http://localhost:8888/W.I.P/camagru-wip/index.php?action=sign-in&id_user='.$id_user.'&key='.$key.'">choose a new password</a>
                  </div>
              </body>
          </html>
          ';
          mail($email, 'change your password', $message, $header);
          $insertUser = $this->bdd->prepare("UPDATE users SET confirm_key = ?, user_status = ? WHERE id_user = ?");
          $insertUser->execute(array($key, 0, $id_user));
          $insertUser->closeCursor();
          $error = "please check your mailbox !";
        }
        else
          $error = "please enter your pseudo !";
        return $error;
      }
    }
    public function forgot_passwd()
    {
      if (!empty($_POST['newpassword']) && !empty($_POST['newpassword_confirm']))
      {
        $newpassword = $_POST['newpassword'];
        $newpassword_confirm = $_POST['newpassword_confirm']; // a crypter !!
        $password_lenght = strlen($newpassword);
        $passwordconfirm_lenght = strlen($newpassword_confirm);
        if (($newpassword == $newpassword_confirm) && ($password_lenght == $passwordconfirm_lenght))
        {
          $id_user = intval($_GET['id_user']);
          $key = htmlspecialchars($_GET['key']);
          $requser = $this->bdd->prepare("SELECT * FROM users WHERE id_user = ?");
          $requser->execute(array($id_user));
          $user_exist = $requser->rowCount();
          $user = $requser->fetch();
          $requser->closeCursor();
          if ($user_exist == 1)
          {
            if (!$user['user_status'] != 0)
              if ($user['confirm_key'] === $key)
              {
                $password = $newpassword;
                $user_status = 1;
                $reqnewpasswd = $this->bdd->prepare("UPDATE users SET password = ?, confirm_key = ?, user_status = ? WHERE id_user = ?");
                $reqnewpasswd->execute(array($password, $key, $user_status, $id_user));
                $reqnewpasswd->closeCursor();
              }
            header('Location: http://localhost:8888/W.I.P/camagru-wip/index.php?action=sign-in');
          }
          else
            header('Location: http://localhost:8888/W.I.P/camagru-wip/index.php?action=sign-in');
        }
        else
          $message = "password aren't the same !";
      }
      else
        $message = "veuillez remplir les champs !";

      return ($message);
    }
    public function sign_up($header)
    {
       $error = "";
       $name = htmlspecialchars($_POST['name']);
       $firstname = htmlspecialchars($_POST['firstname']);
       $pseudo = htmlspecialchars($_POST['pseudo']);
       $email = htmlspecialchars($_POST['email']);
       $password = $_POST['password'];
       $password2 = $_POST['password2'];
       if (!empty($_POST['name']) AND !empty($_POST['firstname']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password2']))
       {
           $pseudolenght = strlen($pseudo);
           $namelenght = strlen($name);
           $firstnamelenght = strlen($firstname);
           if ($pseudolenght <= 255 AND $namelenght <= 255 AND $firstnamelenght <= 255)
           {
               if (filter_var($email, FILTER_VALIDATE_EMAIL))
               {
                   $reqmail = $this->bdd->prepare("SELECT * FROM users where mail = ?");
                   $reqmail->execute(array($email));
                   $mailexist = $reqmail->rowCount();
                   $reqmail->closeCursor();
                   $reqpseudo = $this->bdd->prepare("SELECT * FROM users where pseudo = ?");
                   $reqpseudo->execute(array($pseudo));
                   $pseudoexist = $reqpseudo->rowCount();
                   $reqpseudo->closeCursor();
                   if ($pseudoexist == 0)
                   {
                       if ($mailexist == 0)
                       {
                           if ($password == $password2)
                           {
                               $key_lenght = 12;
                               $key = "";
                               for ($i = 1; $i < $key_lenght; $i++) {
                                  $key .= mt_rand(0, 9);
                              }
                              $message = '
                              <!DOCTYPE html>
                              <html>
                                  <body>
                                      <div align="center">
                                          <a href="http://localhost/W.I.P/index.php?action=user_confirm&pseudo='.$pseudo.'&key='.$key.'">confirm your inscription !</a>
                                      </div>
                                  </body>
                              </html>
                              ';
                              mail($email, 'account confirmation', $message, $header);
                               $avatar_path = './public/images/avatars/avatar-de-base.png';
                               $insert_member = $this->bdd->prepare("INSERT INTO users(name, firstname, pseudo, mail, password, avatar, confirm_key) VALUES(?, ?, ?, ?, ?, ?, ?)");
                               $insert_member->execute(array($name, $firstname, $pseudo, $email, $password, $avatar_path, $key));
                               $insert_member->closeCursor();
                               $message = "your account has been created !";
                               $user = $pseudo;
                               header('Location: index.php?action=sign-in');
                           }
                           else
                               $error = "your password is not the same !";
                       }
                       else
                           $error = "this email is already taken !";
                   }
                   else
                       $error = "this pseudo is already taken !";
               }
               else
                   $error = "your email is not valid !";
           }
           else
               $error = "your pseudo must be less than 255 characters !";
       }
       else
           $error = "you must fill all the empty fields !";
       return ($error);
    }
    public function key_validator($pseudo, $key)
    {
       $requser = $this->bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
       $requser->execute(array($pseudo));
       $userexist = $requser->rowCount();
       if ($userexist == 1)
       {
           $user = $requser->fetch();
           if ($user['confirm_key'] != 1)
           {
               $update_user = $this->bdd->prepare("UPDATE users SET user_status = 1 WHERE pseudo = ? AND confirm_key = ?");
               $update_user->execute(array($pseudo, $key));
               $message = "Your account has been confirmed successfully !";
           }
           else
            $message = "your account is already confirmed !";
       }
       else
        $message = "this user doesnt exist !";
        return ($message);
    }
    public function user_check()
    {
       if (!isset($_SESSION['id']))
           header("Location: ./index.php?action=sign-in");
    }
    public function post_data_by_id($id)
    {
       $reqwriter = $this->bdd->prepare("SELECT * FROM users WHERE id_user = ?");
       $reqwriter->execute(array($id));
       $writer = $reqwriter->fetch();
       $reqwriter->closeCursor();
       return ($writer);
    }
    public function edit_profile()
    {
       $error = NULL;
       $requser = $this->bdd->prepare("SELECT * FROM users WHERE id_user = ?");
       $requser->execute(array($_SESSION['id']));
       $userinfo = $requser->fetch();
       $requser->closeCursor();

       if (empty($userinfo['avatar']))
       {
           $path = './public/images/avatars/avatar-de-base.png';
           $avatar = $this->bdd->prepare("UPDATE users SET avatar = ? WHERE id_user = ?");
           $avatar->execute(array($path, $_SESSION['id']));
           $avatar->closeCursor();
           $_SESSION['avatar'] = $path;
       }
       if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
       {
           $maxSize = 2097152;
           $valid_extension = array('jpg', 'jpeg', 'gif', 'png');
           if ($_FILES['avatar']['size'] <= $maxSize)
           {
               $uploadedExtension = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
               if (in_array($uploadedExtension, $valid_extension))
               {
                   $path = "./public/images/avatars/".$_SESSION['id'].".".$uploadedExtension;
                   $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
                   if ($result)
                   {
                       $updateAvatar = $this->bdd->prepare("UPDATE users SET avatar = ? WHERE id_user = ?");
                       $updateAvatar->execute(array($path, $_SESSION['id']));
                       $_SESSION['avatar'] = $path;
                       // header("Location: private-gallery.php?id=".$_SESSION['id']);
                   }
                   else
                       $error = "a mistake has occured ...";
               }
               else
                   $error = "your picture must be formated as jpg, jpeg, gif or png !";
           }
           else
               $error = "this picture must be less than 2 Mo !";
       }
       if (isset($_POST['newFirstname']) AND !empty($_POST['newFirstname']) AND $_POST['newFirstname'] != $userinfo['firstname'])
       {
           $newFirstname = htmlspecialchars($_POST['newFirstname']);
           $insertFirstname = $this->bdd->prepare("UPDATE users SET firstname = ? WHERE id_user = ?");
           $insertFirstname->execute(array($newFirstname, $_SESSION['id']));
           $_SESSION['firstname'] = $newFirstname;
           $insertFirstname->closeCursor();
           // header("Location: private-gallery.php?id=".$_SESSION['id']);
       }
       if (isset($_POST['newName']) AND !empty($_POST['newName']) AND $_POST['newName'] != $userinfo['name'])
       {
           $newName = htmlspecialchars($_POST['newName']);
           $insertName = $this->bdd->prepare("UPDATE users SET name = ? WHERE id_user = ?");
           $insertName->execute(array($newName, $_SESSION['id']));
           $_SESSION['name'] = $newName;
           $insertName->closeCursor();
           // header("Location: private-gallery.php?id=".$_SESSION['id']);
       }
       if (isset($_POST['newPseudo']) AND !empty($_POST['newPseudo']) AND $_POST['newPseudo'] != $userinfo['pseudo'])
       {
           $newPseudo = htmlspecialchars($_POST['newPseudo']);
           $reqpseudo = $this->bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
           $reqpseudo->execute(array($newPseudo));
           $pseudoexist = $reqpseudo->rowCount();
           if ($pseudoexist == 1)
               $error = "this pseudo is already taken !";
           else
           {
               $insertPseudo = $this->bdd->prepare("UPDATE users SET pseudo = ? WHERE id_user = ?");
               $insertPseudo->execute(array($newPseudo, $_SESSION['id']));
               $_SESSION['pseudo'] = $newPseudo;
               $insertPseudo->closeCursor();
               // header("Location: private-gallery.php?id=".$_SESSION['id']);
           }
       }
       if (isset($_POST['newEmail']) AND !empty($_POST['newEmail']) AND $_POST['newEmail'] != $userinfo['mail'])
       {
           $newEmail = htmlspecialchars($_POST['newEmail']);
           if (filter_var($newEmail, FILTER_VALIDATE_EMAIL))
           {
               $reqmail = $this->bdd->prepare("SELECT * FROM users WHERE mail = ?");
               $reqmail->execute(array($newEmail));
               $mailexist = $reqmail->rowCount();
               if ($mailexist == 1)
                   $error = "this email is already taken !";
               else
               {
                   $insertEmail = $this->bdd->prepare("UPDATE users SET mail = ? WHERE id_user = ?");
                   $insertEmail->execute(array($newEmail, $_SESSION['id']));
                   $_SESSION['mail'] = $newEmail;
                   $insertEmail->closeCursor();
                   // header("Location: private-gallery.php?id=".$_SESSION['id']);
               }
           }
           else
               $error = "this email is invalid !";
       }
       if (isset($_POST['newPassword1']) AND !empty($_POST['newPassword1'])
       AND isset($_POST['newPassword2']) AND !empty($_POST['newPassword2']))
       {
           $mdp1 = $_POST['newPassword1']; // A CRYPTER
           $mdp2 = $_POST['newPassword2']; // A CRYPTER
           if ($mdp1 == $mdp2)
           {
               $insertPassword = $this->bdd->prepare("UPDATE users SET password = ? WHERE id_user = ?");
               $insertPassword->execute(array($mdp1, $_SESSION['id']));
               $_SESSION['password'] = $mdp1;
               $insertPassword->closeCursor();
               // header("Location: private-gallery.php?id=".$_SESSION['id']);
           }
           else
               $error = "your passwords are not the same !";
       }
       return ($error);
    }
    public function set_notifications_on()
    {
      $notification_bool = NULL;

      $requser = $this->bdd->prepare("UPDATE users SET notification_bool = 0 WHERE id_user = ?");
      $requser->execute(array($_SESSION['id']));
      $notification_bool = true;
      return ($notification_bool);
    }
    public function notification_handler()
    {
      if (isset($_POST["notif-checkbox"]) && ($_POST["notif-checkbox"] == yes))
      {
        if ($_SESSION["notification_bool"] == 0)
        {
          $reqnotif = $this->bdd->prepare("UPDATE users SET notification_bool = 1 WHERE id_user = ?");
          $reqnotif->execute(array($_SESSION['id']));
          $reqnotif->closeCursor();
          $_SESSION['notification_bool'] = 1;
        }
      }
      else
      {
        $reqnotif = $this->bdd->prepare("UPDATE users SET notification_bool = 0 WHERE id_user = ?");
        $reqnotif->execute(array($_SESSION['id']));
        $reqnotif->closeCursor();
        $_SESSION['notification_bool'] = 0;
      }
    }
}

/**
 * publication class that treat all publications DB requests
 */

class Publication extends Manager
{
  function __construct()
  {
    parent::__construct();
  }
  // public function create_posts()
  // {
  //     $error = NULL;
  //     if (!empty($_SESSION['id']))
  //     {
  //        $id = $_SESSION['id'];
  //        if (isset($_FILES['local-picture']) && !empty($_FILES['local-picture']['name']))
  //        {
  //            $Post = $this->bdd->prepare("INSERT INTO posts (id_user, creation_date) VALUES (?,DATE(NOW()))");
  //            $Post->execute([$id]);
  //            $Post->closeCursor();
  //            $reqPost = $this->bdd->prepare("SELECT * FROM posts WHERE id_user = ? ORDER BY id_post DESC LIMIT 1");
  //            $reqPost->execute(array($id));
  //            $actualPost = $reqPost->fetch();
  //            $reqPost->closeCursor();
  //            $maxSize = 2097152;
  //            $valid_extension = array('jpg', 'jpeg', 'gif', 'png');
  //            if ($_FILES['local-picture']['size'] <= $maxSize)
  //            {
  //                $uploadedExtension = strtolower(substr(strrchr($_FILES['local-picture']['name'], '.'), 1));
  //                if (in_array($uploadedExtension, $valid_extension))
  //                {
  //                    $path = "./public/images/posts/".$id."-".$actualPost[0].".".$uploadedExtension;
  //                    $result = move_uploaded_file($_FILES['local-picture']['tmp_name'], $path);
  //                    if ($result)
  //                    {
  //                        $updatePost = $this->bdd->prepare("UPDATE posts SET image = ? ORDER BY id_post DESC LIMIT 1");
  //                        $updatePost->execute([$path]);
  //                        $updatePost->closeCursor();
  //                    }
  //                    else
  //                        $error = "a mistake has occured ...";
  //                }
  //                else
  //                    $error = "your picture must be formated as jpg, jpeg, gif or png !";
  //            }
  //            else
  //                $error = "this picture must be less than 2 Mo !";
  //        }
  //        else
  //           $error = "please select a file !";
  //        if (isset($error))
  //        {
  //            $removePost = $this->bdd->prepare("DELETE * FROM posts WHERE id_user = ? ORDER BY id_post DESC LIMIT 1");
  //            $removePost->execute(array([$id]));
  //            $removePost->closeCursor();
  //        }
  //        return $error;
  //     }
  // }

  public function postImg($img)
  {
    echo "$img";
    $req = $this->bdd->prepare("INSERT INTO posts (id_user, image, creation_date) VALUES (?,?, NOW())");
    $req->execute(array($_SESSION['id'], $img));
  }

  public function delete_post($post)
  {
      $user_is_poster = $this->bdd->prepare('SELECT * FROM posts WHERE id_post = ?');
      $user_is_poster->execute(array($post));
      $returnUser = $user_is_poster->fetch();
      $user_is_poster->closeCursor();
      if ($returnUser['id_user'] == $_SESSION['id'])
      {
          $reqcomment = $this->bdd->prepare("DELETE FROM commentary_space WHERE id_post = ?");
          $reqcomment->execute(array($post));
          $reqcomment->closeCursor();
          $reqpost = $this->bdd->prepare("DELETE FROM posts WHERE id_post = ?");
          $reqpost->execute(array($post));
          $reqpost->closeCursor();
      }
  }

  // public function comment_validator($post, $header, $bool)
  // {
  //   $this->create_comment($post);
  //   $this->create_notification($post, $header, $bool);
  // }
  public function user_post_recover($header)
  {
    $publicationParPage = 5;

    $retour_total = $this->bdd->prepare('SELECT COUNT(*) AS total FROM posts WHERE id_user = ?');
    $retour_total->execute(array($_SESSION['id']));
    $donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC); //On range retour sous la forme d'un tableau.
    $total = $donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
    $retour_total->closeCursor();

    $nombreDePages = ceil($total / $publicationParPage);

    if (isset($_GET["user-publication-page"]))
    {
      $pageActuelle = intval($_GET["user-publication-page"]);

      if ($pageActuelle > $nombreDePages)
        $pageActuelle = $nombreDePages;
    }
    else
      $pageActuelle = 1;

    $premiereEntree = ($pageActuelle - 1) * $publicationParPage;

    $retour_publications = $this->bdd->prepare('SELECT * FROM posts WHERE id_user = ? ORDER BY id_post DESC LIMIT '.$premiereEntree.', '.$publicationParPage.'');
    $retour_publications->execute(array($_SESSION['id']));

    while ($donnees_publications = $retour_publications->fetch(PDO::FETCH_ASSOC))
    {
      $reqpost = $this->bdd->prepare('SELECT * FROM users WHERE id_user = ?');
      $reqpost->execute(array($donnees_publications["id_user"]));
      $post_user = $reqpost->fetch();
      $reqpost->closeCursor();
      $is_liked = $this->select_like($donnees_publications['id_post']);
      require('./vue/post_1.php');
      $this->comment_recover($donnees_publications);
      require('./vue/post_2.php');
    }
    $retour_publications->closeCursor();

    for ($i = 1; $i <= $nombreDePages; $i++) {
      if ($i == $pageActuelle)
        echo "<div class='d-flex' style='margin-bottom: 20px;'><p style='margin-right: 5px;'>$i<p/>";
      else
        echo '<a href="./index.php?user-publication-page='.$i.'" class="comment-index">'.$i.'</a></div>';
    }
  }

  public function posts_recover($header)
  {
    // avec pagination
    $publicationParPage = 5;

    $retour_total = $this->bdd->prepare('SELECT COUNT(*) AS total FROM posts');
    $retour_total->execute();
    $donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC); //On range retour sous la forme d'un tableau.
    $total = $donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
    $retour_total->closeCursor();

    $nombreDePages = ceil($total / $publicationParPage);

    if (isset($_GET["publication-page"]))
    {
      $pageActuelle = intval($_GET["publication-page"]);

      if ($pageActuelle > $nombreDePages)
        $pageActuelle = $nombreDePages;
    }
    else
      $pageActuelle = 1;

    $premiereEntree = ($pageActuelle - 1) * $publicationParPage;

    $retour_publications = $this->bdd->prepare('SELECT * FROM posts ORDER BY id_post DESC LIMIT '.$premiereEntree.', '.$publicationParPage.'');
    $retour_publications->execute();

    while ($donnees_publications = $retour_publications->fetch(PDO::FETCH_ASSOC))
    {
      $reqpost = $this->bdd->prepare('SELECT * FROM users WHERE id_user = ?');
      $reqpost->execute(array($donnees_publications["id_user"]));
      $post_user = $reqpost->fetch();
      $reqpost->closeCursor();
      $is_liked = $this->select_like($donnees_publications['id_post']);
      require('./vue/post_1.php');
      $this->comment_recover($donnees_publications);
      require('./vue/post_2.php');
    }
    $retour_publications->closeCursor();

    for ($i = 1; $i <= $nombreDePages; $i++) {
      if ($i == $pageActuelle)
        echo "<div class='d-flex' style='margin-bottom: 20px;'><p style='margin-right: 5px;'>$i<p/>";
      else
        echo '<a href="./index.php?publication-page='.$i.'" class="comment-index">'.$i.'</a></div>';
    }
  }

  public function user_posts()
  {
      $post_array = [];
      $id = $_SESSION['id'];
      $requser = $this->bdd->prepare("SELECT * FROM posts WHERE id_user = ? ORDER BY id_post ASC");
      $requser->execute(array($id));
      while ($userinfo = $requser->fetch(PDO::FETCH_ASSOC))
          $post_array[] = $userinfo;
      $requser->closeCursor();
      return ($post_array);
  }

  public function create_comment($post)
  {
      $req = $this->bdd->prepare('INSERT INTO commentary_space (id_user, id_post, commentary, creation_date) VALUES(?, ?, ?, DATE(NOW()))');
      $req->execute(array($_SESSION['id'], $post['id_post'], $_POST['message']));
      $req->closeCursor();
  }

  public function create_notification($post, $header)
  {
      $bool = $post['notification_bool'];

      if ($bool == 0)
      {
          $message = '
         <!DOCTYPE html>
         <html>
             <body>
                 <div align="center">
                     <p>hello '.$post["pseudo"].', you have a new comment on your post on Camagru !</p>
                 </div>
             </body>
         </html>
         ';
          mail($post['mail'], '1 new notification on Camagru', $message, $header);
      }
  }

  public function comment_recover($post)
  {
      $messagesParPage = 3; //Nous allons afficher 5 messages par page.

      $retour_total = $this->bdd->prepare('SELECT COUNT(*) AS total FROM commentary_space WHERE id_post = ?');
      $retour_total->execute(array($post["id_post"]));
      $donnees_total = $retour_total->fetch(PDO::FETCH_ASSOC); //On range retour sous la forme d'un tableau.
      $total = $donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

      $retour_total->closeCursor();
      //Nous allons maintenant compter le nombre de pages.
      $nombreDePages = ceil($total / $messagesParPage);

      if(isset($_GET['commentary-page'])) // Si la variable $_GET['page'] existe...
      {
          $pageActuelle = intval($_GET['commentary-page']);

          if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
              $pageActuelle = $nombreDePages;
      }
      else // Sinon
          $pageActuelle=1; // La page actuelle est la n°1

      $premiereEntree = ($pageActuelle - 1) * $messagesParPage; // On calcul la première entrée à lire

      // La requête sql pour récupérer les messages de la page actuelle.
      $retour_messages = $this->bdd->prepare('SELECT * FROM commentary_space WHERE id_post = ? ORDER BY id_comment DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
      $retour_messages->execute(array($post['id_post']));
      echo "<div class='commentary-space'>";

      while($donnees_messages= $retour_messages->fetch(PDO::FETCH_ASSOC)) // On lit les entrées une à une grâce à une boucle
      {
        // print_r($donnees_messages);
        // echo "ici";
          // Je vais afficher les messages dans des petits tableaux. C'est à vous d'adapter pour votre design...
          //De plus j'ajoute aussi un nl2br pour prendre en compte les sauts à la ligne dans le message.
          $reqcomment = $this->bdd->prepare('SELECT * FROM users WHERE id_user = ?');
          $reqcomment->execute(array($donnees_messages["id_user"]));
          $comment_user = $reqcomment->fetch();
          $reqcomment->closeCursor();
            echo '
            <div class="comment-div">
                <a href="#" class="comment-writer--link"><p><img src="'.$comment_user["avatar"].'" width="35" height="30" class="user-logo--commentary">
                  '.stripslashes($comment_user["pseudo"]).': </p></a>
                  <p>'.nl2br(stripslashes($donnees_messages["commentary"])).'</p>
            </div>
            ';

          //J'ai rajouté des sauts à la ligne pour espacer les messages.
      }
      $retour_messages->closeCursor();
      for($i = 1; $i <= $nombreDePages; $i++) //On fait notre boucle
      {
          //On va faire notre condition
          if($i == $pageActuelle) //Si il s'agit de la page actuelle...
              echo "$i";
          else
              echo ' <a href="./index.php?commentary-page='.$i.'#'.$post['id_post'].'" class="comment-index">'.$i.'</a>';
      }
  }

  public function post_is_liked($id_post)
  {
    $requser = $this->bdd->prepare("SELECT * FROM like_array WHERE id_user = ? AND id_post = ?");
    $requser->execute(array($_SESSION['id'], $id_post));
    $counter = $requser->rowCount();
    $requser->closeCursor();

    return ($counter);
  }

  public function add_like($id_post)
  {
    $reqpost = $this->bdd->prepare("INSERT INTO like_array (id_user, id_post) VALUES (?,?)");
    $reqpost->execute(array($_SESSION['id'], $id_post));
    $reqpost->closeCursor();
  }

  public function add_like_counter($id_post)
  {
    $reqpost = $this->bdd->prepare("SELECT * FROM posts WHERE id_post = ?");
    $reqpost->execute(array($id_post));
    $postlike = $reqpost->fetch();
    $reqpost->closeCursor();
    $postlike['like_count'] += 1;
    $reqpost = $this->bdd->prepare("UPDATE posts SET like_count = ? WHERE id_post = ?");
    $reqpost->execute(array($postlike['like_count'], $id_post));
    $reqpost->closeCursor();
  }

  public function remove_like($id_post)
  {
    $reqpost = $this->bdd->prepare("DELETE FROM like_array WHERE id_user = ? AND id_post = ?");
    $reqpost->execute(array($_SESSION['id'], $id_post));
    $reqpost->closeCursor();
  }

  public function remove_like_counter($id_post)
  {
    $reqpost = $this->bdd->prepare("SELECT * FROM posts WHERE id_post = ?");
    $reqpost->execute(array($id_post));
    $postlike = $reqpost->fetch();
    $reqpost->closeCursor();
    $postlike['like_count'] -= 1;
    $reqpost = $this->bdd->prepare("UPDATE posts SET like_count = ? WHERE id_post = ?");
    $reqpost->execute(array($postlike['like_count'], $id_post));
    $reqpost->closeCursor();
  }

  public function select_like($id_post)
  {
    $is_liked = 0;
    $req = $this->bdd->prepare("SELECT * FROM like_array WHERE id_post = ? AND id_user = ?");
    $req->execute(array($id_post, $_SESSION["id"]));
    $is_liked = $req->rowCount();
    $req->closeCursor();

    return $is_liked;
  }

  public function send_comment($id_post, $message, $id_sender)
  {
    $postreq = $this->bdd->prepare("INSERT INTO commentary_space (id_post, id_user, commentary, creation_date) VALUES (:id_post, :id_sender, :message, NOW())");
    $postreq->execute(array(
      "id_post" => $id_post,
      "id_sender" => $id_sender,
      "message" => $message));
  }
  public function getPostInfo($id_post)
  {
    $reqPost = $this->bdd->prepare("SELECT * FROM posts WHERE id_post = ?");
    $reqPost->execute(array($id_post));
    $post = $reqPost->fetch();
    $reqPost->closeCursor();
    $id_user = $post["id_user"];
    $requser = $this->bdd->prepare("SELECT * FROM users WHERE id_user = ?");
    $requser->execute(array($id_user));
    $userdata = $requser->fetch();
    $requser->closeCursor();

    return ($userdata);
  }

}

?>
