<?php
    class Pagini extends CI_Controller
    {
        /**
         * Incarca helperele si librariile necesare pentru aplicatie + bara de meniu
         */
        private function meniu_sus()
        {
            $this -> load -> library("session");
            $this -> load -> helper("url");
            $date = array();

            // daca e logat
            if (empty($this -> session -> nume) == false)
            {
                $date["logat"] = true;
            }
            
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
            $this -> load -> model("Utilizator");
            $this -> load -> library("session");
            $this -> load -> database();
            $date = array();

            if (!empty($this -> input -> post("nume")) && !empty($this -> input -> post("parola")))
            {
                // verificare in db daca datele introduse sunt corecte
                $nume = $this -> db -> escape_str($this -> input -> post("nume"));
                $parola = md5($this -> db -> escape_str($this -> input -> post("parola")));
                
                if ($this -> Utilizator -> exista($nume, $parola))
                {
                    $this -> session -> nume = $nume;
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

            $this -> load -> model("Utilizator");
            $this -> load -> model("Utilitati");
            $this -> load -> library("session");
            $this -> load -> database();
            $date = array();

            if (isset($_FILES["pozaQR"]))
            {
                // preluare date din qr
                $fisier = new CURLFile($_FILES["pozaQR"]["tmp_name"]);
                list($nume, $parola) = $this -> Utilitati -> decodare_date_qr($fisier);

                // verificare in db
                if ($this -> Utilizator -> exista($nume, $parola))
                {
                    $this -> session -> nume = $nume;
                    echo "da";
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
            $this -> load -> model("Utilizator");
            $this -> load -> model("Utilitati");
            $this -> load -> model("Validare");
            $this -> load -> library("session");
            $this -> load -> helper("url");
            $this -> load -> helper("file");

            $date = array();
            if (!empty($this -> input -> post("nume")) || !empty($this -> input -> post("email")) || !empty($this -> input -> post("parola")))
            {
                if ($this -> Validare -> nume_email_parola())
                {
                    if ($this -> Utilitati -> exista_email($this -> input -> post("email")) == false)
                    {
                        $this -> Utilizator -> adauga($this -> input -> post("nume"), $this -> input -> post("email"), md5($this -> input -> post("parola")));

                        // dupa adaugarea utilizatorului in db se genereaza un cod QR si se salveaza in directorul root
                        $this -> Utilitati -> encodare_date_qr($this -> input -> post("nume"), md5($this -> input -> post("parola")));
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
            $this -> load -> model("Camera");
            $this -> load -> model("Utilitati");
            $this -> load -> library("session");
            $this -> load -> database();
            $this -> load -> helper("url");
            $date = array();

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
                $this -> Camera -> adauga_rezervare($this -> Utilitati -> preluare_id_utilizator($this -> session -> nume), $this -> Utilitati -> preluare_id_camera($linkCamera), $this -> input -> get("dataCheckIn"), $this -> input -> get("dataCheckOut"));
                $date["rezervat"] = true;
            }

            list($date["pret"], $date["pretNoapte"], $date["denumire"], $date["descriere"], $date["poza"]) = $this -> Camera -> preluare_date($linkCamera);

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
            $this -> load -> model("Validare");
            $this -> load -> library("form_validation");
            $date = array();

            if (!empty($this -> input -> post("first-name")) || !empty($this -> input -> post("last-name")) || !empty($this -> input -> post("email")) || !empty($this -> input -> post("phone-number")) || !empty($this -> input -> post("message")))
            {
                if ($this -> Validare -> nume_prenume_telefon_email_mesaj())
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
    }