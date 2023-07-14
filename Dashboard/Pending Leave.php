<?php
include_once './Sessions.php';
include_once '../Database/Connection.php';
$fname=$_SESSION["fname"];
$lname=$_SESSION['lname'];
$query="SELECT * FROM leavedays WHERE fname='$fname' AND lname='$lname'";
$result=mysqli_query($conn, $query);
if(!$result)
{
    die("Query failed: ". mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once './Includes/Header.php';
    include_once './Includes/Styles.php';
    ?>
    <link rel="stylesheet" href="./CSS/Pending Leave.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>

    <h1>Pending Leave Requests</h1>
    <table>
        <tr>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Number of Days</th>
            <th>Direct Control</th>
            <th>General Manager</th>
            <th>Human Resources</th>
        </tr>
            <?php
            if(mysqli_num_rows($result)>0)
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<tr>";
                    echo "<td>". $row["leaveType"]. "</td>";   
                    echo "<td>". $row["startDate"]. "</td>";   
                    echo "<td>". $row["endDate"]. "</td>";   
                    echo "<td>". $row["numDays"]. "</td>";   
                    echo "<td>". $row["directControl"]. "</td>";   
                    echo "<td>". $row["generalManager"]. "</td>";   
                    echo "<td>". $row["humanResource"]. "</td>";
                }
   
            }
            else
            {
                echo "<tr>
                <td colspan=7 style='text-align: center'>No Records Found</td>
                </tr>";
            }
            ?>
    </table>

    <?php
    include_once './Includes/Scripts.php';
    ?>

</body>
</html>