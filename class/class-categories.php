<?php
    require_once('../functions/db.php');

    class Categorie{
        private $id;
        public $nom;

        public function __construct(){
            $this->db = connect();
        }

// ----------------------------- Add new categories-------------------------------------
        public function addCategories($nom){
            $addCat = $this->db->prepare("INSERT INTO categories(nom) VALUES(:nom)");
            $addCat->bindValue(":nom", $nom, PDO::PARAM_STR);

            $addCat->execute();
        }
// ----------------------------- Delete categories-------------------------------------
        public function deleteCategorie($nom){
            $deleteCat = $this->db->prepare("DELETE FROM categories WHERE id = :nom");
            $deleteCat->bindValue(":nom", $nom, PDO::PARAM_INT);

            $deleteCat->execute();
        }
// ----------------------------- Update categories------------------------------------- 
        public function updateCategorie($old_nom, $nom){
            $updateCat = $this->db->prepare("UPDATE categories SET nom = :nom WHERE id = :old_nom");
            $updateCat->bindValue(":old_nom",$old_nom, PDO::PARAM_INT);
            $updateCat->bindValue(":nom", $nom, PDO::PARAM_STR);

            $updateCat->execute();
        }

        public function affichageCategorie(){
            // $categorie = $this->db->prepare("SELECT * FROM categories");
            // $categorie->execute();
            // $categories = $categorie->fetchAll();
            // $_SESSION['categories'] = $categories;
            // return $_SESSION['categories'];
        }
    }