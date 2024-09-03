document.addEventListener("DOMContentLoaded", () => {
  // Initialize type with "movie" as default
  let type = "movie";

  // Handle dropdown toggle
  document
    .getElementById("dropdown-button-2")
    .addEventListener("click", function (event) {
      event.stopPropagation();
      var dropdown = document.getElementById("dropdown-search-city");
      dropdown.classList.toggle("hidden");
    });

  // Close dropdown if clicked outside
  document.addEventListener("click", function (event) {
    var dropdown = document.getElementById("dropdown-search-city");
    var button = document.getElementById("dropdown-button-2");
    if (!button.contains(event.target)) {
      dropdown.classList.add("hidden");
    }
  });

  // Handle selection
  var dropdownItems = document.querySelectorAll(".dropdown-item");
  var selectedItem = document.getElementById("selected-item");
  dropdownItems.forEach(function (item) {
    item.addEventListener("click", function (e) {
      e.preventDefault();
      selectedItem.textContent = this.textContent.trim(); // Ensure there's no extra space
      if (selectedItem.textContent === "Movie") {
        type = "movie";
      } else if (selectedItem.textContent === "Tv Series") {
        type = "tv";
      }
      document.getElementById("dropdown-search-city").classList.add("hidden");
    });
  });

  //live search
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
          livesearch_dropdown.classList.remove("hidden");
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
                <a href="program-detail.php?id=${
                  item.id
                }&type=${type}" class="inline-flex w-full px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-black" role="menuitem">
                    <p class="inline-flex items-center">
                        <img src="http://image.tmdb.org/t/p/w500/${
                          item.poster_path || "default_image.jpg"
                        }" alt="${
            item.title
          }" class="w-12 h-14 inline-block mr-2">
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
            `livesearch.php?advance_search=${formattedValue}&type=${type}`,
            renderAdvancedSearchResults
          );
        });
    };

    const renderAdvancedSearchResults = (data) => {
      if (Array.isArray(data.results) && data.results.length > 0) {
        const maxItems = 10;
        const items = data.results.slice(0, maxItems).map((item) => {
          let title = "";
          title = item.name;
          const imageUrl = item.poster_path
            ? `http://image.tmdb.org/t/p/w500/${item.poster_path}`
            : "default_image.jpg";
          const media_type = item.media_type;
          const id = item.id;
          return {
            id: id,
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

    fetchResults(`livesearch.php?title=${text}&type=${type}`, (data) => {
      livesearch_dropdown.classList.remove("hidden");
      if (Array.isArray(data) && data.length > 0) {
        renderListItems(data);
      } else {
        renderNotFound();
      }
    });
  });
});
