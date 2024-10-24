document.addEventListener("DOMContentLoaded", function () {
      checkAuth(["doctor"], "../login/login.html");

  const urlParams = new URLSearchParams(window.location.search);
  const patientId = urlParams.get("patient_id");

  if (patientId) {
    console.log(patientId)
    fetchVisits(patientId);
  } else {
    console.error("No patient_id found in URL");
  }
});

function fetchVisits(patientId) {
  fetch(
    `http://localhost/finalProject/api/visit/get_visits.php?patient_id=${patientId}`
  )
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
      const titleRow = document.getElementById("title-row");
      titleRow.innerHTML = ""; // Clear existing content

      data.forEach((visit) => {
        const col = document.createElement("div");
        col.className = "col-6";

        const visitDiv = document.createElement("div");
        visitDiv.className = "title-box";
        visitDiv.innerHTML = `
          <div class="visit-info" style="cursor: pointer;">
            <p>${visit.reason_for_visit}</p>
            <p>Date: ${visit.visited_date}</p>
          </div>
          <button class="btn btn-primary edit-btn" data-id="${visit.visit_id}" data-reason="${visit.reason_for_visit}" data-date="${visit.visited_date}">Edit</button>
        `;

        // Redirect to visit detail page on visit info click
        visitDiv
          .querySelector(".visit-info")
          .addEventListener("click", function () {
            window.location = `../intermediat/intermediat.html?visit_id=${visit.visit_id}`;
          });

        col.appendChild(visitDiv);
        titleRow.appendChild(col);
      });

      // Add event listener to all edit buttons
      document.querySelectorAll(".edit-btn").forEach((button) => {
        button.addEventListener("click", function (event) {
          event.stopPropagation(); // Prevent triggering the visit click event
          const visitId = this.getAttribute("data-id");
          const reason = this.getAttribute("data-reason");
          const date = this.getAttribute("data-date");

          document.getElementById("visit_id").value = visitId;
          document.getElementById("reason_for_visit").value = reason;
          document.getElementById("visited_date").value = date;

          $("#editVisitModal").modal("show");
        });
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
}

// Handle form submission
const editVisitForm = document.getElementById("edit-visit-form");
editVisitForm.addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(editVisitForm);
  const visitId = document.getElementById("visit_id").value;

  fetch(
    `http://localhost/finalProject/api/visit/update_visit.php?visit_id=${visitId}`,
    {
      method: "POST",
      body: JSON.stringify(Object.fromEntries(formData)),
      headers: {
        "Content-Type": "application/json",
      },
    }
  )
    .then((response) => response.json())
    .then((result) => {
      if (result.success) {
        $("#editVisitModal").modal("hide");
        location.reload(); // Refresh the page to show the updated data
      } else {
        document.getElementById("form-message").textContent =
          result.error || "Error updating visit. Please try again.";
      }
    })
    .catch((error) => {
      document.getElementById("form-message").textContent =
        "Error updating visit. Please try again.";
      console.error("Error:", error);
    });
});

// const addVisitButton = document.getElementById("add-visit-button");
// addVisitButton.addEventListener("click", function () {
//   const urlParams = new URLSearchParams(window.location.search);
//   const patientId = urlParams.get("patient_id");
//   window.location.href = `addvisit.html?patient_id=${patientId}`;
// });


//add visit



document
  .getElementById("showVisitFormButton")
  .addEventListener("click", function () {
    document.getElementById("visitFormModal").style.display = "block";

    // Get patient_id from URL query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const patientId = urlParams.get("patient_id");

    // Set patient_id in the hidden input field
    document.getElementById("patient_id_hidden").value = patientId;
  });

document
  .querySelector(".close-button-visit")
  .addEventListener("click", function () {
    document.getElementById("visitFormModal").style.display = "none";
  });

window.addEventListener("click", function (event) {
  if (event.target == document.getElementById("visitFormModal")) {
    document.getElementById("visitFormModal").style.display = "none";
  }
});

document
  .getElementById("visitFormNew")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    const data = {
      patient_id: formData.get("patient_id"),
      reason_for_visit: formData.get("reason_for_visit"),
      visited_date: formData.get("visited_date"),
    };

    fetch(
      "http://localhost/finalProject/api/visit/visits.php?patient_id=" +
        formData.get("patient_id"),
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      }
    )
      .then((response) => response.json())
      .then((result) => {
        console.log("Success:", result);
        // Optionally, you can hide the form again or clear the form inputs
        document.getElementById("visitFormModal").style.display = "none";
        this.reset();
        location.reload();
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
