<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>


<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'parent') {
    die("Access denied! You do not have permission to view this page.");
}
?>

<header class="wgp-hero">
    <div class="wgp-hero__content">
        <h1>Writing Group: <?= htmlspecialchars($data['writingGroup_name']) ?></h1>
        <p class="wgp-hero__subtitle">Read the Chapters Below</p>
    </div>
</header>

<div class="wgp-container">
<section class="wgp-rules-section">
    <h2 class="wgp-rules-title">📌 Tips & Rules</h2>
    <ul class="wgp-rules-list">
        <li>✅ Be respectful to others' writing styles and feedback.</li>
        <li>🕒 Post your chapters consistently to keep the story engaging.</li>
        <li>🔍 Keep content relevant and appropriate for all readers.</li>
        <li>💬 Give constructive feedback on other members' chapters.</li>
        <li>🚫 Plagiarism is strictly prohibited — always share original content.</li>
    </ul>
</section>

    <section class="wgp-posts-section">
        <h2 class="wgp-posts-title">Chapters</h2>

        <a href="<?= URLROOT; ?>/communities/createWritingGroupPostAction/<?= $data['writingGroup_id']; ?>" class="wgp-btn wgp-btn--primary">Create a Chapter</a>

        <?php if (!empty($data['posts'])): ?>
            <ul class="wgp-posts-list">
                <?php foreach ($data['posts'] as $post): ?>
                    <li class="wgp-post">
                        <div class="wgp-post__content">
                            <h3 class="wgp-post__title"><?= htmlspecialchars($post->chapter_title) ?></h3>
                            <p class="wgp-post__date"><?= date('F j, Y', strtotime($post->created_at)); ?></p>
                            <p class="wgp-post__text"><?= nl2br(htmlspecialchars($post->chapter_content)); ?></p>
                            <a 
                                href="<?= URLROOT; ?>/communities/deleteWritingGroupPost/<?= $data['writingGroup_id']; ?>/<?= $post->writingGroup_post_id; ?>" 
                                class="wgp-btn wgp-btn--danger"
                                onclick="return confirm('Are you sure you want to delete this chapter?')"
                            >
                                Delete
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="wgp-no-posts">No chapters found for this writing group.</p>
        <?php endif; ?>
    </section>
</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>
