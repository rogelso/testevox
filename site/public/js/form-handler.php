<?php
if ( !isset( $_SESSION ) ) session_start();
if ( !$_POST ) exit;
if ( !defined( "PHP_EOL" ) ) define( "PHP_EOL", "\r\n" );


$to = "rogelso.salvi@unochapeco.edu.br";
$subject = "Contato pelo site";



foreach ($_POST as $key => $value) {
    if (ini_get('magic_quotes_gpc'))
        $_POST[$key] = stripslashes($_POST[$key]);
    $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

// Assign the input values to variables for easy reference
$name      = @$_POST["name"];
$email     = @$_POST["email"];
$message   = @$_POST["comment"];



// Test input values for errors
$errors = array();
//php verif name
if(isset($_POST["name"])){

    if (!$name) {
        $errors[] = "Você deve digitar um nome.";
    } elseif(strlen($name) < 2)  {
        $errors[] = "O nome deve ter no mínimo 2 caracteres.";
    }

}
//php verif email
if(isset($_POST["email"])){
    if (!$email) {
        $errors[] = "Você deve digitar um e-mail.";
    } else if (!validEmail($email)) {
        $errors[] = "Você deve digitar um e-mail válido.";
    }
}


//php verif comment
if(isset($_POST["comment"])){
    if (strlen($message) < 10) {
        if (!$message) {
            $errors[] = "Tem de introduzir uma mensagem.";
        } else {
            $errors[] = "A mensagem deve ter pelo menos 10 caracteres.";
        }
    }
}


if ($errors) {
    // Output errors and die with a failure message
    $errortext = "";
    foreach ($errors as $error) {
        $errortext .= '<li>'. $error . "</li>";
    }

    echo '<div class="alert alert-error">Sequencia incorreta. :<br><ul>'. $errortext .'</ul></div>';

}else{



    // Send the email
    $headers  = "De: $email" . PHP_EOL;
    $headers .= "Responder para: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

    $mailBody  = "Você foi contactado por $name" . PHP_EOL . PHP_EOL;
    $mailBody .= (!empty($company))?'Company: '. PHP_EOL.$company. PHP_EOL . PHP_EOL:'';
    $mailBody .= (!empty($quoteType))?'project Type: '. PHP_EOL.$quoteType. PHP_EOL . PHP_EOL:'';
    $mailBody .= "Mensagem :" . PHP_EOL;
    $mailBody .= $message . PHP_EOL . PHP_EOL;
    $mailBody .= "Você pode entrar em contato $name via email, $email.";
    $mailBody .= "-------------------------------------------------------------------------------------------" . PHP_EOL;




    //echo '<div class="alert alert-success"> teste! Sua mensagem foi enviada.</div>';

    if(mail($to, $subject, $mailBody, $headers)){
        echo '<div class="alert alert-success">Sucesso! Sua mensagem foi enviada.</div>';
    }

    return $this->redirect()->toRoute('user', [
      'controller' => 'index',
      'action' => 'index'
    ]);
}

// FUNCTIONS
function validEmail($email) {
    $isValid = true;
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex) {
        $isValid = false;
    } else {
        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64) {
            // local part length exceeded
            $isValid = false;
        } else if ($domainLen < 1 || $domainLen > 255) {
            // domain part length exceeded
            $isValid = false;
        } else if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            // local part starts or ends with '.'
            $isValid = false;
        } else if (preg_match('/\\.\\./', $local)) {
            // local part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
            // character not valid in domain part
            $isValid = false;
        } else if (preg_match('/\\.\\./', $domain)) {
            // domain part has two consecutive dots
            $isValid = false;
        } else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) {
                $isValid = false;
            }
        }
        if ($isValid && !(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A"))) {
            // domain not found in DNS
            $isValid = false;
        }
    }
    return $isValid;
}

?>
