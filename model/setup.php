<?php

    phpinfo();
    $root='root'; 
    $root_password="";
    $db = "camagru_db";
   
    // $bdd->prepare("CREATE DATABASE IF NOT EXISTS db_camagru")->execute();
    // $bdd->execute();

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    try {
            $bdd = new \PDO('mysql:host=localhost', $root, '');
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $sql = "CREATE DATABASE camagru_db";
        // use exec() because no results are returned
        // $conn->exec($sql);
        $bdd->prepare("CREATE DATABASE IF NOT EXISTS db_camagru")->execute();
        echo "Database created successfully<br>";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }
?>