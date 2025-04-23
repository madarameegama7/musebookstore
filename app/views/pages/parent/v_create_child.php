<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<!-- Include the parent-child CSS file -->
<link rel="stylesheet" href="<?= URLROOT ?>/css/parent-child.css">

<div class="container mt-5">
    <!-- Header with gradient background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="parent-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1><i class="fas fa-plus-circle mr-2"></i> Create Child Account</h1>
                        <p class="lead mb-0">Create a new account that you'll manage for your child</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <a href="<?= URLROOT ?>/parent_user/index" class="btn-parent btn-parent-light">
                            <i class="fas fa-arrow-left"></i> Back to Children
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Create Child Form Card with new CSS classes -->
            <div class="card-parent mb-5">
                <div class="card-header-parent">
                    <h3><i class="fas fa-child mr-2"></i> Child Account Details</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Create a new child account. You'll manage this account and approve book requests.</p>
                    
                    <form action="<?= URLROOT ?>/parent_user/createChild" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label-parent"><i class="fas fa-user mr-2"></i> Child's Name:</label>
                            <input type="text" name="name" class="form-control-parent <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['name']; ?>">
                            <span class="invalid-feedback"><?= $data['name_err']; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label-parent"><i class="fas fa-envelope mr-2"></i> Email:</label>
                            <input type="email" name="email" class="form-control-parent <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?= $data['email']; ?>">
                            <span class="invalid-feedback"><?= $data['email_err']; ?></span>
                            <small class="text-muted">This will be used for the child to log in</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label-parent"><i class="fas fa-lock mr-2"></i> Password:</label>
                            <input type="password" name="password" class="form-control-parent <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['password']) ? $data['password'] : ''; ?>">
                            <span class="invalid-feedback"><?= isset($data['password_err']) ? $data['password_err'] : ''; ?></span>
                            <small class="text-muted">Create a password for the child account</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password" class="form-label-parent"><i class="fas fa-lock mr-2"></i> Confirm Password:</label>
                            <input type="password" name="confirm_password" class="form-control-parent <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?= isset($data['confirm_password']) ? $data['confirm_password'] : ''; ?>">
                            <span class="invalid-feedback"><?= isset($data['confirm_password_err']) ? $data['confirm_password_err'] : ''; ?></span>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col">
                                <button type="submit" class="btn-parent btn-parent-primary btn-block">
                                    <i class="fas fa-save mr-2"></i> Create Account
                                </button>
                            </div>
                            <div class="col">
                                <a href="<?= URLROOT ?>/parent_user" class="btn-parent btn-parent-light btn-block">
                                    <i class="fas fa-times mr-2"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
