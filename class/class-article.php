<?php
    require_once($database);
    

    class Article{
        private $id;
        public $article;
        public $id_utilisateur;
        public $id_categorie;
        public $date;

        public function __construct(){
            $this->db = connect();
        }


// ----------------------------- Créé article --------------------------------------

        public function create($Titre, $article, $id_categorie){
            $id_utilisateur = $_SESSION['utilisateur']['id'];
            $sql = "INSERT INTO articles (Titre, article, id_utilisateur, id_categorie, date) VALUES (:Titre, :article, :id_utilisateur, :id_categorie, NOW())";
            $result = $this->db->prepare($sql);

            $result->bindValue(":Titre", $Titre, PDO::PARAM_STR);
            $result->bindValue(":article", $article, PDO::PARAM_STR);
            $result->bindValue(":id_utilisateur", $id_utilisateur, PDO::PARAM_INT);
            $result->bindValue(":id_categorie", $id_categorie, PDO::PARAM_INT);

            $result->execute();
            return $result;
        }
// ----------------------------- Créé article menu deroulant --------------------------------------
    public function dropDown(){

        $i = 0;
        $drop = $this->db->prepare("SELECT * FROM categories");
        $drop->execute();
        //stockage des noms dans un tableau et dans le select du formulaire
        // TANT QUE
        while($fetch = $drop->fetch(PDO::FETCH_ASSOC)){
            // le crochets [] vides correspondent à un tableau vide dans lesquels on va insérer $fetch['id'] & $fetch['nom']
            $tableau[$i][] = $fetch['id'];
            $tableau[$i][] = $fetch['nom'];
            $i++;
        }
        return $tableau;
    }



    
    public function dropDownDisplay()
    {
        $modelDroit = new Article;
        $tableau = $modelDroit->dropDown();
        foreach ($tableau as $value) {
            echo '<option value="' . $value[0] . '">' . $value[1] . '</option>';
        }
    }






        public function articlepage(){
            $total = $this->db->query("SELECT COUNT(*) FROM articles")->fetchColumn();

            //How Many items to list per pages
            $limit = 5;

            //How many page will there be
            $pages = ceil($total / $limit); //ceil function qui arondi au nombre supérieurs

            //What page are we currently on ?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                'option' => array(
                    'default' => 1,
                    'min_range' => 1,
                ),
            )));

            //Calcultae the offset for the query
            $offset = ($page) * $limit;

            $start = $offset + 1; // Pour afficher des varirables pas nécessaire
            $end = min(($offset + $limit), $total); // Pour afficher des varirables pas nécessaire

        //The back link
            $prevlink = ($page) ? '<a href="?page=' . ($page - 1) . '" title="Next page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Last page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
            // The "forward" link
            $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

        // Display the paging information
            echo '<div id="paging"><p>', $prevlink, ' Page ', $page,' sur ', $total, $nextlink, ' </p></div>';

            //Prepare the page of query
            $article=$this->db->prepare(
                    "SELECT u.login, a.article, a.id_utilisateur, a.id_categorie, a.date, c.nom, a.Titre, a.id
                    FROM articles a INNER JOIN utilisateurs u ON a.id_utilisateur=u.id
                    INNER JOIN categories c ON a.id_categorie = c.id  ORDER BY a.date DESC LIMIT :limit OFFSET :offset");
            $article->bindValue(':limit', $limit, PDO::PARAM_INT);
            $article->bindValue(':offset', $offset, PDO::PARAM_INT);
            $article->execute();

            //Do we have any result?
            if ($article->rowCount() > 0){
                //Define how we want to fetch the results
                $article->setFetchMode(PDO::FETCH_ASSOC);
                $iterator = new IteratorIterator($article);

                //Display the results
                echo "<table>";
                foreach($iterator as $row){
                echo 
                    "<tr>
                        <td id='Titre_articles'> <a href='article.php?id=" . $row['id'] . "'>" . $row['Titre'] . "</a></td>
                        <td id='txt_articles'>" . $row['article'] . "</td>
                        <td id='categorie_articles'>" . $row['nom'] . "</td>
                        <td id='date_articles'>" . $row['date'] . "</td>
                    </tr>";
                }
                echo "</table>";
            }else{
                echo '<p> No result could be displayed</p>';
            }
        }




    public function articleByCategory($categorie){
        $categories = $this->db->prepare("SELECT a.article, a.id_categorie, a.date, c.nom, a.Titre, c.id 
        FROM articles a INNER JOIN categories c ON a.id_categorie = c.id WHERE c.id = :id_categorie ORDER BY a.date DESC");
        $categories->bindValue(':id_categorie', $categorie, PDO::PARAM_INT);
        $categories->execute();
        $result = $categories->fetchAll();
        $_SESSION['categorie'] = $result;
        // var_dump($result); //{DEBUG}

    }




    public function ArticleById($id){
        $article = $this->db->prepare("SELECT a.article, a.id_categorie, a.date, a.Titre, a.id, c.nom, c.id
        FROM articles a INNER JOIN categories c ON a.id_categorie = c.id WHERE a.id = :id");
        $article->bindValue(':id', $id, PDO::PARAM_INT);
        $article->execute();
        $result = $article->fetchAll();
        $_SESSION['articleId'] = $result;
    }
//-------------------------------------------afficher les 3 dernier articles index----------------------------------
public function articlepageIndex(){
    $total = $this->db->query("SELECT COUNT(*) FROM articles LIMIT 3")->fetchColumn();

    //How Many items to list per pages
    $limit = 3;

    //How many page will there be
    $pages = ceil($total / $limit); //ceil function qui arondi au nombre supérieurs

    //What page are we currently on ?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'option' => array(
            'default' => 1,
            'min_range' => 1,
        ),
    )));

    //Calcultae the offset for the query
    $offset = ($page) * $limit;

    //Prepare the page of query
    $article=$this->db->prepare(
            "SELECT u.login, a.article, a.id_utilisateur, a.id_categorie, a.date, c.nom, a.Titre, a.id
            FROM articles a INNER JOIN utilisateurs u ON a.id_utilisateur=u.id
            INNER JOIN categories c ON a.id_categorie = c.id  ORDER BY a.date DESC LIMIT :limit OFFSET :offset");
    $article->bindValue(':limit', $limit, PDO::PARAM_INT);
    $article->bindValue(':offset', $offset, PDO::PARAM_INT);
    $article->execute();

    //Do we have any result?
    if ($article->rowCount() > 0){
        //Define how we want to fetch the results
        $article->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($article);

        //Display the results
        echo "<table>";
        foreach($iterator as $row){
        echo 
            "<tr>
                <td>" . $row['Titre'] . "</td>
                <td>" . $row['article'] . "</td>
                <td>" . $row['nom'] . "</td>
                <td>" . $row['date'] . "</td>
            </tr>";
        }
        echo "</table>";
    }else{
        echo '<p> No result could be displayed</p>';
    }
}
public function articleByCategoryIndex($categorie){
    $categories = $this->db->prepare("SELECT a.article, a.id_categorie, a.date, c.nom, a.Titre, c.id 
    FROM articles a INNER JOIN categories c ON a.id_categorie = c.id WHERE c.id = :id_categorie ORDER BY a.date DESC LIMIT 3");
    $categories->bindValue(':id_categorie', $categorie, PDO::PARAM_INT);
    $categories->execute();
    $result = $categories->fetchAll();
    $_SESSION['categorie'] = $result;
    // var_dump($result); //{DEBUG}

}
}
?>