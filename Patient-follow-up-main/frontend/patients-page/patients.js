document.addEventListener('DOMContentLoaded', function() {
    checkAuth(["doctor"], "../login/login.html");
    fetchPatients();
});

function fetchPatients() {
    fetch('http://localhost/finalProject/api/patients/get_patients.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const patientList = document.getElementById('patient-list');
            patientList.innerHTML = '';

            data.forEach(patient => {
                const visitButton = document.createElement('button');
                visitButton.textContent = "View Visit";
                visitButton.onclick = () => viewVisit(patient.patient_id); // Call viewVisit function with patient ID
                visitButton.style.margin = "5px"; // Adding margin to the button
                visitButton.style.backgroundColor = "gray";
                patientList.appendChild(visitButton);
               

                // Add patient details to the list
                

                const li = document.createElement('li');
                li.textContent = `${patient.first_name} ${patient.last_name}`;
                
                li.onclick = () => editPatient(patient.patient_id);
                patientList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching patients:', error));
}

function searchPatients() {
    const searchTerm = document.getElementById('search-bar').value.toLowerCase();
    fetch('http://localhost/finalProject/api/patients/get_patients.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const patientList = document.getElementById('patient-list');
            patientList.innerHTML = '';

            data.forEach(patient => {
                const fullName = `${patient.first_name} ${patient.last_name}`.toLowerCase();
                const patientIdString = patient.patient_id.toString(); // Convert patient_id to string for search
                if (fullName.includes(searchTerm) || patientIdString.includes(searchTerm)) {

                    const visitButton = document.createElement('button');
                    visitButton.textContent = "View Visit";
                    visitButton.onclick = () => viewVisit(patient.patient_id); // Call viewVisit function with patient ID
                    patientList.appendChild(visitButton);
                   

                    // Add patient details to the list
                    

                    const li = document.createElement('li');
                    li.textContent = `${patient.first_name} ${patient.last_name}`;
                    
                    li.onclick = () => editPatient(patient.patient_id);
                    patientList.appendChild(li);
                }
            });
        })
        .catch(error => console.error('Error searching patients:', error));
}

function viewVisit(patientId) {
    // Redirect to visit.html with patient ID as query parameter
    window.location= `../visit/visit.html?patient_id=${patientId}`;
}

function openAddPatientForm() {
    document.getElementById('patient-form').reset();
    document.getElementById('patient-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Patient';
    document.getElementById('patient-modal').style.display = 'block';
}

function closePatientForm() {
    document.getElementById('patient-modal').style.display = 'none';
}

function submitPatientForm(event) {
    event.preventDefault();

    const patientId = document.getElementById('patient-id').value;
    const patientData = {
        first_name: document.getElementById('first-name').value,
        last_name: document.getElementById('last-name').value,
        date_of_birth: document.getElementById('date-of-birth').value,
        gender: document.getElementById('gender').value,
        contact_number: document.getElementById('contact-number').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        emergency_contact_name: document.getElementById('emergency-contact-name').value,
        emergency_contact_number: document.getElementById('emergency-contact-number').value,
    };

    const url = patientId ? `http://localhost/finalProject/api/patients/update_patient.php?patient_id=${patientId}` : 'http://localhost/finalProject/api/patients/patient.php';
    const method = patientId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(patientData),
    })
    .then(response => response.json())
    .then(data => {
        closePatientForm();
        fetchPatients();
    })
    .catch(error => console.error('Error submitting patient form:', error));
}

function editPatient(patientId) {
    fetch(`http://localhost/finalProject/api/patients/get_patient.php?patient_id=${patientId}`)
        .then(response => response.json())
        .then(patient => {
            console.log(patient);
            document.getElementById('patient-id').value = patient.patient_id;
            document.getElementById('first-name').value = patient.first_name;
            document.getElementById('last-name').value = patient.last_name;
            document.getElementById('date-of-birth').value = patient.date_of_birth;
            document.getElementById('gender').value = patient.gender;
            document.getElementById('contact-number').value = patient.contact_number;
            document.getElementById('email').value = patient.email;
            document.getElementById('address').value = patient.address;
            document.getElementById('emergency-contact-name').value = patient.emergency_contact_name;
            document.getElementById('emergency-contact-number').value = patient.emergency_contact_number;
            document.getElementById('modal-title').textContent = 'Edit Patient';
            document.getElementById('patient-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching patient details:', error));
}
