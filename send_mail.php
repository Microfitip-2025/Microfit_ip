<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST['nom']));
    $email   = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if (!$name || !$email || !$message) {
        echo "Veuillez remplir correctement tous les champs.";
        exit;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0; // mettre à 2 si tu veux voir les logs
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'microfitip@gmail.com'; // Ton email Gmail
        $mail->Password   = 'corniche'; // Remplace avec le mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('microfitip@gmail.com', 'Microfit');
        $mail->addAddress('microfitip@gmail.com');

        $mail->isHTML(false);
        $mail->Subject = "Nouveau message de contact";
        $mail->Body    = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
