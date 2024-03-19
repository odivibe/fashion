<?php

$title = 'Registration';
require_once '../include/header.php';
/*require_once __DIR__.'/include/config.php';
//require_once __DIR__.'/include/connection.php'; //database connection file
//require 'vendor/autoload.php'; // Include PHPMailer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $password = $confirm_password = $first_name = $last_name = ""
$errors = array('email_err' => '', 'password_err' => '', 'confirm_password_err' => '', 'first_name_err' => '', 'last_name_err' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $errors = [];

    // Check if fields are empty
    if (empty($_POST['first_name'])) {
        $errors['first_name_err'] = "First name is required.";
    }
    else
    {
        $first_name = sanitizeInput($_POST['first_name']);

        if(!preg_match("/^[a-zA-Z]+$/", $first_name))
        {
            $errors['first_name_err'] = "Only letters are required.";
        }
    }

    if (empty($_POST['last_name'])) {
        $errors['last_name_err'] = "Last name is required.";
    }
    else
    {
        $last_name = sanitizeInput($_POST['last_name']);

        if(!preg_match("/^[a-zA-Z]+$/", $last_name))
        {
            $errors['last_name_err'] = "Only letters are required.";
        }
    }

    if (empty($_POST['email'])) {
        $errors['email_err'] = "Email is required.";
    }
    else
    {

        $email = strtolower(filter_var(sanitizeInput($_POST['email']), FILTER_SANITIZE_EMAIL));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {   
          $errors['email_err'] = "Invalid email format.";
        }

        $query = "SELECT email FROM register_user WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindparam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetchColumn())
        {
          $errors['email_err'] = "Email already exist.";
        }
    }

    
    if(empty($_POST['password']))
    {
        $errors['password_err'] = "Password is required.";    
    }
    else
    {
        $password = sanitizeInput($_POST['password']);

        if(strlen($password) < 6)
        {
            $errors['password_err'] = "Must contain 6 characters or more.";
        }
    }

    //confirm password verification
    if(empty($_POST['confirm_password']))
    {
        $errors['confirm_password_err'] = "Confirm password is required.";
    }
    else
    {
        $confirm_password = sanitizeInput($_POST['confirm_password']);

        if($password !== $confirm_password)
        {
            $errors['password_err'] = "Passwords not matched."; 
        }
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $created = date('Y-m-d H:i:s');
    $last_seen = date('Y-m-d H:i:s');

    //token for email verify
    $email_token = bin2hex(openssl_random_pseudo_bytes(16)).md5($email);

    //email verification link
    $verify_email_url = BASE_URL.'account/verify-email.php?token='.
    $email_token.'&email='.$email.'&token_expire='.base64_encode($token_expire_time);






    if (empty($errors)) 
    {
        // Sanitize user input
        $first_name = sanitizeInput($_POST['first_name']);
        $last_name = sanitizeInput($_POST['last_name']);
        $email = filter_var(sanitizeInput($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT);
        $confirm_password = password_hash(sanitizeInput($_POST['confirm_password']), PASSWORD_DEFAULT);

        // Generate activation token
        $token = bin2hex(random_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 day')); // Expiration time: 1 day

        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, activation_token, activation_expiration) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $password, $token, $expiration]);

        // Send activation email using PHPMailer
        $mail = new PHPMailer(true);
        try 
        {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io'; // Change to your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '670c70f26f6810'; // Change to your email
            $mail->Password = 'd4b68560895d65'; // Change to your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525; //587

            $mail->setFrom('probeat8080@gmail.com', 'Evib Codes'); // Change to your email and name
            $mail->addAddress($email, $first_name . ' ' . $last_name);

            $mail->isHTML(true);
            $mail->Subject = 'Activate Your Account';
            $mail->Body = "Click the following link to activate your account:<br> <a href='http://yourwebsite.com/confirm_email.php?email=$email&token=$token&expire=$expiration'>Activate Now</a>";

            $mail->send();
            header("Location: register_user_message.php");
            exit();
        } 
        catch (Exception $e) 
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}*/
?>

<div class="main-content">

    <div class="form-container">
        <h2>Registration</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?= $_POST['first_name'] ?? '' ?>" required>
            <?php if (isset($errors['first_name'])) echo "<p class='error'>{$errors['first_name']}</p>"; ?><br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?= $_POST['last_name'] ?? '' ?>" required>
            <?php if (isset($errors['last_name'])) echo "<p class='error'>{$errors['last_name']}</p>"; ?><br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
            <?php if (isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?><br><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <?php if (isset($errors['password'])) echo "<p class='error'>{$errors['password']}</p>"; ?><br><br>

            <label for="password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            <?php if (isset($errors['confirm_password'])) echo "<p class='error'>{$errors['confirm_password']}</p>"; ?><br><br>

            <input type="submit" name="register" value="Register" >
        </form>

    </div>
    
</div>

<?php require_once '../include/footer.php'; ?>
