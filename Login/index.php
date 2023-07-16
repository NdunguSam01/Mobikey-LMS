<?php
session_start();
include '../Database/Connection.php';
if(isset($_POST["login"]))
{
    //Getting the data submitted in the form
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    //Querying database to check if user information exists
    $query="SELECT * FROM users WHERE userName='$username' AND password='$password' ";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($result);

    if($result)
    {
        if(mysqli_num_rows($result)>0)
        {
            //Setting the session variables
            $_SESSION['username']=$username;
            $_SESSION["status"]="Success";//Used to toastr the successful login message
            $_SESSION['msg']="Sign In successful";//Message to be displayed in the toastr
            $_SESSION["role"]=$row["role"];
            $_SESSION["fname"]=$row["fname"];
            $_SESSION["lname"]=$row["lname"];
            $_SESSION["names"]=$row["fname"]. " ". $row["lname"];
            $_SESSION["login_time"]=time();
        }
        else
        {
            $_SESSION["status"]="Failure";//Used in the process of showing toastr for failed user authentication
            $_SESSION['msg']="Wrong username/password combination!";//Message to be displayed in the toastr
        }
    }
    else
    {
        echo "Error fetching user information!";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Leave Management System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./Toast/CSS/toastr.min.css">
        <link rel="stylesheet" href="../Background.css">
        <link rel="stylesheet" href="./Form.css">
        <link rel="icon" href="../Images/Favicon.png" type="image/x-icon">
    </head>
    <body>
        <form action="./" method="post">
            <h1>Login Form</h1>
            <label for="username">Username: </label><br><br>
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <label for="password">Password: </label><br><br>
            <input type="password" name="password" placeholder="Password" id="password" required>
            <button type="submit" name="login">Login</button><br><br>
            <a href="../" class="cancel">Cancel</a>
            <a href="./Forgot Password" class="forgot">Forgot password?</a>
        </form>
        <script src="./Toast/JS/jquery.js"></script>
        <script src="./Toast/JS//toastr.min.js"></script>
        <script src="./Toast/JS/Options.js"></script>
        <script>
            <?php
                if($_SESSION["status"]=="Success")//Checking if authentication is successful
                {
                    ?>
                    toastr.success("<?php echo $_SESSION["msg"]; ?>");//Displaying the message
                    
                    <?php
                        unset($_SESSION["status"]);
                        unset($_SESSION["msg"]);
                        header( "refresh:3;URL=../Dashboard" );
                }
                elseif($_SESSION["status"]=="Failure")//Checking if authentication is unsuccessful
                {
                    ?>
                    toastr.error("<?php echo $_SESSION["msg"]; ?>");//Displaying error message
                    <?php
                        session_unset();
                        session_destroy();
                        header( "URL=./" );
                }
                elseif($_SESSION["status"]=="Unauthorized")
                {
                    ?>
                    toastr.warning("<?php echo $_SESSION["msg"]; ?>")
                    <?php
                        session_unset();
                        session_destroy();
                        header( "URL=./" );
                }
                elseif($_SESSION["status"]=="Expired")
                {
                    ?>
                    toastr.warning("<?php echo $_SESSION["msg"]; ?>")
                    <?php
                        session_unset();
                        session_destroy();
                        header( "URL=./" );
                }
            ?>
        </script>
    </body>
</html>