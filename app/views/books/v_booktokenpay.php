<?php require APPROOT . '/views/inc/header.php'; ?>
<!--TOP NAV BAR-->
<?php require APPROOT . '/views/inc/components/topnavbar.php'; ?>

<?php
if (!isset($_SESSION['user_role'])) {
    die("Please login");
}
?>
<div class="addbook-container">
    <div class="addbook-photo">
        <h3>Buy token and buy tokens for any book transactions</h3>
        <br>

        <img src="/musebookstore/public/img/books/new.avif" alt="Book Reading image">

    </div>

    <div class="addbook-box">

        <form action="<?php echo URLROOT; ?>/Books/makePayment" method="post" enctype="multipart/form-data">


            <label>Cardholder Name</label>
            <input type="text" name="cardname" value="<?php echo $data['cardname']; ?>">
            <span class="error"><?php echo $data['cardnameError']; ?></span>

            <label>Card Number</label>
            <input type="text" name="cardnumber" value="<?php echo $data['cardnumber']; ?>">
            <span class="error"><?php echo $data['cardnumberError']; ?></span>

            <label>CVN</label>
            <input type="text" name="cvn" value="<?php echo $data['cvn']; ?>">
            <span class="error"><?php echo $data['cvnError']; ?></span>

            <label>Amount</label><br>
            <input type="text" name="amount" id="amount" value="200" readonly required>
            <br>

            <br>

            <button type="submit" name="add-book-btn" class="add-book-btn">Add Book</button>

        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>