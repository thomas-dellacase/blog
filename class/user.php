<?php 

class User
{
    private $id;
    public $login;
    public $password;
    public $email;
    public $db;
    private $id_droits;

    public function __construct()
    {
        $this->db = connect();
    }

// ----------------------------- CONNEXION --------------------------------------

    public function ConnectUser($login, $password)
    {
    // On prépare la requête, on l'execute puis on fait un fetch pour récupérer les infos
        $ConnectUser = $this->db->prepare("SELECT * FROM utilisateurs WHERE login = :login"); 
        $ConnectUser->bindValue(':login', $login, PDO::PARAM_STR); 
        $ConnectUser->execute();
        $user = $ConnectUser->fetch(PDO::FETCH_ASSOC); 
    // si le fetch récupère quelque chose, alors :
        if (!empty($user)) {
           if (password_verify($password, $user['password'])) {
               $this->id = $user['id']; 
               $this->login = $user['login'];
               $this->password = $user['password'];
               $_SESSION['id_droits'] = $user['id_droits'];
               var_dump($user);
                $_SESSION['utilisateur']=$user;
                $_SESSION['id'] = $user['id'];
                echo"jardhoho";
                var_dump($_SESSION['utilisateur']['id']); 
                echo"hardjojo";
                var_dump($_SESSION['id']); 
    // on regroupe le resultat du fetch dans un tableau de session

               $_SESSION['utilisateur'] = [
                'id' =>
                    $this->id, 
                'login' =>
                    $this->login,
                'password' =>
                    $this->password
               ]; 
               echo "coucou";

               header('location:../pages/profil.php'); 

           } else {
            echo "Le login ou le mot de passe est erroné.";
        }
            }else {
                echo "Le login ou le mot de passe est erroné.";
            }
        }
// ---------------------------------- DECONNEXION -----------------------------

        public function Disconnect(){

            session_unset();
            session_destroy();
            header('location:../pages/profil.php'); // ou autres pages 

        }

 // --------------------------- INSCRIPTION ----------------------------------   

    public function register ($login, $email, $password, $confirmPW){
    // $database = connect();

     $error_log = null; 

     $login =  htmlspecialchars(trim($login));
     $email = htmlspecialchars(trim($email));
     $password =  htmlspecialchars(trim($password));
     $confirmPW =  htmlspecialchars(trim($confirmPW));  
    var_dump($_POST);
    if (!empty($login) && !empty($password) && !empty($confirmPW) && !empty($email)) {
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
                   $insert = $this->db->prepare("INSERT INTO utilisateurs (login, password, email, id_droits ) VALUES (:login, :cryptedpass ,:email, 1)"); 
                   $insert->bindValue(":login", $login, PDO::PARAM_STR);
                   $insert->bindValue(":cryptedpass", $cryptedpass, PDO::PARAM_STR);
                   $insert->bindValue(":email", $email, PDO::PARAM_STR); 
                //    $insert->bindValue(); 
                   $insert->execute(); 
                   header('location:../pages/connexion.php'); 
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


// ----------------------------------------- UPDATE ------------------------------------------------//
function profile($login, $email, $password, $confirmPW){ echo 'cc1'; // intégrer e-mail
     $login =  htmlspecialchars(trim($login));
     $email = htmlspecialchars(trim($email));
     $password =  htmlspecialchars(trim($password));
     $confirmPW =  htmlspecialchars(trim($confirmPW));  

     if (!empty($login) && !empty($email) && !empty($password) && !empty($confirmPW)){ echo 'cc2';
        $logLength = strlen($login); 
        $passLength = strlen($password);  
        $confirmLength = strlen($confirmPW);
        $mailLength = strlen($email);

        if (($logLength >=5) && ($passLength >=5) && ($logLength >=5) && ($logLength >=5)) { echo 'cc3';
            $myID = $_SESSION['id']; 
            $select = $this->db->prepare("SELECT * FROM utilisateurs WHERE id=:myID");
            $select->bindValue(":myID", $_SESSION['utilisateur']['id']);
            $select->execute();
            $fetch = $select->fetch();
        // var_dump($count);
        // var_dump($password); 
        // var_dump($confirmPW);
            if ($confirmPW==$password) {
                echo "cc4";
                $cryptedpass = password_hash($password, PASSWORD_BCRYPT); // CRYPTED 
                var_dump($cryptedpass);
                $update = ($this->db)->prepare("UPDATE utilisateurs SET login = :login, password = :cryptedpass, email= :mail WHERE id = :myID"); 
                $update->bindValue(":login", $login, PDO::PARAM_STR);
                $update->bindValue(":cryptedpass",$cryptedpass, PDO::PARAM_STR);
                $update->bindValue(":myID", $_SESSION['utilisateur']['id'], PDO::PARAM_INT);
                $update->bindValue(":mail",$email, PDO::PARAM_STR);
                
                var_dump($_SESSION['utilisateur']['id']);
                $update->execute(); 
            
            }
            else  $error_log="Confirmation du mot de passe incorrect"; 
            
        }
        else $error_log = "Veuillez insérer au moins 5 caractères dans chaques champs"; 
    }
     else {$error_log = "veuillez remplir les champs";}
     
     {if (isset ($error_log)) {
        return $error_log;
    }}
}

//----------------------------- MODDING USER ---------------------------->

    public function getUser(){
        $i = 0;
        //$id = $_SESSION['id'];
        $get = $this->db->prepare("SELECT * FROM utilisateurs");
        $get->execute();

        while($fetch = $get->fetch(PDO::FETCH_ASSOC)){
            $tableau[$i][] = $fetch['id'];
            $tableau[$i][] = $fetch['login'];
            $i++;
        }
        return $tableau;
    }

    public function getDisplay(){
        $display = new User();
        $tableau = $display->getUser();
        foreach($tableau as $value){
            echo '<option value="' . $value[0] . '">' . $value[1] . '</option>';
        }
    }

    public function updateDroit($login, $id_droits){
    $update = $this->db->prepare("UPDATE utilisateurs SET id_droits = :id_droits WHERE id = :login");
    $update->bindValue(":login", $login, PDO::PARAM_STR);
    $update->bindValue(":id_droits", $id_droits, PDO::PARAM_INT);
        var_dump($id_droits, $login);//DEBUG
    $update->execute();
    }

}

?>
