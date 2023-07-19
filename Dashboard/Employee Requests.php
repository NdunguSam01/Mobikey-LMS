<?php

include_once './Sessions.php';
include_once '../Database/Connection.php';

$role=$_SESSION['role'];

if ($role=="HOD") 
{
    //Querying the database for the HOD's department
    $HODquery="SELECT * FROM users WHERE role='$role'";
    $HODresult=mysqli_query($conn,$HODquery);
    $HODrow=mysqli_fetch_assoc($HODresult);

    //Setting the HOD's department to be used while querying the leaveDays table
    $HODsection=$HODrow['section'];
    $HODdepartment=$HODrow['department'];

    //Querying leave days database for requests from users from the HOD's department
    $requestsQuery="SELECT * FROM leavedays WHERE department='$HODdepartment' AND section='$HODsection' AND directControl='Pending' AND generalManager='Pending' AND humanResource='Pending' ";
    $requestResult=mysqli_query($conn,$requestsQuery);
}
elseif($_SESSION['role']=="General Manager")
{
    //Querying the database for the GM's section 
    $GMquery="SELECT * FROM users WHERE role='$role'";
    $GMresult=mysqli_query($conn,$GMquery);
    $GMrow=mysqli_fetch_assoc($GMresult);

    $GMsection=$GMrow['section'];

    //Selecting leave days from the database based on the section
    $requestsQuery="SELECT * FROM leavedays WHERE section='$GMsection' AND directControl='Approved' AND generalManager='Pending'";
    $requestResult=mysqli_query($conn,$requestsQuery);
}
elseif($_SESSION['role']=="HR")
{
    //Querying leave days database for requests from users from the HOD's department
    $requestsQuery="SELECT * FROM leavedays WHERE directControl='Approved' AND generalManager='Approved'";
    $requestResult=mysqli_query($conn,$requestsQuery);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    include_once './Includes/Header.php';
    include_once './Includes/Styles.php';
    ?>
    <link rel="stylesheet" href="./CSS/Table.css">
    <link rel="stylesheet" href="./CSS/Buttons.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>
    <table>
        <h1>Pending Employee Requests</h1>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Number of Days</th>
            <th>File attachment</th>
            <th colspan="2" style="text-align: center;">Action</th>
        </tr>
        <tr>
            <?php
            if($_SESSION['role']=="HOD")
            {
                include_once './Requests/Requests.php';
            }
            elseif($_SESSION['role']=="General Manager")
            {
                include_once './Requests/Requests.php';

            }
            elseif($_SESSION['role']=="HR")
            {
                include_once './Requests/Requests.php';
            }
            ?>
        </tr>

    </table>
    <a href="./Sick Leave/<?php echo $requestRow['filePath'];?>"></a>
    <?php
    include_once './Includes/Scripts.php';
    ?>

</body>
</html>