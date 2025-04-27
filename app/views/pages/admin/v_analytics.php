<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin/admin_style.css">

<style>
    .admin-dashboard-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-section {
        width: 100%;
        margin-bottom: 30px;
    }

    .stat-section h2 {
        margin-bottom: 15px;
        padding-bottom: 5px;
        border-bottom: 2px solid #6c5ce7;
        color: #2d3436;
    }

    .stats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .stat-card {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        flex: 1 1 200px;
        min-width: 200px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-card h3 {
        font-size: 1rem;
        color: #636e72;
        margin-bottom: 10px;
    }

    .stat-card p {
        font-size: 2rem;
        font-weight: bold;
        color: #6c5ce7;
        margin: 0;
    }

    .stat-card.users {
        border-top: 4px solid #6c5ce7;
    }

    .stat-card.books {
        border-top: 4px solid #00b894;
    }

    .stat-card.transactions {
        border-top: 4px solid #0984e3;
    }

    .stat-card.payments {
        border-top: 4px solid #fdcb6e;
    }

    .stat-card.tokens {
        border-top: 4px solid #e84393;
    }

    .stat-card.users p {
        color: #6c5ce7;
    }

    .stat-card.books p {
        color: #00b894;
    }

    .stat-card.transactions p {
        color: #0984e3;
    }

    .stat-card.payments p {
        color: #e17055;
    }

    .stat-card.tokens p {
        color: #e84393;
    }

    .stat-subtitle {
        font-size: 0.85rem;
        color: #b2bec3;
        margin-top: 5px;
    }

    .chart-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 30px;
        height: 350px;
        position: relative;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .chart-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Comprehensive analytics for Muse Bookstore as of <?php echo $data['currentMonth']; ?>.</p>

        <!-- Hidden inputs for chart data -->
        <input type="hidden" id="adminCount" value="<?php echo $data['adminCount']; ?>">
        <input type="hidden" id="parentCount" value="<?php echo $data['parentCount']; ?>">
        <input type="hidden" id="childCount" value="<?php echo $data['childCount']; ?>">
        <input type="hidden" id="ambassadorCount" value="<?php echo $data['ambassadorCount']; ?>">

        <input type="hidden" id="availableBooks" value="<?php echo $data['availableBooks']; ?>">
        <input type="hidden" id="swappedBooks" value="<?php echo $data['swappedBooks']; ?>">
        <input type="hidden" id="soldBooks" value="<?php echo $data['soldBooks']; ?>">

        <input type="hidden" id="swapTransactions" value="<?php echo $data['swapTransactions']; ?>">
        <input type="hidden" id="sellTransactions" value="<?php echo $data['sellTransactions']; ?>">

        <input type="hidden" id="pendingTransactions" value="<?php echo $data['pendingTransactions']; ?>">
        <input type="hidden" id="approvedTransactions" value="<?php echo $data['approvedTransactions']; ?>">
        <input type="hidden" id="completedTransactions" value="<?php echo $data['completedTransactions']; ?>">

        <!-- Chart Grid -->
        <div class="chart-grid">
            <div class="chart-container">
                <canvas id="userRoleChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="bookStatusChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="transactionTypeChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="transactionStatusChart"></canvas>
            </div>
        </div>

        <!-- Users Section -->
        <div class="stat-section">
            <h2>User Analytics</h2>
            <div class="stats-container">
                <div class="stat-card users">
                    <h3>Total Users</h3>
                    <p><?php echo number_format($data['userCount']); ?></p>
                </div>
                <div class="stat-card users">
                    <h3>New Users This Month</h3>
                    <p><?php echo number_format($data['newUsersThisMonth']); ?></p>
                    <div class="stat-subtitle"><?php echo date('F Y'); ?></div>
                </div>
                <div class="stat-card users">
                    <h3>Admin Users</h3>
                    <p><?php echo number_format($data['adminCount']); ?></p>
                </div>
                <div class="stat-card users">
                    <h3>Parent Users</h3>
                    <p><?php echo number_format($data['parentCount']); ?></p>
                </div>
                <div class="stat-card users">
                    <h3>Child Users</h3>
                    <p><?php echo number_format($data['childCount']); ?></p>
                </div>
                <div class="stat-card users">
                    <h3>Ambassador Users</h3>
                    <p><?php echo number_format($data['ambassadorCount']); ?></p>
                </div>
            </div>
        </div>

        <!-- Books Section -->
        <div class="stat-section">
            <h2>Book Analytics</h2>
            <div class="stats-container">
                <div class="stat-card books">
                    <h3>Total Books</h3>
                    <p><?php echo number_format($data['bookCount']); ?></p>
                </div>
                <div class="stat-card books">
                    <h3>New Books This Month</h3>
                    <p><?php echo number_format($data['newBooksThisMonth']); ?></p>
                    <div class="stat-subtitle"><?php echo date('F Y'); ?></div>
                </div>
                <div class="stat-card books">
                    <h3>Available Books</h3>
                    <p><?php echo number_format($data['availableBooks']); ?></p>
                </div>
                <div class="stat-card books">
                    <h3>Swapped Books</h3>
                    <p><?php echo number_format($data['swappedBooks']); ?></p>
                </div>
                <div class="stat-card books">
                    <h3>Sold Books</h3>
                    <p><?php echo number_format($data['soldBooks']); ?></p>
                </div>
            </div>
        </div>

        <!-- Transactions Section -->
        <div class="stat-section">
            <h2>Transaction Analytics</h2>
            <div class="stats-container">
                <div class="stat-card transactions">
                    <h3>Swap Transactions</h3>
                    <p><?php echo number_format($data['swapTransactions']); ?></p>
                </div>
                <div class="stat-card transactions">
                    <h3>Sell Transactions</h3>
                    <p><?php echo number_format($data['sellTransactions']); ?></p>
                </div>
                <div class="stat-card transactions">
                    <h3>Pending Transactions</h3>
                    <p><?php echo number_format($data['pendingTransactions']); ?></p>
                </div>
                <div class="stat-card transactions">
                    <h3>Approved Transactions</h3>
                    <p><?php echo number_format($data['approvedTransactions']); ?></p>
                </div>
                <div class="stat-card transactions">
                    <h3>Completed Transactions</h3>
                    <p><?php echo number_format($data['completedTransactions']); ?></p>
                </div>
            </div>
        </div>

        <!-- Financial Section -->
        <div class="stat-section">
            <h2>Financial Analytics</h2>
            <div class="stats-container">
                <div class="stat-card payments">
                    <h3>Total Payments Received</h3>
                    <p>LKR <?php echo number_format($data['totalPayments'], 2); ?></p>
                </div>
                <div class="stat-card payments">
                    <h3>Payments This Month</h3>
                    <p>LKR <?php echo number_format($data['paymentsThisMonth'], 2); ?></p>
                    <div class="stat-subtitle"><?php echo date('F Y'); ?></div>
                </div>
                <div class="stat-card tokens">
                    <h3>Total Tokens Purchased</h3>
                    <p><?php echo number_format($data['totalTokens']); ?></p>
                </div>
                <div class="stat-card tokens">
                    <h3>Tokens Purchased This Month</h3>
                    <p><?php echo number_format($data['tokensThisMonth']); ?></p>
                    <div class="stat-subtitle"><?php echo date('F Y'); ?></div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Chart.js and our custom analytics charts script -->
<script src="<?php echo URLROOT; ?>/js/vendor/chart.min.js"></script>
<script src="<?php echo URLROOT; ?>/js/analytics_charts.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>