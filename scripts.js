document.addEventListener("DOMContentLoaded", function () {
  // Funksjon for å åpne admin modal
  const adminLink = document.getElementById("admin-link");
  if (adminLink) {
    adminLink.addEventListener("click", function (event) {
      event.preventDefault();
      const modal = document.getElementById("admin-login-modal");
      if (modal) modal.style.display = "block";
    });
  }

  // Funksjon for å lukke modal ved å klikke på 'x'
  const closeModalButton = document.querySelector(".close");
  if (closeModalButton) {
    closeModalButton.addEventListener("click", function () {
      const modal = document.getElementById("admin-login-modal");
      if (modal) modal.style.display = "none";
    });
  }

  // Lukk modal ved å klikke utenfor modalvinduet
  window.addEventListener("click", function (event) {
    const modal = document.getElementById("admin-login-modal");
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // Bekreftelse ved innsending av bestillingsskjema
  const bookingForm = document.getElementById("bookingForm");
  if (bookingForm) {
    bookingForm.addEventListener("submit", function (event) {
      event.preventDefault();
      alert("Din bestilling er bekreftet!");

      const formData = new FormData(this);
      fetch("your_booking_handler.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
          window.location.reload();
        })
        .catch((error) => console.error("Feil ved innsending:", error));
    });
  }

  // Dynamisk last inn matretter i valgmenyen
  function loadMenuItems() {
    const menuItems = document.querySelectorAll(".menu-item");
    const mainDishSelect = document.getElementById("main-dish");

    if (menuItems.length && mainDishSelect) {
      mainDishSelect.innerHTML = '<option value="">Velg en hovedrett</option>';

      menuItems.forEach((item) => {
        const option = document.createElement("option");
        option.value = item.getAttribute("data-name");
        option.textContent = `${item.getAttribute("data-name")} - ${item.getAttribute("data-price")} NOK`;
        mainDishSelect.appendChild(option);
      });
    }
  }

  // Kjør funksjon ved lasting av vinduet
  loadMenuItems();
});
