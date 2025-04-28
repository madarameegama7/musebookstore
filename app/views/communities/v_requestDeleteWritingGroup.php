<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<div class="container">
    <h2>Request to Delete Writing Group</h2>
    
    <form action="<?= URLROOT; ?>/communities/requestDeleteWritingGroup/<?= $data['community']->id ?>" method="POST">
        <input type="hidden" name="communityId" value="<?= $data['community']->id ?>">

        <div class="form-group">
            <label for="reason">Reason for Deletion:</label>
            <textarea name="reason" id="reason" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger mt-3">Submit Delete Request</button>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
