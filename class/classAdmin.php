<?php
require_once('../functions/db.php');

class Admin{
    public $login;
    public $password;
    public $id_droits;

    public function __construct()
    {
        $this->db = connect();
    }
//---------------------------------- UPDATE DROITS DEPUIS ADMIN.PHP -------------------------------------//
    public function updateRights($login, $id_droits){
        $query = $this->db->prepare ("UPDATE utilisateurs SET id_droits=:id WHERE id=:login");
        $query->bindValue(":id", $id_droits, PDO::PARAM_INT);
        $query->bindValue(":login", $login, PDO::PARAM_STR);

        $query->execute();
        var_dump($query);
    }




// ------------------------------------ REGISTER NEW USER DEPUIS ADMIN.PHP ------------------------------------------//

    public function registerNewUser ($login, $email, $password, $confirmPW, $id_droits){

         $error_log = null;

         $login =  htmlspecialchars(trim($login));
         $email = htmlspecialchars(trim($email));
         $password =  htmlspecialchars(trim($password));
         $confirmPW =  htmlspecialchars(trim($confirmPW));

        if (!empty($login) && !empty($password) && !empty($confirmPW) && !empty($email) &&!empty($id_droits)) {
            echo"hardjojo";
        $logLength = strlen($login);
        $passLength = strlen($password);
        $confirmLength = strlen($confirmPW);
        $mailLength = strlen($email);

            if (($logLength >= 5) && ($passLength >= 5) && ($confirmLength >= 5) && ($mailLength >=5)) {
                echo"jardhoho";
               $checkLength = $this->db->prepare("SELECT login FROM utilisateurs WHERE login=:login");
               $checkLength->bindValue(":login", $login, PDO::PARAM_STR);
               $checkLength->execute();
               $count = $checkLength->fetch();
               var_dump($count);

                if (!$count) {
                    echo"hardhoho";
                    var_dump($password, $confirmPW);
                    if ( $password == $confirmPW) {

                        echo"hardhojo";

                       $cryptedpass = password_hash($password, PASSWORD_BCRYPT); // CRYPTED
                    //    $this->login = $login ;
                       $insert = $this->db->prepare("INSERT INTO utilisateurs (login, password, email, id_droits ) VALUES (:login, :cryptedpass ,:email, :id_droits)"); 
                       $insert->bindValue(":login", $login, PDO::PARAM_STR);
                       $insert->bindValue(":cryptedpass", $cryptedpass, PDO::PARAM_STR);
                       $insert->bindValue(":email", $email, PDO::PARAM_STR);
                       $insert->bindValue(":id_droits", $id_droits, PDO::PARAM_INT);
                    //    $insert->bindValue();
                       $insert->execute();
                       echo"Nouvel utilisateur créée";
                    }
                    else {
                        $error_log = "confirmation du mot de passe incorrect";
                    }
                }
                else {
                    $error_log = "l'identifiant existe déjà";
                }
         }
        else {
            $error_log = "5 caractères minimum doivent être insérés dans chaques champs" ;
        }
    }
    else {
        $error_log = "Champs non remplis";
    }
    echo $error_log;
}
//-------------------------------------- UPDATE USER DEPUIS ADMIN.PHP -----------------------------------------------//
    public function UpdateNewUser($old_login, $login, $email, $password, $confirmPW){

        $login =  htmlspecialchars(trim($login));
        $email = htmlspecialchars(trim($email));
        $password =  htmlspecialchars(trim($password));
        $confirmPW =  htmlspecialchars(trim($confirmPW));

        if (!empty($login) && !empty($email) && !empty($password) && !empty($confirmPW)){
            $logLength = strlen($login);
            $passLength = strlen($password);
            $confirmLength = strlen($confirmPW);
            $mailLength = strlen($email);

            if (($logLength >=5) && ($passLength >=5) && ($logLength >=5) && ($logLength >=5)) {
                $select = $this->db->prepare("SELECT * FROM utilisateurs WHERE login = :login");
                $select->bindValue(":login", $old_login);
                $select->execute();
                $fetch = $select->fetch();

                var_dump($old_login);

                if ($confirmPW==$password) {
                    $cryptedpass = password_hash($password, PASSWORD_BCRYPT);
                    $update = ($this->db)->prepare("UPDATE utilisateurs SET login = :login, password = :cryptedpass, email= :mail WHERE id = :old_login");
                    $update->bindParam(":old_login", $old_login, PDO::PARAM_INT);
                    $update->bindParam(":login", $login, PDO::PARAM_STR);
                    $update->bindParam(":cryptedpass",$cryptedpass, PDO::PARAM_STR);
                    $update->bindParam(":mail",$email, PDO::PARAM_STR);
                    var_dump($login);
                    $update->execute();
                }
                else  $error_log="Confirmation du mot de passe incorrect";
            }
            else $error_log = "Veuillez insérer au moins 5 caractères dans chaques champs";
        }
        else {
            $error_log = "veuillez remplir les champs";
        }
        if (isset ($error_log)) {
            return $error_log;
        }
    }

