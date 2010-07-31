<table>
    <?php echo form::open('admin/addnews', array('method' => 'post')) ?>
    <tr>
        <td>Заголовок:</td>
        <td><?php echo form::input('title') ?></td>
    </tr>
    <tr valign="top">
        <td>Текст:</td>
        <td><?php echo form::textarea('content') ?></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><?php echo form::submit('submit', 'Добавить новость') ?></td>
    </tr>
    <?php echo form::close() ?>
</table>