<?php

        echo form::open('order', array('method' => 'post'));
    
        echo '<table align="center">';
    
        echo '<tr valign="top"><td><b>ФИО:</b></td><td>'.form::input('fio').'</td></tr>';
        echo '<tr valign="top"><td><b>Адрес:</b></td><td>'.form::input('address').'</td></tr>';
        echo '<tr valign="top"><td><b>Телефон:</b> +38</td><td>'.form::input('phone').' <br><font size="1"><i>Напр.</i> 0501234567,<br>без пробелов, скобок и тире</font></td></tr>';
        echo '<tr valign="top"><td><b>EMail:</b></td><td>'.form::input('email').'</td></tr>';
        echo '<tr valign="top"><td>'.Captcha::instance()->render().'</td><td valign="top">'.form::input('captcha', '', array('style' => 'width: 143px; height: 48px; font-size: 50px;')).'</td></tr>';
        echo '<tr valign="top"><td colspan="2" align="center">'.form::submit('submit', 'Отправить заказ').'</td></tr>';
    
        echo '</table>';
    
        echo form::close();
        
        if(!empty($err))
        echo $err;

?>