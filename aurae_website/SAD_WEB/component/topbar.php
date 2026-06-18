<?php
require_once("../config/login_ver.php");
?>


<link rel="stylesheet" href="..\assets\css\global.css">

<body>

<div class="topbar">

            <button id="toggleSidebar" class="menu-btn" >
                <i class="fas fa-bars"></i>
            </button>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search task">
            </div>

            <div class="user">
                <div class="icons">
                    <i class="fas fa-envelope"></i>
                    <i class="fas fa-bell"></i>
                </div>

                <div class="avatar"></div>

                <div class="user-info">
                    <span class="name"><?php echo $_SESSION['username']; ?></span>
                    <span class="email"><?php echo $_SESSION['email']; ?></span>
                </div>
            </div>
        </div>
<script src="..\assets\js\sidebar.js"></script>
</body>