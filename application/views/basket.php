<?php
    
    $session = Session::instance()->get('orders');
    
    if(!empty($session))
    {
        echo form::open('editbasket')

?>
<table width="100%">
    <tr><td><b>Действия:</b></td></tr>
    <tr>
        <td>
            
            <?php
            
                echo html::anchor('order', 'Оплатить товар ('.$all_price.' грн.)');
                echo '<br>';
                echo html::anchor('clearbasket', 'Очистить корзину');
            
            ?>
            
        </td>
    </tr>
</table>
<p>
<table align="center">
    <tr>
        <td><b>Наименование</b></td>
        <td><b>Цена</b></td>
        <td><b>Количество</b></td>
        <td><b>Размерность</b></td>
        <td><b>Удалить</b></td>
    </tr>
    
    <?php
    
        foreach(Session::instance()->get('orders') as $k => $v)
        {
            echo '<tr>';
            
            echo '<td>'.$v['name'].form::hidden('basket_id[]', $k).'</td>';
            echo '<td>'.$v['price'].'</td>';
            echo '<td>'.form::input('count[]', $v['count']).'</td>';
            echo '<td><select name="select[]"><option value="kg" '.($v['select'] == 'kg'? 'selected':'').'>килограмм</option><option value="g" '.($v['select'] == 'g'? 'selected':'').'>грамм</option></select></td>';
            echo '<td>'.form::checkbox('del_id[]', $k).'</td>';
            
            echo '</tr>';
        }
        
         echo '<tr><td colspan="5" align="right"><br>'.form::submit('submit_basket', 'Принять изменения').'</td></tr>';
    
    ?>
    
</table>

<?php
    
    }
    else
        echo 'Корзина пуста';
        
    if(!empty($err))
        echo $err;

?>