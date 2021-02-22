<?php 

$database = ("../functions/db.php"); 
require_once("../class/user.php");
require_once("../class/class-article.php");
require_once("../class/class-categories.php");

 // CHEMINS
 $path_index="../index.php";
 $path_inscription="inscription.php";
 $path_connexion="";
 $path_profil="profil.php";
 $path_articles="articles.php";
 $path_create="creer-article.php";
 $path_admin="admin.php";
 $path_deconnexion="deconnexion.php";
 require_once('header.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/articles.css">
    <title>Liste Articles</title>
</head>
<body>
    <main class="flex column j_around a_center" id="">

        <?php $NewArticle = new Article;
            $NewArticle->articlepage();
            if (isset($_POST['trierCategorie'])){
                $trie = new Article;
                $trie->articleByCategory($_POST['updateCat']);
                echo "<table class='flex column j_center a_center' id='tableauArt'>";
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

        <form action="" method="POST" class="flex column a_center">

            <label for="">Choisie une categorie</label>
            <select name="updateCat">
                <option>Select</option>
                    <?php
                      $deleteCat = new Article();
                      $deleteCat->dropDownDisplay();
                    ?>
            </select>

            <input type="submit" value="Trier" name="trierCategorie">

        </form>
    </main>
    <?php require_once('footer.php');?>
</body>
</html>
