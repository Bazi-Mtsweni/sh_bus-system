export function showAlertBox(type, message){
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

export function hideAlertBox(type) {
  var alertBox = document.getElementById("alert");
  var messageBox = document.getElementById("alert-message");

  alertBox.classList.remove("show");
  alertBox.classList.remove(type);
  messageBox.innerHTML = "";
}

export function showAlert(type, message) {
  const intervalId = setInterval(showAlertBox(type, message), 1000); 

  setTimeout(() => {
      clearInterval(intervalId);
      hideAlertBox(type);
  }, 5000); 
}