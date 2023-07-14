<side class="side-bar">
    <header>
        <img src="../Images/Logo.png" alt="Mobikey Logo">
    </header>
    <?php
    ?>
    <div class="menu">
        <div class="item">
            <a href="./"><i class="fa fa-desktop"></i>Dashboard</a>
        </div>
        <div class="item">
            <a class="sub-btn"><i class="fa fa-calendar"></i>My Leave Requests<i class="fa fa-angle-right dropdown"></i></a>
            <div class="sub-menu">
                <a href="./New Leave" class="sub-item">New Request</a>
                <a href="./Pending Leave" class="sub-item">Pending Requests</a>
                <a href="./Approved Leave" class="sub-item">Approved Requests</a>
                <a href="./Rejected Leave" class="sub-item">Rejected Requests</a>
            </div>
        </div>
        <?php
        if($_SESSION['role']=='HOD')
        {
            ?>
            <div class="item">
                <a href="./Employee Requests"><i class="fa fa-clock-o"></i>Pending Requests</a>
            </div>
            <?php
        }
        elseif($_SESSION["role"]=='HR' || $_SESSION['role']=="Admin")
        {
            ?>
            <div class="item">
                <a href="./Employee Requests"><i class="fa fa-clock-o"></i>Employee Requests</a>
            </div>
            <div class="item">
                <a class="sub-btn"><i class=" fa fa-user"></i>Employees<i class="fa fa-angle-right dropdown"></i></a>
                <div class="sub-menu">
                    <a href="./New Employee" class="sub-item">New employee</a>
                    <a href="./View Employees" class="sub-item">View employees</a>
                </div>
            </div>
            <?php
        }
        
        ?>
    </div>
</side>