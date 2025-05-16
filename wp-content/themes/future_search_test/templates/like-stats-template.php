<h1 class="wp-heading-inline"><?php _e('Статистика Лайков и Дизлайков', 'lieferchef')?></h1>

<?php
$table = new \FS\Like_Stats_Table();
$table->prepare_items();

?>
<form id="fs-table" method="GET">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
    <?php $table->display() ?>
</form>
