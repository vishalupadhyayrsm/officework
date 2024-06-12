/* code for cheking switching the tab start here  */
function showTab(tabId) {
  var tabs = document.querySelectorAll(".tab-content");
  tabs.forEach(function (tab) {
    tab.classList.remove("active-tab");
  });
  var selectedTab = document.getElementById(tabId);
  selectedTab.classList.add("active-tab");
}

/* code for decelration form validation start here */
document.getElementById("localadd").addEventListener("input", function (e) {
  const input = e.target;
  const errorMessage = document.getElementById("error-message");
  if (input.value.length !== 6) {
    errorMessage.style.display = "block";
  } else {
    errorMessage.style.display = "none";
  }
});
