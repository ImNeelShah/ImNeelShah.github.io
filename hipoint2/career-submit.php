<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['subject'];

    // File validation
    if (!isset($_FILES['attachment']) || $_FILES['attachment']['error'] !== 0) {
        die("File upload error.");
    }

    $fileTmp = $_FILES['attachment']['tmp_name'];
    $fileName = $_FILES['attachment']['name'];
    $fileSize = $_FILES['attachment']['size'];

    if ($fileSize > 5 * 1024 * 1024) {
        die("File must be less than 5MB.");
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP CONFIG (Gmail example)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourgmail@gmail.com';  // 🔴 replace
        $mail->Password   = 'your_app_password';    // 🔴 use App Password (NOT real password)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom('yourgmail@gmail.com', 'Career Form');
        $mail->addAddress('neelshah6892@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Career Form Submission';
        $mail->Body    = "
            <b>Name:</b> $name <br>
            <b>Email:</b> $email <br>
            <b>Contact:</b> $contact
        ";

        // Attachment
        $mail->addAttachment($fileTmp, $fileName);

        $mail->send();
        echo "Application submitted successfully!";

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}