    public function getArticles()
    {

        $i = 0;
        $drop = $this->db->prepare("SELECT * FROM articles");
        $drop->execute();
        //stockage des noms dans un tableau et dans le select du formulaire
        // TANT QUE
        while ($fetch = $drop->fetch(PDO::FETCH_ASSOC)) {
            // le crochets [] vides correspondent à un tableau vide dans lesquels on va insérer $fetch['id'] & $fetch['nom']
            $tableau[$i][] = $fetch['id'];
            $tableau[$i][] = $fetch['Titre'];
            $i++;
        }
        return $tableau;
    }

    public function getDisplay()
    {
        $display = new Admin();
        $tableau = $display->getArticles();
        foreach ($tableau as $value) {
            echo '<option value="' . $value[0] . '">' . $value[1] . '</option>';
        }
    }

    public function deleteArticle($titre){
        $delete = $this->db->prepare("DELETE FROM Articles WHERE id = :titre");
        $delete->bindValue(":titre", $titre, PDO::PARAM_STR);
        $delete->execute();
    }

// ------------------------------------- TABLEAU ADMIN -----------------------------------------// 

public function userTable() {
    $tableUser = $this->db->query("SELECT d.nom, u.login, u.id_droits, d.id FROM droits d INNER JOIN utilisateurs u ON u.id_droits = d.id WHERE u.id_droits = 1337"); 
    // SI PAS DE VARIABLE = PAS DE bindValue 
    $result = $tableUser->fetchAll(PDO::FETCH_ASSOC);
    echo"<table> <th> Admin </th>"; 
    for ($i=0; $i < count($result) ; $i++) {       
      echo"<tr>
      <td>" . $result[$i]['login'] . "</td>
        </tr>";
    }
    echo"</table>"; 
    $tableUser = $this->db->query("SELECT d.nom, u.login, u.id_droits, d.id FROM droits d INNER JOIN utilisateurs u ON u.id_droits = d.id WHERE u.id_droits = 1"); 
    // SI PAS DE VARIABLE = PAS DE bindValue 
    $result = $tableUser->fetchAll(PDO::FETCH_ASSOC);
    echo"<table> <th> Utilisateur  </th>"; 
    
    for ($i=0; $i < count($result) ; $i++) {       
      echo"<tr>
      <td>" . $result[$i]['login'] . "</td>
        </tr>";
    }
    echo"</table>"; 
    
    $tableUser = $this->db->query("SELECT d.nom, u.login, u.id_droits, d.id FROM droits d INNER JOIN utilisateurs u ON u.id_droits = d.id WHERE u.id_droits = 42"); 
    // SI PAS DE VARIABLE = PAS DE bindValue 
    $result = $tableUser->fetchAll(PDO::FETCH_ASSOC);
    echo"<table><th> Modérateur </th>"; 
    for ($i=0; $i < count($result) ; $i++) {       
      echo"<tr>
      <td>" . $result[$i]['login'] . "</td>
        </tr>";
    }
    echo"</table>"; 

}



    public function deleteUser($login)
    {

        $deleteQuery = $this->db->prepare("DELETE FROM utilisateurs WHERE id = :login");
        $deleteQuery->bindValue(":login", $login, PDO::PARAM_INT);
        $deleteQuery->execute();
    }

    public function updateArticle($old_titre, $titre, $article, $categorie){
        $update = $this->db->prepare("UPDATE articles SET Titre = :titre, article = :txtArticle, id_categorie = :categorie, date = NOW() WHERE id = :old_titre");
        $update->bindValue(":old_titre", $old_titre, PDO::PARAM_INT);
        $update->bindValue(":titre", $titre, PDO::PARAM_STR);
        $update->bindValue(":txtArticle", $article, PDO::PARAM_STR);
        $update->bindValue(":categorie", $categorie, PDO::PARAM_INT);
        $update->execute();
    }
}

?>