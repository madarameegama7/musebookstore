
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
                    <a href="<?php echo URLROOT?>/child/favorites" style="color: #673AB7;">
                        <i class="fas fa-heart"></i> My Favorites
                    </a>
                </li>
                <li class="menu-item" style="margin-right: 15px;">
                    <a href="<?php echo URLROOT?>/child/articles" style="color: #FF5722;">
                        <i class="fas fa-newspaper"></i> Articles
                    </a>
                </li>
                <li class="menu-item" style="margin-right: 15px;">
                    <a href="<?php echo URLROOT?>/child/myArticles" style="color: #E91E63;">
                        <i class="fas fa-pencil-alt"></i> My Articles
                    </a>
                </li>
                <li class="menu-item" style="margin-right: 15px;">
                    <a href="<?php echo URLROOT?>/child/myRequests" style="color: #336699;">
                        <i class="fas fa-bookmark"></i> My Requests
                    </a>
                </li>
            <?php endif; ?>

            <li class="login-button"><a href="<?php echo URLROOT?>/users/logout">Logout</a></li>

            <!-- Check user role and redirect to admin dashboard or user profile -->
            <a href="<?php echo URLROOT?>/pages/parentProfileView">
               <img width="50" height="50" src="https://img.icons8.com/ios/50/user-male-circle--v1.png" alt="user-male-circle--v1"/>
            </a>

        <?php else: ?>
            <li class="login-button"><a href="<?php echo URLROOT?>/users/login">Login</a></li>
        <?php endif; ?>
</ul>

</div>
