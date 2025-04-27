<div class="stat-content">
    <div class="dashboard">
        <h2>
            <center>Summary</center>
        </h2>
        <div class="stats">
            <div class="stat">
                <div class="icon">
                    <img src="/musebookstore/public/img/parent_dashboard/children.png" alt="Child Logo">
                </div>
                <h3>
                    Child Count

                </h3>
                <p>
                <p>
                <p>
                <p><?php echo $data['child']->user_count; ?></p>
                    </p>
                </p>

                </p>
            </div>
            <div class="stat">
                <div class="icon">
                    <img src="/musebookstore/public/img/parent_dashboard/coin.png" alt="Coin Logo">
                    </i>
                </div>
                <h3>
                    Tokens
                </h3>
                <p>
                <p><?php echo $data['token']->token_count; ?></p>
                </p>
                <p class="up">
                more book tokens
                </p>
            </div>
            <div class="stat">
                <div class="icon">
                    <img src="/musebookstore/public/img/parent_dashboard/stack-of-books.png" alt="Book Logo">
                    </i>
                </div>
                <h3>
                    Total books
                </h3>
                <p>
                    <p><?php echo $data['book']->book_count?></p>
                </p>
                <p class="up">
                    uploaded so far
                </p>
            </div>
            <div class="stat">
                <div class="icon">
                    <img src="/musebookstore/public/img/parent_dashboard/progress.png" alt="Child Logo">
                    </i>
                </div>
                <h3>
                    Progress
                </h3>
                <p>
                <p><?php echo $data['transaction']->transaction_count?></p> 
                </p>
                <p class="up">
                <?php echo $data['transaction']->transaction_count?> engages with books
                </p>
            </div>

        </div>
    </div>

</div>