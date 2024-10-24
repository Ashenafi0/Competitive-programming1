document.addEventListener('DOMContentLoaded', function() {
      checkAuth(["doctor"], "../login/login.html");

     const urlParams = new URLSearchParams(window.location.search);
     const visitId = urlParams.get("visit_id");
    fetchDiagnoses(visitId);
});

 


function fetchDiagnoses(visitId) {
    //get vissit_id from the previos page? not compeleted
    fetch(
      `http://localhost/finalProject/api/diagnoses/get_diagnoses.php?visit_id=${visitId}`
    )
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        const diagnosisList = document.getElementById("diagnoses-list");
        diagnosisList.innerHTML = "";

        data.forEach((diagnosis) => {
          const visitButton = document.createElement("button");
          visitButton.textContent = "File";
          visitButton.onclick = () => viewFile(diagnosis.diagnosis_id);
          visitButton.style.margin = "5px";
          visitButton.style.backgroundColor = "gray";

          const li = document.createElement("li");
          li.textContent = diagnosis.diagnosis_description;
          li.onclick = () => editDiagnosis(diagnosis.diagnosis_id);

          const listItem = document.createElement("div");
          listItem.appendChild(visitButton);
          listItem.appendChild(li);

          diagnosisList.appendChild(listItem);
        });
      })
      .catch((error) => console.error("Error fetching diagnoses:", error));
}

function viewFile(diagnosisId) {
    window.location.href = `../file-page/file.html?diagnosis_id=${diagnosisId}`;
}

function openAddDiagnosisForm() {
    document.getElementById('diagnosis-form').reset();
    document.getElementById('diagnosis-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Diagnosis';
    document.getElementById('diagnoses-modal').style.display = 'block';
}

function closeDiagnosisForm() {
    document.getElementById('diagnoses-modal').style.display = 'none';
}

function submitDiagnosisForm(event) {
    event.preventDefault();
    const urlParams = new URLSearchParams(window.location.search);
    const visitId = urlParams.get("visit_id");
    // const visitId =document.getElementById('visit-id').value;
    // console.log(visitId)
    const diagnosisId = document.getElementById('diagnosis-id').value;
    console.log(diagnosisId)

    const diagnosisData = {
        visit_id:visitId,
        diagnosis_description: document.getElementById('diagnosis-description').value
    };

    // const urlParams = new URLSearchParams(window.location.search);
    // const visitId = urlParams.get("visit_id");

    const url = diagnosisId ? `http://localhost/finalProject/api/diagnoses/update_diagnosis.php?diagnosis_id=${diagnosisId}` : `http://localhost/finalProject/api/diagnoses/create_diagnosis.php?visit_id=${visitId}`;
    const method = diagnosisId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(diagnosisData),
    })
    .then(response => response.json())
    .then(data => {
        closeDiagnosisForm();
        fetchDiagnoses(visitId);
    })
    .catch(error => console.error('Error submitting diagnosis form:', error));
}

function editDiagnosis(diagnosisId) {
    fetch(`http://localhost/finalProject/api/diagnoses/get_diagnosis.php?diagnosis_id=${diagnosisId}`)
        .then(response => response.json())
        .then(diagnosis => {
            console.log(diagnosis[0]);
            document.getElementById('diagnosis-id').value = diagnosis[0].diagnosis_id;
            document.getElementById('visit-id').value = diagnosis[0].visit_id;
            document.getElementById('diagnosis-description').value = diagnosis[0].diagnosis_description;
            document.getElementById('modal-title').textContent = 'Edit Diagnosis';
            document.getElementById('diagnoses-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching diagnosis details:', error));
}

