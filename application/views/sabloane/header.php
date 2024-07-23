<!DOCTYPE html>
<html lang="ro" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>V Hotels</title>

        <!-- TAILWIND -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- DAISY UI -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- JQUERY -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

        <!-- SWAL2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- ANIMATII -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

        <!-- BLUEPRINT -->
        <link rel="stylesheet" href="https://unpkg.com/blueprint-css@3.1.3/dist/blueprint.min.css">
        
        <style>
            #bannerCelestial 
            {
                background: url("/resurse/imagini/imagine_terasa.jpg"); 
                background-size:cover;
            }

            @media (min-width: 1280px)
            {
                #bannerCelestial
                {
                    background: url("/resurse/imagini/imagine_terasa_xxl.jpg");
                    background-size:cover;
                }
            }
        </style>

        <script>
            $("document").ready(function() {
                AOS.init();

                $("#inchideMeniuContextual").click(function() {
                    $("#meniuContextual").fadeOut();
                });

                $("#deschideMeniuContextual").click(function() {
                    $("#meniuContextual").fadeIn();
                });

                $("#meniuContextual").hide();
            });
        </script>
        </head>
    <body>
        <header class="bg-purple-600">
            <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                <a href="acasa" class="-m-1.5 p-1.5">
                    <span class="sr-only">V Hotels</span>
                    <img class="h-10 w-auto" src="/resurse/imagini/logo_alb.png" alt="">
                </a>
                </div>
                <div class="flex lg:hidden">
                <button id="deschideMeniuContextual" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-purple-300">
                    <span class="sr-only">Deschide meniu principal</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                <a href="camere" class="text-sm font-semibold leading-6 text-white">Vezi camere</a>
                <a href="evenimente" class="text-sm font-semibold leading-6 text-white">Evenimente</a>
                <a href="contact" class="text-sm font-semibold leading-6 text-white">Contact</a>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <?php if (isset($logat) == false): ?>
                    <a href="autentificare" class="text-sm font-semibold leading-6 text-white">Autentificare <span aria-hidden="true">&rarr;</span></a>
                <?php endif; ?>
                </div>
            </nav>
            <div id="meniuContextual" class="lg:hidden" role="dialog" aria-modal="true">
                <div class="fixed inset-0 z-10"></div>
                <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="acasa" class="-m-1.5 p-1.5">
                    <span class="sr-only">V Hotels</span>
                    <img class="h-10 w-auto" src="/resurse/imagini/logo_mov.png" alt="">
                    </a>
                    <button id="inchideMeniuContextual" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Inchide meniu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="camere" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Vezi camere</a>
                        <a href="evenimente" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Evenimente</a>
                        <a href="contact" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Contact</a>
                    </div>
                    <div class="py-6">
                    <?php if (isset($logat) == false): ?>
                        <a href="autentificare" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Autentificare</a>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </header>