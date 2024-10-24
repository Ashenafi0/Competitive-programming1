document.addEventListener("DOMContentLoaded", function () {
  checkAuth(["admin"], "../login/login.html");
  fetchDoctors();
});

function fetchDoctors() {
  fetch("http://localhost/finalProject/api/doctors.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const doctorList = document.getElementById("doctor-list");
      doctorList.innerHTML = "";

      data.forEach((doctor) => {
        // const visitButton = document.createElement("button");
        // visitButton.textContent = "View Details";
        // visitButton.onclick = () => editDoctor(doctor.id);
        // visitButton.style.margin = "5px";
        // visitButton.style.backgroundColor = "gray";
        // doctorList.appendChild(visitButton);

        const li = document.createElement("li");
        li.textContent = `${doctor.first_name} ${doctor.last_name}`;
        console.log(doctor)
        li.onclick = () => editDoctor(doctor.id);
        doctorList.appendChild(li);
      });
    })
    .catch((error) => console.error("Error fetching doctors:", error));
}

function searchDoctors() {
  const searchTerm = document.getElementById("search-bar").value.toLowerCase();
  fetch("http://localhost/finalProject/api/doctors.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const doctorList = document.getElementById("doctor-list");
      doctorList.innerHTML = "";

      data.forEach((doctor) => {
        const fullName =
          `${doctor.first_name} ${doctor.last_name}`.toLowerCase();
        const doctorIdString = doctor.id.toString();
        if (
          fullName.includes(searchTerm) ||
          doctorIdString.includes(searchTerm)
        ) {
          const visitButton = document.createElement("button");
          visitButton.textContent = "View Details";
          visitButton.onclick = () => editDoctor(doctor.id);
          visitButton.style.margin = "5px";
          visitButton.style.backgroundColor = "gray";
          doctorList.appendChild(visitButton);

          const li = document.createElement("li");
          li.textContent = `${doctor.first_name} ${doctor.last_name}`;
          li.onclick = () => editDoctor(doctor.id);
          doctorList.appendChild(li);
        }
      });
    })
    .catch((error) => console.error("Error searching doctors:", error));
}

function openAddDoctorForm() {
  document.getElementById("doctor-form").reset();
  document.getElementById("doctor-id").value = "";
  document.getElementById("modal-title").textContent = "Add New Doctor";
  document.getElementById("doctor-modal").style.display = "block";
}

function closeDoctorForm() {
  document.getElementById("doctor-modal").style.display = "none";
}

function submitDoctorForm(event) {
  event.preventDefault();

  const doctorId = document.getElementById("doctor-id").value;
  const doctorData = {
    first_name: document.getElementById("first-name").value,
    last_name: document.getElementById("last-name").value,
    date_of_birth: document.getElementById("date-of-birth").value,
    gender: document.getElementById("gender").value,
    contact_number: document.getElementById("contact-number").value,
    email: document.getElementById("email").value,
    address: document.getElementById("address").value,
    license_number: document.getElementById("license-number").value,
    specialization: document.getElementById("specialization").value,
    years_of_experience: document.getElementById("years-of-experience").value,
    username: document.getElementById("username").value,
    password: document.getElementById("password").value,
    role:"doctor",
  };

  const url = doctorId
    ? `http://localhost/finalProject/api/doctors.php?doctor_id=${doctorId}`
    : "http://localhost/finalProject/api/doctors.php";
  const method = doctorId ? "PUT" : "POST";

  fetch(url, {
    method: method,
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(doctorData),
  })
    .then((response) => response)
    .then((data) => {
      closeDoctorForm();
      fetchDoctors();
    })
    .catch((error) => console.error("Error submitting doctor form:", error));
}

function editDoctor(doctorId) {
  fetch(`http://localhost/finalProject/api/doctors.php?doctor_id=${doctorId}`)
    .then((response) => response.json())
    .then((doctor) => {
      console.log(doctor[0]);
      document.getElementById("doctor-id").value = doctor[0].id;
      document.getElementById("first-name").value = doctor[0].first_name;
      document.getElementById("last-name").value = doctor[0].last_name;
      document.getElementById("date-of-birth").value = doctor[0].date_of_birth;
      document.getElementById("gender").value = doctor[0].gender;
      document.getElementById("contact-number").value =
        doctor[0].contact_number;
      document.getElementById("email").value = doctor[0].email;
      document.getElementById("address").value = doctor[0].address;
      document.getElementById("license-number").value =
        doctor[0].license_number;
      document.getElementById("specialization").value =
        doctor[0].specialization;
      document.getElementById("years-of-experience").value =
        doctor[0].years_of_experience;
      document.getElementById("username").value = doctor[0].username;
      document.getElementById("password").value = ""; // Password is not fetched from the backend
      document.getElementById("modal-title").textContent = "Edit Doctor";
      document.getElementById("doctor-modal").style.display = "block";
    })
    .catch((error) => console.error("Error fetching doctor details:", error));
}
