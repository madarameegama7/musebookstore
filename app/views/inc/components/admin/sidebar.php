<aside class="admin-sidebar no-print">
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
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/user/manageUsers') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/user/manageUsers"><i class="fas fa-user-cog"></i> Manage Users</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/verification/manageVerification') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/verification/manageVerification"><i class="fas fa-user-check"></i> User Verification</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/user/addUser') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/user/addUser"><i class="fas fa-user-plus"></i> Add User</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-book"></i> <span>Books</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/book/manageBooks') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/book/manageBooks"><i class="fas fa-book"></i> Manage Books</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/book/createBook') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/book/createBook"><i class="fas fa-plus-square"></i> Add Book</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-users-cog"></i> <span>Community</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/community/manageCommunities') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/community/manageCommunities"><i class="fas fa-users-cog"></i> Manage Communities</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/community/manageCommunityPosts') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/community/manageCommunityPosts"><i class="fas fa-comments"></i> Community Posts</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/community/deleteRequests') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/community/deleteRequests"><i class="fas fa-trash-alt"></i> Delete Requests</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/event/manageEvents') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/event/manageEvents"><i class="fas fa-calendar-alt"></i> Manage Events</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/writinggroup/manageWritingGroups') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/writinggroup/manageWritingGroups"><i class="fas fa-pen-nib"></i> Writing Groups</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/writinggroup/writingGroupPosts') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/writinggroup/writingGroupPosts"><i class="fas fa-book-open"></i> Writing Group Posts</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-file-alt"></i> <span>Reports</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports/index') !== false && !strpos($_SERVER['REQUEST_URI'], '/users') && !strpos($_SERVER['REQUEST_URI'], '/books') && !strpos($_SERVER['REQUEST_URI'], '/transactions') && !strpos($_SERVER['REQUEST_URI'], '/payments') ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/reports/index"><i class="fas fa-chart-line"></i> Reports Dashboard</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports/users') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/reports/users"><i class="fas fa-user"></i> User Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports/books') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/reports/books"><i class="fas fa-book"></i> Book Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports/transactions') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/reports/transactions"><i class="fas fa-exchange-alt"></i> Transaction Reports</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports/payments') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/reports/payments"><i class="fas fa-credit-card"></i> Payment Reports</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/analytics') !== false ? 'active' : ''; ?>">
                <a href="<?php echo URLROOT; ?>/admin/analytics"><i class="fas fa-chart-bar"></i> <span>Analytics</span></a>
            </li>
            <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/transaction/manageTransactions') !== false ? 'active' : ''; ?>">
                <a href="<?php echo URLROOT; ?>/admin/transaction/manageTransactions"><i class="fas fa-exchange-alt"></i> <span>Transactions</span></a>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-coins"></i> <span>Tokens</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/token/manageTokens') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/token/manageTokens"><i class="fas fa-coins"></i> Manage Tokens</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/token/reportTokens') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/token/reportTokens"><i class="fas fa-chart-pie"></i> Token Report</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="sidebar-section-toggle" type="button"><i class="fas fa-credit-card"></i> <span>Payments</span> <i class="fas fa-chevron-down chevron"></i></button>
                <ul class="sidebar-section">
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/payment/managePayments') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/payment/managePayments"><i class="fas fa-credit-card"></i> Manage Payments</a>
                    </li>
                    <li class="<?php echo strpos($_SERVER['REQUEST_URI'], '/admin/payment/reportPayments') !== false ? 'active' : ''; ?>">
                        <a href="<?php echo URLROOT; ?>/admin/payment/reportPayments"><i class="fas fa-chart-pie"></i> Payment Report</a>
                    </li>
                </ul>
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