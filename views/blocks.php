<?php /* Example of generic blocks file */ ?>
<?php $this->start('flash') ?>
<?php if (isset($flash)): ?>
<p class="flash"><?php echo $flash ?></p>
<?php endif ?>
<?php $this->end('flash') ?>

<?php $this->start('form') ?>
<form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
    <?php $this->show('form.content') ?>
    <br />
    <input type="submit" name="submit" value="Submit" />
</form>
<?php $this->end('form') ?>

<?php $this->start('form.password') ?>
<label for="Password">Password:</label>
<br />
<input type="password" name="password" />
<?php $this->end('form.password') ?>