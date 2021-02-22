<?php

$database = ("../functions/db.php");
require_once('../class/user.php');
require_once('../class/classAdmin.php');
require_once('../class/class-droits.php');
require_once('../class/class-categories.php');
require_once('../class/class-article.php');

 // CHEMINS
 $path_index="../index.php";
 $path_inscription="inscription.php";
 $path_connexion="connexion.php";
 $path_profil="profil.php";
 $path_articles="articles.php";
 $path_create="creer-article.php";
 $path_admin="admin.php";
 $path_deconnexion="deconnexion.php";
 $path_footer='../css/footer.css';

 // HEADER
 require_once('header.php');
 if (!isset($_SESSION['id_droits']) OR $_SESSION['id_droits'] != 1337) {
    echo"Cette page est accessible qu'aux administrateurs";
 }
 else {


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/admin.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>
    <main class="flex column j_around" id="">
        <?php

            if(isset($_POST['mod'])){
                $droits = new User();
                $droits->updateDroit($_POST['moddingUser'], $_POST['droitUser']);
                $update = new Admin();
                $update->UpdateNewUser($_POST['moddingUser'], $_POST['UpdateLog'], $_POST['UpdateMail'], $_POST['updatePW'], $_POST['updateCPW']);
            }
            if (isset($_POST['createUser'])) {
                $NewUser = new Admin();
                $NewUser->registerNewUser($_POST['createLogin'], $_POST['eMail'], $_POST['createPW'], $_POST['confirmPW'], $_POST['droitNewUser']);
            }

            if (isset($_POST['deleteArticle'])){
                $deleteArticles = new Admin;
                $deleteArticles->deleteArticle($_POST['titreArticles']);
            }
            if (isset($_POST['deleteUser'])) {
                $delete = new Admin();
                $delete->deleteUser($_POST['moddingUser']); 
            }
            if (isset($_POST['CreateCategorie'])) { 
                $addCat = new Categorie;
                $addCat->addCategories($_POST['createCat']);
            }
            if (isset($_POST['UpdateCategorie'])){
                $updateCat = new Categorie;
                $updateCat->updateCategorie($_POST['updateCat'],$_POST["updateCateg"]);
            }
            if (isset($_POST['deleteCat'])){
                $deleteCat = new Categorie;
                $deleteCat->deleteCategorie($_POST["delCategorie"]);
            }
            if (isset($_POST['updateArticle'])){
                $updateArticle = new Admin;
                $updateArticle->updateArticle($_POST['titreArticles'],$_POST['titre'], $_POST['txtarticle'], $_POST['updateCat']);
            }
        ?>

        
        <form action="" method="POST" class="flex j_around a_center">
            <h1>Modification de User</h1>
            <div class="flex column">
                <label>Update User</label>

                    <select name="moddingUser">
                        <option>Select</option>

                        <?php
                        $article = new User();
                        $article->getDisplay();
                        ?>
                    </select>
            </div>

                <div class="flex column">
                    <label for="UpdateLog">Changez le nv pseudo</label>
                    <input type="text" name="UpdateLog">
                </div>

                <div class="flex column">
                    <label for="UpdateMail">E-Mail:</label>
                    <input type="eMail" name="UpdateMail">
                </div>
                
                <div class="flex column">
                    <label for="updatePW">Nouveau mot de passe:</label>
                    <input type="password" name="updatePW">
                </div>

                <div class="flex column">
                    <label for="updateCPW">Confirmez le mot de passe: </label>
                    <input type="password" name="updateCPW">
                </div>

                <div class="flex column">
                    <label>Select Droits</label>
                    <select name="droitUser">
                        <option>Select</option>
                        <?php
                        $droits = new Droits();
                        $droits->displayChoice();
                        ?>
                    </select>
                </div>

                <div class="flex column">
                    <input type="submit" name="mod" value="Envoyer">
                    <input type="submit" name="deleteUser" value="Supprimer">
                </div>
        </form>

        
        <form action="" method="POST" class="flex j_around a_center">
            <h1>Creation d'Utilisateur</h1>
            <div class="flex column">
                <label for="createLogin">Nouveau Login:</label>
                <input type="text" name="createLogin">
            </div>

            <div class="flex column">
                <label for="eMail">E-Mail:</label>
                <input type="email" name="eMail">
            </div>

            <div class="flex column">
                <label for="createPW">Nouveau mot de passe:</label>
                <input type="password" name="createPW">
            </div>

            <div class="flex column">
                <label for="ConfirmPW">Confirmez le mot de passe: </label>
                <input type="password" name="confirmPW">
            </div>

            <div class="flex column">
                <label>Select Droits</label>
                <select name="droitNewUser">
                    <option>Select</option>
                    <?php
                    $droits = new Droits();
                    $droits->displayChoice();
                    ?>
                </select>
            </div>

            <input type="submit" name="createUser">

        </form>

        
        <form action="" method="POST" class="flex j_around a_center">
            <h1>Modification Article</h1>
            <div class="flex column">
                <label for="">Select Articles</label>
                <select name="titreArticles">
                    <option>Select</option>
                    <?php
                        $articles = new Admin();
                        $articles->getDisplay();
                    ?>
                </select>
            </div>

            <div class="flex column">
                <label for="">New Titres</label>
                <input type="text" name="titre">
            </div>

            <div class="flex column">
                <label for="">New Texte</label>
                <textarea name="txtarticle" cols="40" rows="5"></textarea>
            </div>

            <div class="flex column">
                <label for="">Select categorie</label>
                <select name="updateCat">
                    <option>Select</option>
                        <?php
                        $deleteCat = new Article();
                        $deleteCat->dropDownDisplay();
                        ?>
                </select>
            </div>

            <div class="flex column">
                <input type="submit" name="updateArticle" value="Envoyer"></input>
                <input type="submit" value="Supprimer" name="deleteArticle">
            </div>
        </form>



        
<h1>Modification Categorie</h1>
        <form action="" method="POST" class="flex j_around a_center">
            
            <div class="flex column">
                <label for="createCat">Nouvelle Categorie</label>
                <input type="text" name="createCat">
                <input type="submit" name='CreateCategorie'>
            </div>
        </form>

        <form action="" method="POST" class="flex j_around a_center">
            
            <div class="flex column">
                <label for="updateCat">Update categorie name</label>
                <select name="updateCat">
                    <option>Select</option>
                        <?php
                        $deleteCat = new Article();
                        $deleteCat->dropDownDisplay();
                        ?>
                </select>
            </div>

            <div class="flex column">
                <input type="text" name="updateCateg">
                <input type="submit" name='UpdateCategorie'>
            </div>
        </form>

        <form action="" method="POST" class="flex column j_around a_center">
            <label for='delCategories'>Supprimer categorie</label>
                <select name="delCategorie">
                    <option>Select</option>
                        <?php
                        $deleteCat = new Article();
                        $deleteCat->dropDownDisplay();
                        ?>
                </select>
            <input type="submit" name="deleteCat">
        </form>
    </main>
        <?php require_once('footer.php');?> 
</body>
</html>
<?php 
    // $tableDroits = new Admin;
    // $tableDroits->userTable();
} ?>  
