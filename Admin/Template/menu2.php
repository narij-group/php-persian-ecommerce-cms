</head>
<body background="Template/Images/backB.jpg" class="body-iframe">
<div id="darklayer"
     style="background-color:rgba(0,0,0,0.6); position:fixed;top:0; left:0; width: 100%; height: 100%; z-index: 99; display: none;">
</div>
<div class="top-bar" id="menu">
    <div class="menu-btn">
        <img src="Template/Images/mobile/menu.png"/>
    </div>
    <div class="MainTitle3"><span><?php echo str_replace(".php" , "" , basename($_SERVER['PHP_SELF']));?></span></div>
</div>
<div class="menu-bar" id="menu-bar">
    <div class="Profile">
        <img src="Template/Images/malecostume-128.png" alt=""/>
        <div class="Name"><?php echo $settings->Owner; ?></div>
    </div>
    <ul>
        <li>
            <a href="../index.php">
                <img src="Template/Images/Homepage.png" alt=""/>
                صفحه اصلی
            </a>
        </li>
        <li>
            <a href="Index.php">
                <img src="Template/Images/Start.png" alt=""/>
                داشبورد
            </a>
        </li>
        <li>
            <a href="Stats.php">
                <img src="Template/Images/stats.png" alt=""/>
                آمار بازدید
            </a>
        </li>
        <li>
            <a href="Financial.php">
                <img src="Template/Images/bank1.png" alt=""/>
                آمار فروش
            </a>
        </li>
        <?php
        if ($role->EditUser != 1) {
            ?>
            <li>
                <a href="User.php?id=<?php echo $user1->UserId; ?>"><img
                        src="Template/Images/profile.png" alt=""/>
                    ویرایش حساب
                </a>
            </li>
            <?php
        }
        ?>
        <li>
            <a href="Settings.php">
                <img src="Template/Images/Setting.png" alt=""/>
                تنظیمات
            </a>
        </li>
        <li>
            <a href="Logoff.php">
                <img src="Template/Images/Logoff.png" alt=""/>
                خروج از حساب
            </a>
        </li>

    </ul>
</div>

<script>
    $(document).ready(function () {
        $("#menu").click(function () {
            $("#darklayer").fadeIn(500);
            $("#menu-bar").css("right", "0");
        });
        $("#darklayer").click(function () {
            $("#darklayer").fadeOut(500);
            $("#menu-bar").css("right", "-70%");
        });

    });
</script>
