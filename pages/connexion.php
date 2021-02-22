<?php

$database = ("../functions/db.php");
require_once('../functions/db.php');
require_once('../class/user.php');

 // CHEMINS
 $path_index="../index.php";
 $path_inscription="inscription.php";
 $path_connexion="";
 $path_profil="profil.php";
 $path_articles="articles.php";
 $path_create="creer-article.php";
 $path_admin="admin.php";
 $path_deconnexion="deconnexion.php";
 $path_footer='../css/footer.css';
 // HEADER
 require_once('header.php');


?>

<?php 

// public function register($login, $password, $confirmPW)

if (isset($_POST["connect"])){
                $user = new User();
                $user->ConnectUser($_POST['login'], $_POST['password']);
                }
                //var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/connexion.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <main id="mainConnect">
    <form id="form_connect" action="" method="POST">
        <label for="login">Login</label>
        <input type="text" name="login">
        <label for="password" name="password">Mot de passe</label>
        <input type="password" name="password">
        <input type="submit" name="connect" value="go!">

    </form>
</main>  
    <?php require_once('footer.php');?>
</body>
</html>
