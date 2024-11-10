const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public";
const SERVER = "http://localhost/sh-bus-system/backend/";

// --------------------------------------- NAV SUB MENU TOGGLE ------------------------------------
const menuBtn = document.getElementById("dropdown-icon");

function toggleSubMenu() {
  var menu = document.getElementById("user-menu");
  menu.classList.toggle("active");
}

menuBtn.addEventListener("click", toggleSubMenu);

// --------------------------------------- DARK MODE HANDLER ------------------------------------

// Check if a dark mode cookie exists
const isDarkMode = getCookie("darkMode");

// Set the initial mode based on the cookie or default to light mode
if (isDarkMode === "true") {
  body.classList.add("dark");
  updateDarkContent();
} else {
  updateLightContent();
}

// Function to set a cookie
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// Function to get a cookie value
function getCookie(name) {
  const keyValue = document.cookie.match("(^|;) ?" + name + "=([^;]*)(;|$)");
  return keyValue ? keyValue[2] : null;
}

// Functions to update content based on theme
function updateDarkContent() {
  const logos = document.querySelectorAll("#logo");

  darkModeToggle.title = "Switch To Light Mode";
  logos.forEach((logo) => {
    logo.src = BASE_URL + "/images/logo-dark.svg";
    console.log(logo.src);
  });
}
function updateLightContent() {
  const logos = document.querySelectorAll("#logo");

  darkModeToggle.title = "Switch To Dark Mode";
  logos.forEach((logo) => {
    logo.src = BASE_URL + "/images/logo.svg";
  });
}

//Toggle between light and dark mode
darkModeToggle.addEventListener("click", function () {
  body.classList.toggle("dark");

  const isDarkModeActive = body.classList.contains("dark");
  setCookie("darkMode", isDarkModeActive.toString(), 365);

  if (isDarkModeActive) {
    updateDarkContent();
  } else {
    updateLightContent();
  }
});

// ------------------------------------------- ALERTS FUNCTIONS -----------------------------------------------

function showAlertBox(type, message) {
  var alertBox = document.getElementById("alert");
  var messageBox = document.getElementById("alert-message");
  var icon = document.getElementById("alert-icon");

  alertBox.classList.add("show");
  alertBox.classList.add(type);

  if (type == "error") {
    icon.classList.add("fa-circle-xmark");
  } else {
    icon.classList.add("fa-circle-check");
  }

  messageBox.innerHTML = message;
}

function hideAlertBox(type) {
  var alertBox = document.getElementById("alert");
  var messageBox = document.getElementById("alert-message");

  alertBox.classList.remove("show");
  alertBox.classList.remove(type);
  messageBox.innerHTML = "";
}

function showAlert(type, message) {
  const intervalId = setInterval(showAlertBox(type, message), 1000);

  setTimeout(() => {
    clearInterval(intervalId);
    hideAlertBox(type);
  }, 5000);
}

// ------------------------------------------- DELETE MODAL -------------------------------------------------------------

function showModal(studentID) {
  const modal = document.getElementById("delete-modal");
  const ID = studentID;
  localStorage.setItem("student-ID", ID);
  modal.classList.add("opened");
}

function deleteApplication() {
  studentId = localStorage.getItem("student-ID");
  if(studentId){
  fetch(SERVER + "/scripts/delete.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `studentId=${studentId}`,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        showAlert("success","Application deleted successfully.");
        closeModal();
        setTimeout(() => {location.reload();}, 5000); //Reload page after alert
      } else {
        showAlert("error", "Failed to delete application: " + data.error);
      }
    })
    .catch((error) => showAlert("error", error));
} else {
    showAlert("error", "Cannot Delete: No learner ID");
}
} 
function closeModal() {
  const modal = document.getElementById("delete-modal");
  modal.classList.remove("opened");
  localStorage.removeItem("student-ID");
}

// ------------------------------------------ FETCH LEARNERS FROM DB ------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {
  fetch(SERVER + "/controllers/view-status.php")
    .then((response) => response.json())
    .then((data) => {
      const learnerStatusBody = document.getElementById("learner-status-body");
      learnerStatusBody.innerHTML = "";

      data.forEach((learner) => {
        const row = `
                    <tr>
                        <td>${learner.studentName}</td>
                        <td>${learner.grade}</td>
                        <td>${learner.tel}</td>
                        <td>${learner.bus_name}</td>
                        <td>${learner.morning_use ? "Yes" : "No"}</td>
                        <td>${learner.afternoon_use ? "Yes" : "No"}</td>
                        <td>${learner.status}</td>
                        <td><button class="action btn-red" onclick="showModal(${
                          learner.studentId
                        })"><i class="fa-solid fa-trash-can"></i>Delete Application</button></td>
                    </tr>
                `;
        learnerStatusBody.innerHTML += row;
      });
    })
    .catch((error) => console.error(error));
});
