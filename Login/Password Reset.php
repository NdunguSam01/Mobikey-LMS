<?php
session_start();

//Including the database config file
include '../Database/Connection.php';

//Getting the email and token from the link
$email=$_GET['email'];
global $token;
$token=$_GET['token'];

//Querying database to see if record exists
$query="SELECT * FROM `password_resets` WHERE email='$email' AND token='$token'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);
if($row['email']===$email && $row['token']===$token)
{
    if(isset($_POST['reset_password']))
    {
        //Getting the data submitted through the form
        $newPassword=$_POST['newPassword'];
        $confirmPassword=$_POST['confirmPassword'];

        //Checking if the two password match
        if($newPassword==$confirmPassword)
        {
            //Hashing the password
            $hashedPassword=md5($confirmPassword);

            //Querying database and updating the password of the account linked to the email
            $accountQuery="UPDATE `users` SET `password`='$hashedPassword' WHERE email='$email'";
            if(mysqli_query($conn,$accountQuery))
            {
                //Deleting token from the database
                $deleteToken="DELETE FROM `password_resets` WHERE email='$email'";
                if(mysqli_query($conn,$deleteToken))
                {
                    $_SESSION['reset_status']="Success";
                    $_SESSION['reset_status_msg']="Password updated successfully";
    
                    //Clearing form data such that it is not re-submitted when page is refreshed
                    header('Location: ./');// Redirect to another page
                    exit();
                }
            }
        }
        else
        {
            $_SESSION['reset_status']="Password mismatch";
            $_SESSION['reset_status_msg']="Passwords don't match";

        }
    }
}
else
{
    $_SESSION['reset_status']="Not found";
    $_SESSION['reset_status_msg']="Token is invalid/has expired";

    //Clearing form data such that it is not re-submitted when page is refreshed
    header('Location: ./Forgot Password');// Redirect to another page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Background.css">
    <link rel="stylesheet" href="./Form.css">
    <link rel="stylesheet" href="./Toast/CSS/toastr.min.css">
    <link rel="icon" href="../Images/Favicon.png" type="image/x-icon">
    <title>Leave Management System</title>
</head>
<body>
    <form action="./Password Reset" method="post">
        <h1>Password Reset Page</h1>
        <label for="token">Password Reset Token</label>
        <input type="text" name="token" value="<?php echo $token;?>" readonly disabled>
        <label for="newPassword">New Password</label>
        <input type="password" name="newPassword" placeholder="Enter your new password" required>
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" name="confirmPassword" placeholder="Confirm password" required>
        <button type="submit" name="reset_password">Reset Password</button><br><br>
        <a href="./" class="login-link">Cancel</a>
    </form>
    <script src="./Toast/JS/jquery.js"></script>
    <script src="./Toast/JS/toastr.min.js"></script>
    <script src="./Toast/JS/Options.js"></script>
    <script>
        <?php
        if(isset($_SESSION['reset_status']))
        {
            if($_SESSION['reset_status']=="Success")
            {
                ?>
                toastr.success("<?php echo $_SESSION["reset_status_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['reset_status']);
                unset($_SESSION['reset_status_msg']);
                header("URL=./Password Reset");
            }
            elseif($_SESSION['reset_status']=="Not found")
            {
                ?>
                toastr.error("<?php echo $_SESSION["reset_status_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['reset_status']);
                unset($_SESSION['reset_status_msg']);
                header("URL=./Password Reset");
            }
            elseif($_SESSION['reset_status']=="Password mismatch")
            {
                ?>
                toastr.error("<?php echo $_SESSION["reset_status_msg"]; ?>");//Displaying the message
                <?php
                unset($_SESSION['reset_status']);
                unset($_SESSION['reset_status_msg']);
                header("URL=./Password Reset");
            }
        }
        ?>
    </script>
</body>
</html>