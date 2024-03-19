<?php
/*
this file shows success message after form registration, register.php is redirected to it.
*/

$title = "Resend Registration Success";
$email = '';

require_once '../include/configs.php';

if (isset($_SESSION['user_email'])) 
{
    $email = $_SESSION['user_email'];
}

?>

<?php require_once '../include/header.php'; ?>

<div class="main-content">
    <div class="msg-output">
	    <p>
	    	Verification email has been sent to your email address again,<?php echo '<b> '.$email.'</b>'; ?> 
	    </p>
	    <p>Click the link in the email to verify your account</p>
	    <div class="align-button">
            <p>
                If you having any issue receiving the email, please check your spam filter. Also ensure that email address u supplied do exist.
            </p>
	    </div>
    </div>

</div>

<?php require_once '../include/footer.php'; ?>

  