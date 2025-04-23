
<script>
  function toggleMenu() {
    const menu = document.querySelector('.topnavbar .menu');
    menu.classList.toggle('show');
  }
</script>

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
            
            <!-- Add Browse All Books option for child users -->
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'child'): ?>
                <li class="menu-item" style="margin-right: 15px;">
                    <a href="<?php echo URLROOT?>/pages/index" style="color: #336699; font-weight: bold;">
                        <i class="fas fa-book"></i> Browse All Books
                    </a>
                </li>
                <li class="menu-item" style="margin-right: 15px;">
                    <a href="<?php echo URLROOT?>/child/childHome" style="color: #4CAF50; font-weight: bold;">
                        <i class="fas fa-th-large"></i> Features
                    </a>
                </li>
            <?php endif; ?>

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
                        case 'child':
                            $profileLink = URLROOT . '/chid/profile';
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
              <img width="50" height="50" src="<?php echo URLROOT?>/img/profileImgs/<?php echo $_SESSION['user_photo']?>" alt="user-male-circle--v1"/>
            </a>

        <?php else: ?>
            <li class="login-button"><a href="<?php echo URLROOT?>/users/login">Login</a></li>
        <?php endif; ?>
</ul>

</div>
