const userCardTemplate = document.querySelector("[data-user-template]")
const userCardContainer = document.querySelector("[data-user-cards-container]")
const searchInput = document.querySelector("[data-search]")


let users = []

searchInput.addEventListener("input", e => {
  const value = e.target.value.toLowerCase()
  users.forEach(user => {
  const isVisible = user.name.includes(value) || user.tags.includes(value)
  user.element.classList.toggle("hide", !isVisible)
  })

})

fetch("../Java Files/RecipeData.json")
.then(res => res.json())
.then(data => {
  users = data.map(user => {
    const cardLink = userCardTemplate.content.cloneNode(true).children[0];
    const card = cardLink.querySelector(".card");
    const header = card.querySelector("[data-header]");
    const body = card.querySelector("[data-body]");
    const img = card.querySelector("[data-img]");

    header.textContent = user.name;
    body.textContent = user.tags;
    img.src = user.img || "default.jpg";
    cardLink.href = user.link || "#";

    userCardContainer.append(cardLink);
    return {
      name: user.name,
      tags: user.tags.toLowerCase(),
      element: cardLink
    };
  });
});





function darkMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
  }


  function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
  }


