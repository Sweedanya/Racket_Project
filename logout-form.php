<?php
session_start();
session_destroy();
require __dir__ . '/layout/header.php';
require __dir__ . '/includes/navbar.php';


?>

<div class="container">
    <h1>You Are Now Logged Out</h1>
    <p>Click <a href="index.php">here</a> to log back in.</p>
</div>

<?php include __dir__ . '/layout/footer.php'; ?>