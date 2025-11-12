<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = $_POST['name'] ?? '';
  $phone = $_POST['phone'] ?? '';
  $service = $_POST['service'] ?? '';
  $message = $_POST['message'] ?? '';

  // Create an uploads folder if it doesn't exist
  $uploadDir = __DIR__ . '/uploads/';
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  // Handle multiple file uploads
  if (!empty($_FILES['photos']['name'][0])) {
    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
      $fileName = basename($_FILES['photos']['name'][$key]);
      $targetFile = $uploadDir . $fileName;
      move_uploaded_file($tmp_name, $targetFile);
    }
  }

  // OPTIONAL: send an email to notify you (no attachments here)
  $to = "toplevelrestorations@gmail.com";
  $subject = "New Quote Request from $name";
  $body = "Name: $name\nPhone: $phone\nService: $service\nMessage:\n$message";
  $headers = "From: no-reply@toplevelrestoration.net";

  mail($to, $subject, $body, $headers);

  echo "<h2>Thank you, $name. Your request has been sent!</h2>";
  echo "<p>We’ll review your message and photos shortly.</p>";
}
?>
