document.addEventListener('DOMContentLoaded', function() {

    checkAuth(["doctor"], "../login/login.html");
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const diagnosisId = urlParams.get('diagnosis_id');

    if (diagnosisId) {
        document.getElementById('diagnosis-id').value = diagnosisId;
        fetchFiles(diagnosisId);
    }
});

function fetchFiles(diagnosisId) {
    fetch(`http://localhost/finalProject/api/files/get_files.php?diagnosis_id=${diagnosisId}`)
        .then(response => response.json())
        .then(files => {
            const filesList = document.getElementById('files-list');
            filesList.innerHTML = '';
            files.forEach(file => {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'file-item';

                const fileName = document.createElement('span');
                fileName.textContent = file.file_name;

                const fileType = document.createElement('span');
                fileType.textContent = ` (${file.file_type})`;

                const downloadButton = document.createElement('button');
                downloadButton.textContent = "Download";
                downloadButton.onclick = () => downloadFile(file.file_id);

                const deleteButton = document.createElement('button');
                deleteButton.textContent = "Delete";
                deleteButton.onclick = () => deleteFile(file.file_id, diagnosisId);

                fileDiv.appendChild(fileName);
                fileDiv.appendChild(fileType);
                fileDiv.appendChild(downloadButton);
                fileDiv.appendChild(deleteButton);
                filesList.appendChild(fileDiv);
            });
        })
        .catch(error => console.error('Error fetching files:', error));
}

function downloadFile(fileId) {
    window.location.href = `http://localhost/finalProject/api/files/download_file.php?file_id=${fileId}`;
}

function deleteFile(fileId, diagnosisId) {
    fetch(`http://localhost/finalProject/api/files/delete_file.php?file_id=${fileId}`, {
        method: 'DELETE',
    })
    .then(response => response.json())
    .then(data => {
        console.log('File deleted:', data);
        fetchFiles(diagnosisId);
    })
    .catch(error => console.error('Error deleting file:', error));
}

function uploadFile(event) {
    event.preventDefault();
    const fileInput = document.getElementById('file-input');
    const fileType = document.getElementById('file-type').value;
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);
    formData.append('file_type', fileType);

    const diagnosisId = document.getElementById('diagnosis-id').value;
    fetch(`http://localhost/finalProject/api/files/upload_file.php?diagnosis_id=${diagnosisId}`, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log('File uploaded:', data);
        closeFilesModal();
        fetchFiles(diagnosisId);
    })
    .catch(error => console.error('Error uploading file:', error));
}

function openAddFileForm() {
    document.getElementById('file-upload-form').reset();
    document.getElementById('files-modal').style.display = 'block';
}

function closeFilesModal() {
    document.getElementById('files-modal').style.display = 'none';
}
