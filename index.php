<?php require('./controllers/controller.php');
require("./controllers/mail.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- <link href="./public/css/gallery.css" rel="stylesheet"> -->
        <link href="https://fonts.googleapis.com/css?family=Monoton&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./public/css/main_style.css?version=51">
        <?php require("./vue/title.php"); ?>
        <link rel="shortcut icon" href="./public/images/camagru-logo.png">
    </head>
    <body>
          <?php
          $id = $_SESSION['id'];
          if (!isset($id))
            require('./vue/public-header.php');
          else
            require('./vue/private-header.php');
        if (!isset($_GET['action']))
        {
          like_controller($header);
          posts_recover($header);
        }
        else
        {
            switch ($_GET['action'])
            {
              case 'sign-in':
                if (isset($_GET['sub_action']))
                  forgot_passwd_mailer($header);
                else if (isset($_GET['id_user']) && isset($_GET['key']))
                  forgot_password_manager();
                else
                  sign_in_validator();
                break;
              case 'sign-up':
                sign_up_validator($header);
                break;
              case 'user_confirm':
                key_validator_controller();
                break;
              case 'new_picture':
                user_check();
                $message = posts_generator();
                require('./vue/picture.php');
                break;
              case 'profile':
                user_check();
                user_posts_view();
                require('./vue/profile.php');
                break;
              case 'settings':
                user_check();
                require('./vue/settings.php');
                switch ($_GET['settings'])
                {
                    case 'user-settings':
                        edit_profile_controller();
                        break;
                    case 'general-settings':
                        general_settings_controller();
                        break;
                }
                break;
              case 'delete-post':
                if (isset($_GET['post']) && isset($_SESSION['id']))
                {
                    delete_post_controller();
                    header("Location: ./index.php");
                }
                else
                    header("Location: ./index.php?action=sign-in");
                break;
                case 'add-comment':
                  comment_validator($header);
                  // print_r($_SESSION);
                  break;

            }
          }
          ?>
        <footer>
				<p>© Producted by ychahbar, 19CodingSchool (42Network)</p>
        </footer>
        <script type="text/javascript" src="./public/js/app-manager.js?v=2">

        </script>
    </body>
</html>
