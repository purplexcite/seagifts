<?php defined('SYSPATH') or die('No direct script access.');

// Return page content
Class Model_Page extends Model
{
    function getpage($page = 'index')
    {
        return View::factory($page);
    }
}

Class Model_New extends ORM
{
    function getnews()
    {
        return ORM::factory('new')->find_all()->as_array();
    }
}

Class Model_Good extends ORM
{
    function getgoods($limit, $offset, $like = '')
    {
       return ORM::factory('good')->where('name', 'like', '%'.$like.'%')->or_where('description', 'like', '%'.$like.'%')->limit($limit)->offset($offset)->find_all()->as_array();
    }
    
    function getbyid($id)
    {
        return ORM::factory('good', $id)->as_array();
    }
    
    function sendorder()
    {
        $check = Validate::factory($_POST)->label('fio', 'ФИО')->label('address', 'адрес')->label('phone', 'телефон')->label('email', 'EMail')->label('orderid', 'номер заказа')->label('count', 'количество')->rule('count', 'not_empty')->rule('count', 'numeric')->rule('fio', 'not_empty')->rule('address', 'not_empty')->rule('phone', 'not_empty')->rule('phone', 'phone')->rule('email', 'not_empty')->rule('email', 'email')->rule('orderid', 'not_empty')->rule('orderid', 'numeric');
    
        if($check->check())
        {
            $order = ORM::factory('good', $_POST['orderid'])->as_array();
            
            $mailer = email::connect();
            $message = Swift_Message::NewInstance('Новый заказ', '<b>ФИО:</b>&nbsp;'.$_POST['fio'].'<br><b>Адрес:</b>&nbsp;'.$_POST['address'].'<br><b>Телефон:</b>&nbsp;'.$_POST['phone'].'<br><b>EMail:</b>&nbsp;'.$_POST['email'].'<br><b>Наименование:</b>&nbsp;'.$order['name'].' (id '.$order['id'].') '.$order['price'].' грн.<br><b>Количество:</b>&nbsp;'.$_POST['count'].'&nbsp;'.$_POST['select'], 'text/html', 'utf-8');
            $message->setTo('info@sg.od.ua');
            $message->setFrom('no-reply@sg.od.ua');
            $mailer->send($message);
            
            
            return TRUE;
        }
        else
            return strtolower(implode(' и ', $check->errors('')));
    }
    
    function getcount($like = '')
    {
        return ORM::factory('good')->where('name', 'like', '%'.$like.'%')->count_all();
    }
}