<?php
    class Compte {
        // Données membres
        private $id;
        private $mdp;
        
        
        // Constructeur
        public function __construct($sId,$sMdp) {
            $this->setId ($sId);
            $this->setMdp($sMdp);
        }
        
        
        // Getters-setters
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getMdp() {
            return $this->mdp;
        }

        public function setMdp($mdp) {
            $this->mdp = $mdp;
        }
    }
?>