const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public";

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