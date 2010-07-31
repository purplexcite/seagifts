<?php

    if(!empty($err))
        echo $err;
    elseif(!empty($order))
    {
        echo form::open('order', array('method' => 'post'));
    
        echo '<table>';
    
        echo '<tr><td><b>Товар:</b></td><td>'.$order['name'].' - '.$order['price'].' грн.</td></tr>';
        echo '<tr><td><b>ФИО:</b></td><td>'.form::input('fio').'</td></tr>';
        echo '<tr><td><b>Адрес:</b></td><td>'.form::input('address').'</td></tr>';
        echo '<tr><td><b>Телефон:</b> +38</td><td>'.form::input('phone').'</td></tr>';
        echo '<tr><td><b>EMail:</b></td><td>'.form::input('email').'</td></tr>';
        echo '<tr><td><b>Количество:</b></td><td>'.form::input('count').'&nbsp;<select name="select"><option value="kg">килограмм</option><option value="g">грамм</option></select></td></tr>';
        echo '<tr><td>'.Captcha::instance()->render().'</td><td valign="top">'.form::input('captcha').'</td></tr>';
        echo '<tr><td colspan="2" align="right">'.form::submit('submit', 'Отправить заказ').form::hidden('orderid', $order['id']).'</td></tr>';
    
        echo '</table>';
    
        echo form::close();
    }

?>