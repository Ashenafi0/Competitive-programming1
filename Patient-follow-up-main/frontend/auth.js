// Function to check if the user is logged in and their role
function checkAuth(requiredRoles, redirectPath) {
  const userId = localStorage.getItem("userId");
  const encryptedRole = localStorage.getItem("role");

  if (!userId || !encryptedRole) {
    // If userId or role is not found in localStorage, redirect to login page
    redirectTo(redirectPath);
    return;
  }

  try {
    // Decrypt the role
    const bytes = CryptoJS.AES.decrypt(encryptedRole, "secret");
    const role = bytes.toString(CryptoJS.enc.Utf8);

    if (!requiredRoles.includes(role)) {
      // If the role is not in the required roles array, redirect to the specified path
      redirectTo(redirectPath);
      return;
    }

    // If the user is logged in and has one of the required roles, allow access to the page
    console.log(
      `User is authenticated and authorized as one of the roles: ${requiredRoles.join(
        ", "
      )}.`
    );
  } catch (error) {
    // If there is an error during decryption, redirect to the specified path
    console.error("Error decrypting role:", error);
    redirectTo(redirectPath);
  }
}

function redirectTo(path) {
  window.location = path;
}



