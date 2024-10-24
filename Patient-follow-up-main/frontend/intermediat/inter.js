document.addEventListener("DOMContentLoaded", function () {
  checkAuth(["doctor"], "../login/login.html");
});

// Function to redirect to a given URL
function redirectTo(url) {
  window.location = url;
}

// Get references to the buttons
const diagnosisBtn = document.getElementById("diagnosisBtn");
const treatmentBtn = document.getElementById("treatmentBtn");
const medicationBtn = document.getElementById("medicationBtn");
const follow_up = document.getElementById("Follow-Upsbtn");


 const urlParams = new URLSearchParams(window.location.search);
 const visitId = urlParams.get("visit_id");
// Add click event listeners to each button, using the redirectTo function
diagnosisBtn.addEventListener("click", function () {
  redirectTo(`../diagnoses-page/diagnoses.html?visit_id=${visitId}`);
});

treatmentBtn.addEventListener("click", function () {
  redirectTo(`../treatment-page/treatment.html?visit_id=${visitId}`);
});

medicationBtn.addEventListener("click", function () {
  redirectTo(`../medications-page/medication.html?visit_id=${visitId}`);
});

follow_up.addEventListener("click", function () {
  redirectTo(`../followup-page/followup.html?visit_id=${visitId}`);
});
