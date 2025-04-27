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

    <?php flash('join_success'); ?>
    <?php flash('join_error'); ?>

</header>

<div class="writing-container">
    <section class="writing-groups">
        <h2 class="writing-groups__title">Available Writing Groups</h2>

        <ul class="writing-groups__list">
            <?php if (!empty($data['writingGroups'])): ?>
                <?php foreach ($data['writingGroups'] as $group): ?>
                    <li class="writing-group__card" data-id="<?= $group->writingGroup_id ?>">
                        <div class="writing-group__image">
                            <a href="<?= URLROOT ?>/communities/viewCommunityWritingGroupPosts/<?= $group->writingGroup_id ?>">
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
                            <a href="<?= URLROOT ?>/communities/viewCommunityWritingGroupPosts/<?= $group->writingGroup_id ?>" 
                             class="writing-group-btn view-details-btn">
                             View Details
                              </a>

                              <button 
                              type="button" 
                              class="writing-group-btn join-now-btn" 
                              onclick="openJoinModal(<?= $group->writingGroup_id ?>)">
                              Join Now
                              </button>
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

<!-- Join Modal -->
<div id="joinModal" class="modal" style="display:none;">
    <div class="modal__content">
        <span class="modal__close" onclick="closeJoinModal()">&times;</span>
        <h2 class="modal__title">Terms and Conditions</h2>
        <div class="modal__form-group">
            <p class="modal__text">
                Before joining the writing group, you must agree to the following:
            </p>
            <ul class="modal__list">
                <li>Respect all members and their opinions.</li>
                <li>Do not plagiarize any content.</li>
                <li>Stay active and contribute to discussions.</li>
                <li>Follow group-specific rules set by administrators.</li>
            </ul>
        </div>
        <form id="joinGroupForm" method="POST" action="<?= URLROOT; ?>/communities/joinWritingGroupAction/">
            <input type="hidden" name="group_id" id="join-group-id">
            <button type="submit" class="modal__submit-btn">I Accept and Join</button>
        </form>
    </div>
</div>


<script>
function openJoinModal(groupId) {
    document.getElementById('join-group-id').value = groupId;
    document.getElementById('joinModal').style.display = 'block';
}

function closeJoinModal() {
    document.getElementById('joinModal').style.display = 'none';
}
</script>


<?php require APPROOT.'/views/inc/footer.php'; ?>
