<?php

if($numDays>90)
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
            $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`,`section`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`, `submissionDate`) VALUES ('$employeeID','$fname','$lname','$section','$department','$type','$start','$end','$numDays','NULL','$directControl','$humanResource','$generalManager','$submissionDate')";
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
?>