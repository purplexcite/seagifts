<?php defined('SYSPATH') OR die('No Direct Script Access');

Class Controller_Admin extends Controller_Template
{
    public $template = 'admin';
    
    function before()
    {
        parent::before();
        
        $this->admin = new Model_Admin;
        $this->action_index();
    }
    
    // Main page of admin
    function action_index()
    {
        // Check if already logged in
        if($this->admin->islogged() === TRUE)
            $this->template->content = $this->admin->genpage();
        else
            $this->template->content = $this->admin->showlogin();
            
        // Check if login data sended
        if(isset($_POST['login']) and isset($_POST['password']) and isset($_POST['captcha']))
        {
            if(Captcha::valid($_POST['captcha']))
            {
                // Check auth
                $auth = $this->admin->checklogin();
            
                if($auth === TRUE)
                {
                    Session::instance()->set('islogged', 'on');
                    
                    $this->request->redirect('admin');
                }
                else if(gettype($auth) == 'string')
                    $this->template->err = $auth;
            }
            else
                $this->template->err = 'Неверно введена капча';
        }
    }
    
    // Logout from admin panel
    function action_logout()
    {
        if($this->admin->islogged() !== TRUE)
            $this->request->redirect('admin');
        else
        {
         Session::instance()->delete('islogged');
        
         $this->request->redirect('admin');   
        }
    }
    
    function action_addgood()
    {
        // Show HTML of good adding
        $this->template->option = View::factory('admin_addgood');
        
        // Show already inserted goods
        $this->template->type = 'goods';
        $this->template->list = $this->admin->showlist('goods');
        
        // If new good inserted
        if(isset($_POST['name']) and isset($_POST['price']) and isset($_FILES['photo']) and isset($_POST['description']))
        {
            // Validate, then add to database and print result
            $addgood = $this->admin->addgood();
            
            if($addgood === TRUE)
            {
                $this->request->redirect('admin/addgood');                
                $this->template->err = 'Товар добавлен в базу';    
            }
            else $this->template->err = $addgood;
        }
        
        // If requested delete or edit of good
        if(isset($_POST['edit_id']))
        {
            // If delete requested
            if(isset($_POST['edit_delete']) and isset($_POST['edit_button']))
            {   
                $this->admin->delgood();
                $this->request->redirect('admin/addgood');
                $this->template->err = 'Товар(ы) удален(ы)';
            }
            // If edit requested
            else
            {
                $editgood = $this->admin->editgood();
                
                if($editgood !== TRUE)
                    $this->template->err = $editgood;
                else
                    $this->template->err = 'Товар(ы) сохранен(ы)';
                
                $this->request->redirect('admin/addgood');
            }
        }
    }
    
    function action_addnews()
    {
        $this->template->option = View::factory('admin_addnews');
        
        $this->template->type = 'news';
        $this->template->list = $this->admin->showlist('news');
        
        // If news inserted
        if(isset($_POST['title']) and isset($_POST['content']))
        {
            // Validate, then add to database and print result
            $addnews = $this->admin->addnews();
            
            if($addnews === TRUE)
            {
                $this->request->redirect('admin/addnews');                
                $this->template->err = 'Новость добавлена в базу';    
            }
            else $this->template->err = $addnews;
        }
        
        // Edit or delete news
        if(isset($_POST['edit_id']))
        {
            // If delete requested
            if(isset($_POST['edit_delete']) and isset($_POST['edit_button']))
            {   
                $this->admin->delnews();
                $this->request->redirect('admin/addnews');
                $this->template->err = 'Удалено';
            }
            // If edit requested
            else
            {
                $editnews = $this->admin->editnews();
                
                if($editnews !== TRUE)
                    $this->template->err = $editnews;
                else
                    $this->template->err = 'Сохранено';
                
                $this->request->redirect('admin/addnews');
            }
        }
    }
}