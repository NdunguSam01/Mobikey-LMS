<?php
include_once './Sessions.php';
include_once '../Database/Connection.php';

//Calling the functions
include './Functions/Sentence Case.php';
include './Functions/Random Password.php';

//Calling the Mailer settings file
include './Mailer settings.php';
    
if (isset($_POST['create_employee'])) 
{
    $fname=convertToSentenceCase($_POST['fname']);
    $mname=convertToSentenceCase($_POST['mname']);
    $lname=convertToSentenceCase($_POST['lname']);
    $email=$_POST['email'];
    $startDate=$_POST['start'];
    $section=$_POST['section'];
    $department=$_POST['department'];
    $position=$_POST['position'];
    $role=$_POST['role'];

    //Setting the username
    $firstLetter=substr($fname,0,1);
    $username=strtolower($firstLetter.$lname); 

    //Generating a random password
    $password=generateRandomPassword(15);

    //Creating a hashed password to be inserted into the database
    $hashedPassword=md5($password);

    //Querying the database to see if the record exists
    $query="SELECT *  FROM `users` WHERE userName='$username' OR email='$email'";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0)
    {
        $row=mysqli_fetch_assoc($result);
        if($row['userName']==$username)
        {
            $_SESSION['employee_creation']='Username taken';
            $_SESSION['employee_creation_msg']='The names entered are linked with a different account';

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./New Employee');// Redirect to another page
            exit();
        }
        elseif($row['email']==$email)
        {
            $_SESSION['employee_creation']='Email taken';
            $_SESSION['employee_creation_msg']='Email is linked with a different account';

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./New Employee');// Redirect to another page
            exit();
        }
    }
    else
    {
        //Inserting information into the database
        $insert="INSERT INTO `users`(`fname`, `mname` ,`lname`, `userName`, `email`, `startDate`, `section`, `department`, `position`, `role`, `password`) VALUES ('$fname','$mname','$lname','$username','$email','$startDate','$section','$department','$position','$role','$hashedPassword')";
        if(mysqli_query($conn,$insert))
        {
            //Creating the email message
            $loginLink="<a href='http://mobikey-leave-tracker.liveblog365.com/Login/' target='_blank'>Login page</a>";
            $message="Dear ".$fname." ".$mname." ".$lname.","."<br><br>".
            "Your leave management system account has been created successfully. Use the login credentials below to login"."<br>"."<br>".
            "Link to the login page: ".$loginLink."<br><br>".
            "Username: ".$username."<br><br>".
            "Password: ".$password."<br><br>".
            "Kindly do not share your login credentials with anyone else"
            ;
            $message=wordwrap($message,70);

            // Setting the email body and email recipient
            $mailer->addAddress($email, $fname." ".$lname);
            $mailer->Subject="Leave Management System-Account creation";
            $mailer->Body=$message;
            $mailer->AltBody=strip_tags($message);

            if(!$mailer->send())
            {
                $_SESSION['employee_creation']="Email send failed";
                $_SESSION['employee_creation_msg']="Email could not be sent: ".$mailer->ErrorInfo;

                //Clearing form data such that it is not re-submitted when page is refreshed
                header('Location: ./New Employee');// Redirect to another page
                exit();
            }
            else
            {
                //Creating a session to be used in the toast message
                $_SESSION['employee_creation']="Successful";
                $_SESSION['employee_creation_msg']='Account created successfully';

                //Clearing form data such that it is not re-submitted when page is refreshed
                header('Location: ./New Employee');// Redirect to another page
                exit();
            }
        }
        else
        {
            //Creating a session to be used in the toast message
            $_SESSION['employee_creation']="Save failed";
            $_SESSION['employee_creation_msg']='Error saving information in the database';

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./New Employee');// Redirect to another page
            exit();
        }        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once './Includes/Header.php';
    include_once './Includes/Styles.php';
    ?>
    <link rel="stylesheet" href="./CSS/New Employee.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>

    <form action="./New Employee" method="post">
        <h1>Employee Registration Form</h1>
        <table>
            <tr>
                <td>
                    <label for="fname">First Name <span>*</span></label>
                </td>
                <td>
                    <label for="mname">Middle Name<span>*</span></label>
                </td>
                <td>
                    <label for="lname">Last Name <span>*</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="fname" placeholder="First Name" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="mname" placeholder="Middle Name" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="lname" placeholder="Last Name" autocomplete="off" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email">Email Address <span>*</span></label>
                </td>
                <td>
                    <label for="startDate">Start Date <span>*</span></label>
                </td>
                <td>
                    <label for="section">Section <span>*</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="email" name="email" placeholder="Email Address" autocomplete="off" required>
                </td>
                <td>
                    <input type="date" name="start" autocomplete="off" required>
                </td>
                <td>
                    <select name="section">
                        <option value="">Select Section</option>
                        <option value="Mobikey">Mobikey</option>
                        <option value="OOTB">Out Of The Box</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="department">Department<span>*</span></label>
                </td>
                <td>
                    <label for="position">Position<span>*</span></label>
                </td>
                <td>
                    <label for="role">Role<span>*</span></label>
                </td>
            </tr>
            <tr>
                <td>
                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="Admin">Administration</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Logistics">Logistics</option>
                        <option value="Sales">Sales</option>
                        <option value="Finance">Finance</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="OOTB">Out of The Box</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="position" placeholder="Position" autocomplete="off" required>
                </td>
                <td>
                    <select name="role" required>
                        <option value="">Select role</option>
                        <option value="User">User</option>
                        <option value="HOD">Head of Department</option>
                        <option value="General Manager">General Manager</option>
                        <option value="HR">HR Manager</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" name="create_employee">Create Employee</button>
    </form>
    <?php
    include_once './Includes/Scripts.php';
    include_once './Includes/Toasts.php'
    ?>
    <script src='./JS/Date Disable.js'></script>
    <script>
        <?php

        if(isset($_SESSION['employee_creation']))
        {
            if($_SESSION["employee_creation"]=="Successful")
            {
                ?>
                toastr.success("<?php echo $_SESSION["employee_creation_msg"];?>");
                <?php
                unset($_SESSION["employee_creation"]);
                unset($_SESSION["employee_creation_msg"]);
            }
            elseif($_SESSION["employee_creation"]=="Email taken")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["employee_creation_msg"];?>")
                <?php
                unset($_SESSION["employee_creation"]);
                unset($_SESSION["employee_creation_msg"]);
            }
            elseif($_SESSION["employee_creation"]=="Username taken")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["employee_creation_msg"];?>")
                <?php
                unset($_SESSION["employee_creation"]);
                unset($_SESSION["employee_creation_msg"]);
            }
            elseif($_SESSION["employee_creation"]=="Save failed")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["employee_creation_msg"];?>")
                <?php
                unset($_SESSION["employee_creation"]);
                unset($_SESSION["employee_creation_msg"]);
            }
            elseif($_SESSION["employee_creation"]=="Email send failed")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["employee_creation_msg"];?>")
                <?php
                unset($_SESSION["employee_creation"]);
                unset($_SESSION["employee_creation_msg"]);
            }
        }
        ?>
    </script>
</body>
</html>