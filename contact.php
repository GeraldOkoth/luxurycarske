<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Variables for storing user input
$firstname = $lastname = $email = $phoneNumber = $mesgSubject = $msg = "";
$errors = [];

//Function to sanitize user input
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitizeInput($_POST["firstname"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $phoneNumber = sanitizeInput($_POST["phoneNumber"]); // Correct variable name
    $mesgSubject = sanitizeInput($_POST["mesgSubject"]);
    $msg = sanitizeInput($_POST["msg"]);


    if (empty($firstname)) {
        $errors[] = "First Name is required";
    }

    if (empty($lastname)) {
        $errors[] = "Last Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($phoneNumber)) {
        $errors[] = "Phone number is required";
    }

    if (empty($mesgSubject)) {
        $errors[] = "Subject is required";
    }

    if (empty($msg)) {
        $errors[] = "Message is required";
    }

    /*if (empty($errors)) {
        $to = "okothgerald449@gmail.com";
        $from = $email;
        $headers = "From: $from";
        
        $email_body = "First Name: $firstname\n" .
                      "Last Name: $lastname\n" .
                      "Email: $email\n" .
                      "Phone Number: $phoneNumber\n" .
                      "Subject: $mesgSubject\n" .
                      "Message:\n$msg";

        if (mail($to, $mesgSubject, $email_body, $headers)) {
            echo "Your message has been sent successfully!";
        } else {
            echo "Failed to send your message. Please try again.";
        }
    }*/
    else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>

<?php
//Variables for connecting to the server
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inbox";

//Create connection with database
$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if ($conn->connect_error) {
    die("Connection failed!". $conn->connect_error);
}
//Create database if connection is successful
$sql = "CREATE DATABASE IF NOT EXISTS inbox"; // Using IF NOT EXISTS to avoid error if the database already exists
if ($conn->query($sql) === false) {
    echo "Database creation failed!";
} else {
    echo "Database has been created successfully!";
}

// Create the ContactTable
$sqltbl = "CREATE TABLE IF NOT EXISTS contacttable (
    id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    email VARCHAR(30),
    phoneNumber INT(10) NOT NULL,
    mesgSubject VARCHAR(50),
    msg VARCHAR(255) NOT NULL,
    contactDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sqltbl) === true) {
    echo "Table has been created successfully!";

    //prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO ContactTable (firstname, lastname, email, phoneNumber, mesgSubject, msg) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $phoneNumber, $mesgSubject, $msg);

    //Execute SQL
    if($stmt->execute()) {
        echo "New record has been added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error creating the table!";
}

$conn->close();
?>

</body>
</html>
