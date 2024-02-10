
<?php
require_once "../../vendor/autoload.php";
include "../../bootstrap.php";

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// require 'phpmailer/phpmailer/src/Exception';
// // require 'PHPMailer/PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);

use CT466\Project\dattiec;
use CT466\Project\User;
// Khởi tạo đối tượng PHPMailer


$user = new User($PDO);
$dattiec = new dattiec($PDO);
if (isset($_GET['huy'])) {
    $id_dt = $_GET['huy'];
    $dattiecUser = $dattiec->find($id_dt);
    $dattiecUser->id_user;

    // echo $dattiec->id_user;
    $userDat = $user->find($dattiecUser->id_user);
    // echo "<pre>";
    // print_r($userDat) ;
    $emailDat = $userDat->email;
    // echo $email;

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP(); // gửi mail SMTP
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'tinb1910157@student.ctu.edu.vn'; // SMTP username
        $mail->Password = 'pRYmcQ6P3f'; // SMTP password
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to
        //Recipients
        $mail->setFrom('tinb1910157@student.ctu.edu.vn', 'TiecLuuDong');
        $mail->addAddress($emailDat); // Add a recipient

        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = 'TIEC-LUU-DONG';
        $mail->Body = 'Đơn đặt tiệc của bạn đã bị hủy!!! Xin lỗi vì sự bất tiện này. ';
        $mail->AltBody = 'Đơn đặt tiệc của bạn đã bị hủy!!!';
        if ($mail->send()) {

            if (isset($_GET['huy'])) {
                $id_dt = $_GET['huy'];
                $dattiec->huy($id_dt);
                echo '<script>alert("Bạn đã hủy đơn đặt tiệc này."); javascript:history.go(-1)</script>';
            } else {
                echo '<script>alert("Có lỗi xảy ra. Vui lòng kiểm tra lại."); javascript:history.go(-1)</script>';
            }
        } else {
            echo '<script>alert("Gửi mail thất bại. Vui lòng kiểm tra lại");  javascript:history.go(-1)</script>';
        }
        // $mail->send();
        // echo 'Message has been sentttttttttttttttttttttttttttttttttttttttttttttt';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
