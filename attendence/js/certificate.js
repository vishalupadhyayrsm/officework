document.addEventListener("DOMContentLoaded", () => {
  const openPopupBtn = document.getElementById("openPopupBtn");
  const popupForm = document.getElementById("popupForm");
  const closeBtn = document.querySelector(".close");

  openPopupBtn.addEventListener("click", () => {
    popupForm.style.display = "block";
  });

  closeBtn.addEventListener("click", () => {
    popupForm.style.display = "none";
  });

  window.addEventListener("click", (event) => {
    if (event.target === popupForm) {
      popupForm.style.display = "none";
    }
  });

  const certificateForm = document.getElementById("certificateForm");
  certificateForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(certificateForm);

    fetch("your-server-endpoint", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        alert("Certificate sent successfully!");
        popupForm.style.display = "none";
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Failed to send certificate.");
      });
  });
});

/* code for creating the gatepass model  */

document.addEventListener("DOMContentLoaded", () => {
  const openPopupBtn = document.getElementById("openPopupBtngatepass");
  const popupForm = document.getElementById("popupFormgatepass");
  const closeBtn = document.querySelector(".close");

  openPopupBtn.addEventListener("click", () => {
    popupForm.style.display = "block";
  });

  closeBtn.addEventListener("click", () => {
    popupForm.style.display = "none";
  });

  window.addEventListener("click", (event) => {
    if (event.target === popupForm) {
      popupForm.style.display = "none";
    }
  });

  // const certificateForm = document.getElementById("certificateForm");
  // certificateForm.addEventListener("submit", (event) => {
  //   event.preventDefault();

  //   const formData = new FormData(certificateForm);

  //   fetch("your-server-endpoint", {
  //     method: "POST",
  //     body: formData,
  //   })
  //     .then((response) => response.json())
  //     .then((data) => {
  //       alert("Certificate sent successfully!");
  //       popupForm.style.display = "none";
  //     })
  //     .catch((error) => {
  //       console.error("Error:", error);
  //       alert("Failed to send certificate.");
  //     });
  // });
});
