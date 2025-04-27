<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<!-- Add Bootstrap and FontAwesome for this page only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="container py-4">
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h1 class="display-5 text-center mb-0">
                <i class="fas fa-user-circle mr-2"></i> My Dashboard
            </h1>
        </div>
        
        <div class="card-body">
            <div class="row align-items-center mb-4">
                <div class="col-md-4 text-center">
                    <div class="avatar-container mb-3">
                        <img src="<?php echo URLROOT; ?>/public/img/child-avatar.jpeg" alt="Profile Avatar" class="img-fluid rounded-circle border border-primary" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="profile-info bg-light p-4 rounded">
                        <h2 class="text-primary">
                            <i class="fas fa-id-card mr-2"></i> 
                            Hello, <?php echo $data['child']->user_name; ?>!
                        </h2>
                        <p class="lead">Welcome to your personal dashboard!</p>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope mr-2"></i> Email:</strong><br> 
                                <?php echo $data['child']->user_email; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar-alt mr-2"></i> Joined:</strong><br>
                                <?php echo date('F j, Y', strtotime($data['child']->created_at)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <!-- Books Stats -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-primary shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="h5 mb-0"><i class="fas fa-book mr-2"></i> My Books</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-6">
                                    <div class="activity-box p-3">
                                        <i class="fas fa-heart text-danger fa-3x mb-2"></i>
                                        <h4 class="counter"><?php echo $data['favorite_count']; ?></h4>
                                        <p class="text-muted">Favorite Books</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="activity-box p-3">
                                        <i class="fas fa-comment text-info fa-3x mb-2"></i>
                                        <h4 class="counter"><?php echo $data['comment_count']; ?></h4>
                                        <p class="text-muted">Comments</p>
                                    </div>
                                </div>
                            </div>
                            <a href="<?php echo URLROOT; ?>/child/favorites" class="btn btn-primary mt-3">
                                <i class="fas fa-heart mr-2"></i> See My Favorites
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Article Stats -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-success shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h3 class="h5 mb-0"><i class="fas fa-pencil-alt mr-2"></i> My Articles</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="activity-box p-3">
                                <i class="fas fa-newspaper text-success fa-3x mb-3"></i>
                                <h4 class="counter"><?php echo $data['article_count']; ?></h4>
                                <p class="text-muted">Articles Written</p>
                            </div>
                            <div class="mt-3">
                                <a href="<?php echo URLROOT; ?>/child/myArticles" class="btn btn-success">
                                    <i class="fas fa-newspaper mr-2"></i> Read My Articles
                                </a>
                                <a href="<?php echo URLROOT; ?>/child/createArticle" class="btn btn-outline-success ml-2">
                                    <i class="fas fa-plus mr-2"></i> Write New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Book Requests -->
                <div class="col-md-12 mb-4">
                    <div class="card border-warning shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h3 class="h5 mb-0"><i class="fas fa-bookmark mr-2"></i> My Book Requests</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="activity-box p-3">
                                        <i class="fas fa-hourglass-half text-warning fa-3x mb-2"></i>
                                        <h4 class="counter"><?php echo $data['pending_count']; ?></h4>
                                        <p class="text-muted">Waiting for Approval</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="activity-box p-3">
                                        <i class="fas fa-check-circle text-success fa-3x mb-2"></i>
                                        <h4 class="counter"><?php echo $data['approved_count']; ?></h4>
                                        <p class="text-muted">Approved Books</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="activity-box p-3">
                                        <i class="fas fa-book-open text-primary fa-3x mb-2"></i>
                                        <h4 class="counter"><?php echo $data['request_count']; ?></h4>
                                        <p class="text-muted">Total Requests</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="<?php echo URLROOT; ?>/child/myRequests" class="btn btn-warning">
                                    <i class="fas fa-list-alt mr-2"></i> View All Requests
                                </a>
                                <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-outline-warning ml-2">
                                    <i class="fas fa-search mr-2"></i> Browse Books
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <a href="<?php echo URLROOT; ?>/child/childHome" class="btn btn-lg btn-outline-primary">
                        <i class="fas fa-home mr-2"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add some custom CSS for animations and styling -->
<style>
    .activity-box {
        transition: all 0.3s ease;
        border-radius: 10px;
    }
    
    .activity-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .counter {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
    }
    
    .avatar-container::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(0,123,255,0.5);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0,123,255,0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(0,123,255,0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0,123,255,0);
        }
    }
</style>

<!-- Add Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
