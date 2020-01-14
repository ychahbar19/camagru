<?php
session_start();
require("./model/class.php");

function sign_in_validator()
{
    $user = new User();
    $message = NULL;

    if (isset($_POST['formconnexion']))
    {
     $message = $user->sign_in();
     if(isset($message))
         echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
    }
    require('./vue/sign-in.php');
}

function forgot_password_manager()
{
  $user = new User();

  if (isset($_POST['passwd_button']))
  {
    $message = $user->forgot_passwd();
    if (isset($message))
      echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
  }
  require('./vue/forgot_password.php');
}

function forgot_passwd_mailer($header)
{
  $user = new User();
  $message = NULL;

  if (isset($_POST['mail_button']))
    $message = $user->password_mailer($header);
  if (isset($message))
    echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';;
  require('./vue/forgot_passwd_mail.php');
}

function sign_up_validator($header)
{
    $user = new User();
    $message = NULL;

    if (isset($_POST["form_signup--submission"]))
    {
        $message = $user->sign_up($header);
        if (isset($message))
            echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
    }
    require('./vue/sign-up.php');
}

function key_validator_controller()
{
    $user = new User();
    $message = NULL;
    if (isset($_GET['pseudo']) && isset($_GET['key']))
    {
        $pseudo = htmlspecialchars($_GET['pseudo']);
        $key = intval($_GET['key']);
        $message = $user->key_validator($pseudo, $key);
    }
    if (isset($message))
        echo '<p style="color:red;font-size: 10px; font-weight: bold; margin-top: 5px;">'.$message.'</p>';
}

function comment_validator($header)
{
    $Post = new Publication();
    $id_post = $_GET['id_post'];
    $message = $_POST["message"];
    $id_sender = $_SESSION['id'];

    $postData = $Post->getPostInfo($id_post);
    $Post->send_comment($id_post, $message, $id_sender);
    $Post->create_notification($postData, $header);
    header("Location: http://localhost:8888/camagru/index.php");

}

function user_check()
{
    $user = new User();
    $user->user_check();
}

function posts_generator()
{
    $message = NULL;
    $post = new Publication();

    if (isset($_POST["local-picture--button"]))
        $message = $post->create_posts();
    return $message;
}

function post_data_by_id($id_writer)
{
    $writer = new User();
    $writer_info = $writer->post_data_by_id($id_writer);
    return ($writer_info);
}

function posts_recover($header)
{
    $post_array = NULL;
    $counter = 0;
    $counter_like = 0;
    $i = 0;
    $post = new Publication();
    require('./vue/gallery.php');
    $post->posts_recover($header);
    echo "</section>";
    return ($post_array);
}

function user_recover()
{
    $user_info = NULL;
    $user = new User();

    return ($user_info);
}

function user_posts_view()
{
    $post_array = [];
    $counter = 0;
    $user_post = new Publication();

    $post_array = $user_post->user_posts();
    $counter = count($post_array);
    require('./vue/gallery.php');
    $user_post->user_post_recover($header);
    // for ($i=0; $i < $counter; $i++)
    // {
    //     $writer_info = $_SESSION;
    //     require('vue/post_1.php');
    //     $user_post->comment_recover($post_array[$i]);
    //     require('vue/post_2.php');
    // }
    echo "</section>";
}

function delete_post_controller()
{
    $Post = new Publication();
    $post_delete = $_GET['post'];

    $Post->delete_post($post_delete);
}

function edit_profile_controller()
{
    $message = NULL;
    $user = new User();

    if (isset($_POST["edit-connexion"]))
        $message = $user->edit_profile();
    require('./vue/edit-profile.php');
}


function set_notifications()
{
    $notification_bool = NULL;
    $user = new User();

    $notification_bool = $user->set_notifications_on();
    return ($notification_bool);
}

function general_settings_controller()
{
  $bool = NULL;
  $user = new User();

  if (isset($_POST["notification-button"]))
    $user->notification_handler();
  require('./vue/general-settings.php');
  // return ($bool);
}

function like_controller($header)
{
  $post = new Publication();
  $user = new User();

  if (isset($_GET['id_post']) && isset($_GET['sub-action']) && ($_GET['sub-action'] == 'like' || $_GET['sub-action'] == 'dislike') && isset($_SESSION['id']))
  {
    $id_post = intval($_GET['id_post']);
    $is_liked = $post->post_is_liked($id_post);
    $userData = $user->getByPost($id_post);
    if ($is_liked != 1)
    {
      $message = "someone likes your picture :) !";
      $post->add_like($id_post);
      mail($userData['mail'], 'new like', $message, $header);
      $post->add_like_counter($id_post);

      $is_liked = 1;
    }
    else if ($is_liked == 1)
    {
      $message = "someone unlikes your picture :( !";
      $post->remove_like($id_post);
      mail($userData['mail'], 'new dislike', $message, $header);
      $post->remove_like_counter($id_post);
      $is_liked = 0;
    }
  }

  return ($is_liked);
}

function apply_calc_to_img()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
      $image = $_POST['img'];
      $filter_img = $_POST['calc'];
      $login = $_SESSION['name'];
      // print_r($_POST);

      $folder = './public/images/temp';
      if (!is_dir($folder))
        mkdir($folder);
      $new_file = time().'.png';
      $file_path = $folder.'/'.$new_file;

      $array = explode(',', $image);
      $data_64 = str_replace(' ', '+', $array[1]);
      $data = base64_decode($data_64);
      file_put_contents($file_path, $data);

      $calc0 = imagecreatefrompng($file_path);
      $calc1 = imagecreatefrompng($filter_img);

      $calc1_size = getimagesize($filter_img);
      $dst_x = 50;
      $dst_y = 10;
      $src_x = 0;
      $src_y = 0;
      $src_w = $calc1_size[0];
      $src_h = $calc1_size[1];
      $dst_w = 150;
      $dst_h = 150;
      imagecopyresampled($calc0, $calc1, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
      imagepng($calc0, $file_path);

      echo '<p id="new_file">'.$new_file.'</p>';
    }
}
function post_new_img()
{
  $galleryManager = new Publication();

  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $image_path = $_POST['image'];
    $img = basename($image_path);
    $new_file = "./public/images/posts/".$img;

    rename($image_path, $new_file);
    $galleryManager->postImg($new_file);
    array_map('unlink', glob("./public/images/temp/*.png"));
  }
}
?>
