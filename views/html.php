<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php $this->show('top') ?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title>
    <?php $this->start('title') ?>
        Default title
    <?php $this->end('title') ?>
    </title>

    <?php $this->show('head') ?>

</head>

<body>
    <?php $this->start('body') ?>
    <h1>Default title</h1>
    <p>Default content</p>
    <?php $this->end('body') ?>

</body>
</html>
<?php $this->show('bottom') ?>