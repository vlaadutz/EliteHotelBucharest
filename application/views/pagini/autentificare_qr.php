    <div class="text-center mt-5">
            <h1 class="text-4xl font-semibold">Autentifica-te in contul tau</h1>

            <form class="text-center border-gray-200 border-2 m-10 p-10 rounded" action="" method="post" enctype="multipart/form-data">
                <input type="file" name="pozaQR" class="file-input">
                <br>
                <a class="mt-2 text-purple-600 flex justify-center align-center" href="autentificare">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-slash-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                    Nu ai cod QR? Apasa aici!
                </a>
                <br>
                <input class="bg-purple-600 text-white p-2 rounded hover:bg-purple-400 transition" type="submit" value="Autentificare">
            </form>
        </div>

        <?php if (isset($incorect)): ?>
            <script>
                Swal.fire({
                    "title": "Eroare de autentificare",
                    "text": "Codul QR nu este valid! Incearca din nou.",
                    "icon": "error"
                });
            </script>
        <?php endif; ?>
    </body>
</html>