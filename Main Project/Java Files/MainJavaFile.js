document.addEventListener("DOMContentLoaded", () => {
  // Dark Mode Initialization
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }

  window.darkMode = function () {
    document.body.classList.toggle("dark-mode");
    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem('darkMode', 'enabled');
    } else {
      localStorage.setItem('darkMode', 'disabled');
    }
  };

  // Elements
  const userCardTemplate = document.querySelector("[data-user-template]");
  const userCardContainer = document.querySelector("[data-user-cards-container]");
  const searchInput = document.querySelector("[data-search]");
  const tagFilterContainer = document.getElementById("tag-filter");

  let users = [];
  const tagCountMap = new Map();
  const urlParams = new URLSearchParams(window.location.search);
  const tagFromUrl = urlParams.get("tag");

  function filterUsers(value) {
    users.forEach(user => {
      const isVisible = user.name.includes(value) || user.tags.includes(value);
      user.element.classList.toggle("hide", !isVisible);
    });
  }

  if (searchInput) {
    searchInput.addEventListener("input", e => {
      const value = e.target.value.toLowerCase();
      filterUsers(value);
    });
  }

  function createTagElements(tagsMap) {
    if (!tagFilterContainer) return;

    tagFilterContainer.innerHTML = "";

    const allTag = document.createElement("span");
    allTag.classList.add("tag-link");
    allTag.textContent = "All";
    allTag.addEventListener("click", () => {
      users.forEach(user => user.element.classList.remove("hide"));
      if (searchInput) searchInput.value = '';
      history.pushState(null, "", window.location.pathname);
    });
    tagFilterContainer.appendChild(allTag);

    tagsMap.forEach((count, tag) => {
      const tagEl = document.createElement("span");
      tagEl.classList.add("tag-link");
      tagEl.dataset.tag = tag;
      tagEl.textContent = `${tag} (${count})`;

      tagEl.addEventListener("click", () => {
        filterUsers(tag.toLowerCase());
        history.pushState(null, "", `${window.location.pathname}?tag=${encodeURIComponent(tag)}`);
      });

      tagFilterContainer.appendChild(tagEl);
    });

    if (tagFromUrl) {
      users.forEach(user => {
        const isVisible = user.tags.includes(tagFromUrl.toLowerCase());
        user.element.classList.toggle("hide", !isVisible);
      });
    }
  }

  function renderRecipes(dataArray) {
    users = dataArray.map(user => {
      const tagList = user.tags.split(",");
      tagList.forEach(tag => {
        const tagTrimmed = tag.trim().toLowerCase();
        tagCountMap.set(tagTrimmed, (tagCountMap.get(tagTrimmed) || 0) + 1);
      });

      const cardLink = userCardTemplate.content.cloneNode(true).children[0];
      const card = cardLink.querySelector(".card");
      const header = card?.querySelector("[data-header]");
      const body = card?.querySelector("[data-body]");
      const img = card?.querySelector("[data-img]");
      const tagContainer = card?.querySelector("[data-tags-container]");

      if (!card || !header || !body || !img) return null;

      header.textContent = user.name;
      body.textContent = user.tags;
      img.src = user.img || "default.jpg";
      cardLink.href = `${user.link}?id=${user.id}`;

      if (tagContainer) {
        tagContainer.innerHTML = "";
        tagList.forEach(tag => {
          const tagSpan = document.createElement("span");
          tagSpan.classList.add("card-tag");
          tagSpan.textContent = tag.trim();
          tagContainer.appendChild(tagSpan);
        });
      }

      userCardContainer.append(cardLink);

      return {
        name: user.name.toLowerCase(),
        tags: user.tags.toLowerCase(),
        element: cardLink
      };
    }).filter(Boolean);

    createTagElements(tagCountMap);
  }

  if (userCardTemplate && userCardContainer) {
    if (typeof likedRecipesData !== "undefined" && Array.isArray(likedRecipesData)) {
      renderRecipes(likedRecipesData);
    } else if (typeof myRecipesData !== "undefined" && Array.isArray(myRecipesData)) {
      renderRecipes(myRecipesData);
    } else {
      fetch("../Java Files/RecipeData.json?nocache=" + Date.now())
        .then(res => res.json())
        .then(renderRecipes)
        .catch(err => console.error("Failed to load recipes:", err));
    }
  }

  window.showForm = function (formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
  };

  // LIKE BUTTON HANDLER
  const likeBtn = document.getElementById("like-btn");
  if (likeBtn) {
    likeBtn.addEventListener("click", () => {
      const recipeId = likeBtn.dataset.recipeId;
      fetch("LikeRecipe.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "recipe_id=" + encodeURIComponent(recipeId),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            const countSpan = document.getElementById("like-count");
            countSpan.textContent = data.new_count;
            likeBtn.innerHTML = `${data.liked ? "❤️ Liked" : "🤍 Like"} (<span id="like-count">${data.new_count}</span>)`;
          } else {
            alert("Failed to update like.");
          }
        });
    });
  }

  // ✅ COMMENT HANDLING — Includes refresh + delete
  const commentForm = document.getElementById("comment-form");
  const commentList = document.getElementById("comment-list");
  const currentUserId = parseInt(document.body.dataset.userId || 0);
  const recipeId = parseInt(document.body.dataset.recipeId || 0);

  function createCommentElement(comment) {
    const div = document.createElement("div");
    div.className = "comment";
    div.innerHTML = `<p><strong>${comment.username}</strong>: ${comment.comment_text}</p>`;

    if (comment.user_id == currentUserId) {
      const deleteBtn = document.createElement("button");
      deleteBtn.className = "delete-comment";
      deleteBtn.dataset.commentId = comment.id;
      deleteBtn.textContent = "Delete";
      deleteBtn.addEventListener("click", () => deleteComment(deleteBtn));
      div.appendChild(deleteBtn);
    }

    return div;
  }

  function deleteComment(button) {
    const commentId = button.dataset.commentId;
    fetch("DeleteComment.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: "comment_id=" + encodeURIComponent(commentId),
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          button.parentElement.remove();
        } else {
          alert("Failed to delete comment.");
        }
      })
      .catch(err => console.error("Error deleting comment:", err));
  }

  function loadComments() {
    fetch("GetComments.php?recipe_id=" + recipeId)
      .then(res => res.json())
      .then(comments => {
        console.log(comments); // ✅ should be an array of objects with user_id
        commentList.innerHTML = "";
        comments.forEach(comment => {
          const commentEl = createCommentElement(comment);
          commentList.appendChild(commentEl);
        });
      })
      
      .catch(err => console.error("Error loading comments:", err));
      
  }

  if (commentForm && commentList) {
    loadComments();

    commentForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(commentForm);
      fetch("SubmitComment.php", {
        method: "POST",
        body: formData,
      })
        .then(res => res.json())
        .then(data => {
          console.log("Submit response:", data); // 🔍 Add this line
          if (data.success) {
            const newComment = {
              id: data.comment.id,
              username: data.comment.username,
              comment_text: data.comment.text,
              user_id: currentUserId,
            };
            loadComments(); // reload full comment list

            commentForm.reset();
          } else {
            alert("Failed to submit comment.");
          }
        })
        .catch(err => console.error("Error submitting comment:", err));
    });
  }
    // ✅ MY COMMENTS PAGE — Show user's comments with recipe links
    const userCommentsContainer = document.getElementById("user-comments");

    if (userCommentsContainer) {
      const userId = parseInt(document.body.dataset.userId || 0);
      const recipesById = {};
  
      fetch("../Java Files/RecipeData.json")
        .then(res => res.json())
        .then(recipes => {
          recipes.forEach(r => recipesById[r.id] = r.name);
          return fetch("../Java Files/comments.json");
        })
        .then(res => res.json())
        .then(comments => {
          const myComments = comments.filter(c => c.user_id === userId);
  
          if (myComments.length === 0) {
            userCommentsContainer.innerHTML = "<p>You haven’t made any comments yet.</p>";
            return;
          }
  
          myComments.forEach(comment => {
            const recipeName = recipesById[comment.recipe_id] || "Unknown Recipe";
            const div = document.createElement("div");
            div.className = "comment-card";
            div.style = "border: 1px solid #ccc; padding: 1rem; margin-bottom: 1rem; border-radius: 8px; background: #f9f9f9;";
            div.innerHTML = `
              <p><strong>Recipe:</strong> <a href="Recipe.php?id=${comment.recipe_id}">${recipeName}</a></p>
              <p><strong>Comment:</strong> ${comment.comment_text}</p>
              <p><em>${comment.timestamp}</em></p>
            `;
            userCommentsContainer.appendChild(div);
          });
        })
        .catch(err => {
          console.error("Failed to load user's comments:", err);
          userCommentsContainer.innerHTML = "<p>Unable to load your comments.</p>";
        });
    }
  
});
