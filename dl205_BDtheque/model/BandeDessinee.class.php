<?php
    class BandeDessinee {
        // Données membres
        private $id;
        private $titre;
        private $resume;
        private $image;
        private $auteur;
        
        
        // Constructeur
        public function __construct($sId,$sTitre,$sResume,$sImage,$sAuteur) {
            $this->setId($sId);
            $this->setTitre($sTitre);
            $this->setResume($sResume);
            $this->setImage($sImage);
            $this->setAuteur($sAuteur);
        }
        
        
        // Getters-setters
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getTitre() {
            return $this->titre;
        }

        public function setTitre($titre) {
            $this->titre = $titre;
        }

        public function getResume() {
            return $this->resume;
        }

        public function setResume($resume) {
            $this->resume = $resume;
        }

        public function getImage() {
            return $this->image;
        }

        public function setImage($image) {
            $this->image = $image;
        }

        public function getAuteur() {
            return $this->auteur;
        }

        public function setAuteur($auteur) {
            $this->auteur = $auteur;
        }
    }
?>