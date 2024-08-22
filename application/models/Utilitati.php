<?php
    class Utilitati extends CI_Model
    {
        /**
         * Encodare date din text in QR
         * 
         * @param String $nume
         * @param String $parola
         * 
         * @return void
         */
        function encodare_date_qr($nume, $parola)
        {
            require APPPATH . "/../resurse/codqr/phpqrcode.php";
            QRcode::png($nume . "," . $parola, $nume . ".png");
        }

        /**
         * Decodare date din QR in text
         * 
         * @param mixed $fisier
         * 
         * @return array
         */
        function decodare_date_qr($fisier)
        {
            $this -> load -> database();

            // decodare
            $curl = curl_init("https://zxing.org/w/decode");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,  CURLOPT_POSTFIELDS, array("f" => $fisier));
            $raspuns = curl_exec($curl);
            curl_close($curl);

            // regex pe response-ul de la request-ul trimis
            $rezultate = array();
            preg_match("/\w+,\w+/", $raspuns, $rezultate);
            $nume = $this -> db -> escape_str(trim(explode(",", $rezultate[0])[0]));
            $parola = $this -> db -> escape_str(trim(explode(",", $rezultate[0])[1]));

            return array($nume, $parola);
        }

        /**
         * Verifica daca adresa de email exista deja in baza de date
         * 
         * @param String $email
         * 
         * @return bool
         */
        function exista_email($email)
        {
            $this -> load -> database();
            $exista = $this -> db -> get_where("Utilizatori", array("Email" => $email));

            return count($exista -> result()) > 0;
        }

        /**
         * Preia ID-ul utilizatorului dupa nume
         * 
         * @param String $nume
         * 
         * @return int
         */
        function preluare_id_utilizator($nume)
        {
            $this -> load -> database();

            $rezultat = $this -> db -> get_where("Utilizatori", array("Nume" => $nume));
            return intval($rezultat -> result()[0] -> ID);
        }

        /**
         * Preia ID-ul camerei dupa link
         * 
         * @param String $linkCamera
         * 
         * @return int
         */
        function preluare_id_camera($linkCamera)
        {
            $this -> load -> database();
            return intval($this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> ID);
        }
    }