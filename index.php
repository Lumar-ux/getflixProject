<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.js" integrity="sha512-bkge924rHvzs8HYzPSjoL47QZU0PYng6QsMuo3xxmEtCeGsfIeDl6t4ATj+NxwUbwOEYKsGO8A5zIAkMXP+cHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Getflix</title>
  </head>
  <body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php");?>
    <main class="w-[80%] sm:container mx-auto h-fit">
      <section class="cate-main w-full h-[748px] sm:h-[801px] flex items-center sm:my-[39px] overflow-x-scroll">
        <article class="w-full h-[622px] sm:h-[691px] flex justify-between space-x-3">
          <img src="image/Chernobyles.jpg" alt="Chernobyles" name="img-hero_01" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/BohemianRhapsody-Crop.png" alt="Bohemian-Rhapsody" name="img-hero_02" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/SISU.jpg" alt="SISU" name="img-hero_03" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/NightAgent-Crop.png" alt="Night_Agent" name="img-hero_04" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/DropOfGod-Crop.png" alt="DropOfGod" name="img-hero_05" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/Avatar_2-Crop.png" alt="Avatar_2" name="img-hero_06" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
          <img src="image/Lucky.png" alt="Lucky" name="img-hero_07" class="object-cover h-[622px] sm:h-[652px] w-[93.16px] sm:w-[190px] rounded-xl">
        </article>
      </section>
      <section class="cate-main w-full h-fit overflow-x-scroll mb-14"> 
        <article class="grid1 h-full space-y-3 sm:space-y-6">
            <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
              <h1 name="category-01" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Movie<br>Top 10</h1>
              <a href="category.php?movies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a> 
            </div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-1">1</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-2">2</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3">3</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-4">4</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3" name="img-cat-5">5</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-6">6</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-7">7</div>
            <div class="grid-item bg-gray-500 rounded-xl" name="img-cat-8">8</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-9">9</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-10">10</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-11">11</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-12">12</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-13">13</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-14">14</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-15">15</div>
        </article>
      </section>
      <section class="cate-main w-full h-fit overflow-x-scroll mb-14"> 
        <article class="grid1 h-full space-y-3 sm:space-y-6">
            <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
              <h1 name="category-02" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Tv Shows Top 10</h1>
              <a href="category.php?series" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a> 
            </div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-1">1</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-2">2</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3">3</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-4">4</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3" name="img-cat-5">5</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-6">6</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-7">7</div>
            <div class="grid-item bg-gray-500 rounded-xl" name="img-cat-8">8</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-9">9</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-10">10</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-11">11</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-12">1</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-13">13</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-14">14</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-15">15</div>
        </article>
      </section>
      <section class="cate-main w-full h-fit overflow-x-scroll mb-14"> 
        <article class="grid1 h-full space-y-3 sm:space-y-6">
            <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
              <h1 name="category-03" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Movies</h1>
              <a href="category.php?movies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a> 
            </div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-1">1</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-2">2</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3">3</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-4">4</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3" name="img-cat-5">5</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-6">6</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-7">7</div>
            <div class="grid-item bg-gray-500 rounded-xl" name="img-cat-8">8</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-9">9</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-10">10</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-11">11</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-12">12</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-13">13</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-14">14</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-15">15</div>
        </article>
      </section>
      <section class="cate-main w-full h-fit overflow-x-scroll mb-14"> 
        <article class="grid1 h-full space-y-3 sm:space-y-6">
            <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-3 sm:mt-6">
              <h1 name="category-04" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">Discover Tv Shows</h1>
              <a href="category.php?movies" class="self-end w-[19%] h-[19%]"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie" class="w-full h-full"></a> 
            </div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-1">1</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-2">2</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-3">3</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-4">4</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3" name="img-cat-5">5</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-6">6</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-7">7</div>
            <div class="grid-item bg-gray-500 rounded-xl" name="img-cat-8">8</div>
            <div class="grid-item  bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-9">9</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-10">10</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-11">11</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-12">12</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-13">13</div>
            <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-14">14</div>
            <div class="grid-item bg-gray-500 rounded-xl ml-3 sm:ml-6" name="img-cat-15">15</div>
        </article>
      </section>
    </main>
    <?php include_once("./footer.php");?>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- <script src="./masonry.pkgd.js"></script> -->
  </body>
</html>