<?php
include "../db/conn.php";
include "../includes/responses.php";
require "../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($data, $env)
{

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = $env['EMAIL_USERNAME'];
        $mail->Password = $env['EMAIL_PASSWORD'];

        $mail->setFrom("strivehigh53@gmail.com");
        $mail->addAddress($data['clientEmail'], "User");

        $mail->Subject = $data['subject'];
        $mail->isHTML(true);
        $mail->Body = $data['message'];

        $mail->send();

        // Send JSON response for redirect
        header('Content-Type: application/json');
        redirect(true, "../sent.php");
        exit;
    } catch (Exception $e) {
        response(false, "Email could not be sent. Please try again.");
        echo "Mailer error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Get .env
    $envFilePath = __DIR__ . '/../includes/.env';
    $env = parse_ini_file($envFilePath);

    //So a couple of things should happen here
    //1. Get the data from AJAX
    //2. Insert data into the database, inside the students table
    //3. Check capacity from the buses table using bus_number, to see if there's space
    //4. Get busId using bus_number and insert it into the registrations table together with the studentId, adminId, then based on the availability of space, insert 1 or 0 in the columns waiting, approved, and canceled.
    //5. Send email to the parent confirm the registration
    //6. Add a notification in the notifications table for the admin

    // Step 1: Get data from AJAX request
    $studentName = $_POST['name'];
    $grade = $_POST['grade'];
    $tel = $_POST['tel'];
    $busNumber = $_POST['bus'];
    $pickupNumber = isset($_POST['pickup']) ? $_POST['pickup'] : null;
    $dropoffNumber = isset($_POST['dropoff']) ? $_POST['dropoff'] : null;
    $parentId = $_SESSION['parent_id']; // Assuming parentId is stored in session

    // Check if any required data is missing
    if (empty($studentName) || empty($grade) || empty($tel) || empty($busNumber)) {
        response(false, "Please fill the missing fields.");
        exit;
    }

    // Step 2: Check bus capacity
    $stmt = $conn->prepare("SELECT capacity FROM buses WHERE bus_number = ?");
    $stmt->bind_param("s", $busNumber);
    $stmt->execute();
    $stmt->bind_result($capacity);
    $stmt->fetch();
    $stmt->close();

    // Count currently approved registrations for this bus
    $stmt = $conn->prepare("SELECT COUNT(*) FROM registrations WHERE busId = (SELECT busId FROM buses WHERE bus_number = ?) AND waiting = 0 AND canceled = 0");
    $stmt->bind_param("s", $busNumber);
    $stmt->execute();
    $stmt->bind_result($currentRegistrations);
    $stmt->fetch();
    $stmt->close();

    $hasSpace = $currentRegistrations < $capacity;
    $waiting = $hasSpace ? 0 : 1;
    $approved = $hasSpace ? 1 : 0;
    $canceled = 0; // default to 0 on initial registration

    // Step 3: Insert learner data into the `students` table
    $stmt = $conn->prepare("INSERT INTO students (studentName, grade, tel, parentId, bus_number, pickup_number, dropoff_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $studentName, $grade, $tel, $parentId, $busNumber, $pickupNumber, $dropoffNumber);
    if (!$stmt->execute()) {
        response(false, "Failed to register student. Please try again.");
        exit;
    }
    $studentId = $stmt->insert_id;
    $stmt->close();

    // Step 4: Get `busId` from `buses` table
    $stmt = $conn->prepare("SELECT busId FROM buses WHERE bus_number = ?");
    $stmt->bind_param("s", $busNumber);
    $stmt->execute();
    $stmt->bind_result($busId);
    $stmt->fetch();
    $stmt->close();

    // Insert into `registrations` table
    $adminId = 3; // predefined admin ID
    $stmt = $conn->prepare("INSERT INTO registrations (adminId, studentId, busId, waiting, approved, canceled, date) VALUES (?, ?, ?, ?, ?, ?, CURDATE())");
    $stmt->bind_param("iiiiii", $adminId, $studentId, $busId, $waiting, $approved, $canceled);
    if (!$stmt->execute()) {
        response(false, "Failed to register for the bus. Please try again.");
        exit;
    }
    $stmt->close();

    // Step 5: Add notification for the admin
    $notificationText = $hasSpace
        ? "$studentName has been successfully registered for $busNumber."
        : "$studentName has been added to the waiting list for $busNumber.";

    $stmt = $conn->prepare("INSERT INTO notifications (notification, seen) VALUES (?, 0)");
    $stmt->bind_param("s", $notificationText);

    if (!$stmt->execute()) {
        response(false, "Failed to add admin notification. Registration succeeded, but notification was not sent.");
        exit;
    }

    $stmt->close();

    // Step 6: Send email to parent
    $parentEmail = $_SESSION['parent_email'];

    if ($hasSpace) {
        $emailData = [
            'clientEmail' => $parentEmail,
            'subject' => 'Bus Registration Confirmation',
            'message' => "Dear Parent,\n\n Your child $studentName has been successfully registered for $busNumber. Thank you for your registration. \n\n Regards, \n Strive High Secondary School"
        ];
    } else {
        $emailData = [
            'clientEmail' => $parentEmail,
            'subject' => 'Bus Registration Confirmation',
            'message' => "Dear Parent,\n\n Your child $studentName has been placed on the waiting list for $busNumber. Keep checking your child's status for improvements.\n\n Regards,\n Strive High Secondary School"
        ];
    }

    sendEmail($emailData, $env);
} else {
    response(false, "Error: Bad Request");
}
