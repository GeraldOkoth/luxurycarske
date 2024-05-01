<?php
$fullname = $phone = $addressno = $taxId = $ID = $email = $city =  ""; 
$fullnameErr = $phoneErr = $addressnoErr = $taxIdErr = $IDErr = $emailErr = $cityErr =  ""; 
$transmission = "";
$Brand = "";

function test_input($input) {
    //$input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = test_input($_POST["fullname"]);
    $phone = test_input($_POST["phone"]);
    $addressno = test_input($_POST["addressno"]);
    //$taxId = test_input($_POST["taxId"]);
    $ID = test_input($_POST["ID"]);
    $email = test_input($_POST["email"]);
    $city = test_input($_POST["city"]);
    $Brand = test_input($_POST["Brand"]);
    $transmission = test_input($_POST["transmission"]);

    // Validate input
    $valid = true;

    if (empty($fullname)) {
        $fullnameErr = "Name is required!";
        $valid = false;
    }

    if (empty($phone)) {
        $phoneErr = "Phone Number required!";
        $valid = false;
    } elseif (!preg_match("/^\+254/", $phone)) {
        $phoneErr = "Phone Number is invalid!";
        $valid = false;
    }

    if (empty($addressno)) {
        $addressnoErr = "Address required!";
        $valid = false;
    }

    if(empty($taxId)) {
        $taxIdErr = "Tax Id Rquired!";
        $valid = false;
    }

    if (empty($ID)) {
        $IDErr = "ID required!";
        $valid = false;
    } elseif (!preg_match("/\d/", $ID)) {
        $IDErr = "Invalid ID Number!";
        $valid = false;
    }

    if (empty($email)) {
        $emailErr = "Email is required!";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format!";
        $valid = false;
    }

    if ($valid) {
        // Database connection details
        $host = "127.0.0.1";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "luxury_cars";

        // Create connection
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
        if ($conn->connect_error) {
            die('Connection Failed : ' . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO luxury_cars (fullname, phone, addressno, taxId, ID, email, city, Brand, transmission) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissssss", $fullname, $phone, $addressno, $taxId, $ID, $email, $city, $Brand, $transmission);
        
        // Execute SQL
        if ($stmt->execute()) {
            echo "Your details have been successfully submitted!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>
