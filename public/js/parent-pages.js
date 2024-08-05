const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public";

import { showAlert, showAlertBox, hideAlertBox } from "./alerts.js";
import { validateName, validateRSAID, luhnCheck, validateTel, validateBotCheck } from "./form-validation.js" ;

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

// --------------------------------------- FORM VALIDATION ------------------------------------
window.validateName = validateName;
window.validateRSAID = validateRSAID;
window.validateTel = validateTel;
window.validateBotCheck = validateBotCheck;

const nextButton = document.getElementById("next-button");
nextButton.addEventListener("click", login);

function login(e) {
  e.preventDefault();

  const SERVER = "http://localhost/sh-bus-system/backend/";
  localStorage.setItem("buttonId", "next-loader");

  // Validate fields again for submission
  let name = validateName(
    document.getElementById("name"),
    "name-error"
  );
  let tel = validateTel(
    document.getElementById("tel"),
    "tel-error"
  );

  if (name && tel) {
    // Get grade
    let grade = document.getElementById("grade").value;

    // Call the function with form data
    sendAjaxRequest(
      SERVER + "scripts/learner.php",
      { name: "name", value: name },
      { name: "tel", value: tel },
      { name: "grade", value: grade }
    );
  } else {
    showAlert("error", "Please fix all errors and try again");
  }
}

function sendAjaxRequest(url, ...fields) {
  let params = new URLSearchParams();
  var buttonId = localStorage.getItem("buttonId");
  showLoader(buttonId);
  fields.forEach((field) => {
    if (field.name && field.value) {
      params.append(field.name, field.value);
    }
  });

  // Initialize the XMLHttpRequest
  var xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4) {
      hideLoader(buttonId);
      // showAlert("success", "Success! Redirecting...");
      if (xhr.status == 200) {
        var response = JSON.parse(xhr.responseText);
        console.log(response);
        if (response.success) {
          window.location.href = response.redirect;
        } else {
          showAlert("error", response.error);
        }
      } else {
        showAlert(
          "error",
          "Error: Message could not be sent. Please try again later."
        );
      }
    }
  };
  xhr.send(params);
}

function showLoader(buttonId) {
  var loader = document.getElementById(buttonId);
  loader.style.display = "inline";
}

function hideLoader(buttonId) {
  var loader = document.getElementById(buttonId);
  loader.style.display = "none";
  localStorage.removeItem(buttonId);
}