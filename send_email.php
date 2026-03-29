<?php
// Include PHPMailer library files (Adjust these paths if you didn't use Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
// require 'PHPMailer/src/Exception.php'; // If manual install
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');

// Get the JSON data sent from the JavaScript fetch()
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'No data received.']);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$activityName = $data['activityName'];
$scoreText = $data['scoreText'];

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth   = true;
    $mail->Username   = 'biology1.module@gmail.com'; // Your Gmail address
    $mail->Password   = 'pirg gflr hcww mito';       // Your Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('your_project_email@gmail.com', 'BioSphere Learning');
    $mail->addAddress($email, $name); // Send TO the student

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Your Results: {$activityName} - BioSphere Module 1";
    
    // The Email Body Layout
    $mail->Body = "
        <div style='font-family: sans-serif; color: #1a3a2a; max-width: 600px; margin: auto; border: 1px solid #d8f3dc; border-radius: 12px; overflow: hidden;'>
            <div style='background: #1a3a2a; color: #fefae0; padding: 20px; text-align: center;'>
                <h2>🌿 BioSphere Learning</h2>
            </div>
            <div style='padding: 30px; background: #f4f9f5;'>
                <p>Hello <strong>{$name}</strong>,</p>
                <p>Great job completing <strong>{$activityName}</strong> in Module 1: The Cell Theory!</p>
                <div style='background: #d8f3dc; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0;'>
                    <h3 style='margin: 0; color: #2d6a4f;'>Your Score:</h3>
                    <h1 style='margin: 10px 0 0 0; color: #1a3a2a;'>{$scoreText}</h1>
                </div>
                <p>Keep up the great work as you continue exploring the foundations of biology.</p>
                <br>
                <p>Best regards,<br><strong>Saimond James M. Lin</strong><br>Lead Developer, BioSphere</p>
            </div>
        </div>
    ";

    $mail->send();
    echo json_encode(['status' => 'success', 'message' => 'Email sent successfully']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
?>