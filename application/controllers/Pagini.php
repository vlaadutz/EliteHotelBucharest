<?php
    class Pagini extends CI_Controller
    {
        /**
         * Incarca helperele si librariile necesare pentru aplicatie + bara de meniu
         */
        private function meniu_sus()
        {
            $this -> load -> library("session");
            $date = array();

            // daca e logat
            if (empty($this -> session -> nume) == false)
            {
                $date["logat"] = true;
            }

            $this -> load -> library("session");
            $this -> load -> helper("url");
            $date["url"] = base_url();

            $this -> load -> view("sabloane/header.php", $date);
        }

        /**
         * Incarca bara de jos din pagina
         */
        private function meniu_jos()
        {
            $this -> load -> view("sabloane/footer.php");
        }

        /**
         * In cazul in care pentru acest controller nu se specifica functia, se redirectioneaza pe acasa
         */
        function index()
        {
            $this -> load -> helper("url");    
            header("Location: " . base_url() . "acasa");
        }

        /**
         * Pagina acasa
         */
        function acasa()
        {
            $this -> meniu_sus();
            $this -> load -> view("pagini/acasa.php");
            $this -> meniu_jos();
        }

        /**
         * Pagina autentificare
         */
        function autentificare()
        {
            $date = array();

            if (!empty($this -> input -> post("nume")) && !empty($this -> input -> post("parola")))
            {
                $this -> load -> database();

                // verificare in db daca datele introduse sunt corecte
                $nume = $this -> db -> escape_str($this -> input -> post("nume"));
                $parola = md5($this -> db -> escape_str($this -> input -> post("parola")));
                
                $rezultat = ($this -> db -> get_where("Utilizatori", array("nume" => $nume, "parola" => $parola))) -> result();
                if (count($rezultat) == 1)
                {
                    $this -> load -> library("session");
                    $this -> session -> nume = $rezultat[0] -> Nume;
                }
                else
                {
                    $date["incorect"] = true;
                }
            }
            
            // daca nu s-a autentificat pana acum se afiseaza pagina de autentificare, altfel se redirectioneaza acasa
            if (empty($this -> session -> nume))
            {
                $this -> meniu_sus();
                $this -> load -> view("pagini/autentificare.php", $date);
                $this -> meniu_jos();
            }
            else
            {
                $this -> index();
            }
        }

        /**
         * Pagina autentificare prin cod QR
         */
        function autentificare_qr()
        {
            error_reporting(0);
            $date = array();

            if (isset($_FILES["pozaQR"]))
            {
                $this -> load -> database();

                // preluare date din qr
                $fisier = new CURLFile($_FILES["pozaQR"]["tmp_name"]);
                $curl = curl_init("https://zxing.org/w/decode");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl,  CURLOPT_POSTFIELDS, array("f" => $fisier));
                $raspuns = curl_exec($curl);
                curl_close($curl);

                // regex pe response-ul de la request-ul trimis
                $rezultate = array();
                preg_match("/\w+,\w+/", $raspuns, $rezultate);
                $nume = $this -> db -> escape_str(trim(explode(",", $rezultate[0])[0]));
                $parola = md5($this -> db -> escape_str(trim(explode(",", $rezultate[0])[1])));

                // verificare in db
                $rezultat = ($this -> db -> get_where("Utilizatori", array("nume" => $nume, "parola" => $parola))) -> result();
                if (count($rezultat) == 1)
                {
                    $this -> load -> library("session");
                    $this -> session -> nume = $rezultat[0] -> Nume;
                }
                else
                {
                    $date["incorect"] = true;
                }
            }
            
            // daca nu s-a autentificat pana acum se afiseaza pagina de autentificare, altfel se redirectioneaza acasa
            if (empty($this -> session -> nume))
            {
                $this -> meniu_sus();
                $this -> load -> view("pagini/autentificare_qr.php", $date);
                $this -> meniu_jos();
            }
            else
            {
                $this -> index();
            }
        }

        /**
         * Pagina inregistrare cont nou
         */
        function cont_nou()
        {
            $this -> load -> helper("url");
            $this -> load -> helper("file");
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("nume", "Nume", "required");
            $this -> form_validation -> set_rules("email", "Email", "required");
            $this -> form_validation -> set_rules("parola", "Parola", "min_length[6]");

            $date = array();
            if (!empty($this -> input -> post("nume")) || !empty($this -> input -> post("email")) || !empty($this -> input -> post("parola")))
            {
                if ($this -> form_validation -> run() == true)
                {
                    if ($this -> exista_email($this -> input -> post("email")) == false)
                    {
                        $this -> db -> insert("Utilizatori", array("Nume" => $this -> input -> post("nume"), "Parola" => md5($this -> input -> post("parola")), "Email" => $this -> input -> post("email")));

                        // dupa adaugarea utilizatorului in db se genereaza un cod QR si se salveaza in directorul root
                        $this -> generare_cod_qr($this -> input -> post("nume"), $this -> input -> post("parola"));
                        $date["afisareQR"] = true;
                        $date["numeQR"] = $this -> input -> post("nume") . ".png";
                    }
                    else
                    {
                        $date["incorect"] = true;
                    }
                }
                else
                {
                    $date["incorect"] = true;
                }
            }

            // la submiterea formularului ascuns de la afisarea codului QR, se sterge fisierul cu codul QR
            if (empty($this -> input -> post("stergere")) == false)
            {
                unlink("C:\\xampp\\htdocs\\" . $this -> input -> post("stergere"));
                header("Location: " . base_url() . "autentificare_qr");
            }

            $this -> meniu_sus();
            $this -> load -> view("pagini/cont_nou.php", $date);
            $this -> meniu_jos();
        }

        /**
         * Pagina vizualizare camere
         */
        function camere()
        {
            $date = array();

            // se afiseaza dialog daca datele nu au fost trimise prin formularul din dialog
            if (empty($this -> input -> get("dataCheckIn")) || empty($this -> input -> get("dataCheckOut")))
            {
                $date["afiseazaDlg"] = true;
            }
            else
            {
                $nrZile = (strtotime($this -> input -> get("dataCheckOut")) - strtotime($this -> input -> get("dataCheckIn"))) / 86400;
                $date["nrZile"] = $nrZile;
                $date["dataCheckIn"] = $this -> input -> get("dataCheckIn");
                $date["dataCheckOut"] = $this -> input -> get("dataCheckOut");
            }
            
            $this -> meniu_sus();
            $this -> load -> view("pagini/camere.php", $date);
            $this -> meniu_jos();
        }

        /**
         * Pagina de vizualizare camera
         */
        function vizualizeaza_camera($linkCamera = null)
        {
            $date = array();
            $this -> load -> database();
            $this -> load -> helper("url");
            $this -> load -> library("session");

            // cazuri pt care se afiseaza 404 sau se cere autentificare
            if (empty($linkCamera))
            {
                show_404();
            }
            if (empty($this -> input -> get("zile")) || empty($this -> input -> get("dataCheckIn")) || empty($this -> input -> get("dataCheckOut")))
            {
                show_404();
            }
            if (empty($this -> session -> nume))
            {
                header("Location: " . base_url() . "autentificare");
            }     

            // adaugare rezervare in db la submiterea formularului ascuns
            if (empty($this -> input -> post("rezervare")) == false)
            {
                $this -> db -> insert("Rezervari", array("ID_Utilizator" => $this -> preluare_id_utilizator($this -> session -> nume), "ID_Camera" => $this -> preluare_id_camera($linkCamera), "Data_Check_In" => $this -> input -> get("dataCheckIn"), "Data_Check_Out" => $this -> input -> get("dataCheckOut")));
                $date["rezervat"] = true;
            }

            $date["pret"] = intval($this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Pret) * intval($this -> input -> get("zile"));
            $date["pretNoapte"] = $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Pret;
            $date["denumire"] = $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Denumire;
            $date["descriere"] = $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Descriere;
            $date["poza"] = $this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> Poza;

            $this -> meniu_sus();
            $this -> load -> view("pagini/vizualizeaza_camera.php", $date);
            $this -> meniu_jos();
        }

        /**
         * Pagina evenimente (sala de sedinta/conferinta)
         */
        function evenimente()
        {
            $this -> meniu_sus();
            $this -> load -> view("pagini/evenimente.php");
            $this -> meniu_jos();
        }

        /**
         * Pagina formular contact
         */
        function contact()
        {
            $date = array();
            $this -> load -> library("form_validation");

            $this -> form_validation -> set_rules("first-name", "Nume", "required");
            $this -> form_validation -> set_rules("last-name", "Prenume", "required");
            $this -> form_validation -> set_rules("email", "Email", "required");
            $this -> form_validation -> set_rules("phone-number", "Telefon", "required");
            $this -> form_validation -> set_rules("message", "Message", "required");

            if (!empty($this -> input -> post("first-name")) || !empty($this -> input -> post("last-name")) || !empty($this -> input -> post("email")) || !empty($this -> input -> post("phone-number")) || !empty($this -> input -> post("message")))
            {
                if ($this -> form_validation -> run())
                {
                    $mesaj = "```\nNume: " . $this -> input -> post("first-name") . "\nPrenume: " . $this -> input -> post("last-name") . "\nEmail: " . $this -> input -> post("email") . "\nTelefon: " . $this -> input -> post("phone-number") . "\nMesaj: " . $this -> input -> post("message") . "\n```";

                    $curl = curl_init("https://discord.com/api/webhooks/1257826647026040922/vuhLeWWSgK202gl_6qYSiw_XLW9MHO4qsaNN2TmRTjo1l5mtrJl41_iCiBXniASEGkgj");
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array("content" => $mesaj));
                    curl_exec($curl);
                }
                else
                {
                    $date["incorect"] = true;
                }
            }
            
            $this -> meniu_sus();
            $this -> load -> view("pagini/contact.php", $date);
            $this -> meniu_jos();
        }

        // ----------------------------------------------------------------
        //                           UTILITATI
        // ----------------------------------------------------------------

        /**
         * Genereaza un cod QR ce contine numele si parola in formatul NUME,PAROLA
         * 
         * @param String $nume
         * @param String $parola
         * 
         * @return void
         */
        private function generare_cod_qr($nume, $parola)
        {
            require "resurse/codqr/phpqrcode.php";
            QRcode::png($nume . "," . $parola, $nume . ".png");
        }

        /**
         * Verifica daca adresa de email exista deja in baza de date
         * 
         * @param String $email
         * 
         * @return bool
         */
        private function exista_email($email)
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
        private function preluare_id_utilizator($nume)
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
        private function preluare_id_camera($linkCamera)
        {
            $this -> load -> database();
            return intval($this -> db -> get_where("Camere", array("Link" => $linkCamera)) -> result()[0] -> ID);
        }
    }