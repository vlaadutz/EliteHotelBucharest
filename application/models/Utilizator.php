<?php
    class Utilizator extends CI_Model
    {
        /**
         * Verifica daca datele introude (nume, parola exista in baza de date)
         * 
         * @param String $nume
         * @param String $parola
         * 
         * @return bool
         */
        function exista($nume, $parola)
        {
            $this -> load -> database();
            return count($this -> db -> get_where("Utilizatori", array("nume" => $nume, "parola" => $parola)) -> result()) == 1;
        }

        /**
         * Adaugare utilizator in baza de date
         * 
         * @param String $nume
         * @param String $email
         * @param String $parola
         * 
         * @return void
         */
        function adauga($nume, $email, $parola)
        {
            $this -> load -> database();
            $this -> db -> insert("utilizatori", array("Nume" => $nume, "Email" => $email, "Parola" => $parola));
        }
    }