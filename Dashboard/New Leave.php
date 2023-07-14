<?php
include_once '../Database/Connection.php';
include_once './Sessions.php';

//Declaring the path to the functions
include './Functions/Check Holidays.php';
include './Functions/Count Saturdays.php';
include './Functions/Count Sundays.php';
include './Functions/Subtract Days.php';

$fname=$_SESSION['fname'];
$query="SELECT * FROM users WHERE fname='$fname'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);

if(isset($_POST["submit_request"]))
{
    //Initializing variables to be inserted into DB
    $employeeID=$_POST['employeeID'];
    $fname=$_SESSION['fname'];
    $lname=$_SESSION["lname"];
    $department=$_POST['department'];
    $type=$_POST["type"];
    $start=$_POST["start"];
    $end=$_POST["end"];
    $reason=$_POST["reason"];

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
    
    //Subtracting the days excluding the holidays,Saturdays and Sundays
    $leaveDays=subtractDays($start, $end);

    //Start of Maternity leave data handling and processing
    if($type=="Maternity")
    {
        if($leaveDays>90)
        {
            $_SESSION['leave_submission']="Maternity exceeded!";
            $_SESSION['leave_submission_msg']="Maternity leave should not be more than 90 days";

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./New Leave');// Redirect to another page
            exit();
        }
        else
        {
            //Checking if leave record exists
            $leaveQuery="SELECT * FROM leavedays WHERE employeeID='$employeeID' AND startDate='$start' AND endDate='$end' AND leaveType='$type'";
            $result=mysqli_query($conn,$leaveQuery);
            if($result)
            {
                if(mysqli_num_rows($result)>0)
                {
                    $_SESSION["leave_submission"]="Failed";
                    $_SESSION['leave_submission_msg']="Request already exists!";
                    
                    //Clearing form data such that it is not re-submitted when page is refreshed
                    header('Location: ./New Leave');// Redirect to another page
                    exit();
                }
                else
                {
                    $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES ('$employeeID','$fname','$lname','$department','$type','$start','$end','$leaveDays','NULL','$directControl','$humanResource','$generalManager')";
                    mysqli_query($conn,$insert);
                    $_SESSION["leave_submission"]="Successful";
                    $_SESSION['leave_submission_msg']='Request submitted succesfully!';
                    header('Location: ./New Leave');
                    exit();
                }
            }
            else
            {
                echo 'Error: '.mysqli_connect_error();
            }
            $_POST=array();
        }
    }//End of Maternity leave data handling and processing


    //Start of Paternity leave data handling and processing
    elseif($type=="Paternity")
    {
        if($leaveDays>14)
        {
            $_SESSION['leave_submission']="Paternity exceeded!";
            $_SESSION['leave_submission_msg']="Paternity leave should not be more than 14 days";

            //Clearing form data such that it is not re-submitted when page is refreshed
            header('Location: ./New Leave');// Redirect to another page
            exit();
        }
        else
        {
            //File submission handling
            $file=$_FILES["file-attachment"];
            $fileName=$_FILES['file-attachment']['name'];
            $fileTmpName=$_FILES['file-attachment']['tmp_name'];
            $fileSize=$_FILES['file-attachment']['size'];
            $fileError=$_FILES['file-attachment']['error'];

            //Extracting the file extension
            $fileExt=explode('.', $fileName);
            $fileActualExt=strtolower(end($fileExt));

            if($fileError===0)
            {
                if($fileSize<10000000)
                {
                    //Creating a unique ID for the uploads
                    $fileNewName=uniqid('', true). ".".$fileActualExt;
                    echo $fileNewName;
                    $fileDestination='Paternity Leave/'. $fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    // Checking if leave record exists
                    $leaveQuery="SELECT * FROM leavedays WHERE employeeID='$employeeID' AND startDate='$start' AND endDate='$end' AND leaveType='$type'";
                    $result=mysqli_query($conn,$leaveQuery);
                    if($result)
                    {
                        if(mysqli_num_rows($result)>0)
                        {
                            $_SESSION["leave_submission"]="Failed";
                            $_SESSION['leave_submission_msg']="Request already exists!";

                            //Clearing form data such that it is not re-submitted when page is refreshed
                            header('Location: ./New Leave');// Redirect to another page
                            exit();
                        }
                        else
                        {
                            $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES ('$employeeID','$fname','$lname','$department','$type','$start','$end','$leaveDays','$fileNewName','$directControl','$humanResource','$generalManager')";
                            mysqli_query($conn,$insert);
                            $_SESSION["leave_submission"]="Successful";
                            $_SESSION['leave_submission_msg']='Request submitted succesfully!';

                            //Clearing form data such that it is not re-submitted when page is refreshed
                            header('Location: ./New Leave');// Redirect to another page
                            exit();
                        }
                    }
                    else
                    {
                        echo 'Error: '.mysqli_connect_error();
                    }
                }
                else
                {
                    $_SESSION["leave_submission"]="File too big";
                    $_SESSION['leave_submission_msg']="Your file is too big!";

                    //Clearing form data such that it is not re-submitted when page is refreshed
                    header('Location: ./New Leave');// Redirect to another page
                    exit();
                }
            }
            else
            {
                $_SESSION["leave_submission"]="Error uploading file";
                $_SESSION['leave_submission_msg']="Error uploading file. Please try again!";
            }
            $_POST=array();
        }
    }//End of Paternity leave data handling and processing

    //Start of Sick leave data handling and processing
    elseif($type=="Sick")
    {
        //File submission handling
        $file=$_FILES["file-attachment"];
        $fileName=$_FILES['file-attachment']['name'];
        $fileTmpName=$_FILES['file-attachment']['tmp_name'];
        $fileSize=$_FILES['file-attachment']['size'];
        $fileError=$_FILES['file-attachment']['error'];

        //Extracting the file extension
        $fileExt=explode('.', $fileName);
        $fileActualExt=strtolower(end($fileExt));

        if($fileError===0)
        {
            if($fileSize<10000000)
            {
                //Creating a unique ID for the uploads
                $fileNewName=uniqid('', true). ".".$fileActualExt;
                $fileDestination='Sick Leave/'. $fileNewName;
                move_uploaded_file($fileTmpName, $fileDestination);

                // Checking if leave record exists
                $leaveQuery="SELECT * FROM leavedays WHERE employeeID='$employeeID' AND startDate='$start' AND endDate='$end' AND leaveType='$type'";
                $result=mysqli_query($conn,$leaveQuery);
                if($result)
                {
                    if(mysqli_num_rows($result)>0)
                    {
                        $_SESSION["leave_submission"]="Failed";
                        $_SESSION['leave_submission_msg']="Request already exists!";

                        //Clearing form data such that it is not re-submitted when page is refreshed
                        header('Location: ./New Leave');// Redirect to another page
                        exit();
                    }
                    else
                    {
                        
                        //Calling the functions 
                        countSaturdays($start,$end);
                        countSundays($start,$end);
                        includesHolidays($start,$end);

                        // Subtracting Saturdays, Sundays and holidays from the counted days
                        $remainingNumdays=$leaveDays-($saturdayCount*0.5)-($sundayCount*1)-($holidayCount*1);
                        echo $remainingNumdays;

                        $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES ('$employeeID','$fname','$lname','$department','$type','$start','$end','$remainingNumdays','$fileNewName','$directControl','$humanResource','$generalManager')";
                        mysqli_query($conn,$insert);
                        $_SESSION["leave_submission"]="Successful";
                        $_SESSION['leave_submission_msg']='Request submitted succesfully!';

                        //Clearing form data such that it is not re-submitted when page is refreshed
                        header('Location: ./New Leave');// Redirect to another page
                        exit();
                    }
                }
                else
                {
                    echo 'Error: '.mysqli_connect_error();
                }
            }
            else
            {
                $_SESSION["leave_submission"]="File too big";
                $_SESSION['leave_submission_msg']="Your file is too big!";

                //Clearing form data such that it is not re-submitted when page is refreshed
                header('Location: ./New Leave');// Redirect to another page
                exit();
            }
        }
        else
        {
            $_SESSION["leave_submission"]="Error uploading file";
            $_SESSION['leave_submission_msg']="Error uploading file. Please try again!";
        }
        $_POST=array();
    }//End of Sick leave data handling and processing

    //Start of Normal leave data handling and processing
    else
    {
        //Calling the functions 
        countSaturdays($start,$end);
        countSundays($start,$end);
        includesHolidays($start,$end);

        // Subtracting Saturdays and Sundays from the counted days
        $remainingNumdays=$leaveDays-($saturdayCount*0.5)-($sundayCount*1)-($holidayCount*1);

        //Checking if leave record exists
        $leaveQuery="SELECT * FROM leavedays WHERE employeeID='$employeeID' AND startDate='$start' AND endDate='$end' AND leaveType='$type'";
        $result=mysqli_query($conn,$leaveQuery);
        if($result)
        {
            if(mysqli_num_rows($result)>0)
            {
                $_SESSION["leave_submission"]="Failed";
                $_SESSION['leave_submission_msg']="Request already exists!";

                //Clearing form data such that it is not re-submitted when page is refreshed
                header('Location: ./New Leave');// Redirect to another page
                exit();
            }
            else
            {
                $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES ('$employeeID','$fname','$lname','$department','$type','$start','$end','$remainingNumdays','NULL','$directControl','$humanResource','$generalManager')";
                mysqli_query($conn,$insert);
                $_SESSION["leave_submission"]="Successful";
                $_SESSION['leave_submission_msg']='Request submitted succesfully!';

                //Clearing form data such that it is not re-submitted when page is refreshed
                header('Location: ./New Leave');// Redirect to another page
                exit();
            }
        }
        else
        {
            echo 'Error: '.mysqli_connect_error();
        }
        $_POST=array();
    }//End of Normal leave data handling and processing
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once './Includes/Header.php';
    include_once './Includes/Styles.php';
    ?>
    <link rel="stylesheet" href="./CSS/New Leave.css">
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
                <td><input type="date" id="start" name="start" required></td>
                <td><input type="date" id="end" name="end" required></td>      
            </tr>
            <tr>
                <td>Reason for leave (Optional)</td>
                <td id="fileLabel">Attach file</td>
            </tr>
            <tr>
                <td><textarea placeholder="Reason for leave..." name="reason"></textarea></td>
                <td>
                    <input type="file" id="file-attachment" name="file-attachment" accept=".png, .jpg, .jpeg, .pdf">
                </td>
                <input type="hidden" name="employeeID" value="<?php echo $row['employeeID'];?>">     
                <input type="hidden" name="department" value="<?php echo $row['department'];?>">       
            </tr>
        </table>
        <button type="submit" name="submit_request">Submit Application</button>
    </form>
    <?php
    include_once './Includes/Scripts.php';
    include_once './Includes/Toasts.php'
    ?>
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