<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="admin-container">
    <?php require APPROOT . '/views/inc/components/admin/sidebar.php'; ?>

    <main class="admin-main-content">
        <h1><?php echo $data['title']; ?></h1>
        <p>Overview of website activity.</p>

        <div class="admin-dashboard-stats">
            <div class="stat-card">
                <h2>Total Users</h2>
                <p><?php echo $data['userCount']; ?></p>
            </div>
            <div class="stat-card">
                <h2>Total Books Listed</h2>
                <p><?php echo $data['bookCount']; ?></p>
            </div>
            <!-- Add more analytics displays here -->
            <!-- Example: Charts using Chart.js could be added later -->
        </div>

        <!-- Placeholder for future charts/graphs -->
        <div style="margin-top: 30px;">
            <h2>More Analytics Coming Soon...</h2>
            <!-- <canvas id="userSignupChart"></canvas> -->
        </div>

    </main>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>