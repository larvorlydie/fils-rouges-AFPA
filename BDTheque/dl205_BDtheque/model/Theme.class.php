<?php
    class Theme {
        // Données membres
        private $id;
        private $intitule;
        
        
        // Constructeur
        public function __construct() {
            $sNum = func_num_args();
            if ($sNum === 1) {
                $sIntitule = func_get_arg(0);
                if ($sIntitule != "") {
                    $this->setIntitule($sIntitule);
                }
            }
            else if ($sNum === 2) {
                $sId = func_get_arg(0);
                $sIntitule = func_get_arg(1);
                if ($sId !== "") {
                    $this->setId ($sId);
                }
                if ($sIntitule !== "") {
                    $this->setIntitule($sIntitule);
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

        public function getIntitule() {
            return $this->intitule;
        }

        public function setIntitule($intitule) {
            $this->intitule = $intitule;
        }
    }
?>