<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php echo $title ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link rel="shortcut icon" href="favicon.ico">
		<meta name="keywords" content="some, key, words">
		<meta name="description" content="some description">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache">
		<?php echo html::style(Kohana::config('site.css_reset')) ?>
		<?php echo html::style(Kohana::config('site.css_default')) ?>
		<?php echo html::script('media/js/jquery.js') ?>
		<?php echo html::script('media/js/jquery01.js') ?>
	</head>
<body>
<div class="wrapper">
	<div class="header">
		<?php echo html::anchor('', '<div class="logo"></div>') ?>
	</div><!-- [END] header -->

	<div class="navigation">
		<ul id="sdt_menu" class="sdt_menu">
			<li>
				<a href="/">
					<?php echo html::image('media/images/20000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">Новости</span>
						<span class="sdt_descr">Узнайте первыми</span>
					</span>
				</a>
			</li>
			<li>
				<a href="/goods">
					<?php echo html::image('media/images/10000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">Каталог</span>
						<span class="sdt_descr">Наши товары</span>
					</span>
				</a>
			</li>
			<li>
				<a href="/basket">
					<?php echo html::image('media/images/30000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">Корзина</span>
						<span class="sdt_descr">Сделать заказ</span>
					</span>
				</a>
			</li>
			<li>
				<a href="/recepts">
					<?php echo html::image('media/images/40000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">Рецепты</span>
						<span class="sdt_descr">Самое вкусное</span>
					</span>
				</a>
			</li>
			<li>
				<a href="/about">
					<?php echo html::image('media/images/50000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">О нас</span>
						<span class="sdt_descr">Узнайте больше</span>
					</span>
				</a>
			</li>
			<li>
				<a href="/contacts">
					<?php echo html::image('media/images/60000000.jpg') ?>
					<span class="sdt_active"></span>
					<span class="sdt_wrap">
						<span class="sdt_link">Контакты</span>
						<span class="sdt_descr">Звоните</span>
					</span>
				</a>
			</li>
		</ul>
	</div> <!-- [END] navigation -->
	

<script type="text/javascript">
$(function() {
$('#sdt_menu > li').bind('mouseenter',function(){
					var $elem = $(this);
					$elem.find('img')
						 .stop(true)
						 .animate({
							'width':'150px',
							'height':'150px',
							'left':'0px'
						 },400,'easeOutBack')
						 .andSelf()
						 .find('.sdt_wrap')
					     .stop(true)
						 .animate({'top':'85px'},500,'easeOutBack')
						 .andSelf()
						 .find('.sdt_active')
					     .stop(true)
						 .animate({'height':'150px'},300,function(){
						var $sub_menu = $elem.find('.sdt_box');
						if($sub_menu.length){
							var left = '150px';
							if($elem.parent().children().length == $elem.index()+1)
								left = '-150px';
							$sub_menu.show().animate({'left':left},200);
						}	
					});
				}).bind('mouseleave',function(){
					var $elem = $(this);
					var $sub_menu = $elem.find('.sdt_box');
					if($sub_menu.length)
						$sub_menu.hide().css('left','0px');
					
					$elem.find('.sdt_active')
						 .stop(true)
						 .animate({'height':'0px'},300)
						 .andSelf().find('img')
						 .stop(true)
						 .animate({
							'width':'0px',
							'height':'0px',
							'left':'85px'},400)
						 .andSelf()
						 .find('.sdt_wrap')
						 .stop(true)
						 .animate({'top':'25px'},500);
				});
$('#rp_list a').tipsy({gravity: 's'});
});
</script>
<div class="content">
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
													echo '<hr noshade color="#032c5b" size="5" width="60%" align="center">';
													echo form::close();
													echo '</center>';
													
													if($pagination->total_items != 1)
																	echo '<center>'.$pagination.'</center><hr noshade color="#032c5b" size="5" width="60%" align="center">';
													
													foreach($content as $data)
																	{
																					if(!empty($data->photo))
																									$photo = html::anchor('upload/'.$data->photo, html::image('upload/'.$data->photo, array('width' => 50, 'height' => 50, 'alt' => $data->photo)));
																					else
																									$photo = 'Нет фото';
																					
																					echo '<table border="0" width="60%" align="center">';
																					
																					echo '<tr valign="top"><td width="25%"><b>Название:</b></td><td width="25%">'.$data->name.'</td><td width="50%" rowspan="4" width="50%"><center><b>Описание:</b></center><br>'.(!empty($data->description) ? nl2br($data->description):"Нет описания").'</td></tr>';
																					echo '<tr valign="top"><td width="25%"><b>Цена (за КГ):</b></td><td width="25%">'.$data->price.'&nbsp;грн.</td></tr>';
																					echo '<tr valign="top"><td width="25%" valign="top"><b>Фото:</b></td><td width="25%" valign="top">'.$photo.'</td></tr>';
																					echo '<tr valign="top"><td width="50%" colspan="2">'.html::anchor('addbasket/'.$data->id, 'Добавить в корзину', array('title' => 'Купить '.$data->name.' - '.$data->price.' грн. за килограмм')).'</td></tr>';
																					
																					echo '</table><hr noshade color="#032c5b" size="1" width="60%" align="center"><p>';
																	}
													
													if($pagination->total_items != 1)
																	echo '<hr noshade color="#032c5b" size="5" width="60%" align="center"><center>'.$pagination.'</center>';
									}
					}
	
					?>
	</div><!-- [END] content -->
	<div class="footer">
        <p>design & code &#169; <?php echo html::mailto('purplexcite@yahoo.com', 'm.r.s.a.') ?></p>
	</div>							
				
	</div><!-- [END] wrapper -->

</body>
</html>