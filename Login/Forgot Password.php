<?php
session_start();

include_once '../Database/Connection.php';

//Calling the Mailer settings file
include './Mailer settings.php';

if (isset($_POST['reset'])) 
{
    //Initalizing the input
    $email=$_POST['email'];

    //Querying the database to see if the email exists
    $emailQuery="SELECT * FROM users WHERE email='$email'";
    $result=mysqli_query($conn,$emailQuery);
    $row=mysqli_fetch_assoc($result);

    if($row['email']==$email)
    {
        //Generating the token
        $token=bin2hex(random_bytes(15));

        //Creating the email message
        $resetLink="<a href='http://mobikey-leave-tracker.liveblog365.com/Login/Password Reset?token='.$token' target='_blank'>Reset link</a>";
        $message="Greetings dear." ."\n". "Click on the link below to reset your password successfully:\n\n". $resetLink;
        $message="
        Greetings."."<br>"."<br>".
        "Your password reset token has been created successfully. Click on the link below to reset your password."."<br>"."<br>".
        "Password reset token: ".$resetLink."
        ";
        $message=wordwrap($message,70);

        //Setting the email message, address and other headers
        $mailer->addAddress($email);
        $mailer->Subject="Password Reset";
        $mailer->Body=$message;
        $mailer->AltBody=strip_tags($message);

        //Sending the email
        if(!$mailer->send())
        {
            $_SESSION['password_reset_status']="Failed";
            $_SESSION['password_reset_msg']="Email could not be sent!";

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./Forgot Password');// Redirect to another page
            exit();
        }
        else
        {
            $_SESSION['password_reset_status']="Success";
            $_SESSION['password_reset_msg']="Password reset link has been sent to your email!";

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./Forgot Password');// Redirect to another page
            exit();
        }

    }
    else
    {
        $_SESSION['password_reset_status']="Missing";
        $_SESSION['password_reset_msg']="Email not found!";

        //Clearing form data such that it is not re-submitted when page is refreshed
        header('Location: ./Forgot Password');// Redirect to another page
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Background.css">
    <link rel="stylesheet" href="./Toast/CSS/toastr.min.css">
    <link rel="stylesheet" href="./Forgot.css">
    <link rel="icon" href="../Images/Favicon.png" type="image/x-icon">
    <title>Leave Management System</title>
</head>
<body>
    <form action="./Forgot Password" method="post">
        <h1>Password</h1>
        <h1>Reset Form</h1>
        <label for="email">Email: </label>
        <input type="email" name="email" placeholder="Email Address" required>
        <button type="submit" name="reset">Reset password</button>
        <a href="./">Back to Login</a>
    </form>
    
    <script src="./Toast/JS/jquery.js"></script>
    <script src="./Toast/JS//toastr.min.js"></script>
    <script src="./Toast/JS/Options.js"></script>
    <script>
        <?php
        if(isset($_SESSION['password_reset_status']))
        {
            if($_SESSION['password_reset_status']=="Success")
            {
                ?>
                toastr.success("<?php echo $_SESSION["password_reset_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['password_reset_status']);
                unset($_SESSION['password_reset_msg']);
                header("URL=./Forgot Password");
            }
            elseif($_SESSION['password_reset_status']=="Failed")
            {
                ?>
                toastr.error("<?php echo $_SESSION["password_reset_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['password_reset_status']);
                unset($_SESSION['password_reset_msg']);
                header("URL=./Forgot Password");
            }
            elseif($_SESSION['password_reset_status']=="Missing")
            {
                ?>
                toastr.error("<?php echo $_SESSION["password_reset_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['password_reset_status']);
                unset($_SESSION['password_reset_msg']);
                header("URL=./Forgot Password");
            }
        }
        
        ?>
    </script>
</body>
</html>