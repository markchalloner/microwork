<?php $this->inherits('html') ?>
<?php $this->uses('blocks') ?>
<?php $this->start('title') ?>
Secure page
<?php $this->end('title') ?>

<?php $this->start('body') ?>
    <h1>Secure page</h1>
    <?php $this->show('flash') ?>
    <p>
        This page is an example of a "secured" page (requires a certain GET url).
    </p>
<?php $this->end('body') ?>