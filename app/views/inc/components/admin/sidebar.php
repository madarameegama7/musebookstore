<aside class="admin-sidebar">
    <div class="logo-container">
        <a href="<?php echo URLROOT; ?>/admin">
            <img src="<?php echo URLROOT; ?>/img/muse%20logo.png" alt="Muse Admin Logo">
        </a>
    </div>
    <div class="sidebar-header">
        <div class="admin-info">
            <span class="admin-name"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'; ?></span>
            <span class="admin-role">Administrator</span>
        </div>
    </div>
    <div class="sidebar-divider"></div>
    <nav>
        <ul>
            <li class="<?php echo ($_SERVER['REQUEST_URI'] == URLROOT . '/admin' || $_SERVER['REQUEST_URI'] == URLROOT . '/admin/') ? 'active' : ''; ?>">
                <a href="<?php echo URLROOT; ?>/admin"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-users"></i> <span>Users</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageUsers') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/manageUsers"><i class="fas fa-user-cog"></i> Manage Users</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageVerification') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/manageVerification"><i class="fas fa-user-check"></i> User Verification</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/addUser') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/addUser"><i class="fas fa-user-plus"></i> Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-book"></i> <span>Books</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageBooks') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/manageBooks"><i class="fas fa-book"></i> Manage Books</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/createBook') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/createBook"><i class="fas fa-plus-square"></i> Add Book</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-users-cog"></i> <span>Community</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageCommunities') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/manageCommunities"><i class="fas fa-users-cog"></i> Manage Communities</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/deleteRequests') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/deleteRequests"><i class="fas fa-trash-alt"></i> Delete Requests</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageEvents') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/manageEvents"><i class="fas fa-calendar-alt"></i> Manage Events</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/writingGroups') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/writingGroups"><i class="fas fa-pen-nib"></i> Writing Groups</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-file-alt"></i> <span>Reports</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin_controllers/reports') !== false && !strpos($_SERVER['REQUEST_URI'], '/users') && !strpos($_SERVER['REQUEST_URI'], '/books') && !strpos($_SERVER['REQUEST_URI'], '/transactions') && !strpos($_SERVER['REQUEST_URI'], '/payments') ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin_controllers/reports"><i class="fas fa-chart-line"></i> Reports Dashboard</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin_controllers/reports/users') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin_controllers/reports/users"><i class="fas fa-user"></i> User Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin_controllers/reports/books') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin_controllers/reports/books"><i class="fas fa-book"></i> Book Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin_controllers/reports/transactions') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin_controllers/reports/transactions"><i class="fas fa-exchange-alt"></i> Transaction Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin_controllers/reports/payments') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin_controllers/reports/payments"><i class="fas fa-credit-card"></i> Payment Reports</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/analytics') !== false ? 'active' : ''; ?>">
                <a href="<?php echo URLROOT; ?>/admin/analytics"><i class="fas fa-chart-bar"></i> <span>Analytics</span></a>
            </li>
            <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/manageTransactions') !== false ? 'active' : ''; ?>">
                <a href="<?php echo URLROOT; ?>/admin/manageTransactions"><i class="fas fa-exchange-alt"></i> <span>Transactions</span></a>
            </li>
            <div class="sidebar-divider"></div>
            <li>
                <a href="<?php echo URLROOT; ?>/users/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <p>Muse Bookstore &copy; <?php echo date('Y'); ?></p>
    </div>
    <script>
        // Active section management for collapsible sections
        document.addEventListener('DOMContentLoaded', function() {
            // Open sections that contain active items
            const activeItems = document.querySelectorAll('.sidebar-section .active');
            activeItems.forEach(function(item) {
                const section = item.closest('.sidebar-section');
                if (section) {
                    section.classList.add('open');
                    const toggle = section.previousElementSibling;
                    if (toggle && toggle.classList.contains('sidebar-section-toggle')) {
                        const chevron = toggle.querySelector('.chevron');
                        if (chevron) {
                            chevron.classList.remove('fa-chevron-down');
                            chevron.classList.add('fa-chevron-up');
                        }
                    }
                }
            });

            // Toggle section functionality
            const toggles = document.querySelectorAll('.sidebar-section-toggle');
            toggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const section = this.nextElementSibling;
                    section.classList.toggle('open');
                    const chevron = this.querySelector('.chevron');
                    chevron.classList.toggle('fa-chevron-down');
                    chevron.classList.toggle('fa-chevron-up');
                });
            });
        });
    </script>
</aside>