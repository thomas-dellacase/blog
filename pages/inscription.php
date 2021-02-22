<?php 

$database = ("../functions/db.php");
require_once('../functions/db.php');
require_once('../class/user.php');

 // CHEMINS
 $path_index="../index.php";
 $path_inscription="";
 $path_connexion="connexion.php";
 $path_profil="profil.php";
 $path_articles="articles.php";
 $path_create="creer-article.php";
 $path_admin="admin.php";
 $path_deconnexion="deconnexion.php";
 $path_footer='../css/footer.css';

if (isset($_POST["register"])){
    $user = new User();
    $user->register($_POST['login'],$_POST['email'], $_POST['password'], $_POST['confirmPW']); 
    $_SESSION['user']=$user; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/inscription.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php include_once('header.php'); ?>

    <main id="main_register">
    <div id ="title">
    <h1>Inscrivez-vous!</h1>
    </div>
        <form  id="form_register" action="" method="POST">

            <label for="login">Login</label>
            <input type="text" name="login">
            <label for="email">Email</label>
            <input type="email" name="email">
            <label for="password" name="password">Mot de passe</label>
            <input type="password" name="password">
            <label for="confirmPW">Confirmz vote mot de passe</label>
            <input type="password" name="confirmPW">
            <input type="submit" name="register" value="go!">

        </form>
    </main>
        <?php require_once('footer.php');?>
</body>
</html>