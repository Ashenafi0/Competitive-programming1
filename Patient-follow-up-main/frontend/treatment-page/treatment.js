document.addEventListener('DOMContentLoaded', function() {
    checkAuth(["doctor"], "../login/login.html");
    fetchTreatments();
});

function fetchTreatments() {
    // Get visit_id from the previous page or other source
    const urlParams = new URLSearchParams(window.location.search);
    const visitId = urlParams.get("visit_id");
    fetch(`http://localhost/finalProject/api/visit/treatments?visit_id=${visitId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const treatmentList = document.getElementById('treatments-list');
            treatmentList.innerHTML = '';

            data.forEach(treatment => {
                const li = document.createElement('li');
                li.textContent = treatment.treatment_description;
                li.onclick = () => editTreatment(treatment.treatment_id);

                treatmentList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching treatments:', error));
}

function openAddTreatmentForm() {
    document.getElementById('treatment-form').reset();
    document.getElementById('treatment-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Treatment';
    document.getElementById('treatments-modal').style.display = 'block';
}

function closeTreatmentForm() {
    document.getElementById('treatments-modal').style.display = 'none';
}

function submitTreatmentForm(event) {
    event.preventDefault();

    // const visitId = document.getElementById('visit-id').value;
    const urlParams = new URLSearchParams(window.location.search);
    const visitId = urlParams.get("visit_id");

    const treatmentId = document.getElementById('treatment-id').value;
    const treatmentData = {
        visit_id: visitId,
        treatment_type: document.getElementById('treatment-type').value,
        treatment_description: document.getElementById('treatment-description').value
    };

    const url = treatmentId ? `http://localhost/finalProject/api/treatments?treatment_id=${treatmentId}` : `http://localhost/finalProject/api/visit/treatments?visit_id=${visitId}`;
    const method = treatmentId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(treatmentData),
    })
    .then(response => response.json())
    .then(data => {
        closeTreatmentForm();
        fetchTreatments();
    })
    .catch(error => console.error('Error submitting treatment form:', error));
}

function editTreatment(treatmentId) {
    fetch(`http://localhost/finalProject/api/treatments?treatment_id=${treatmentId}`)
        .then(response => response.json())
        .then(treatment => {
            console.log(treatment[0]);
            document.getElementById('treatment-id').value = treatment[0].treatment_id;
            document.getElementById('visit-id').value = treatment[0].visit_id;
            document.getElementById('treatment-type').value = treatment[0].treatment_type;
            document.getElementById('treatment-description').value = treatment[0].treatment_description;
            document.getElementById('modal-title').textContent = 'Edit Treatment';
            document.getElementById('treatments-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching treatment details:', error));
}
