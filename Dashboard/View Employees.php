<?php

include_once './Sessions.php';
include_once '../Database/Connection.php';

$fname=$_SESSION["fname"];
$lname=$_SESSION['lname'];
$query="SELECT * FROM users ";
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
    <link rel="stylesheet" href="./CSS/View Employees.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>
    <h1>Employee Records</h1>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Employment Date</th>
            <th>Section</th>
            <th>Department</th>
            <th>Position</th>
            <th colspan="2">Action</th>
        </tr>
            <?php
            if(mysqli_num_rows($result)>0)
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    echo "<tr>";
                    echo "<td>". $row["fname"]. "</td>";   
                    echo "<td>". $row["lname"]. "</td>";   
                    echo "<td>". $row["email"]. "</td>";   
                    echo "<td>". $row["startDate"]. "</td>";   
                    echo "<td>". $row["section"]. "</td>";   
                    echo "<td>". $row["department"]. "</td>";
                    echo "<td>". $row["position"]. "</td>";
                    echo "<td><i class='fa fa-edit'></i></td>";
                    echo "<td><i class='fa fa-trash-o'></i></td>";
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