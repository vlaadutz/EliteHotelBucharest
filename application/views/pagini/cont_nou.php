<div class="text-center mt-5">
            <?php if (empty($afisareQR) == false): ?>
                <h1 class="text-4xl font-semibold">Cod QR pentru autentificare</h1>
                <p>Salveaza codul QR de mai jos pentru a te putea autentifica mai simplu pe viitor.</p>
                <div class="border-gray-200 border-2 m-10 p-10 rounded">
                    <div class="flex justify-center">
                        <img src="/<?php echo $numeQR; ?>" width="200">
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="stergere" value="<?php echo $numeQR; ?>">
                        <input class="bg-purple-600 text-white p-2 rounded hover:bg-purple-400 transition" type="submit" value="Autentifica-te folosind codul QR">
                    </form>
                </div>
            <?php else: ?>
            <h1 class="text-4xl font-semibold">Inregistrare cont nou</h1>
            <form class="border-gray-200 border-2 m-10 p-10 rounded" action="" method="post">
                <input class="p-2 border-2 border-purple-400 rounded hover:border-purple-600 transition" type="text" name="nume" placeholder="Nume" required>
                <br>
                <input class="p-2 mt-5 border-2 border-purple-400 rounded hover:border-purple-600 transition" type="email" name="email" placeholder="Email" required>
                <br>
                <input class="p-2 mt-5 border-2 border-purple-400 rounded hover:border-purple-600 transition" type="password" name="parola" placeholder="Parola" required>
                <br>
                <a class="mt-2 text-purple-600 flex justify-center align-center" href="autentificare">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-slash-fill" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                     Ai deja cont? Apasa aici!
                </a>
                <br>
                <input class="bg-purple-600 text-white p-2 rounded hover:bg-purple-400 transition" type="submit" value="Inregistrare">
            </form>
            <?php endif; ?>
        </div>

        <?php if (isset($incorect)): ?>
            <script>
                Swal.fire({
                    "title": "Eroare de inregistrare",
                    "text": "Fiecare camp este obligatoriu! Parola necesita minim 6 caractere!",
                    "icon": "error"
                });
            </script>
        <?php endif; ?>
    </body>
</html>