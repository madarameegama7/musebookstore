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
                if (modal.style.display === "block") {
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
                                        <a href="<?= URLROOT ?>/parent_user/editChild/<?= $child->user_id ?>" class="btn-parent btn-parent-primary mr-2" title="Edit account">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="javascript:void(0);" onclick="deleteconfirm(<?= $child->user_id ?>, event)" class="btn-parent btn-parent-danger btn-delete" title="Delete account">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Delete Confirmation Modal with new CSS classes -->
                                <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background-color: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; display:none;" id="deleteModal<?= $child->user_id ?>">
                                    <div class="modal-parent modal-parent-danger" 
                                        tabindex="-1" 
                                        role="dialog" 
                                        aria-labelledby="deleteModalLabel<?= $child->user_id ?>" 
                                        aria-hidden="true" 
                                        style="width: 50%; margin-right: auto; margin-left: auto; background-color: rgb(255, 255, 255);">
                                        <div class="modal-dialog" role="document" style="margin: 0; max-width: 100%;">
                                            <div class="modal-content" style="border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.5);">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $child->user_id ?>">Confirm Deletion</h5>
                                                    <button type="button" class="close" aria-label="Close" onclick="cancelDelete(<?= $child->user_id ?>)" style="background: none; border: none; font-size: 1.5rem;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete <strong><?= $child->user_name ?>'s</strong> account? This action cannot be undone.</p>
                                                    <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> All associated book requests and data will also be deleted.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn-parent btn-parent-light" onclick="cancelDelete(<?= $child->user_id ?>)">Cancel</button>
                                                    <a href="<?= URLROOT ?>/parent_user/deleteChild/<?= $child->user_id ?>" class="btn-parent btn-parent-danger">Yes, Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<script>
function deleteconfirm(childId, event) {
    event.preventDefault();
    // Close all other modals first
    document.querySelectorAll('[id^="deleteModal"]').forEach(function(modal) {
        modal.style.display = "none";
    });
    
    // Show this modal
    const modal = document.getElementById('deleteModal' + childId);
    if (modal) {
        modal.style.display = "block";
        modal.style.zIndex = "9999";
        
        // Prevent scrolling on the body while modal is open
        document.body.style.overflow = "hidden";
    } else {
        console.error("Modal not found for child ID:", childId);
    }
}

function cancelDelete(childId) {
    document.getElementById('deleteModal' + childId).style.display = "none";
    // Restore scrolling
    document.body.style.overflow = "";
}

// Add escape key handler to close any open modals
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        document.querySelectorAll('[id^="deleteModal"]').forEach(function(modal) {
            if (modal.style.display === "block") {
                modal.style.display = "none";
                // Restore scrolling
                document.body.style.overflow = "";
            }
        });
    }
});

// Add click outside modal to close
document.addEventListener('click', function(event) {
    document.querySelectorAll('[id^="deleteModal"]').forEach(function(modal) {
        if (modal.style.display === "block" && !event.target.closest('.modal-parent') && 
            !event.target.closest('.btn-delete')) {
            modal.style.display = "none";
            // Restore scrolling
            document.body.style.overflow = "";
        }
    });
});
</script>

<?php require APPROOT.'/views/inc/footer.php';?>