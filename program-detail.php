<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./output.css">
    <title>Program</title>
</head>

<body class="bg-halfBlack h-screen w-screen">
    <?php include_once("./header.php");?>
    <main class="container mx-auto w-full mt-14">
        <section class="porg-detail flex w-full h-[801px] mb-28">
            <div class="bg-gray-500 rounded-xl h-full w-[679px] mr-14" name="img-cat_08"></div>
            <article class="flex flex-col w-[801px] h-full justify-between mb-14">
                <section class="w-full">
                    <h1 name="name-prog"
                        class="bg-pastelBlue text-white py-4 pl-4 text-[34px] text-1 font-[570] uppercase mb-6 rounded-[10px] leading-none w-full">
                        SILO</h1>
                    <article class="info flex items-center mb-6">
                        <button name="genre-01"
                            class="bg-white p-[10px] text-base font-[570] leading-none mr-2 rounded-[10px]">Genre</button>
                        <button name="genre-02"
                            class="bg-white p-[10px] text-base font-[570] leading-none mr-2 rounded-[10px]">Genre</button>
                        <p name="year" class="font-[570] text-base text-white mr-2">year</p>
                        <p name="duration" class="font-[570] text-base text-white mr-2">duration</p>
                        <p name="imbdb-note" class="font-[570] text-base text-white">0.0</p>
                    </article>
                    <article class="flex">
                        <ul class="list-none mr-6">
                            <li class="text-white text-xs mb-[10px]">Country : <span name="prog-country">United
                                    States</span></li>
                            <li class="text-white text-xs">Production : <span name="prog-prod">AMC Studios</span></li>
                        </ul>
                        <ul class="list-none">
                            <li class="text-white text-xs mb-[10px]">Date Release : <span name="prog-release">May 05
                                    2023</span></li>
                            <li class="text-white text-xs w-[370px]">Cast : <span name="prog-cast">Tim Robbins, Rebecca
                                    Ferguson, Avi Nash, Rashida Jones, David Oyewolo, Tim Robbins</span></li>
                        </ul>
                    </article>
                </section>
                <section>
                    <div class="bg-gray-500 rounded-xl min-h-[238px] w-[417px] mb-6" name="trailer-video">video</div>
                    <p class="text-white font-[570] text-[18px]">In a future where the Earth has been devastated and the
                        air has become toxic, the survivors live in a giant 144-storey underground silo. Within this
                        community, individuals must abide by a series of strict rules designed to protect them. Citizens
                        who break the law are sent outside the silo, condemned to die in the unbreathable atmosphere.
                        Gradually, however, the idea that those in charge are lying about what's going on outside is
                        gaining ground...</p>
                </section>
            </article>
        </section>
        <section class="suggestion w-full mb-28">
            <article class="grid1 w-full h-fit space-y-6  overflow-x-auto">
                <div
                    class="grid-item grid-item--width2 bg-pastelBlue rounded-xl p-4 flex flex-col justify-between mt-6">
                    <h1 name="category-01" class="text-white text-[56px] font-[570] uppercase break-words">You may also
                        like</h1>
                    <a href="#" class="self-end"><img src="image/Arrow-Categorie.svg" alt="Arrow-Categorie"
                            class="w-[72px] h-[72px] self-end"></a>
                </div>
                <div class="grid-item  bg-gray-500 rounded-xl ml-6" name="img-cat-3">0.1</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-1">1</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-6" name="img-cat-2">2</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl" name="img-cat-3">3</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-3">4</div>
                <div class="grid-item grid-item--width2 bg-gray-500 rounded-xl ml-6" name="img-cat-4">5</div>
                <div class="grid-item bg-gray-500 rounded-xl ml-6" name="img-cat-5">6</div>
            </article>
        </section>
        <section class="w-full mb-14">
            <h1 class="text-white uppercase text-2xl font-semibold mb-14">Comments</h1>
            <article name="Comment-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="form-floating">
                        <form action="#" method="POST" class="flex flex-col">
                            <textarea class="form-control w-[875px] h-20 rounded-xl p-4 mb-1"
                                placeholder="Leave a comment here..." id="floatingTextarea2"
                                name="message-current-user"></textarea>
                            <button type="submit" name="submit"
                                class="send text-[12px] font-normal text-white w-fit hover:bg-[#424242] px-4 py-2 rounded-xl"><span
                                    class="text-[12px] font-normal text-white">Envoyé</span></button>
                        </form>
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
            <article name="post-Area" class="flex mb-10">
                <div class="w-[104px] h-[104px] bg-greyWhite rounded-full mr-4"></div>
                <section>
                    <h2 name="current-name-user" class="text-white font-bold leading-none mb-2">User</h2>
                    <div class="screen-message w-[875px] h-20 rounded-xl p-4 mb-1 bg-greyWhite" name="message-user">
                    </div>
                    <div class="flex">
                        <button class="p-2 hover:bg-[#424242] mr-2 rounded-full"><img
                                src="image/thumb_up_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Up"
                                class="w-[18px] h-[18px]"></button>
                        <button class="p-2 hover:bg-[#424242] rounded-full"><img
                                src="image/thumb_down_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Thumb-Down"
                                class="w-[18px] h-[18px]"></button>
                        <!-- <button type="submit" name="submit" class="send flex hover:bg-[#424242] px-4 py-2 rounded-xl"><img src="image/reply_32dp_FFF_FILL0_wght400_GRAD0_opsz40.svg" alt="Reply-Icon" class="w-[18px] h-[18px] mr-1"><span class="text-[12px] font-normal text-white">Reply</span></button> -->
                    </div>
                </section>
            </article>
        </section>
    </main>
    <?php include_once("./footer.php");?>
</body>

</html>