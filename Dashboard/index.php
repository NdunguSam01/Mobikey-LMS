<?php
include_once './Sessions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once './Includes/Styles.php';
    include_once './Includes/Header.php';
    ?>
    <link rel="stylesheet" href="./CSS/Welcome message.css">
</head>
<body>
    <?php
    include_once './Includes/Nav.php';
    include_once './Includes/Side.php';
    ?>
    <section class="main">
        <div class="welcome-txt">
            <img src="../Images/Profile.png" alt="User profile" class="profile-img">
            <h1>Welcome back, <?php echo $_SESSION["names"];?></h1>
        </div>
    </section>
    <?php
    include_once './Includes/Scripts.php';
    include_once './Includes/Styles.php';
    ?>
</body>
</html>