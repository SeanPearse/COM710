function darkMode() {
    var element = document.body;
    element.classList.toggle("dark-mode");
  }


  function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
  }