export function validateName(input, error) {
  const name = input.value;
  const nameError = document.getElementById(error);

  if (name.length == 0) {
    nameError.innerHTML = "Name is required";
    return false;
  }
  if (!name.match(/^[A-Za-z]*\s{1}[A-Za-z]{1,}$/)) {
    nameError.innerHTML = "Please write your full name";
    return false;
  }
  nameError.innerHTML = " ";
  return name;
}

export function validateUsername(input, error) {
  const username = input.value;
  const usernameError = document.getElementById(error);

  if (username.length == 0) {
    usernameError.innerHTML = "Username is required";
    return false;
  }
  usernameError.innerHTML = " ";
  return username;
}

export function luhnCheck(idNumber) {
  let sum = 0;
  let alternate = false;
  for (let i = idNumber.length - 1; i >= 0; i--) {
    let n = parseInt(idNumber.charAt(i), 10);
    if (alternate) {
      n *= 2;
      if (n > 9) {
        n = (n % 10) + 1;
      }
    }
    sum += n;
    alternate = !alternate;
  }
  return sum % 10 == 0;
}

export function validateRSAID(input, error) {
  const idNumber = input.value;
  const idNumberError = document.getElementById(error);
  const rsaIdRegex = /^(\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])\d{4}[01][89]\d$/;

  if (idNumber.length == 0) {
    idNumberError.innerHTML = "ID number is required";
    return false;
  }
  if (!rsaIdRegex.test(idNumber)) {
    idNumberError.innerHTML = "Enter a valid RSA ID number";
    return false;
  }
  if (!luhnCheck(idNumber)) {
    idNumberError.innerHTML = "Invalid ID Number";
    return false;
  }
  idNumberError.innerHTML = " ";
  return idNumber;
}

export function validateEmail(input, error) {
  const email = input.value;
  const emailError = document.getElementById(error);

  if (email.length == 0) {
    emailError.innerHTML = "Email required";
    return false;
  }
  if (!email.match(/^[A-Za-z0-9\._\-[0-9]*[@][A-Za-z]*([\.][a-z]{2,6}){1,}$/)) {
    emailError.innerHTML = "Enter a valid email";
    return false;
  }
  emailError.innerHTML = " ";
  return email;
}

export function validateTel(input, error) {
  const tel = input.value;
  const telError = document.getElementById(error);

  if (tel.length == 0) {
    telError.innerHTML = " ";
    return true;
  }
  if (tel.length !== 10) {
    telError.innerHTML = "phone number should be 10 digits";
    return false;
  }
  if (!tel.match(/^0(?! \d+)[0-9]{9}$/)) {
    telError.innerHTML = "Enter a valid phone number";
    return false;
  }
  telError.innerHTML = " ";
  return tel;
}

export function validatePassword(input, error) {
  const password = input.value;
  const passwordError = document.getElementById(error);
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

  if (password.length == 0) {
    passwordError.innerHTML = "Password is required";
    return false;
  }

  // Check each condition
    (password.length >= 8) ? pwdPassed("length-condition", "length-icon") : pwdFail("length-condition", "length-icon");     
    (/(?=.*[a-z])/.test(password)) ? pwdPassed("lowercase-condition", "lowercase-icon") : pwdFail("lowercase-condition", "lowercase-icon");
    (/(?=.*[A-Z])/.test(password)) ? pwdPassed("uppercase-condition", "uppercase-icon") : pwdFail("uppercase-condition", "uppercase-icon");
    (/(?=.*\d)/.test(password)) ? pwdPassed("number-condition", "number-icon") : pwdFail("number-condition", "number-icon");
    (/(?=.*[!@#$%^&*()_+])/.test(password)) ? pwdPassed("specialchar-condition", "specialchar-icon") : pwdFail("specialchar-condition", "specialchar-icon");

    // Validate against full regex pattern
    if (!passwordRegex.test(password)) {
        passwordError.innerHTML = "Password does not meet all criteria";
        return false;
    }

  passwordError.innerHTML = " ";
  return password;
}

export function pwdPassed(condition, icon){
    document.getElementById(condition).classList.add("passed");
    document.getElementById(icon).classList.remove("fa-circle-xmark");
    document.getElementById(icon).classList.add("fa-circle-check");
}
export function pwdFail(condition, icon){
    document.getElementById(condition).classList.remove("passed");
    document.getElementById(icon).classList.remove("fa-circle-check");
    document.getElementById(icon).classList.add("fa-circle-xmark");
}

export function matchPasswords(input, error) {
    const passwordOne = document.getElementById("password").value;
    const passwordTwo = input.value;
    const password2Error = document.getElementById(error);

    if (passwordTwo.length == 0) {
        password2Error.innerHTML = "Please repeat password";
        return false;
    }

    if(passwordTwo !== passwordOne){
        password2Error.innerHTML = "Passwords do not match";
        return false;
    }

    password2Error.innerHTML = " ";
    return passwordTwo;
}

export function validateLoginPassword(input, error){
    const password = input.value;
    const passwordError = document.getElementById(error);
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

    if (password.length == 0) {
        passwordError.innerHTML = "Password is required";
        return false;
    }

    if (!passwordRegex.test(password)) {
        passwordError.innerHTML = "Password does not meet all criteria";
        return false;
    }

  passwordError.innerHTML = " ";
  return password;
}

export function validateAdminID(input, error){
    const adminID = input.value;
    const adminIDError = document.getElementById(error);

    if (adminID.length == 0) {
        adminIDError.innerHTML = "Admin ID is required";
        return false;
    }
    if (adminID !== "ICT3715") {
        adminIDError.innerHTML = "Invalid Admin ID";
        return false;
    }

    adminIDError.innerHTML = " ";
    return adminID;
}

export function validateBotCheck() {
  let check = document.getElementById("bot-check").value;

  if (check != "") {
    console.log("Message failed to submit");
    return false;
  }

  return true;
}
