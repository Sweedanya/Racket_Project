<?php

if (isset($status)) : ?>
    <div class="container <?php echo ($status['code'] === 1 ? 'bg-success' : 'bg-warning'); ?> ">
        <p>
            <?php echo $status["message"] ?>
        </p>
<?php endif; ?> 