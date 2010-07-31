<table>
    <?php echo form::open('admin/addgood', array('enctype' => 'multipart/form-data')) ?>
    <tr>
        <td>Наименование:</td>
        <td><?php echo form::input('name') ?></td>
    </tr>
    <tr>
        <td>Цена за килограмм:</td>
        <td><?php echo form::input('price') ?></td>
    </tr>
    <tr>
        <td>Фото:</td>
        <td><?php echo form::file('photo') ?></td>
    </tr>
    <tr>
        <td valign="top">Описание:</td>
        <td><?php echo form::textarea('description') ?></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><?php echo form::submit('submit', 'Добавить товар') ?></td>
    </tr>
    <?php echo form::close() ?>
</table>