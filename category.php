<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./output.css">
  <title>Category</title>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

</head>

<body class="bg-halfBlack h-screen w-screen">
  <?php
  require_once "header.php";

  $rows_per_page = 5;
  $start = 0;
  $page = 1;

  if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
    $start = ($page - 1) * $rows_per_page;
  }
  try {
    // Fetch total row count
    $p_query = $conn->prepare("SELECT COUNT(*) FROM movies");
    $p_query->execute();
    $rows_count = $p_query->fetchColumn();
    $total_page = ceil($rows_count / $rows_per_page);

    // Fetch the data with limit and offset
    $query = $conn->prepare("SELECT * FROM movies LIMIT :start, :rows_per_page");
    $query->bindValue(':start', $start, PDO::PARAM_INT);
    $query->bindValue(':rows_per_page', $rows_per_page, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
  }
  ?>

  <section class="container w-full mx-auto">
    <h1 name="name-category text-pastelBlue text-[56px]">Action</h1>
    <article class="w-full grid grid-cols-[288.74px_288.74px_288.74px_288.74px_288.74px] grid-flow-row auto-rows-[388px] gap-6 ">
      <?php foreach ($result as $rows) { ?>
        <a class="w-full h-full bg-gray-500 rounded-xl shrink-0 mb-6 ml-6" href="program-detail.php?id=<?php echo $rows['movieapi_id']; ?>">
          <img class="rounded-xl w-[288.74px] h-[388px]" src="http://image.tmdb.org/t/p/w500/<?php echo $rows["poster_path"]; ?>" alt="">
        </a>
      <?php } ?>
    </article>
  </section>
  <section class="container w-full mx-auto my-4 flex justify-center">
    <nav aria-label="Page navigation example" class="mx-auto mt-5">
      <ul class="inline-flex -space-x-px text-sm gap-1">
        <li>
          <a href="?page=<?php echo max(1, $page - 1); ?>" class="flex items-center justify-center px-3 h-8 rounded-l-xl text-gray-50 border border-gray-300 bg-gray-900 hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">Previous</a>
        </li>

        <?php for ($x = 1; $x <= $total_page; $x++): ?>
          <li>
            <a href="?page=<?php echo $x; ?>" class="flex items-center justify-center px-3 h-8 text-gray-50 border border-gray-300  hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white <?php echo ($x == $page) ? 'font-bold bg-gray-500' : 'bg-gray-900'; ?>">
              <?php echo $x; ?>
            </a>
          </li>
        <?php endfor; ?>

        <li>
          <a href="?page=<?php echo min($total_page, $page + 1); ?>" class="flex items-center justify-center px-3 h-8 rounded-r-xl text-gray-50 border border-gray-300 bg-gray-900 hover:bg-gray-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">Next</a>
        </li>
      </ul>
    </nav>
  </section>
  <?php include_once("./footer.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
  <script src="livesearch.js"></script>
  <!-- to do live search -->

</body>

</html>