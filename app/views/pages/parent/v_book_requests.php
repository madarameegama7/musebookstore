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
                        <h1><i class="fas fa-book-reader mr-2"></i> Book Requests</h1>
                        <p class="lead mb-0">Manage book requests from your children</p>
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
    
    <?php flash('request_success'); ?>
    <?php flash('request_error'); ?>
    
    <div class="card-parent mb-4">
        <div class="card-header-parent">
            <h3><i class="fas fa-list mr-2"></i> Request List</h3>
        </div>
        <div class="card-body">
            <?php if(empty($data['requests'])) : ?>
                <div class="alert-parent alert-parent-info">
                    <div class="alert-parent-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <p class="mb-0">You don't have any pending book requests from your children.</p>
                </div>
                <div class="text-center mt-3">
                    <a href="<?= URLROOT ?>/parent_user/index" class="btn-parent btn-parent-primary">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Children List
                    </a>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-parent">
                        <thead>
                            <tr>
                                <th>Child Name</th>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['requests'] as $request) : ?>
                                <tr class="<?= $request->status == 'pending' ? 'table-warning' : ($request->status == 'approved' ? 'table-success' : 'table-danger') ?>">
                                    <td><?= $request->child_name ?></td>
                                    <td><?= $request->book_title ?></td>
                                    <td><?= $request->book_author ?></td>
                                    <td><?= date('M d, Y', strtotime($request->created_at)) ?></td>
                                    <td>
                                        <?php if($request->status == 'pending') : ?>
                                            <span class="badge-parent badge-parent-warning">Pending</span>
                                        <?php elseif($request->status == 'approved') : ?>
                                            <span class="badge-parent badge-parent-success">Approved</span>
                                        <?php elseif($request->status == 'denied') : ?>
                                            <span class="badge-parent badge-parent-danger">Denied</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($request->status == 'pending') : ?>
                                            <a href="<?= URLROOT ?>/parent_user/approveRequest/<?= $request->request_id ?>" class="btn-parent btn-parent-success btn-sm" title="Approve Request">
                                                <i class="fas fa-check"></i> Approve
                                            </a>
                                            <a href="<?= URLROOT ?>/parent_user/denyRequest/<?= $request->request_id ?>" class="btn-parent btn-parent-danger btn-sm" title="Deny Request">
                                                <i class="fas fa-times"></i> Deny
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">Processed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- No need for another back button since we have one in the header -->

</div>

<?php require APPROOT.'/views/inc/footer.php';?>
