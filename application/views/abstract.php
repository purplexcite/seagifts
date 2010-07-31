<?php echo html::style(Kohana::config('site.css_default')) ?>
<html>
    <head>
        <title><?php echo $title ?></title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="keywords" content="some, key, words">
        <meta name="description" content="some description">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="pragma" content="no-cache">
    </head>
    <body>
        <div class="logo"></div>
        <p>
        
        <div class="menu">
            <div class="options">
            <center>
            <?php
            
                echo html::anchor('', '<Новости>');
                echo '&nbsp;';
                echo html::anchor('goods', '<Каталог>');
                echo '&nbsp;';
                echo html::anchor('about', '<О нас>');
                echo '&nbsp;';
                echo html::anchor('contacts', '<Контакты>');
            
            ?>
            </center>
            </div>
            <div class="text">
            <?php
            
            // Requested news or static page?
            if(gettype($content) != 'array')
                echo $content;
            else
            {
                if($opt == 'news')
                {
                    foreach($content as $data)
                        echo '<center><b>'.$data->title.'</b></center><br>'.nl2br($data->content).'<p>';
                }
                else
                {
                    echo '<center>';
                    echo form::open('goods', array('method' => 'get'));
                    echo '<b>Поиск товара:</b> '.form::input('search', (empty($_REQUEST['search']) ? '':$_REQUEST['search'])).'&nbsp;'.form::submit('submit', 'Найти').'<p>';
                    echo '<hr noshade color="black" size="5">';
                    echo form::close();
                    echo '</center>';
                    
                    if($pagination->total_items != 1)
                        echo '<center>'.$pagination.'</center><hr noshade color="black" size="5">';
                    
                    foreach($content as $data)
                        {
                            if(!empty($data->photo))
                                $photo = html::anchor('upload/'.$data->photo, html::image('upload/'.$data->photo, array('width' => 50, 'height' => 50, 'alt' => $data->photo)));
                            else
                                $photo = 'Нет фото';
                            
                            echo '<table border="0" cellspacing="0" cellpadding="4" width="100%">';
                            
                            echo '<tr><td><b>Название:</b></td><td>'.$data->name.'</td><td rowspan="4" width="60%" valign="top"><center><b>Описание:</b></center><br>'.nl2br($data->description).'</td></tr>';
                            echo '<tr><td><b>Цена (за КГ):</b></td><td>'.$data->price.'&nbsp;грн.</td></tr>';
                            echo '<tr><td valign="top"><b>Фото:</b></td><td valign="top">'.$photo.'</td></tr>';
                            echo '<tr><td colspan="2">-->&nbsp;'.html::anchor('order/'.$data->id, 'Купить '.$data->name).'</td></tr>';
                            
                            echo '</table><p>';
                        }
                    
                    if($pagination->total_items != 1)
                        echo '<hr noshade color="black" size="5"><center>'.$pagination.'</center>';
                }
            }
        
            ?>
            </div>
        </div>
        <p>
        <center><font color="white" size="1">design & code &#169; <?php echo html::mailto('purplexcite@yahoo.com', 'm.r.s.a.') ?></font></center>
    </body>
</html>