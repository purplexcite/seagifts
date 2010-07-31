<?php

        echo form::open('order', array('method' => 'post'));
    
        echo '<table>';
    
        echo '<tr valign="top"><td><b>ФИО:</b></td><td>'.form::input('fio').'</td></tr>';
        echo '<tr valign="top"><td><b>Адрес:</b></td><td>'.form::input('address').'</td></tr>';
        echo '<tr valign="top"><td><b>Телефон:</b> +38</td><td>'.form::input('phone').' <br><font size="1"><i>Напр.</i> 0501234567, без пробелов, скобок и тире</font></td></tr>';
        echo '<tr valign="top"><td><b>EMail:</b></td><td>'.form::input('email').'</td></tr>';
        echo '<tr valign="top"><td>'.Captcha::instance()->render().'</td><td valign="top">'.form::input('captcha').'</td></tr>';
        echo '<tr valign="top"><td colspan="2" align="right">'.form::submit('submit', 'Отправить заказ').'</td></tr>';
    
        echo '</table>';
    
        echo form::close();
        
        if(!empty($err))
        echo $err;

?>