<?php 
//co db
$database = ("functions/db.php");
require_once("functions/db.php"); 
require_once("class/user.php");
require_once("class/class-article.php");

 // CHEMINS
 $path_index="";
 $path_inscription="pages/inscription.php";
 $path_connexion="pages/connexion.php";
 $path_profil="pages/profil.php";
 $path_articles="pages/articles.php";
 $path_create="pages/creer-article.php";
 $path_admin="pages/admin.php";
 $path_deconnexion="pages/deconnexion.php";
 $path_footer='../css/footer.css';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/articles.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="flex column j_between">
    
   <?php include_once('pages/header.php'); ?>

    <main class="flex column a_center j_around">
        <h1 class="flex">Le Bouclier</h1>
        <section class="flex j_around a_center">
            <p class="txtBouclier">Le bouclier est l'arme défensive la plus ancienne et destinée à parer une attaque</p>
            <img src="ressources/img/Bouclier_rond.jpg" alt="" id="imgBouclierRond">
            <p class="txtBouclier">Tout objet permettant d'opposer à l'adversaire une surface derrière laquelle on se protège est appelé un bouclier et celui-ci était parfois de « fortune », assurant une bonne protection pour un coût minimal.</p>
        </section>

        <?php
            $NewArticle = new Article;
            $NewArticle->articlepageIndex();
            if (isset($_POST['trierCategorie'])){
                $trie = new Article;
                $trie->articleByCategoryIndex($_POST['updateCat']);
                echo "<table>";
                foreach($_SESSION['categorie'] as $row){
                    echo 
                    "<tr>
                        <td>" . $row['Titre'] . "</td>
                        <td>" . $row['article'] . "</td>
                        <td>" . $row['nom'] ."</td>
                        <td>" . $row['date'] ."</td>
                    </tr>";
                }
                echo "</table>";
            }
        ?>
    </main>
    <?php require_once('pages/footer.php');?>
</body>
</html>