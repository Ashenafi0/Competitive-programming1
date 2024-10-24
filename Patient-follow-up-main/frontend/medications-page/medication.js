document.addEventListener('DOMContentLoaded', function() {
     checkAuth(["doctor"], "../login/login.html");
    fetchMedications();
});

function fetchMedications() {
    // Get visit_id from the previous page or other source
        const urlParams = new URLSearchParams(window.location.search);
        const visitId = urlParams.get("visit_id");
    fetch(`http://localhost/finalProject/api/visit/medications?visit_id=${visitId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const medicationList = document.getElementById('medications-list');
            medicationList.innerHTML = '';

            data.forEach(medication => {
                // console.log(medication)
                const li = document.createElement('li');
                li.textContent = `${medication.medication_name} - ${medication.dosage}`;
                li.onclick = () => editMedication(medication.medication_id);

                medicationList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching medications:', error));
}

function openAddMedicationForm() {
    document.getElementById('medication-form').reset();
    document.getElementById('medication-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Medication';
    document.getElementById('medications-modal').style.display = 'block';
}

function closeMedicationForm() {
    document.getElementById('medications-modal').style.display = 'none';
}

function submitMedicationForm(event) {
    event.preventDefault();

    const urlParams = new URLSearchParams(window.location.search);
    const visitId = urlParams.get("visit_id");
    const medicationId = document.getElementById('medication-id').value;
    const medicationData = {
        visit_id: visitId,
        medication_name: document.getElementById('medication-name').value,
        dosage: document.getElementById('dosage').value,
        instructions: document.getElementById('instructions').value
    };

    const url = medicationId ? `http://localhost/finalProject/api/medications?medication_id=${medicationId}` : `http://localhost/finalProject/api/visit/medications?visit_id=${visitId}`;
    const method = medicationId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(medicationData),
    })
    .then(response => response.json())
    .then(data => {
        closeMedicationForm();
        fetchMedications();
    })
    .catch(error => console.error('Error submitting medication form:', error));
}

function editMedication(medicationId) {
    fetch(`http://localhost/finalProject/api/medications?medication_id=${medicationId}`)
        .then(response => response.json())
        .then(medication => {
            console.log(medication[0]);
            document.getElementById('medication-id').value = medication[0].medication_id;
            document.getElementById('visit-id').value = medication[0].visit_id;
            document.getElementById('medication-name').value = medication[0].medication_name;
            document.getElementById('dosage').value = medication[0].dosage;
            document.getElementById('instructions').value = medication[0].instructions;
            document.getElementById('modal-title').textContent = 'Edit Medication';
            document.getElementById('medications-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching medication details:', error));
}
