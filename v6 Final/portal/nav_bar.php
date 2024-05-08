<?php
	require_once 'auth.php';
?>
<html>
    <head>
        <link rel="stylesheet" href="../assets/css/navbar.css"/>
         <style type="text/css">
            ul li a:hover {
             background: gray;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-xl fixed-top bg-dark navbar-dark">
            <a href="https://nohs.ca/" target="_blank" class="navbar-brand">
                <img src="../assets/images/logo.png" alt="logo" style="width:40px;height:40px;">
                <span class="menu-collapsed">NOHS - Attendance/Leave System</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsible">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsible">
                <ul class="navbar-nav">
                    <!-- manager -->
                    <?php if($role == 'manager') { ?>
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="manager_schedule.php" class="nav-link">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a href="manager_time_off.php" class="nav-link">Request</a>
                    </li>
                    <li class="nav-item">
                        <a href="punchcard.php" class="nav-link">Clock In/Clock Out</a>
                    </li>
                    <li class="nav-item">
                        <a href="manager_timesheet.php" class="nav-link">Timesheet</a>
                    </li> 
                    <li class="nav-item">
                        <a href="users.php" class="nav-link">Manage Employee</a>
                    </li> 
                    <li class="nav-item">
                        <a href="help.php" class="nav-link">Help</a>
                    </li>
                    <!-- employee -->
                    <?php } elseif($role == 'employee') { ?>
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_schedule.php" class="nav-link">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a href="emp_time_off.php" class="nav-link">Request</a>
                    </li>
                    <li class="nav-item">
                        <a href="punchcard.php" class="nav-link">Clock In/Clock Out</a>
                    </li>
                    <li class="nav-item">
                        <a href="employee_timesheet.php" class="nav-link">Timesheet</a>
                    </li> 
                    <li class="nav-item">
                        <a href="help.php" class="nav-link">Help</a>
                    </li>
                    <?php } ?>
                    <div class="dropdown-divider"></div>
                </ul>
            </div>
            
            <ul class="navbar-nav">
                <form class="form-inline" style="float:right;">
                <div class="down-nav">
                    <p><font color="white">Welcome, <?php echo $user_fname ?>&emsp;</font></p>
                </div>
                <a href="logout.php">
                    <button type="button" class="btn btn-danger navbar-btn"><span class="fa fa-power-off lead text"></span> Log out</button>
                </a>           
                 </form>     
             </ul>
       </nav>
    </body>
</html>