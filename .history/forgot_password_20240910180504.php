use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Specify main SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'youremail@gmail.com';  // SMTP username
    $mail->Password = 'yourpassword';        // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    //Recipients
    $mail->setFrom('youremail@gmail.com', 'Mailer');
    $mail->addAddress($email);     // Add the recipient's email

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = 'Click the following link to reset your password: ' . $reset_link;

    $mail->send();
    echo 'Password reset link has been sent to your email.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
