<?php
    class Commentaire {
        // Données membres
        private $id;
        private $bd;
        private $date;
        private $auteur;
        private $texte;
        private $moderation;
        
        
        // Constructeur
        public function __construct() {
            $sNum = func_num_args();
            if ($sNum === 5) {
                $sId = func_get_arg(0);
                $sBD = func_get_arg(1);
                $sDate = func_get_arg(2);
                $sAuteur = func_get_arg(3);
                $sTexte = func_get_arg(4);
                
                $this->setId($sId);
                $this->setBd($sBD);
                $this->setDate($sDate);
                $this->setAuteur($sAuteur);
                $this->setTexte($sTexte);
            }
            else if ($sNum === 6) {
                $sId = func_get_arg(0);
                $sBD = func_get_arg(1);
                $sDate = func_get_arg(2);
                $sAuteur = func_get_arg(3);
                $sTexte = func_get_arg(4);
                $sMod = func_get_arg(5);
                
                $this->setId($sId);
                $this->setBd($sBD);
                $this->setDate($sDate);
                $this->setAuteur($sAuteur);
                $this->setTexte($sTexte);
                $this->setModeration($sMod);
            }
        }
        
        
        // Getters-setters
        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getBd() {
            return $this->bd;
        }

        public function setBd($bd) {
            $this->bd = $bd;
        }

        public function getDate() {
            return $this->date;
        }

        public function setDate($date) {
            $this->date = $date;
        }

        public function getAuteur() {
            return $this->auteur;
        }

        public function setAuteur($auteur) {
            $this->auteur = $auteur;
        }

        public function getTexte() {
            return $this->texte;
        }

        public function setTexte($texte) {
            $this->texte = $texte;
        }
        
        function getModeration() {
            return $this->moderation;
        }

        function setModeration($moderation) {
            $this->moderation = $moderation;
        }
    }
?>