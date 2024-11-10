const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;
const BASE_URL = "http://localhost/sh-bus-system/public";
const SERVER = "http://localhost/sh-bus-system/backend/";

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
if(nextButton){
  nextButton.addEventListener("click", saveData);
}

// Store part 1 data in a session storage
function saveData(e) {
  e.preventDefault();

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

    // Save data to local storage
    const learnerData = {
      name: name,
      grade: grade,
      tel: tel
    }

    sessionStorage.setItem("learnerData", JSON.stringify(learnerData));
    window.location.href = BASE_URL + "/views/forms/bus-form.php";

  } else {
    showAlert("error", "Please fix all errors and try again");
  }
}

function sendAjaxRequest(url, dataObject) {
  let params = new URLSearchParams();
  var buttonId = localStorage.getItem("buttonId");
  showLoader(buttonId);
  
  // Add each key-value pair in dataObject to params
  for (const key in dataObject) {
    if (dataObject.hasOwnProperty(key) && dataObject[key] !== null) {
      params.append(key, dataObject[key]);
    }
  }

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
  var loaderId = buttonId.replace('button', 'loader');
  var loader = document.getElementById(loaderId);
  loader.style.display = "inline";
}

function hideLoader(buttonId) {
  var loaderId = buttonId.replace('button', 'loader');
  var loader = document.getElementById(loaderId);
  loader.style.display = "none";
  localStorage.removeItem(buttonId);
}


// --------------------------------------------------- GET BUS DATA --------------------------------------------------

const busTabs = document.querySelectorAll(".bus-tab");
if (busTabs) {  
    busTabs.forEach((tab) => {
        tab.addEventListener("click", function () {
            // Removes 'active' class from all tabs and add it to the clicked one
            busTabs.forEach((t) => t.classList.remove("active"));
            this.classList.add("active");

            const busNumber = this.getAttribute("data-bus");

            // Call function to fetch and display data for selected bus
            fetchBusData(busNumber);
        });
    });
}

function fetchBusData(busNumber) {
    // AJAX request to fetch data for the selected bus
    fetch(SERVER + `/scripts/fetch_bus_data.php?bus_number=${busNumber}`)
        .then((response) => response.json())
        .then((data) => {
            const pickupBody = document.getElementById("pickup-body");
            const dropoffBody = document.getElementById("dropoff-body");

            // Clear current table contents
            pickupBody.innerHTML = "";
            dropoffBody.innerHTML = "";

            // Populate Morning Pickup Table
            data.morning_pickups.forEach((pickup) => {
                const row = `<tr>
                    <td>${pickup.number}</td>
                    <td>${pickup.location}</td>
                    <td>${pickup.time}</td>
                </tr>`;
                pickupBody.innerHTML += row;
            });

            // Populate Afternoon Dropoff Table
            data.afternoon_dropoffs.forEach((dropoff) => {
                const row = `<tr>
                    <td>${dropoff.number}</td>
                    <td>${dropoff.location}</td>
                    <td>${dropoff.time}</td>
                </tr>`;
                dropoffBody.innerHTML += row;
            });
        })
        .catch((error) => showAlert("error", error));
}


// ----------------------------------------------- POPULATE FORMS ON SELECT --------------------------------------------


const bus = document.getElementById("bus");

if(bus) {
  bus.addEventListener("change", function () {
    const busNumber = this.value;
    if (busNumber) {
        populateFormDropdowns(busNumber);
    } else {
        // Clear the form if no bus is selected
        document.getElementById("pickup-location").innerHTML = `<option value="">-- Select A Bus First --</option>`;
        document.getElementById("dropoff-location").innerHTML = `<option value="">-- Select A Bus First --</option>`;
        document.getElementById("pickup-time").value = "";
        document.getElementById("dropoff-time").value = "";
    }
  });
}

function populateFormDropdowns(busNumber) {
  fetch(SERVER + `/scripts/fetch_bus_data.php?bus_number=${busNumber}`)
      .then((response) => response.json())
      .then((data) => {
          // Populate form dropdowns
          const pickupLocationSelect = document.getElementById("pickup-location");
          const dropoffLocationSelect = document.getElementById("dropoff-location");

          pickupLocationSelect.innerHTML = `<option value="">-- Select Pickup Location --</option>`;
          dropoffLocationSelect.innerHTML = `<option value="">-- Select Dropoff Location --</option>`;

          data.morning_pickups.forEach((pickup) => {
              const option = `<option value="${pickup.number}">${pickup.location}</option>`;
              pickupLocationSelect.innerHTML += option;
          });

          data.afternoon_dropoffs.forEach((dropoff) => {
              const option = `<option value="${dropoff.number}">${dropoff.location}</option>`;
              dropoffLocationSelect.innerHTML += option;
          });

          // Set times on location change
          pickupLocationSelect.addEventListener("change", function () {
              const selectedPickup = data.morning_pickups.find(pickup => pickup.number === this.value);
              document.getElementById("pickup-time").value = selectedPickup ? selectedPickup.time : "";
          });

          dropoffLocationSelect.addEventListener("change", function () {
              const selectedDropoff = data.afternoon_dropoffs.find(dropoff => dropoff.number === this.value);              
              document.getElementById("dropoff-time").value = selectedDropoff ? selectedDropoff.time : "";
          });
      })
      .catch((error) => showAlert("error", error));
}

// Retrieve part 1 data and combine with part 2 data and send everything

const submitBtn = document.getElementById("submit-button");
if (submitBtn) {
  submitBtn.addEventListener("click", (e) => {
    e.preventDefault();

    localStorage.setItem("buttonId", "submit-button");
    
    const busSelected = document.getElementById("bus").value;
    const pickupLocation = document.getElementById("pickup-location").value;
    const dropoffLocation = document.getElementById("dropoff-location").value;
    const pickupTime = document.getElementById("pickup-time").value;
    const dropoffTime = document.getElementById("dropoff-time").value;

    // Tiny validation for part 2 before send, you can't trust people
    if(busSelected == ""){
      showAlert("error", "You cannot submit an empty form");
    } else if(pickupLocation == "" && dropoffLocation == "") {
      showAlert("error", "Please select atleast 1 location");
    } else {

      //Validation passed, process form data. First get the data from session storage...
      const learnerData = JSON.parse(sessionStorage.getItem("learnerData"));
      
      const busData = {
        bus: busSelected,
        pickup: pickupLocation || null,
        dropoff: dropoffLocation || null,
        pickupTime: pickupTime || null,
        dropoffTime: dropoffTime || null
      }

      //combine 2 data sets using a spread 
      const completeData = {...learnerData, ...busData}

      sendAjaxRequest(SERVER + '/scripts/register-learner.php', completeData);
    }

  })
}