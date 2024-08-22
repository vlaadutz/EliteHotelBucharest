<?php
    class Camera extends CI_Model
    {
        /**
         * Preluare date despre camera
         * 
         * @param String $linkCamera
         * 
         * @return array
         */
        function preluare_date($linkCamera)
        {
            return array(
                intval($this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Pret) * intval($this -> input -> get("zile")),
                $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Pret,
                $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Denumire,
                $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Descriere,
                $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Poza
            );
        }

        /**
         * Adaugare rezervare pentru camera
         * 
         * @param int $ID_Utilizator
         * @param int $ID_Camera
         * @param mixed $Data_Check_In
         * @param mixed $Data_Check_Out
         * 
         * @return void
         */
        function adauga_rezervare($ID_Utilizator, $ID_Camera, $Data_Check_In, $Data_Check_Out)
        {
            $this -> db -> insert("Rezervari", array("ID_Utilizator" => $ID_Utilizator, "ID_Camera" => $ID_Camera, "Data_Check_In" => $Data_Check_In, "Data_Check_Out" => $Data_Check_Out));
        }
    }