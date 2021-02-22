<?php
require_once('../functions/db.php');

class Droits{
    private $id;
    public $nom;

    public function __construct(){
        $this->db = connect();
    }
    public function getChoice(){
        $i = 0;
        $choice = $this->db->prepare("SELECT * FROM droits");
        $choice->execute();
        while($fetch = $choice->fetch(PDO::FETCH_ASSOC)){
            $tableau[$i][] = $fetch['id'];
            $tableau[$i][] = $fetch['nom'];
            $i++;
        }
        return $tableau;
    }
    public function displayChoice(){
        $modelDroit = new Droits;
        $tableau = $modelDroit->getChoice();
        foreach($tableau as $value){
            echo '<option value="'.$value[0].'">'.$value[1] .'</option>';
        }
    }
}

?>