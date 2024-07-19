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

document.addEventListener("DOMContentLoaded", function() {
  const dailyReportController = "http://localhost/sh-bus-system/backend/controllers/daily-report.php";
  function fetchTableData(tableType, searchTerm = "") {
    console.log(tableType);
    var xhr = new XMLHttpRequest();
    xhr.open("GET", dailyReportController + "?type=" + tableType + "&search=" + encodeURIComponent(searchTerm), true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(tableType + "-table-body").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
  }

  function setupSearch(tableType) {
    var searchInput = document.getElementById(tableType + "-search");
    searchInput.addEventListener("keyup", function() {
        fetchTableData(tableType, this.value);
    });
  }

  setupSearch("waiting");
  setupSearch("approved");
  setupSearch("canceled");

  // Initial fetch without searching
  fetchTableData("waiting");
  fetchTableData("approved");
  fetchTableData("canceled");
});

// ------------------------------------------- DOWNLOAD PDF ---------------------------------------------------

async function downloadPDF(type) {
  const { jsPDF } = window.jspdf;
  const content = document.getElementById(type + '-report');

  // Use html2canvas to convert the content to a canvas image
  html2canvas(content).then(canvas => {
      const imgData = canvas.toDataURL('image/png');
      const doc = new jsPDF({
          orientation: 'portrait',
          unit: 'mm',
          format: 'a4'
      });

      const imgProps = doc.getImageProperties(imgData);
      const pdfWidth = doc.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      // Add the image to the PDF
      doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
      doc.save('document.pdf');
  });
}

function printReport() {
  window.print();
}