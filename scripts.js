document.getElementById("admin-link").onclick = function (event) {
  event.preventDefault();
  document.getElementById("admin-login-modal").style.display = "block";
};

// Lukk modal når man klikker på 'x' eller utenfor modalvinduet
document.querySelector(".close").onclick = function () {
  document.getElementById("admin-login-modal").style.display = "none";
};

window.onclick = function (event) {
  if (event.target == document.getElementById("admin-login-modal")) {
    document.getElementById("admin-login-modal").style.display = "none";
  }
};

// Bekreftelse på innsending av bestillingsskjema
document.getElementById("bookingForm").addEventListener("submit", function (event) {
  event.preventDefault();
  alert("Din bestilling er bekreftet!");
});

// Dynamisk last inn matretter i valgmenyen for bestilling
function loadMenuItems() {
  const menuItems = document.querySelectorAll(".menu-item");
  const foodSelection = document.getElementById("foodSelection");

  menuItems.forEach((item) => {
    const option = document.createElement("option");
    option.value = item.dataset.name;
    option.textContent = `${item.dataset.name} - ${item.dataset.price} NOK`;
    foodSelection.appendChild(option);
  });
  let slideIndex = 0;
  showSlides();

  function showSlides() {
    const slides = document.querySelectorAll(".slide");
    slides.forEach((slide) => (slide.style.display = "none"));

    slideIndex++;
    if (slideIndex > slides.length) {
      slideIndex = 1;
    }
    slides[slideIndex - 1].style.display = "block";

    setTimeout(showSlides, 3000); // Endrer bilde hvert 3. sekund
  }
}

window.onload = loadMenuItems;
