/* code for dec form validation */
document.getElementById("aadhar").addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    const aadharInput = e.target.value;
    const isValid = /^\d{12}$/.test(aadharInput);

    if (!isValid) {
      e.preventDefault(); // Prevent form submission
      document.querySelector(".invalid-feedback").style.display = "block";
      e.target.classList.add("is-invalid");
    } else {
      document.querySelector(".invalid-feedback").style.display = "none";
      e.target.classList.remove("is-invalid");
    }
  }
});

/* code for validating that it shoudl accpet only jepg and ng file format */
document.getElementById("image").addEventListener("change", function (e) {
  const fileInput = e.target;
  const file = fileInput.files[0];
  const validTypes = ["image/jpeg", "image/png"];

  if (file && !validTypes.includes(file.type)) {
    fileInput.value = ""; // Clear the input
    document.querySelector(".invalid-feedback").style.display = "block";
    fileInput.classList.add("is-invalid");
  } else {
    document.querySelector(".invalid-feedback").style.display = "none";
    fileInput.classList.remove("is-invalid");
  }
});
