<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<header class="writing-hero">
    <div class="writing-hero__content">
        <h1 class="writing-hero__title">JOIN A <span class="highlight-text">WRITING GROUP</span></h1>
        <p class="writing-hero__subtitle">BECOME A BETTER WRITER</p>
        <p class="writing-hero__description">
            Meet new friends for support and feedback on your journey to getting published, 
            or find a writing course and improve your skills.
        </p>
        <button class="writing-hero__btn" id="join-now-btn">Join a Writing Group Now</button>
    </div>
</header>

<div class="writing-container">
    <section class="writing-groups">
        <h2 class="writing-groups__title">Available Writing Groups</h2>
        <a href="<?= URLROOT; ?>/communities/createWritingGroups/<?= $data['community']->communityId ?>" class="writing-groups__create-btn">Create Writing Group</a>
        <ul class="writing-groups__list">
            <?php if (!empty($data['writingGroups'])): ?>
                <?php foreach ($data['writingGroups'] as $group): ?>
                    <li class="writing-group__card" data-id="<?= $group->writingGroup_id ?>">
                        <div class="writing-group__image">
                            <a href="<?= URLROOT ?>/communities/viewWritingGroupPosts/<?= $group->writingGroup_id ?>">
                            <?php if (!empty($group->image_path)): ?>
    <img src="<?= URLROOT . '/' . $group->image_path ?>" alt="<?= htmlspecialchars($group->writingGroup_name) ?>" class="group-image-preview">
<?php else: ?>
    <img src="<?= URLROOT ?>/public/img/community/default_group.jpg" alt="<?= htmlspecialchars($group->writingGroup_name) ?>" class="group-image-preview">
<?php endif; ?>

                            </a>
                        </div>
                        <div class="writing-group__header">
                            <h3><?= htmlspecialchars($group->writingGroup_name) ?></h3>
                        </div>
                        <div class="writing-group__body">
                            <p class="writing-group__description"><?= htmlspecialchars($group->writingGroup_description) ?></p>
                            <p class="writing-group__label">Writing Group</p>
                            <div class="writing-group-buttons">
                             <button 
                               class="writing-group-btn edit-group-btn" 
                               data-id="<?= $group->writingGroup_id ?>" 
                               data-name="<?= $group->writingGroup_name ?>" 
                               data-description="<?= $group->writingGroup_description ?>" 
                               data-communityid="<?= $data['community']->communityId ?>" 
                               onclick="openEditModal(this)">
                                Edit
                             </button>

                            <form action="<?= URLROOT ?>/communities/deleteWritingGroup/<?= $group->writingGroup_id ?>" method="post" onsubmit="return confirm('Are you sure?')">
                            <input type="hidden" name="communityId" value="<?= $data['community']->communityId ?>">
                            <button type="submit" class="writing-group-btn delete-group-btn">Delete</button>
                            </form>
                        </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="writing-groups__empty">No writing groups found.</p>
            <?php endif; ?>
        </ul>
    </section>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal" style="display:none;">
    <div class="modal__content">
        <span class="modal__close" onclick="closeEditModal()">&times;</span>
        <h2 class="modal__title">Edit Writing Group</h2>
        <form id="editGroupForm" method="POST" action="<?= URLROOT; ?>/communities/updateWritingGroup/">
            <input type="hidden" name="id" id="edit-id">
            <input type="hidden" name="communityId" value="<?= $data['community']->communityId ?>">

            <div class="modal__form-group">
                <label for="edit-name">Group Name:</label>
                <input type="text" name="name" id="edit-name" required>
            </div>
            <div class="modal__form-group">
                <label for="edit-description">Description:</label>
                <textarea name="description" id="edit-description" required></textarea>
            </div>
            <button type="submit" class="modal__submit-btn">Update</button>
        </form>
    </div>
</div>

<script>
function openEditModal(button) {
    document.getElementById('edit-id').value = button.getAttribute('data-id');
    document.getElementById('edit-name').value = button.getAttribute('data-name');
    document.getElementById('edit-description').value = button.getAttribute('data-description');
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
