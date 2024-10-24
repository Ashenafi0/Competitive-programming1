<?php
require_once "../includes/dbconn.php";

$sql="CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    date_of_birth DATE,
    gender VARCHAR(10),
    contact_number VARCHAR(15),
    email VARCHAR(100),
    address TEXT,
    username VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    role VARCHAR(20)
    
);
";

if(mysqli_query($conn,$sql)){

    echo "Admin Table created";
}
else{
    echo "Failed to create connect admin table";
}


$sql="CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    contact_number VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    emergency_contact_name VARCHAR(100),
    emergency_contact_number VARCHAR(15)
);
";



if(mysqli_query($conn,$sql)){

    echo "Patient Table created";
}
else{
    echo "Failed to create connect patient table";
}


$sql1="CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    date_of_birth DATE,
    gender VARCHAR(10),
    contact_number VARCHAR(15),
    email VARCHAR(100),
    address TEXT,
    license_number VARCHAR(50),
    specialization VARCHAR(100),
    years_of_experience INT,
    username VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    role VARCHAR(20)
);
"; 

if(mysqli_query($conn,$sql1)){

    echo "Doctor Table created";
}
else{
    echo "Failed to create connect doctor table";
}

$sql1="CREATE TABLE visits (
    visit_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    reason_for_visit TEXT NOT NULL,
    visited_date DATE NOT NULL,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);";

if(mysqli_query($conn,$sql1)){

    echo "Visits Table created";
}
else{
    echo "Failed to create connect visits table";
}

?>