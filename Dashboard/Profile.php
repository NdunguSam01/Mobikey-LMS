<?php
include_once '../Database/Connection.php';
include_once './Sessions.php';

$fname=$_SESSION['fname'];
$query="SELECT * FROM users WHERE fname='$fname'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once './Includes/Header.php';
    include_once './Includes/Styles.php';
    ?>
    <link rel="stylesheet" href="./CSS/Profile.css">
</head>
<body>
    <!-- <div class="profile-img">
        <img src="" alt="Profile picture">
        <button id="openFile">Change profile picture</button>
        <input type="file" id="fileInput" style="display: none;">
    </div> -->
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>
    <form>
        <table>
            <tr>
                <td colspan="4">
                    <h1>User details</h1>
                </td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email Address</td>
                <td>Phone Number</td>
            </tr>
            <tr>
                <td><input type="text" readonly disabled value="<?php echo $_SESSION["fname"];?>"></td>
                <td><input type="text" readonly disabled value="<?php echo $_SESSION["lname"];?>"></td>
                <td><input type="email" readonly disabled value="<?php echo $row["email"];?>"></td>
                <td><input type="text" readonly disabled value="<?php echo $row["phone"];?>"></td>

            </tr>
            <tr>
                <td>Section</td>
                <td>Department</td>
                <td>Position</td>
                <td>Employment Date</td>
            </tr>
            <tr>
                <td><input type="text" readonly disabled value="<?php echo $row["section"];?>"></td>
                <td><input type="text" readonly disabled value="<?php echo $row["department"];?>"></td>
                <td><input type="text" readonly disabled value="<?php echo $row["position"];?>"></td>
                <td><input type="text" readonly disabled value="<?php echo $row["startDate"];?>"></td>
            </tr>
        </table>
    </form>
    <form>
        <table>
            <tr>
                <td colspan="3">
                    <h1>Change password</h1>
                </td>
            </tr>
            <tr>
                <td>Current password</td>
                <td>New password</td>
                <td>Confirm new password</td>
            </tr>
            <tr>
                <td><input type="password" readonly disabled value="<?php echo $row["password"];?>"></td>
                <td><input type="password" placeholder="New password" required></td>
                <td><input type="password" placeholder="Confirm new password" required></td>
            </tr>
            <tr>
                <td colspan="4">
                    <button type="submit">Update password</button>
                </td>
            </tr>
        </table>
    </form>
    <?php
    include_once './Includes/Scripts.php';
    ?>
    <script src="./JS/Profile.js"></script>
</body>
</html>