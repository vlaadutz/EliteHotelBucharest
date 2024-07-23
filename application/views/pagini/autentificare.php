    <div class="text-center mt-5">
            <h1 class="text-4xl font-semibold">Autentifica-te in contul tau</h1>

            <form class="border-gray-200 border-2 m-10 p-10 rounded" action="" method="post">
                <input class="p-2 border-2 border-purple-400 rounded hover:border-purple-600 transition" type="text" name="nume" placeholder="Nume">
                <br>
                <input class="p-2 mt-5 border-2 border-purple-400 rounded hover:border-purple-600 transition" type="password" name="parola" placeholder="Parola">
                <br>
                <a class="mt-2 text-purple-600 flex justify-center align-center" href="autentificare_qr">
                    <svg width="20" height="20" fill="currentColor"><path d="M2 2h2v2H2z"/><path d="M6 0v6H0V0zM5 1H1v4h4zM4 12H2v2h2z"/><path d="M6 10v6H0v-6zm-5 1v4h4v-4zm11-9h2v2h-2z"/><path d="M10 0v6h6V0zm5 1v4h-4V1zM8 1V0h1v2H8v2H7V1zm0 5V4h1v2zM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8zm0 0v1H2V8H1v1H0V7h3v1zm10 1h-1V7h1zm-1 0h-1v2h2v-1h-1zm-4 0h2v1h-1v1h-1zm2 3v-1h-1v1h-1v1H9v1h3v-2zm0 0h3v1h-2v1h-1zm-4-1v1h1v-2H7v1z"/><path d="M7 12h1v3h4v1H7zm9 2v2h-3v-1h2v-1z"/></svg>
                    Ai cod QR? Apasa aici!
                </a>
                <a class="mt-2 text-purple-600 flex justify-center align-center" href="cont_nou">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-slash-fill" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/></svg>
                     Nu ai cont? Apasa aici!
                </a>
                <br>
                <input class="bg-purple-600 text-white p-2 rounded hover:bg-purple-400 transition" type="submit" value="Autentificare">
            </form>
        </div>

        <?php if (isset($incorect)): ?>
            <script>
                Swal.fire({
                    "title": "Eroare de autentificare",
                    "text": "Numele si/sau parola nu sunt corecte! Incearca din nou.",
                    "icon": "error"
                });
            </script>
        <?php endif; ?>
    </body>
</html>