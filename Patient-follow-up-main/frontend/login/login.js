const themes = [
    {
        background: "#1A1A2E",
        color: "#FFFFFF",
        primaryColor: "#0F3460"
    },
    {
        background: "#461220",
        color: "#FFFFFF",
        primaryColor: "#E94560"
    },
    {
        background: "#192A51",
        color: "#FFFFFF",
        primaryColor: "#967AA1"
    },
    {
        background: "#F7B267",
        color: "#000000",
        primaryColor: "#F4845F"
    },
    {
        background: "#F25F5C",
        color: "#000000",
        primaryColor: "#642B36"
    },
    {
        background: "#231F20",
        color: "#FFF",
        primaryColor: "#BB4430"
    }
];

const setTheme = (theme) => {
    const root = document.querySelector(":root");
    root.style.setProperty("--background", theme.background);
    root.style.setProperty("--color", theme.color);
    root.style.setProperty("--primary-color", theme.primaryColor);
    root.style.setProperty("--glass-color", theme.glassColor);
};

const displayThemeButtons = () => {
    const btnContainer = document.querySelector(".theme-btn-container");
    themes.forEach((theme) => {
        const div = document.createElement("div");
        div.className = "theme-btn";
        div.style.cssText = `background: ${theme.background}; width: 25px; height: 25px`;
        btnContainer.appendChild(div);
        div.addEventListener("click", () => setTheme(theme));
    });
};

displayThemeButtons();

//login part
document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    const errorMessageElement = document.getElementById("error-message");
    errorMessageElement.textContent = "";

    if(username.length==0){
        displayError("username is empty.");
        return;
    }

    // Validate password length
    if (password.length < 8) {
      displayError("Password must be at least 8 characters long.");
      return;
    }

    // If validation passes, send data to the backend
    loginUser(username, password);
  });

function loginUser(username, password) {
  fetch("http://localhost/finalProject/api/login.php", {
    
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ username, password }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.message === "Login successful") {

        const encryptedRole = CryptoJS.AES.encrypt(data.role, 'secret').toString();
        // Redirect to the other page on successful login
         localStorage.setItem("userId", data.id);
         localStorage.setItem("username", username);
         localStorage.setItem("role", encryptedRole);
       console.log(data)
        window.location = "../dashboard-pages/dashboard.html";
      } else {
        // Display error message from backend
        displayError(data.message);
      }
    })
    .catch((error) => {
      // Display general error message if the request fails
      console.log(error);
      displayError("An error occurred. Please try again.");
    });
}

function displayError(message) {
  const errorMessageElement = document.getElementById("error-message");
  errorMessageElement.textContent = message;
  errorMessageElement.style.color = "red";
}



//onload
document.addEventListener("DOMContentLoaded", function () {
  logout()
});


function logout() {
  // Remove user information from local storage
  localStorage.removeItem("userId");
  localStorage.removeItem("role");
  localStorage.removeItem("username");

  // Redirect to login page
 
}
