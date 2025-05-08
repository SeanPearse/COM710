document.addEventListener("DOMContentLoaded", () => {
  const userCardTemplate = document.querySelector("[data-user-template]");
  const userCardContainer = document.querySelector("[data-user-cards-container]");
  const searchInput = document.querySelector("[data-search]");
  const tagFilterContainer = document.getElementById("tag-filter");

  let users = [];
  const uniqueTags = new Set();

  // Filtering logic (used by search and tag clicks)
  function filterUsers(value) {
    users.forEach(user => {
      const isVisible = user.name.includes(value) || user.tags.includes(value);
      user.element.classList.toggle("hide", !isVisible);
    });
  }

  // Set up search filtering
  searchInput.addEventListener("input", e => {
    const value = e.target.value.toLowerCase();
    filterUsers(value);
  });

  // Create clickable tag elements (including "All")
  function createTagElements(tagsSet) {
    tagFilterContainer.innerHTML = ""; // clear first

    // Add "All" tag
    const allTag = document.createElement("span");
    allTag.classList.add("tag-link");
    allTag.textContent = "All";

    allTag.addEventListener("click", () => {
      users.forEach(user => {
        user.element.classList.remove("hide");
      });
    });

    tagFilterContainer.appendChild(allTag);

    tagsSet.forEach(tag => {
      const tagEl = document.createElement("span");
      tagEl.classList.add("tag-link");
      tagEl.dataset.tag = tag;
      tagEl.textContent = tag;

      tagEl.addEventListener("click", () => {
        filterUsers(tag.toLowerCase()); // ✅ ensure lowercase filtering
      });

      tagFilterContainer.appendChild(tagEl);
    });
  }

  // Fetch and render recipe cards
  fetch("../Java Files/RecipeData.json?nocache=" + Date.now())
    .then(res => res.json())
    .then(data => {
      console.log("Loaded data:", data);
      users = data.map(user => {
        console.log("Rendering:", user.name); // ✅ Debug log

        // Collect unique tags
        user.tags.split(",").forEach(tag => {
          uniqueTags.add(tag.trim().toLowerCase());
        });

        const cardLink = userCardTemplate.content.cloneNode(true).children[0];
        if (!cardLink) {
          console.error("Failed to clone template for:", user.name); // ❌ Template failed
        }

        const card = cardLink.querySelector(".card");
        const header = card?.querySelector("[data-header]");
        const body = card?.querySelector("[data-body]");
        const img = card?.querySelector("[data-img]");

        if (!card) {
          console.error("MISSING `.card` for:", user.name);
        }
        if (!header) {
          console.error("MISSING `[data-header]` for:", user.name);
        }
        if (!body) {
          console.error("MISSING `[data-body]` for:", user.name);
        }
        if (!img) {
          console.error("MISSING `[data-img]` for:", user.name);
        }
        
        if (!card || !header || !body || !img) {
          console.error("Skipping rendering of:", user.name);
          return null;
        }
        

        header.textContent = user.name;
        body.textContent = user.tags;
        img.src = user.img || "default.jpg";
        cardLink.href = user.link || "#";

        userCardContainer.append(cardLink);

        return {
          name: user.name.toLowerCase(),
          tags: user.tags.toLowerCase(),
          element: cardLink
        };
      }).filter(Boolean); // Remove any nulls caused by failed cards

      createTagElements(uniqueTags);
    });

  // Final check for "Beans"
  setTimeout(() => {
    console.log("All users:", users);
    const hasBeans = users.some(u => u.name.includes("beans"));
    console.log("Beans found?", hasBeans);
  }, 1000);
});

// Optional helpers
function darkMode() {
  document.body.classList.toggle("dark-mode");
}

function showForm(formId) {
  document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
  document.getElementById(formId).classList.add("active");
}

