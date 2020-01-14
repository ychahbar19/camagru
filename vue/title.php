<title><?php
    $title = "camagru | public gallery";
     if (isset($_SESSION['id']))
     {
         $title = "camagru | ".$_SESSION["pseudo"]."'s gallery";
     }
     echo $title;
?></title>
