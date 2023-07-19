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
    <link rel="stylesheet" href="./CSS/Statistics.css">
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
        <div class="grid">
            <div class="stat-box">
                <div class="counter-box">
                    <i class="fa fa-history"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>Total requests</h4>
                </div>
            </div>
            <div class="stat-box">
                <div class="counter-box">
                    <i class="fa fa-calendar-check-o"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>approved requests</h4>
                </div>
            </div>
            <div class="stat-box">
                <div class="counter-box">
                    <i class="fa fa-calendar-times-o"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>rejected requests</h4>
                </div>
            </div>
            <div class="stat-box">
                <div class="counter-box">
                    <i class="fa fa-clock-o"></i>                
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>pending requests</h4>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col">
                <div class="counter-box">
                    <i class="fa fa-history"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>Total requests</h4>
                </div>
            </div>
            <div class="col">
                <div class="counter-box">
                    <i class="fa fa-calendar-check-o"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>approved requests</h4>
                </div>
            </div>
            <div class="col">
                <div class="counter-box">
                    <i class="fa fa-calendar-times-o"></i>
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>rejected requests</h4>
                </div>
            </div>
            <div class="col">
                <div class="counter-box">
                    <i class="fa fa-clock-o"></i>                
                    <h2 class="counter" data-count="300">0</h2>
                    <h4>pending requests</h4>
                </div>
            </div>
        </div> -->

    </section>
    <?php
    include_once './Includes/Scripts.php';
    include_once './Includes/Styles.php';
    ?>
    <script src="./JS/Statistic counter.js"></script>
</body>
</html>