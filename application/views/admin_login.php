<table>
    <?php echo form::open('admin', array('method' => 'post')) ?>
    <tr>
        <td>Логин:</td>
        <td><?php echo form::input('login') ?></td></tr>
    </tr>
    <tr>
        <td>Пароль:</td>
        <td><?php echo form::password('password') ?></td>
    </tr>
    <tr>
        <td><?php echo Captcha::instance()->render() ?></td>
        <td valign="top"><?php echo form::input('captcha') ?></td>
    </tr>
    <tr>
        <td align="right" colspan="2"><?php echo form::submit('submit', 'Send') ?></td>
    </tr>
    <?php echo form::close() ?>
</table>