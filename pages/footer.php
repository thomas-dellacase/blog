
<footer>
    <nav class="flex j_center" id="headernav">
        <ul class="flex j_around">        
            <li><a class='headerlink' href="<?= $path_index ?>">INDEX</a></li>
    


    <?php if (empty($_SESSION['utilisateur'])) { ?>
        
        <li><a class='headerlink' href='<?= $path_inscription ?>'>INSCRIPTION</a></li>
        <li><a class='headerlink' href='<?= $path_connexion?>'>CONNEXION</a></li>
        
    <?php } ?> 


    <?php if (isset($_SESSION['utilisateur'])) 
    {
        echo
        "
        <a class='headerlink' href='$path_profil'>PROFIL</a>
        <a class='headerlink' href='$path_articles'>ARTICLES</a>
        <a class='headerlink' href='$path_deconnexion'>DECONNEXION</a>
        ";
    }
if (isset($_SESSION['id_droits'])) {
    if ($_SESSION['id_droits']==42 || $_SESSION['id_droits']==1337) {
        echo" <a class='headerlink' href='$path_create'>CREER ARTICLE</a>";
        echo"
        <a class='headerlink' href='$path_admin'>ADMIN</a>";
    }
}

?>
    </ul>
    </nav>
</footer>
