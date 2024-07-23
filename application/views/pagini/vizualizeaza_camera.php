<div class="relative bg-white">
  <img class="h-56 w-full bg-gray-50 object-cover lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-1/2" src="<?php echo $poza; ?>" alt="">
  <div class="mx-auto grid max-w-7xl lg:grid-cols-2">
    <div class="px-6 pb-24 pt-16 sm:pb-32 sm:pt-20 lg:col-start-2 lg:px-8 lg:pt-32">
      <div class="mx-auto max-w-2xl lg:mr-0 lg:max-w-lg">
        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl"><?php echo $denumire; ?></p>
        <p class="mt-6 text-lg leading-8 text-gray-600"><?php echo $descriere; ?></p>
        <dl class="mt-16 grid max-w-xl grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 xl:mt-16">
          <div class="flex flex-col gap-y-3 border-l border-gray-900/10 pl-6">
            <dt class="text-xs leading-6 text-gray-600"><?php echo "*" . $pretNoapte . " RON / noapte"; ?></dt>
            <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900"><?php echo $pret . " RON"; ?></dd>
            <form action="" method="post">
                <input type="hidden" name="rezervare" value="rezervat">
                <input class="btn btn-primary" type="submit" value="     REZERVA     " style="background-color: rgb(147 51 234); border-color: rgb(147 51 234); color: white;">
            </form>
          </div>
        </dl>
      </div>
      
    </div>
  </div>
</div>

<?php if(isset($rezervat)): ?>
    <script>
        Swal.fire({title: "Succes", text: "Rezervarea a fost realizata cu succes!", icon:"success"});
    </script>
<?php endif; ?>