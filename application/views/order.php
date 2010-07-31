<?php

    if(!empty($err))
        echo $err;
    elseif(!empty($order))
    {
        echo form::open('order', array('method' => 'post'));
    
        echo '<table>';
    
        echo '<tr valign="top"><td><b>Товар:</b></td><td>'.$order['name'].' - '.$order['price'].' грн. за килограмм</td></tr>';
        echo '<tr valign="top"><td><b>ФИО:</b></td><td>'.form::input('fio').'</td></tr>';
        echo '<tr valign="top"><td><b>Адрес:</b></td><td>'.form::input('address').'</td></tr>';
        echo '<tr valign="top"><td><b>Телефон:</b> +38</td><td>'.form::input('phone').' <br><font size="1"><i>Напр.</i> 0501234567, без пробелов, скобок и тире</font></td></tr>';
        echo '<tr valign="top"><td><b>EMail:</b></td><td>'.form::input('email').'</td></tr>';
        echo '<tr valign="top"><td><b>Количество:</b></td><td>'.form::input('count').'&nbsp;<select name="select"><option value="kg">килограмм</option><option value="g">грамм</option></select><br><font size="1"><i>Напр.</i> 10 или 10.5, без пробелов</font></td></tr>';
        echo '<tr valign="top"><td>'.Captcha::instance()->render().'</td><td valign="top">'.form::input('captcha').'</td></tr>';
        echo '<tr valign="top"><td colspan="2" align="right">'.form::submit('submit', 'Отправить заказ').form::hidden('orderid', $order['id']).'</td></tr>';
    
        echo '</table>';
    
        echo form::close();
    }

?>