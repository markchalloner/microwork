<?php $this->inherits('html') ?>

<?php $this->start('title') ?>
    404 Page Not Found
<?php $this->end('title') ?>

<?php $this->start('head') ?>

<?php $this->end('head') ?>

<?php $this->start('body') ?>
    <h1>404 Not Found</h1>
    <p>The page at <?php echo $_SERVER['REQUEST_URI'] ?> does not exist.</p>
<?php $this->end('body') ?>