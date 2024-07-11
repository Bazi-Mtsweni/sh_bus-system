const passwordInput = document.getElementById("password");
const pwdIcon = document.getElementById("eyeIcon");
const pwdConditions = document.querySelector(".conditions");
const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public"; 

import { showAlert, showAlertBox, hideAlertBox } from "./alerts.js";
import * as validators from "./form-validation.js";

// ----------------------------------------------- FORM VALIDTAION ----------------------------

window.validateName = validators.validateName;
window.validateUsername = validators.validateUsername;
window.validateRSAID = validators.validateRSAID;
window.validateEmail = validators.validateEmail;
window.validateTel = validators.validateTel;
window.validatePassword = validators.validatePassword;
window.validateLoginPassword = validators.validateLoginPassword;
window.matchPasswords = validators.matchPasswords;
window.validateAdminID = validators.validateAdminID;

// Password visibility eye icon toggler
pwdIcon.addEventListener("click", function() {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    pwdIcon.classList.remove("fa-eye");
    pwdIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    pwdIcon.classList.remove("fa-eye-slash");
    pwdIcon.classList.add("fa-eye");
  }
});

if(passwordInput && pwdConditions) {
  passwordInput.addEventListener("focus", function(){
    pwdConditions.classList.toggle("focused");
  })

  passwordInput.addEventListener("blur", function(){
    pwdConditions.classList.remove("focused");
  })
}


// --------------------------------------- NAV SUB MENU TOGGLE ------------------------------------

function toggleSubMenu(button) {
  var menu = document.querySelector(".sub-menu." + button);
  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  } else {
    menu.classList.add("active");
  }
}
function closeSubMenu(button) {
  var menu = document.querySelector(".sub-menu." + button);
  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  }
}

const buttons = document.querySelectorAll("#dropdown-icon");
buttons.forEach(function (button) {
  button.addEventListener("click", () => {
    if (button.dataset.menu == "academics") {
      closeSubMenu("apply");
      toggleSubMenu("academics");
    }
    if (button.dataset.menu == "apply") {
      closeSubMenu("academics");
      toggleSubMenu("apply");
    }
  });
});



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