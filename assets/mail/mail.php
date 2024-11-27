<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize e atribui os valores das variáveis
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validações básicas
    if (empty($name) || !$email || empty($message)) {
        header("location: ../mail-error.html"); // Redireciona para uma página de erro
        exit;
    }

    // Cria o corpo do e-mail
    $email_message = "
    Name: $name
    Email: $email
    Phone: $phone
    Subject: $subject
    Message: $message
    ";

    // Configura os cabeçalhos do e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envia o e-mail
    if (mail("andrejota@gmail.com", "Solicitação Cliente", $email_message, $headers)) {
        header("location: ../mail-success.html"); // Redireciona para a página de sucesso
    } else {
        header("location: ../mail-error.html"); // Redireciona para a página de erro
    }
} else {
    // Redireciona caso o método não seja POST
    header("location: ../mail-error.html");
    http_response_code(405);
    echo "Método não permitido.";
    exit;
}
?>

