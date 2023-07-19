<?php

if($numDays>14)
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
                    $insert="INSERT INTO `leavedays`(`employeeID`, `fname`, `lname`,`section`, `department`,`leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`, `submissionDate`) VALUES ('$employeeID','$fname','$lname','$section','$department','$type','$start','$end','$numDays','$fileNewName','$directControl','$humanResource','$generalManager','$submissionDate')";
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
?>