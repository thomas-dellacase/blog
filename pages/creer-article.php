<?php 
$database = ("../functions/db.php");
include('../functions/db.php');
require_once('../class/class-article.php');
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
 // HEADER
 require_once('header.php');


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/creer-article.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main id="mainCreate">
    <?php

    // public function create($article, $id_utilisateur, $id_categorie, $date) 
        if(isset($_POST['create'])){
            $article = new Article();
            $article->create($_POST['titre'],$_POST['article'], $_POST['categorie']);
        }



    ?>
        <article id="boxForm">
            <form action="" method="POST" class="flex column a_center j_around">
                <label for="Titre">Titre</label><br>
                <input class="BookingInput" type="text" name="titre">

                <label for="article"></label>
                <textarea class="BookingInput" name="article" placeholder="Type article here"></textarea>

                <label>Categories</label>
                    <select class="BookingInput" name="categorie">
                        <option>Select</option>
                            <?php
                            $article = new Article();
                            $article->dropDownDisplay();

                            ?>

                    </select>   
                <input class="BookingInput" type="submit" name="create" value="go!">

            </form>
               
        </article> 
          
    </main>
 <?php require_once('footer.php');?> 
</body>
</html>