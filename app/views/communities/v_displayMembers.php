<?php require APPROOT.'/views/inc/header.php'; ?>
<?php require APPROOT.'/views/inc/components/topnavbar.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/css/displayMembers.css">

<div class="members-main-content">
  <div class="members-container">
    <h1 class="members-title">
      <center>Members of <?= $data['community']->communityName ?></center>
    </h1>

    <button id="openMemberModalBtn" class="members-btn-submit">Add New Member</button>

    <?php if (!empty($data['members'])): ?>
      <ul class="members-list">
        <?php foreach ($data['members'] as $member): ?>
          <li class="members-list-item">
            <strong>Name:</strong> <?= $member->community_member_name ?><br>
            <a class="members-view-btn">Delete</a>
          </li>
          <hr>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="members-empty">No members found in this community.</p>
    <?php endif; ?>

    <a href="<?= URLROOT ?>/communities" class="members-back-btn">⬅ Back to Communities</a>
  </div>
</div>

<!-- Modal -->
<div id="addMemberModal" class="members-modal">
  <div class="members-modal-content">
    <span class="members-close-btn" id="closeMemberModalBtn">&times;</span>
    <h2 class="members-modal-title">Add New Member</h2>

    <?php if (!empty($data['users'])): ?>
      <form action="<?= URLROOT ?>/communities/addMembers/<?= $data['community']->communityId ?>" method="POST" class="members-form">
      <input type="text" name="community_member_name" placeholder="Enter Member Name" required class="members-input">


        <select name="user_id" required class="members-select">
          <option value="" disabled selected>Select a user</option>
          <?php foreach ($data['users'] as $user): ?>
            <option value="<?= $user->user_id ?>"><?= $user->user_name ?></option>
          <?php endforeach; ?>
        </select>

        <button type="submit" class="members-btn-submit">Add Member</button>
      </form>
    <?php else: ?>
      <p class="members-empty">No users available to add.</p>
    <?php endif; ?>
  </div>
</div>

<script>
document.getElementById("openMemberModalBtn").addEventListener("click", function() {
  document.getElementById("addMemberModal").style.display = "block";
});

document.getElementById("closeMemberModalBtn").addEventListener("click", function() {
  document.getElementById("addMemberModal").style.display = "none";
});

window.addEventListener("click", function(event) {
  const modal = document.getElementById("addMemberModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
});
</script>

<?php require APPROOT.'/views/inc/footer.php'; ?>
