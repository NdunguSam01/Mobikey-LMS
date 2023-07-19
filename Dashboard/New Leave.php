<?php
include_once '../Database/Connection.php';
include_once './Sessions.php';

$fname=$_SESSION['fname'];
$query="SELECT * FROM users WHERE fname='$fname'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);

//Setting the default time zone
date_default_timezone_set('Africa/Nairobi');

if(isset($_POST["submit_request"]))
{
    //Initializing variables to be inserted into DB
    $employeeID=$_POST['employeeID'];
    $fname=$_SESSION['fname'];
    $lname=$_SESSION["lname"];
    $section=$_POST['section'];
    $department=$_POST['department'];
    $type=$_POST["type"];
    $start=$_POST["start"];
    $end=$_POST["end"];
    $numDays=$_POST['numDays'];
    $reason=$_POST["reason"];
    $submissionDate=date("Y-m-d H:i:s");

    if($_SESSION["role"]=="HOD")
    {
        $directControl="Approved";
        $humanResource="Pending";
        $generalManager="Pending";
    }
    elseif($_SESSION["role"]=="HR")
    {
        $directControl="Approved";
        $humanResource="Approved";
        $generalManager="Pending";
    }
    else
    {
        $directControl="Pending";
        $humanResource="Pending";
        $generalManager="Pending";
    }

    if($type=="Maternity")
    {
        include_once './Data processing/Maternity Leave.php';

    }
    elseif($type=="Paternity")
    {
        include_once './Data processing/Paterity Leave.php';
    }
    elseif($type=="Sick")
    {
        include_once './Data processing/Sick Leave.php';
    }
    else
    {
        include_once './Data processing/Normal Leave.php';
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
    <link rel="stylesheet" href="./CSS/Form.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>

    <form method="post" action="./New Leave" enctype="multipart/form-data" class="main">
        <h1>Leave Application Form</h1>
        <table>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
            </tr>
            <tr>
                <td><input type="text" name="fname" value="<?php echo $_SESSION["fname"];?>" readonly disabled></td>
                <td><input type="text" name="lname" value="<?php echo $_SESSION["lname"];?>" readonly disabled></td>
                <td><input type="email" value="<?php echo $row["email"];?>" readonly disabled></td>
            </tr>
            <tr>
                <td>Department</td>
                <td>Position</td>
                <td>Available Leave Days</td>
            </tr>
            <tr>
                <td><input type="text" value="<?php echo $row["department"];?>" readonly disabled></td>
                <td><input type="text" value="<?php echo $row["position"];?>" readonly disabled></td>
                <td><input type="text" value="<?php echo $_SESSION["lname"];?>" readonly disabled></td>
            </tr>
            <tr>
                <td>
                    <label for="type">Select Leave Type<span>*</span></label><br>
                    <td>Start Date<span>*</span></td>
                    <td>End Date<span>*</span></td>
                </td>
            </tr>
            <tr>
                <td>
                    <select id="type" name="type" required onchange="toggleFileInput()">
                        <option value="">Select leave type</option>
                        <option value="Normal">Normal Leave</option>
                        <option value="Maternity">Maternity Leave</option>
                        <option value="Paternity">Paternity Leave</option>
                        <option value="Sick">Sick Leave</option>
                    </select>
                </td>
                <td>
                    <input type="date" id="start" name="start" required>
                </td>
                <td>
                    <input type="date" id="end" name="end" required>
                </td>      
            </tr>
            <tr>
                <td>Total number of days</td>
                <td>Reason for leave (Optional)</td>
                <td id="fileLabel">Attach file</td>
            </tr>
            <tr>
                <td>
                    <input type="text" name="numDays" id="numDays" readonly>
                    <P id="test"></P>
                </td>
                <td>
                    <textarea placeholder="Reason for leave..." name="reason"></textarea>
                </td>
                <td>
                    <input type="file" id="file-attachment" name="file-attachment" accept=".png, .jpg, .jpeg, .pdf">
                </td>
                <input type="hidden" name="employeeID" value="<?php echo $row['employeeID'];?>">
                <input type="hidden" name="section" value="<?php echo $row['section'];?>">     
                <input type="hidden" name="department" value="<?php echo $row['department'];?>">       
            </tr>
        </table>
        <button type="submit" name="submit_request">Submit Application</button>
    </form>

    <?php
    include_once './Includes/Scripts.php';
    include_once './Includes/Toasts.php'
    ?>
    <script src="./JS/Subtract Days.js"></script>
    <script src="./JS/Date Disable.js"></script>
    <script src="./JS/New Leave.js"></script>
    <script>
        <?php
        if(isset($_SESSION['leave_submission']))
        {
            if($_SESSION["leave_submission"]=="Successful")
            {
                ?>
                toastr.success("<?php echo $_SESSION["leave_submission_msg"];?>");
                <?php
                unset($_SESSION["leave_submission"]);
                unset($_SESSION["leave_submission_msg"]);
            }
            elseif($_SESSION["leave_submission"]=="Failed")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["leave_submission_msg"];?>")
                <?php
                unset($_SESSION["leave_submission"]);
                unset($_SESSION["leave_submission_msg"]);
            }
            elseif($_SESSION["leave_submission"]=="Maternity exceeded!")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["leave_submission_msg"];?>")
                <?php
                unset($_SESSION["leave_submission"]);
                unset($_SESSION["leave_submission_msg"]);
            }
            elseif($_SESSION["leave_submission"]=="Paternity exceeded!")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["leave_submission_msg"];?>")
                <?php
                unset($_SESSION["leave_submission"]);
                unset($_SESSION["leave_submission_msg"]);
            }
            elseif($_SESSION["leave_submission"]=="File too big")
            {
                ?>
                toastr.warning("<?php echo $_SESSION["leave_submission_msg"];?>")
                <?php
                unset($_SESSION["leave_submission"]);
                unset($_SESSION["leave_submission_msg"]);
            }
        }
        ?>
    </script>
</body>
</html>