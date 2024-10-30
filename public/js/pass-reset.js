const passwordInput = document.getElementById("password");
const pwdIcon = document.getElementById("eyeIcon");
const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public";

import { showAlert, showAlertBox, hideAlertBox } from "./alerts.js";
import * as validators from "./form-validation.js";

window.validateEmail = validators.validateEmail;
window.validateLoginPassword = validators.validateLoginPassword;

// Password visibility eye icon toggler
function showPassword() {
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    pwdIcon.classList.remove("fa-eye");
    pwdIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    pwdIcon.classList.remove("fa-eye-slash");
    pwdIcon.classList.add("fa-eye");
  }
}
if(pwdIcon) {
    pwdIcon.addEventListener("click", showPassword);
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

// Form buttons
const resetSubmitBtn = document.getElementById("p-reset-submit");
const requestSubmitBtn = document.getElementById("p-request-submit");

if (resetSubmitBtn) {
  resetSubmitBtn.addEventListener("click", processForms);
} else if (requestSubmitBtn) {
  requestSubmitBtn.addEventListener("click", processForms);
}

// Process Form and Send Link

function processForms(e) {
  e.preventDefault();

  const SERVER = "http://localhost/sh-bus-system/backend/";

  // Validate fields again for submission
  let botCheck = validators.validateBotCheck();

  let form = document.getElementsByTagName("form")[0];
  let formID = form.getAttribute("id");

  switch (formID) {
    case "p-request":
      localStorage.setItem("buttonId", "p-request-loader");
      let email = validators.validateEmail(
        document.getElementById("email"),
        "email-error"
      );
      if (email && botCheck) {
        // Call the function with form data
        sendAjaxRequest(SERVER + "scripts/send-reset-link.php", {
          name: "email",
          value: email,
        });
      } else {
        showAlert("error", "Please fix all errors and try again");
      }
      break;

    case "p-reset":
      localStorage.setItem("buttonId", "p-reset-loader");
      let pwd = validators.validateLoginPassword(
        document.getElementById("password"),
        "password-error"
      );
      if (pwd && botCheck) {
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }
        
        // Call the function with form data
        sendAjaxRequest(SERVER + "scripts/update-password.php", 
          {name: "password", value: pwd},
          {name: "email", value: getQueryParam('email')} //Get email from the reset link in the URL
        );
      } else {
        showAlert("error", "Please fix all errors and try again");
      }
      break;
  }
}

function sendAjaxRequest(url, ...fields) {
  let params = new URLSearchParams();
  var buttonId = localStorage.getItem("buttonId");
  showLoader(buttonId);
  fields.forEach(field => {
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
          showAlert("success", response.error);
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
