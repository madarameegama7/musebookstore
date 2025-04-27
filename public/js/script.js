// public/js/script.js

document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById("swapBtn");
  
    if (button) {
      button.addEventListener("click", function () {
        alert("📬 Book swap request sent to the owner!");
      });
    }
  });
  