const darkModeToggle = document.getElementById("dark-mode-toggle");
const body = document.body;

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
    if (button.dataset.menu == "admin") {
      closeSubMenu("notifications");
      toggleSubMenu("admin");
    }
    if (button.dataset.menu == "notifications") {
      closeSubMenu("admin");
      toggleSubMenu("notifications");
    }
  });
});

// --------------------------------------- SIDENAV MENU TOGGLE ------------------------------------

document.getElementById("sidenav-btn").addEventListener("click", () => {
  document.getElementById("side-nav").classList.toggle("opened");
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

// --------------------------------------- TABLE SEARCH BAR ------------------------------------

const dailyReportController =
  "http://localhost/sh-bus-system/backend/controllers/daily-report.php";

function fetchTableData(tableType, searchTerm = "") {
  var xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    dailyReportController +
      "?type=" +
      tableType +
      "&search=" +
      encodeURIComponent(searchTerm),
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById(tableType + "-table-body").innerHTML =
        xhr.responseText;
    }
  };
  xhr.send();
}

function setupSearch(tableType) {
  var searchInput = document.getElementById(tableType + "-search");
  searchInput.addEventListener("keyup", function () {
    fetchTableData(tableType, this.value);
  });
}

// UNCOMMENT WHEN DOING NOTIFICATIONS
// setInterval(function () {
//   fetchTableData("waiting");
//   fetchTableData("approved");
//   fetchTableData("canceled");
// }, 1000);

// Initial fetch without searching
function refreshData() {
  fetchTableData("waiting");
  fetchTableData("approved");
  fetchTableData("canceled");
}

document.addEventListener("DOMContentLoaded", refreshData);

setupSearch("waiting");
setupSearch("approved");
setupSearch("canceled");



// ------------------------------------------- ACTION BUTTONS -------------------------------------------------

function updateStatus(action, studentId) {
  var xhr = new XMLHttpRequest();
  const scriptsPath = "http://localhost/sh-bus-system/backend/scripts/";
  xhr.open(
    "GET",
    scriptsPath +
      "update-status.php?action=" +
      action +
      "&student_id=" +
      studentId,
    true
  );
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        // Update the table row based on the response
        updateTableRow(studentId, response.newStatus);
        refreshData();
        showAlert("success", response.message);
      } else {
        showAlert("error", response.message);
      }
    }
  };
  xhr.send();
}

function updateTableRow(studentId, newStatus) {
  var row = document.querySelector('tr[data-student-id="' + studentId + '"]');
  if (row) {
    // Update the row based on the new status
    row.querySelector(".status-cell").innerText = newStatus;
    row.querySelector(".actions-cell").innerHTML = newActions(
      newStatus,
      studentId
    );
  }
}

function newActions(status, studentId) {
  var actions = "";
  switch (status) {
    case "approved":
      actions = `
              <a href='#' onclick='updateStatus("return_to_waiting", ${studentId})' class='action btn-blue'><i class='fa-solid fa-hourglass-half'></i>Return To Waiting List</a>
              <a href='#' onclick='updateStatus("remove_student", ${studentId})' class='action btn-red'><i class='fa-solid fa-ban'></i>Remove Student</a>`;
      break;
    case "waiting":
      actions = `
              <a href='#' onclick='updateStatus("approve_student", ${studentId})' class='action btn-blue'><i class='fa-solid fa-check'></i>Approve Student</a>
              <a href='#' onclick='updateStatus("decline_student", ${studentId})' class='action btn-red'><i class='fa-solid fa-ban'></i>Decline Student</a>`;
      break;
    case "canceled":
      actions = `
              <a href='#' onclick='updateStatus("approve_student", ${studentId})' class='action btn-blue'><i class='fa-solid fa-check'></i>Approve Student</a>
              <a href='#' onclick='updateStatus("add_to_waiting", ${studentId})' class='action btn-blue'><i class='fa-solid fa-hourglass-half'></i>Add To Waiting List</a>`;
      break;
    default:
      break;
  }
  return actions;
}

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

// ------------------------------------------- DELETE MODAL ---------------------------------------------------
function showModal(studentID) {
  const modal = document.getElementById("delete-modal");
  const ID = studentID;
  localStorage.setItem("student-ID", ID);
  modal.classList.add("opened");
}

function deleteApplication(studentId) {
  studentId = localStorage.getItem("student-ID");
  updateStatus("remove_student", studentId);
}

function closeModal() {
  const modal = document.getElementById("delete-modal");
  modal.classList.remove("opened");
  localStorage.removeItem("student-ID");
}



// ------------------------------------------- DOWNLOAD PDF ---------------------------------------------------

async function downloadPDF(type) {
  const { jsPDF } = window.jspdf;
  const content = document.getElementById(type + "-report");

  // Use html2canvas to convert the content to a canvas image
  html2canvas(content).then((canvas) => {
    const imgData = canvas.toDataURL("image/png");
    const doc = new jsPDF({
      orientation: "portrait",
      unit: "mm",
      format: "a4",
    });

    const imgProps = doc.getImageProperties(imgData);
    const pdfWidth = doc.internal.pageSize.getWidth();
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

    // Add the image to the PDF
    doc.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
    doc.save("document.pdf");
  });
}

function printReport() {
  window.print();
}
