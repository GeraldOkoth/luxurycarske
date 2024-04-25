<?php

$firstname = $lastname = $email = $number = $subject = $message = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = sanitizeInput($_POST["firstname"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $number = sanitizeInput($_POST["number"]);
    $subject = sanitizeInput($_POST["subject"]);
    $message = sanitizeInput($_POST["message"]);

    function sanitizeInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

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

    if (empty($number)) {
        $errors[] = "Phone number is required";
    }

    if (empty($subject)) {
        $errors[] = "Subject is required";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        $to = "okothgerald449@gmail.com";
        $from = $email;
        $headers = "From: $from";
        
        $email_body = "First Name: $firstname\n" .
                      "Last Name: $lastname\n" .
                      "Email: $email\n" .
                      "Phone Number: $number\n" .
                      "Subject: $subject\n" .
                      "Message:\n$message";

        if (mail($to, $subject, $email_body, $headers)) {
            echo "Your message has been sent successfully!";
        } else {
            echo "Failed to send your message. Please try again later.";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

?>
