<?php require APPROOT.'/views/inc/header.php';?>
<!--TOP NAV BAR-->
<?php require APPROOT.'/views/inc/components/topnavbar.php';?>

<style>
    .requests-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .requests-header {
        background-color: #336699;
        color: white;
        padding: 30px 40px;
        border-radius: 10px 10px 0 0;
        position: relative;
        overflow: hidden;
        margin-bottom: 0;
    }
    
    .requests-header::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transform: skewX(-25deg);
    }
    
    .requests-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 600;
    }
    
    .requests-content {
        background: white;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .requests-empty {
        text-align: center;
        padding: 30px;
        border: 2px dashed #eaeaea;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
    
    .requests-empty p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 20px;
    }
    
    .requests-empty img {
        max-width: 120px;
        margin-bottom: 20px;
        opacity: 0.6;
    }
    
    .btn-browse {
        background-color: #ff9900;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .btn-browse:hover {
        background-color: #e68a00;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .requests-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .requests-table th {
        background-color: #f5f7fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        padding: 16px 12px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .requests-table td {
        padding: 16px 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    
    .requests-table tr:hover {
        background-color: #f8f9fa;
    }
    
    .requests-table tr:last-child td {
        border-bottom: none;
    }
    
    .book-title {
        font-weight: 600;
        color: #336699;
    }
    
    .book-link {
        color: #336699;
        text-decoration: none;
        transition: all 0.2s;
        position: relative;
        display: inline-block;
    }
    
    .book-link:hover {
        color: #ff9900;
        text-decoration: none;
    }
    
    .book-link .fa-external-link-alt {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-left: 5px;
        vertical-align: super;
    }
    
    .book-author {
        color: #666;
    }
    
    .request-date {
        color: #666;
        font-style: italic;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background-color: #fff8e6;
        color: #ffa000;
        border: 1px solid #ffe0b3;
    }
    
    .status-approved {
        background-color: #e6f7ed;
        color: #00a854;
        border: 1px solid #b3e6cc;
    }
    
    .status-denied {
        background-color: #fff1f0;
        color: #f5222d;
        border: 1px solid #ffc6c4;
    }
    
    .action-button {
        display: inline-block;
        margin-top: 20px;
    }
    
    .btn-back {
        background-color: #f5f5f5;
        color: #333;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .btn-back:hover {
        background-color: #e0e0e0;
        text-decoration: none;
        color: #333;
    }
    
    @media (max-width: 768px) {
        .requests-header {
            padding: 20px;
        }
        
        .requests-header h1 {
            font-size: 1.8rem;
        }
        
        .requests-content {
            padding: 15px;
        }
        
        .requests-table th {
            font-size: 0.8rem;
        }
        
        .status-badge {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
    }
</style>

<div class="requests-container">
    <?php flash('request_success'); ?>
    <?php flash('request_error'); ?>
    
    <div class="requests-header">
        <h1>My Book Requests</h1>
    </div>
    
    <div class="requests-content">
        <?php if(empty($data['requests'])) : ?>
            <div class="requests-empty">
                <img src="<?= URLROOT ?>/public/img/empty-requests.png" alt="No Requests" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5058/5058432.png';this.onerror='';" >
                <p>You haven't made any book requests yet.</p>
                <a href="<?= URLROOT ?>/child/childHome" class="btn-browse">Browse Books</a>
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Request Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['requests'] as $request) : ?>
                            <tr>
                                <td class="book-title">
                                    <a href="<?= URLROOT ?>/child/viewBook/<?= $request->book_id ?>" class="book-link">
                                        <?= $request->book_title ?>
                                        <i class="fas fa-external-link-alt fa-xs ml-1"></i>
                                    </a>
                                </td>
                                <td class="book-author"><?= $request->book_author ?></td>
                                <td><?= $request->book_genre ?></td>
                                <td class="request-date"><?= date('M d, Y', strtotime($request->created_at)) ?></td>
                                <td>
                                    <?php if($request->status == 'pending') : ?>
                                        <span class="status-badge status-pending">Pending</span>
                                    <?php elseif($request->status == 'approved') : ?>
                                        <span class="status-badge status-approved">Approved</span>
                                    <?php elseif($request->status == 'denied') : ?>
                                        <span class="status-badge status-denied">Denied</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <div class="action-button">
            <a href="<?= URLROOT ?>/child/childHome" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Books
            </a>
        </div>
    </div>
</div>

<?php require APPROOT.'/views/inc/footer.php';?>
