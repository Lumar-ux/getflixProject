document.addEventListener("DOMContentLoaded", () => {
  const livesearch = document.getElementById("livesearch");
  const livesearch_dropdown = document.getElementById("livesearch_dropdown");
  const livesearch_ul = document.getElementById("livesearch_ul");

  livesearch.addEventListener("input", () => {
    const text = livesearch.value.trim();

    if (!text) {
      livesearch_dropdown.classList.add("hidden");
      return;
    }

    const fetchResults = (url, callback) => {
      fetch(url)
        .then((response) => response.json())
        .then((data) => callback(data))
        .catch(() => {
          livesearch_ul.innerHTML = `<li class="border-b p-2">
                    <p class="inline-flex w-full px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black">
                        Error parsing data. Try again later.
                    </p>
                </li>`;
        });
    };

    const renderListItems = (items) => {
      livesearch_ul.innerHTML = items
        .map(
          (item) => `
            <li class="border-b p-2">
                <a href="program-detail.php?id=${item.movieapi_id}&type=${item.type}" class="inline-flex w-full px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                    <p class="inline-flex items-center">
                        <img src="http://image.tmdb.org/t/p/w500/${item.poster_path}" alt="${item.title}" class="w-10 h-15 inline-block mr-2">
                        ${item.title}
                    </p>
                </a>
            </li>
        `
        )
        .join("");
    };

    const renderNotFound = () => {
      livesearch_ul.innerHTML = `
            <li class="border-b p-2" id="advance_search">
                <p class="inline-flex w-full px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black cursor-pointer">
                    Not Found! Write full name and click here.
                </p>
            </li>
        `;
      document
        .getElementById("advance_search")
        .addEventListener("click", () => {
          const formattedValue = encodeURIComponent(livesearch.value);
          fetchResults(
            `livesearch.php?advance_search=${formattedValue}`,
            renderAdvancedSearchResults
          );
        });
    };

    const renderAdvancedSearchResults = (data) => {
      if (Array.isArray(data.results) && data.results.length > 0) {
        const maxItems = 10;
        const items = data.results.slice(0, maxItems).map((item) => {
          let title = "";
          if (item.media_type == "movie") {
            title = item.title;
          } else if (item.media_type == "tv") {
            title = item.name;
          }
          const imageUrl = item.poster_path
            ? `http://image.tmdb.org/t/p/w500/${item.poster_path}`
            : "default_image.jpg";
          const media_type = item.media_type;
          return {
            movieapi_id: item.id,
            poster_path: imageUrl,
            title: title,
            type: media_type,
          };
        });
        renderListItems(items);
      } else {
        renderNotFound();
      }
    };

    fetchResults(`livesearch.php?title=${text}`, (data) => {
      livesearch_dropdown.classList.remove("hidden");
      if (Array.isArray(data) && data.length > 0) {
        renderListItems(data);
      } else {
        renderNotFound();
      }
    });
  });
});
