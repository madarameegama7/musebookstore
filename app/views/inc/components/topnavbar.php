
<div class="topnavbar">
<ul>
        <li class="logo-container">
            <img src="/musebookstore/public/img/muse logo.png" alt="Muse Bookstore Logo">
        </li>

        <li class="menu">
            <ul>
                <li><a href="<?php echo URLROOT?>/pages/index">Home</a></li>
                <li><a href="<?php echo URLROOT?>/pages/whymuse">Why Muse</a></li>
                <li><a href="<?php echo URLROOT?>/pages/aboutus">About Us</a></li>
                <li><a href="<?php echo URLROOT?>/pages/contactus">Contact Us</a></li>
                <li><a href="<?php echo URLROOT?>/pages/services">Services</a></li>
            </ul>
        </li>

        <?php if (isset($_SESSION['user_name'])): ?>
            <span class="welcome-text" style="font-family: 'Poppins', sans-serif; font-weight: 500; margin-right: 15px">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>

            <li class="login-button"><a href="<?php echo URLROOT?>/users/logout">Logout</a></li>


            <!-- Check user role and redirect to appropriate profile view -->
            <?php
                $profileLink = '#'; // Default link
                if (isset($_SESSION['user_role'])) {
                    switch ($_SESSION['user_role']) {
                        case 'admin':
                            $profileLink = URLROOT . '/pages/adminProfileView';
                            break;
                        case 'parent':
                            $profileLink = URLROOT . '/pages/parentProfileView';
                            break;
                        case 'ambassador':
                            // Add ambassador profile link if it exists
                            // $profileLink = URLROOT . '/pages/ambassadorProfileView';
                            break;
                        // Add other roles as needed
                    }
                }
            ?>
            <a href="<?php echo $profileLink; ?>">
               <img width="50" height="50" src="https://img.icons8.com/ios/50/user-male-circle--v1.png" alt="user-male-circle--v1"/>

            </a>

        <?php else: ?>
            <li class="login-button"><a href="<?php echo URLROOT?>/users/login">Login</a></li>
        <?php endif; ?>
</ul>

</div>
