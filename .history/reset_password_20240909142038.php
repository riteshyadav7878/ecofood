// Send reset email
$reset_link = "http://yourdomain.com/reset-password.php?token=" . $reset_token;
$to = $user['email'];
$subject = "Password Reset Request";
$message = "Hi " . $username . ",\n\nPlease click the link below to reset your password:\n" . $reset_link . "\n\nIf you did not request this, please ignore this email.";
$headers = "From: no-reply@yourdomain.com";

mail($to, $subject, $message, $headers);
