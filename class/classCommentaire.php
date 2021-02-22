<?php 
require_once('../functions/db.php');

class Commentaires
{
    private $id;
    public $commentaire;
    private $id_article;
    private $id_utilisateur;
    public $date;

    public function __construct()
    {
        $this->db = connect();
    }


// ----------------------------- Ajout commentaire -------------------------------------
    public function postComment($login, $commentaire){
        $errorCom = null;
        $securedComment = htmlspecialchars(trim($commentaire)); 

        if(!empty($commentaire)){
            $comLength = strlen($commentaire);

            if (($comLength < 240)){
                $insertCom = $this->db->prepare("INSERT INTO commentaires (id_utilisateur, commentaire, id_article, date) VALUES (:login, :commentaire, :id_article, NOW())");
                $insertCom->bindValue(":login", $login['id'], PDO::PARAM_INT);
                $insertCom->bindValue(":commentaire", $securedComment, PDO::PARAM_STR);
                $insertCom->bindValue(":id_article", $_GET["id"],  PDO::PARAM_INT);
                $insertCom->execute();
            }
            else{
                $errorCom = "La taille de commentaire maximum est de 240 caractères";
            }
        
        }
        echo $errorCom;
    }

// ----------------------------- display commentaire -------------------------------------

public function displayComment($id){
    $commentaire = $this->db->prepare("SELECT c.commentaire, c.date, c.id_utilisateur, c.id_article, a.id, u.login  FROM commentaires c INNER JOIN articles a ON c.id_article = a.id INNER JOIN utilisateurs u ON c.id_utilisateur = u.id WHERE a.id = :id ORDER BY DATE DESC"); 
    $commentaire->bindValue(':id', $id, PDO::PARAM_INT);
    $commentaire->execute();
    $result = $commentaire->fetchAll();
    $_SESSION['commentaire'] = $result;
}
}