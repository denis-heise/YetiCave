<?php
    require_once('header.php');
?>

<main <?php if($_SERVER["REQUEST_URI"] === "/") : ?>class="container"<?php endif ?>>
    <?=$content; ?>
</main>

<?php
    require_once('footer.php');
?>
