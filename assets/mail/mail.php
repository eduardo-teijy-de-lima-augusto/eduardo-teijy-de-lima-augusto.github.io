<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize e validação dos campos
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || !$email || empty($message)) {
        header("location: ../mail-error.html");
        exit;
    }

    // Prevenção de injeção de cabeçalhos
    $clean_email = preg_replace("/[\r\n]+/", "", $email);

    // Cria o corpo do e-mail
    $email_message = "
    Name: $name
    Email: $clean_email
    Phone: $phone
    Subject: $subject
    Message: $message
    ";

    $headers = "From: $clean_email\r\n";
    $headers .= "Reply-To: $clean_email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail("andrejota@gmail.com", "Solicitação Cliente", $email_message, $headers)) {
        header("location: ../mail-success.html");
    } else {
        header("location: ../mail-error.html");
    }
} else {
    header("location: ../mail-error.html");
    http_response_code(405);
    exit("Método não permitido.");
}
?>
