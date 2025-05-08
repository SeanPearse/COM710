document.addEventListener("DOMContentLoaded", () => {
  // Dark Mode Initialization
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }

  window.darkMode = function () {
    document.body.classList.toggle("dark-mode");

    // Store the dark mode state in localStorage
    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem('darkMode', 'enabled');
    } else {
      localStorage.setItem('darkMode', 'disabled');
    }
  };

  // Tag Filtering Logic
  const userCardTemplate = document.querySelector("[data-user-template]");
  const userCardContainer = document.querySelector("[data-user-cards-container]");
  const searchInput = document.querySelector("[data-search]");
  const tagFilterContainer = document.getElementById("tag-filter");

  let users = [];
  const tagCountMap = new Map(); // To track tag counts

  // Get the 'tag' query parameter from the URL
  const urlParams = new URLSearchParams(window.location.search);
  const tagFromUrl = urlParams.get("tag");

  // Filter users based on the search value or tag
  function filterUsers(value) {
    users.forEach(user => {
      const isVisible = user.name.includes(value) || user.tags.includes(value);
      user.element.classList.toggle("hide", !isVisible);
    });
  }

  // Set up search filtering
  if (searchInput) {
    searchInput.addEventListener("input", e => {
      const value = e.target.value.toLowerCase();
      filterUsers(value);
    });
  }

  // Create clickable tag elements (including "All")
  function createTagElements(tagsMap) {
    if (!tagFilterContainer) return;

    tagFilterContainer.innerHTML = "";

    // Add "All" tag
    const allTag = document.createElement("span");
    allTag.classList.add("tag-link");
    allTag.textContent = "All";
    allTag.addEventListener("click", () => {
      // Remove filter and show all users
      users.forEach(user => user.element.classList.remove("hide"));
      searchInput.value = ''; // Clear the search field when "All" is clicked

      // Update the URL to remove the tag filter
      history.pushState(null, "", "MainPage.php");
    });
    tagFilterContainer.appendChild(allTag);

    tagsMap.forEach((count, tag) => {
      const tagEl = document.createElement("span");
      tagEl.classList.add("tag-link");
      tagEl.dataset.tag = tag;
      tagEl.textContent = `${tag} (${count})`; // Display tag and its count

      tagEl.addEventListener("click", () => {
        filterUsers(tag.toLowerCase());

        // Update the URL with the clicked tag
        history.pushState(null, "", `MainPage.php?tag=${encodeURIComponent(tag)}`);
      });

      tagFilterContainer.appendChild(tagEl);
    });

    // If there is a tag from the URL, filter based on that tag
    if (tagFromUrl) {
      users.forEach(user => {
        const isVisible = user.tags.includes(tagFromUrl.toLowerCase());
        user.element.classList.toggle("hide", !isVisible);
      });
    }
  }

  // Render cards for MainPage
  if (userCardTemplate && userCardContainer) {
    fetch("../Java Files/RecipeData.json?nocache=" + Date.now())
      .then(res => res.json())
      .then(data => {
        users = data.map(user => {
          user.tags.split(",").forEach(tag => {
            const tagTrimmed = tag.trim().toLowerCase();
            // Update the count for this tag in the map
            tagCountMap.set(tagTrimmed, (tagCountMap.get(tagTrimmed) || 0) + 1);
          });

          const cardLink = userCardTemplate.content.cloneNode(true).children[0];
          const card = cardLink.querySelector(".card");
          const header = card?.querySelector("[data-header]");
          const body = card?.querySelector("[data-body]");
          const img = card?.querySelector("[data-img]");

          if (!card || !header || !body || !img) return null;

          header.textContent = user.name;
          body.textContent = user.tags;
          img.src = user.img || "default.jpg";
          cardLink.href = `${user.link}?id=${user.id}`;

          userCardContainer.append(cardLink);

          return {
            name: user.name.toLowerCase(),
            tags: user.tags.toLowerCase(),
            element: cardLink
          };
        }).filter(Boolean);

        createTagElements(tagCountMap); // Pass the tag count map to create the tag elements
      });
  }

  // Optional helper for showing forms
  window.showForm = function (formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
  };
});
