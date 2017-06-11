<?php
    class Auteur {
        // Données membres
        private $id;
        private $nom;
        
        
        // Constructeur
        public function __construct() {
            $sNum = func_num_args();
            if ($sNum === 1) {
                $sNom = func_get_arg(0);
                if ($sNom != "") {
                    $this->setNom($sNom);
                }
            }
            else if ($sNum === 2) {
                $sId = func_get_arg(0);
                $sNom = func_get_arg(1);
                if ($sId !== "") {
                    $this->setId ($sId);
                }
                if ($sNom !== "") {
                    $this->setNom($sNom);
                }
            }
        }
        
        
        // Getters-setters
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getNom() {
            return $this->nom;
        }

        public function setNom($nom) {
            $this->nom = $nom;
        }
    }       
?>