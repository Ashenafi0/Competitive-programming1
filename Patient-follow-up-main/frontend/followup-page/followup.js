document.addEventListener('DOMContentLoaded', function() {
     checkAuth(["doctor"], "../login/login.html");
    fetchFollowUps();
});

function fetchFollowUps() {
    // Get visit_id from the previous page or other source
      const urlParams = new URLSearchParams(window.location.search);
      const visitId = urlParams.get("visit_id");
    fetch(`http://localhost/finalProject/api/visit/follow-ups?visit_id=${visitId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const followUpList = document.getElementById('follow-ups-list');
            followUpList.innerHTML = '';

            data.forEach(followUp => {
                const li = document.createElement('li');
                li.textContent = `${followUp.follow_up_date} - ${followUp.follow_up_instructions}`;
                li.onclick = () => editFollowUp(followUp.follow_up_id);

                followUpList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching follow-ups:', error));
}

function openAddFollowUpForm() {
    document.getElementById('follow-up-form').reset();
    document.getElementById('follow-up-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Follow-Up';
    document.getElementById('follow-ups-modal').style.display = 'block';
}

function closeFollowUpForm() {
    document.getElementById('follow-ups-modal').style.display = 'none';
}

function submitFollowUpForm(event) {
    event.preventDefault();

    // const visitId = document.getElementById('visit-id').value;
    const urlParams = new URLSearchParams(window.location.search);
    const visitId = urlParams.get("visit_id");
    const followUpId = document.getElementById('follow-up-id').value;
    const followUpData = {
        visit_id: visitId,
        follow_up_date: document.getElementById('follow-up-date').value,
        follow_up_instructions: document.getElementById('follow-up-instructions').value
    };

    const url = followUpId ? `http://localhost/finalProject/api/follow_ups?follow_up_id=${followUpId}` : `http://localhost/finalProject/api/visit/follow-ups?visit_id=${visitId}`;
    const method = followUpId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(followUpData),
    })
    .then(response => response.json())
    .then(data => {
        closeFollowUpForm();
        fetchFollowUps();
    })
    .catch(error => console.error('Error submitting follow-up form:', error));
}

function editFollowUp(followUpId) {
    fetch(`http://localhost/finalProject/api/follow_ups?follow_up_id=${followUpId}`)
        .then(response => response.json())
        .then(followUp => {
            console.log(followUp[0]);
            document.getElementById('follow-up-id').value = followUp[0].follow_up_id;
            document.getElementById('visit-id').value = followUp[0].visit_id;
            document.getElementById('follow-up-date').value = followUp[0].follow_up_date;
            document.getElementById('follow-up-instructions').value = followUp[0].follow_up_instructions;
            document.getElementById('modal-title').textContent = 'Edit Follow-Up';
            document.getElementById('follow-ups-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching follow-up details:', error));
}
