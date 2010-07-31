<html>
    <head>
        <title>Admin</title>
    </head>
    <body>
        <?php echo $content ?>
        <?php
        
            if(!empty($option))
                echo $option;
                
            if(!empty($err))
                echo $err;
            
            if(!empty($list))
            {
                echo '<hr align="center">';
                
                if($type == 'goods')
                {
                    echo form::open('admin/addgood', array('enctype' => 'multipart/form-data'));
                    echo form::submit('edit_submit', 'Сохранить');
                    echo form::submit('edit_button', 'Удалить');
                    
                    echo '<table>';
                    
                    echo '<tr align="center"><td>Удалить</td><td>Название</td><td>Цена за килограмм</td><td>Новое фото</td><td>Фотография</td><td>Описание</td></tr>';
                    
                    foreach($list as $entry)
                    {
                        echo '<tr align="center">';
                        
                        echo form::hidden('edit_id[]', $entry['id']);
                        echo '<td>'.form::checkbox('edit_delete[]', $entry['id']).'</td>';
                        echo '<td>'.form::input('edit_name[]', $entry['name']).'</td>';
                        echo '<td>'.form::input('edit_price[]', $entry['price']).'</td>';
                        echo '<td>'.form::file('edit_photo[]').'</td>';
                        echo '<td>';
                        
                        if(empty($entry['photo']))
                            echo 'Пусто';
                        else
                            echo html::anchor('./upload/'.$entry['photo'], html::image('./upload/'.$entry['photo'], array('width' => 50, 'height' => 50, 'border' => 0)));
                        
                        echo '<td>'.form::textarea('edit_description[]', $entry['description']).'</td>';
                        
                        echo '</td></tr>';
                    }
                    
                    echo '</table>';
                    
                    echo form::submit('edit_submit', 'Сохранить');
                    echo form::submit('edit_button', 'Удалить');
                    echo form::close();
                }
                else
                {
                    echo form::open('admin/addnews', array('method' => 'post'));
                    echo form::submit('edit_submit', 'Сохранить');
                    echo form::submit('edit_button', 'Удалить');
                    
                    echo '<table>';
                    
                    echo '<tr align="center"><td>Удалить</td><td>Заголовок</td><td>Текст</td></tr>';
                    
                    foreach($list as $entry)
                    {
                        echo '<tr align="center" valign="top">';
                        
                        echo form::hidden('edit_id[]', $entry['id']);
                        echo '<td>'.form::checkbox('edit_delete[]', $entry['id']).'</td>';
                        echo '<td>'.form::input('edit_title[]', $entry['title']).'</td>';
                        echo '<td>'.form::textarea('edit_content[]', $entry['content']).'</td>';
                        
                        echo '</tr>';
                    }
                    
                    echo '</table>';
                    
                    echo form::submit('edit_submit', 'Сохранить');
                    echo form::submit('edit_button', 'Удалить');
                    echo form::close();
                }
            }
        
        ?>
    </body>
</html>