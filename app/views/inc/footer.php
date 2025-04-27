<!-- Load our custom alert JS -->
<script src="/musebookstore/public/js/custom-alerts.js"></script>

<?php
// Display any pending alerts
if (class_exists('Alert_Helper')) {
    echo Alert_Helper::display();
}
?>
</body>

</html>