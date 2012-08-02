<?php $this->inherits('html') ?>
<?php $this->uses('blocks') ?>
<?php $this->start('title') ?>
Welcome
<?php $this->end('title') ?>

<?php $this->start('body') ?>
    <h1>Page</h1>
    <?php $this->show('flash') ?>
    <p>
        This file uses the equivalently named controller controller/index.php,
        and shows how to include, override and use snippets of other templates.
    </p>
    <?php $this->start('form') ?>
        <?php $this->start('form.content') ?>
        <?php $this->show('form.password') ?>
        <?php $this->end('form.content') ?>
    <?php $this->end('form') ?>
<?php $this->end('body') ?>