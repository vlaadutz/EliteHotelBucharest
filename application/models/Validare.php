<?php
    class Validare extends CI_Model
    {
        /**
         * Validare pentru nume, email si parola
         * 
         * @return bool
         */
        function nume_email_parola()
        {
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("nume", "Nume", "required");
            $this -> form_validation -> set_rules("email", "Email", "required");
            $this -> form_validation -> set_rules("parola", "Parola", "min_length[6]");
            
            return $this -> form_validation -> run();
        }

        /**
         * Validare pentru nume, prenume, telefon, email si mesaj
         * 
         * @return bool
         */
        function nume_prenume_telefon_email_mesaj()
        {
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("first-name", "Nume", "required");
            $this -> form_validation -> set_rules("last-name", "Prenume", "required");
            $this -> form_validation -> set_rules("email", "Email", "required");
            $this -> form_validation -> set_rules("phone-number", "Telefon", "required");
            $this -> form_validation -> set_rules("message", "Message", "required");

            return $this -> form_validation -> run();
        }
    }