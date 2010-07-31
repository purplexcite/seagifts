<?php defined('SYSPATH') or die('No direct script access.');

Class Model_Admin extends Model
{
    // Check if already logged in
    function islogged()
    {
        if(Session::instance()->get('islogged') == 'on')
            return TRUE;
    }
    
    // Show HTML form of admin login
    function showlogin()
    {
        return View::factory('admin_login');
    }
    
    // Validate input data and check if login is successfull
    function checklogin()
    {
        $post = Validate::factory($_POST)->label('login', 'логин')->label('password', 'пароль')->rule('login', 'not_empty')->rule('password', 'not_empty');
        
        if($post->check())
        {
            $res = DB::select('id')->from('admins')->where('login', '=', $_POST['login'])->where('password', '=', $_POST['password'])->execute()->as_array();
            
            if(!empty($res))
                return TRUE;
            else
                return FALSE;
        }
        else
            return strtolower(implode(' и ', $post->errors('')));
    }
    
    // Page for admin
    function genpage()
    {
        return View::factory('admin_options');
    }
    
    // Check new inserted good and add to database
    function addgood()
    {
        $data = Validate::factory(array_merge($_POST, $_FILES))->label('name', 'наименование')->label('price', 'цена')->rule('name', 'not_empty')->rule('price', 'not_empty')->rule('price', 'numeric')->label('photo', 'фото')->rule('photo', 'upload::type', array(array('gif', 'png', 'jpg')));
        
        if($data->check())
        {
            $photo = upload::save($_FILES['photo'], $_FILES['photo']['name']);
            
            $db = DB::insert('goods', array('name', 'price', 'photo', 'description'))->values(array($_POST['name'], $_POST['price'], $_FILES['photo']['name'], $_POST['description']))->execute();
            
            return TRUE;
        }
        else
            return strtolower(implode(' и ', $data->errors('')));
    }
    
    // Show list of goods or news
    function showlist($list)
    {    
        // If resize online
        /*if($list == 'goods')
            foreach($res as &$entry)
            {
                if(!empty($entry['photo']))
                {
                    $this->thumb = Image::factory('./upload/'.$entry['photo']);
                    $this->thumb->resize(NULL, 200);
            
                    $entry['photo_thumb'] = $this->thumb->render();
                }
            }*/
        
        return DB::select()->from($list)->execute()->as_array();
    }
    
    // Delete goods
    function delgood()
    {
        DB::delete('goods')->where('id', 'IN', $_POST['edit_delete'])->execute();
    }
    
    // Edit goods
    function editgood()
    {   
        $data = Validate::factory(array_merge($_POST, $_FILES))->label('edit_name', 'наименование')->label('edit_id', 'id')->label('edit_price', 'цена')->rule('edit_name', 'not_empty')->rule('edit_price', 'not_empty')->rule('edit_id', 'not_empty')->label('edit_photo', 'фото')->rule('edit_photo', 'upload::type', array(array('gif', 'png', 'jpg')));
        
        if($data->check())
        {   
            for($i = 0; $i < count($_POST['edit_id']); $i++)
            {
                // If new photo exist
                if(!empty($_FILES['edit_photo']['name'][$i]))
                {echo Kohana::debug($_FILES);
                    $arr = array('edit_photo' => array('name' => $_FILES['edit_photo']['name'][$i], 'type' => $_FILES['edit_photo']['type'][$i], 'tmp_name' => $_FILES['edit_photo']['tmp_name'][$i], 'error' => $_FILES['edit_photo']['error'][$i], 'size' => $_FILES['edit_photo']['size'][$i]));
                    
                    $photo = upload::save($arr['edit_photo'], $_FILES['edit_photo']['name'][$i]);
                    
                    DB::update('goods')->set(array('name' => $_POST['edit_name'][$i], 'price' => $_POST['edit_price'][$i], 'description' => $_POST['edit_description'][$i], 'photo' => $_FILES['edit_photo']['name'][$i]))->where('id', '=', $_POST['edit_id'][$i])->execute();
                }
                else
                    DB::update('goods')->set(array('name' => $_POST['edit_name'][$i], 'description' => $_POST['edit_description'][$i], 'price' => $_POST['edit_price'][$i]))->where('id', '=', $_POST['edit_id'][$i])->execute();
            }
            
            return TRUE;
        }
        else
            return strtolower(implode(' и ', $data->errors('')));
    }
    
    // Add news
    function addnews()
    {
        $data = Validate::factory($_POST)->label('title', 'заголовок')->label('content', 'текст')->rule('title', 'not_empty')->rule('content', 'not_empty');
        
        if($data->check())
        {
            $db = DB::insert('news', array('title', 'content'))->values(array($_POST['title'], $_POST['content']))->execute();
            
            return TRUE;
        }
        else
            return strtolower(implode(' и ', $data->errors('')));
    }
    
    function delnews()
    {
        DB::delete('news')->where('id', 'IN', $_POST['edit_delete'])->execute();
    }
    
    // Edit news
    function editnews()
    {   
        $data = Validate::factory($_POST)->label('edit_title', 'заголовок')->label('edit_id', 'id')->label('edit_content', 'текст')->rule('edit_title', 'not_empty')->rule('edit_content', 'not_empty')->rule('edit_id', 'not_empty');
        
        if($data->check())
        {   
            for($i = 0; $i < count($_POST['edit_id']); $i++)
                DB::update('news')->set(array('title' => $_POST['edit_title'][$i], 'content' => $_POST['edit_content'][$i]))->where('id', '=', $_POST['edit_id'][$i])->execute();
            
            return TRUE;
        }
        else
            return strtolower(implode(' и ', $data->errors('')));
    }
}