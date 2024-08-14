<!DOCTYPE html>
<html lang="en" class="h-screen w-screen">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Program</title>
  </head>
  <body class="bg-halfBlack sm:w-screen w-full h-fit">
    <?php include_once("./header.php");?>
    <main class="w-[80%] sm:container mx-auto h-fit">
      <section class="relative w-full mb-6 pt-[57.14%;] sm:block hidden">
        <div class="absolute top-0 right-0 w-full h-full bg-gray-500 rounded-xl" name="trailer-video">video</div>
      </section>
      <section class="porg-detail block sm:flex w-full sm:h-[801px] h-[716.4px] sm:mb-28 mb-[78px]">
        <div class="bg-gray-500 rounded-xl h-[270px] sm:h-full w-full sm:w-[679px] sm:mr-14 sm:mb-0 mb-3 sm:m-0" name="img-cat_08"></div>
        <article class="flex flex-col w-full sm:w-[801px] sm:h-full h-[436px] sm:justify-between">
          <section class="detail w-full">
            <h1 name="name-prog" class="bg-pastelBlue text-white py-4 pl-4 text-[34px] text-1 font-[570] uppercase sm:mb-6 mb-2.5 rounded-[10px] leading-none w-full">SILO</h1>
            <article class="info flex items-center sm:mb-6 mb-2.5">
              <button name="genre-01" class="bg-white p-[10px] sm:text-base text-[13px] font-[570] leading-none mr-2 rounded-[10px]">Genre</button>
              <button name="genre-02" class="bg-white p-[10px] sm:text-base text-[13px] font-[570] leading-none mr-2 rounded-[10px]">Genre</button>
              <p name="year" class="font-[570] sm:text-base text-[13px] text-white mr-2">year</p>
              <p name="duration" class="font-[570] sm:text-base text-[13px] text-white mr-2">duration</p>
              <p name="imbdb-note" class="font-[570] sm:text-base text-[13px] text-white">0.0</p>
            </article>
            <article class="flex">
              <ul class="list-none mr-6">
                <li class="text-white text-xs mb-[10px]">Country : <span name="prog-country">United States</span></li>
                <li class="text-white text-xs">Production : <span name="prog-prod">AMC Studios</span></li>
              </ul>
              <ul class="list-none">
                <li class="text-white text-xs mb-[10px]">Date Release : <span name="prog-release">May 05 2023</span></li>
                <li class="text-white text-xs sm:w-[370px] w-[136.5px] line-clamp-2">Cast : <span name="prog-cast">Tim Robbins, Rebecca Ferguson, Avi Nash, Rashida Jones, David Oyewolo, Tim Robbins</span></li>
              </ul>
            </article>
          </section>
          <section class="descriptif mt-auto">
            <p class="text-white font-[570] sm:text-[18px] text-3.5 line-clamp-6">In a future where the Earth has been devastated and the air has become toxic, the survivors live in a giant 144-storey underground silo. Within this community, individuals must abide by a series of strict rules designed to protect them. Citizens who break the law are sent outside the silo, condemned to die in the unbreathable atmosphere. Gradually, however, the idea that those in charge are lying about what's going on outside is gaining ground...</p>
          </section>
        </article>
      </section>
      <section class="cate-main w-full h-fit overflow-x-scroll mb-14"> 
        <article class="grid1 h-full space-y-3 sm:space-y-6">
            <div class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-0 sm:mt-6">
              <h1 name="category-01" class="text-white text-[51px] sm:text-[56px] font-[570] uppercase break-words leading-tight">You may also like</h1>
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
      <section class="w-full mb-14">
        <h1 class="text-white uppercase text-2xl font-semibold mb-14">Comments</h1>
        <article name="Comment-Area" class="flex mb-10">
            <section class="w-full sm:w-[875px]">
              <article class="flex items-center mb-2">
                <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
                <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
              </article>
              <div class="form-floating">
                <form action="#" method="POST" class="flex flex-col">
                  <textarea class="form-control w-full h-20 rounded-xl p-4 mb-1" placeholder="Leave a comment here..." id="floatingTextarea2" name="message-current-user"></textarea>
                  <button type="submit" name="submit" class="send text-[12px] font-normal text-white w-fit hover:bg-[#424242] px-4 py-2 rounded-xl"><span class="text-[12px] font-normal text-white">Envoyé</span></button>
                </form>
              </div>
            </section>
        </article>
        <article name="post-Area" class="flex mb-10">
            <section class="w-full sm:w-[875px]">
              <article class="flex items-center mb-2">
                <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
                <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
              </article>
              <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite"  name="message-user"></div>
              <div class="flex">
                <button class="p-2 hover:bg-coloHover mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
                <button class="p-2 hover:bg-coloHover rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button>
                <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
              </div>
            </section>
        </article>
        <article name="post-Area" class="flex mb-10">
            <section class="w-full sm:w-[875px]">
              <article class="flex items-center mb-2">
                <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
                <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
              </article>
              <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite"  name="message-user"></div>
              <div class="flex">
                <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
                <button class="p-2 hover:bg-[#424242] rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button>
                <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
              </div>
            </section>
        </article>
        <article name="post-Area" class="flex mb-10">
            <section class="w-full sm:w-[875px]">
              <article class="flex items-center mb-2">
                <div class="flex-none w-[40px] h-[40px] bg-greyWhite rounded-full mr-2"></div>
                <h2 name="current-name-user" class="text-white font-bold leading-none">User</h2>
              </article>
              <div class="screen-message w-full h-20 rounded-xl p-4 mb-1 bg-greyWhite"  name="message-user"></div>
              <div class="flex">
                <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up" class="w-[18px] h-[18px]"></button>
                <button class="p-2 hover:bg-[#424242] rounded-full"><img src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down" class="w-[18px] h-[18px]"></button>
                <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
              </div>
            </section>
        </article>
      </section>
    </main>
    <?php include_once("./footer.php");?>
</body>

</html>