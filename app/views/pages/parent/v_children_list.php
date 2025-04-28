<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<!-- Include the parent-child CSS file -->
<link rel="stylesheet" href="<?= URLROOT ?>/css/parent-child.css">

<!-- Add global event listener to close modals -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Close any open modals when clicking links
    document.querySelectorAll('a:not([href^="#"]):not(.btn-delete)').forEach(function(link) {
        link.addEventListener('click', function(event) {
            // Find all visible modals
            const visibleModals = document.querySelectorAll('[id^="deleteModal"]');
            let hasVisibleModal = false;
            
            visibleModals.forEach(function(modal) {
                if (modal.style.display === "flex") {
                    hasVisibleModal = true;
                    modal.style.display = "none";
                }
            });
            
            // If a modal was visible and we're not clicking on a delete button within the modal
            if (hasVisibleModal && !event.target.closest('.modal-footer')) {
                // Prevent the default navigation
                event.preventDefault();
                
                // Get the href to navigate to after closing the modal
                const href = this.getAttribute('href');
                
                // Navigate after a short delay to ensure modal is closed
                setTimeout(function() {
                    window.location.href = href;
                }, 50);
            }
        });
    });
});
</script>

<div class="container mt-5">
    <!-- Header with gradient background using the new CSS class -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="parent-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1><i class="fas fa-child mr-2"></i> Manage Children</h1>
                        <p class="lead mb-0">Create and manage your children's accounts and their book access</p>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <a href="<?= URLROOT ?>/parent_user/createChild" class="btn-parent btn-parent-light">
                            <i class="fas fa-plus-circle"></i> New Child Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php flash('child_account'); ?>
    <?php flash('child_updated'); ?>
    <?php flash('child_deleted'); ?>
    
    <!-- Child Accounts Card with new CSS classes -->
    <div class="card-parent mb-4">
        <div class="card-header-parent">
            <h3><i class="fas fa-users mr-2"></i> My Children Accounts</h3>
        </div>
        <div class="card-body">
            <?php if(empty($data['children'])) : ?>
                <div class="alert-parent alert-parent-info">
                    <div class="alert-parent-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <p class="mb-0">You haven't created any child accounts yet. Click the button above to create your first child account.</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-parent">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th class="text-center" style="width: 50%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; foreach($data['children'] as $child) : ?>
                                <tr>
                                    <td class="text-center"><?= $count++ ?></td>
                                    <td class="font-weight-bold"><?= $child->user_name ?></td>
                                    <td><?= $child->user_email ?></td>
                                    <td><span class="badge-parent badge-parent-light"><?= date('M d, Y', strtotime($child->created_at)) ?></span></td>
                                    <td class="text-center">
                                        <a href="<?= URLROOT ?>/parent_user/editChild/<?= $child->user_id ?>" class="action-btn action-btn-edit" title="Edit account">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteConfirm(<?= $child->user_id ?>, '<?= $child->user_name ?>')" class="action-btn action-btn-delete" title="Delete account">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Book Requests Card with new CSS classes -->
    <div class="card-parent mt-4 mb-5">
        <div class="card-header-parent card-header-success">
            <h3><i class="fas fa-book mr-2"></i> Book Requests</h3>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="lead mb-0">View and manage pending book requests from your children</p>
                </div>
                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                    <a href="<?= URLROOT ?>/parent_user/requests" class="btn-parent btn-parent-success">
                        <i class="fas fa-book"></i> View Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 32px;
        border-radius: 16px;
        font-size: 12px;
        transition: all 0.3s ease;
        margin: 0 3px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        padding: 0 12px;
        font-weight: 600;
        text-decoration: none;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        text-decoration: none;
    }
    
    .action-btn-edit {
        background: #3498db;
        color: white;
        border: none;
    }
    
    .action-btn-edit:hover {
        background: #2980b9;
        color: white;
    }
    
    .action-btn-delete {
        background: #e74c3c;
        color: white;
        border: none;
    }
    
    .action-btn-delete:hover {
        background: #c0392b;
        color: white;
    }
    
    .mr-1 {
        margin-right: 4px;
    }
</style>

<script>
function deleteConfirm(childId, childName) {
    if (confirm('Are you sure you want to delete ' + childName + '\'s account? This action cannot be undone.\n\nAll associated book requests and data will also be deleted.')) {
        window.location.href = '<?= URLROOT ?>/parent_user/deleteChild/' + childId;
    }
}
</script>

<?php require APPROOT.'/views/inc/footer.php';?>