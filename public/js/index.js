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
pwdIcon.addEventListener("click", function () {
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

if (passwordInput && pwdConditions) {
  passwordInput.addEventListener("focus", function () {
    pwdConditions.classList.toggle("focused");
  });

  passwordInput.addEventListener("blur", function () {
    pwdConditions.classList.remove("focused");
  });
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

// --------------------------------------- FORM SUBMISSION -------------------------------------------------

const adminSubmitBtn = document.getElementById("admin-submit");
const loginSubmitBtn = document.getElementById("login-submit");

if (adminSubmitBtn) {
  adminSubmitBtn.addEventListener("click", login);
} else {
  loginSubmitBtn.addEventListener("click", login);
}

function login(e) {
  e.preventDefault();
  const SERVER = "http://localhost/sh-bus-system/backend/";
  localStorage.setItem("buttonId", "admin-loader");

  // Validate fields again for submission
  let email = validators.validateEmail(
    document.getElementById("email"),
    "email-error"
  );
  let password = validators.validateLoginPassword(
    document.getElementById("password"),
    "password-error"
  );

  let botCheck = validators.validateBotCheck();
  let form = document.getElementsByTagName("form")[0];
  let formID = form.getAttribute("id");

  switch (formID) {
    case "admin-form":
      let adminID = validators.validateAdminID(
        document.getElementById("admin-id"),
        "admin-id-error"
      );

      if (email && password && adminID && botCheck) {
        // Call the function with form data
        sendAjaxRequest(
          SERVER + "scripts/login.php",
          { name: "email", value: email },
          { name: "password", value: password },
          { name: "admin_id", value: adminID }
        );
      } else {
        showAlert("error", "Please fix all errors and try again");
      }
      break;

    case "user-login":
      if (email && password && botCheck) {
        // Call the function with form data
        sendAjaxRequest(
          SERVER + "scripts/login.php",
          { name: "email", value: email },
          { name: "password", value: password }
        );
      } else {
        showAlert("error", "Please fix all errors and try again");
      }
      break;

    default:
      console.log("Form Error");
      break;
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
