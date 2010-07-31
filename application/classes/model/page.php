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
    function all_price()
    {
        $price = 0;
        
        $session = Session::instance()->get('orders');
        
        if(!empty($session))
            foreach($session as $k => $v)
            {
                $price += ORM::factory('good')->where('id', '=', $v['id'])->find()->price;
            }
        
        return $price;
    }
    
    function delbasket()
    {
        $session = Session::instance();
            
        $_SESSION =& $session->as_array();
        
        foreach($_POST['del_id'] as $k)
        {
            unset($_SESSION['orders'][$k]);
        }
    }
    
    function editbasket()
    {
        $session = Session::instance();
        
        $_SESSION =& $session->as_array();
        //echo Kohana::debug($_POST);
        //echo Kohana::debug($_SESSION);
        foreach($_POST['basket_id'] as $k)
        {
            //$chk = Validate::factory($_POST['count'], $_POST['select'], $_POST['basket_id'])->label('basket_id', 'ID записи')->label('count', 'количество')->label('select', 'размерность')->rule('basket_id', 'numeric')->rule('count', 'numeric')->rule('select', 'not_empty');
            //echo Kohana::debug($_POST['basket_id'][$k]);
            //if($chk->check())
            //{
                $_SESSION['orders'][$k]['count'] = (float)abs($_POST['count'][$k]);
                $_SESSION['orders'][$k]['select'] = $_POST['select'][$k];
            //}
            //else
                //return strtolower(implode(' и ', $chk->errors('')));
        }
        
        return 'Товар(ы) успешно обновлен(ы)';
    }
    
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
        $check = Validate::factory($_POST)->label('fio', 'ФИО')->label('address', 'адрес')->label('phone', 'телефон')->label('email', 'EMail')->rule('fio', 'not_empty')->rule('address', 'not_empty')->rule('phone', 'not_empty')->rule('phone', 'phone')->rule('email', 'not_empty')->rule('email', 'email');
    
        if($check->check())
        {
            //$order = ORM::factory('good', $_POST['orderid'])->as_array();
            
            $session = Session::instance();
        
            $_SESSION =& $session->as_array();
            
            $orders = '<b>Наименования:</b><br>';
            $price = 0;
            
            foreach($_SESSION['orders'] as $k => $v)
            {
                $orders .= $_SESSION['orders'][$k]['name'].' (ID: '.$_SESSION['orders'][$k]['id'].') - '.$_SESSION['orders'][$k]['price'].' грн. ('.$_SESSION['orders'][$k]['count'].'&nbsp;'.$_SESSION['orders'][$k]['select'].')<br>';
                
                $cof = ($_SESSION['orders'][$k]['select'] == 'kg' ? $_SESSION['orders'][$k]['count']:$_SESSION['orders'][$k]['count']/1000);
                
                $price += ($_SESSION['orders'][$k]['price']*$cof);
            }
            
            $text = '<b>ФИО:</b>&nbsp;'.$_POST['fio'].'<br>
                     <b>Адрес:</b>&nbsp;'.$_POST['address'].'<br>
                     <b>Телефон:</b>&nbsp;'.$_POST['phone'].'<br>
                     <b>EMail:</b>&nbsp;'.$_POST['email'].'<br>'.$orders.'<p><b>Итоговая цена без доставки:</b> '.$price;
            
            $mailer = email::connect();
            $message = Swift_Message::NewInstance('Новый заказ', $text, 'text/html', 'utf-8');
            $message->setTo('info@sg.od.ua');
            $message->setFrom('no-reply@sg.od.ua');
            $mailer->send($message);
            
            Session::instance()->delete('orders');
            
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