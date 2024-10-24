// Function to navigate to different pages
function navigateTo(page) {
    window.location.href = `${page}`;
}

// Function to handle logout
function logout() {
    // Clear session storage
    sessionStorage.clear();
    // Redirect to login page
    window.location.href = '/login';
}

// Display the welcome message
document.addEventListener('DOMContentLoaded', function() {
    const user = sessionStorage.getItem('username') || 'User';
    document.getElementById('welcome-message').innerText = `Welcome, ${user}!`;
});

//auth
//auth
window.onload = function () {
  checkAuth(["doctor", "admin"], "../login/login.html");
  // Decrypt the role
  const encryptedRole = localStorage.getItem("role");

  const bytes = CryptoJS.AES.decrypt(encryptedRole, "secret");
  const role = bytes.toString(CryptoJS.enc.Utf8);
  console.log(role)
hideButtonsBasedOnRole(role);
};


function logout() {
  // Remove user information from local storage
  localStorage.removeItem("userId");
  localStorage.removeItem("role");
  localStorage.removeItem("username");

  // Redirect to login page
  window.location = "../login/login.html";
}

//
function hideButtonsBasedOnRole(role) {
  const patientsButton = document.getElementById("patients-button");
  const doctorsButton = document.getElementById("doctors-button");

  if (role === 'admin') {
    patientsButton.style.display = 'none';
  } else if (role === 'doctor') {
    doctorsButton.style.display = 'none';
  }
}