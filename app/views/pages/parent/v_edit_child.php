<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<!-- Include the parent-child CSS file -->
<link rel="stylesheet" href="<?= URLROOT ?>/css/parent-child.css">

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="parent-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1><i class="fas fa-user-edit mr-2"></i> Edit Child Account</h1>
                        <p class="lead mb-0">Update your child's account information</p>
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
            <!-- Edit Child Form Card with new CSS classes -->
            <div class="card-parent mb-5">
                <div class="card-header-parent">
                    <h3><i class="fas fa-child mr-2"></i> Child Account Details</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Update the child account information.</p>
                    
                    <form action="<?php echo URLROOT ?>/parent_user/editChild/<?php echo $data['id']; ?>" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label-parent"><i class="fas fa-user mr-2"></i> Child's Name:</label>
                            <input type="text" name="name" class="form-control-parent <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label-parent"><i class="fas fa-envelope mr-2"></i> Email:</label>
                            <input type="email" name="email" class="form-control-parent <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                            <small class="text-muted">This will be used for the child to log in</small>
                        </div>
                        
                        <div class="alert-parent alert-parent-info">
                            <div class="alert-parent-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <p class="mb-0">If you need to change the password, please delete this account and create a new one.</p>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col">
                                <input type="submit" value="Update Account" class="btn-parent btn-parent-primary btn-block">
                            </div>
                            <div class="col">
                                <a href="<?php echo URLROOT ?>/parent_user" class="btn-parent btn-parent-light btn-block">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
