<?php defined('SYSPATH') OR die('No Direct Script Access');

// Main template to generate content in (header, footer, title and etc settings)
Class Controller_Abstract extends Controller_Template
{
    public $template = 'abstract';
    
    function before()
    {
        parent::before();
        
        $this->template->title = Kohana::config('site.title');
        $this->page = new Model_Page;
        $this->news = new Model_New;
        $this->goods = new Model_Good;
        
        if(!empty($_REQUEST['search']))
            $count = $this->goods->getcount($_REQUEST['search']);
        else
            $count = $this->goods->getcount();
        
        $this->pagination = new Pagination(array('current_page' => array('source' => 'route', 'key' => 'id'), 'total_items' => $count, 'items_per_page' => 5));
    }
}

// View custom page
Class Controller_Page extends Controller_Abstract
{   
    function action_showpage($page = 'index')
    {
        if($page == 'goods')
        {
            $id = $this->request->param('id');
            
            if(empty($id))
                $id = 1;
            
            if($this->goods->getcount() < ($id-1)*5)
                $this->template->content = 'Неверный номер страницы';
            else
            {
             if(!empty($_REQUEST['search']))
                $this->template->content = $this->goods->getgoods(5, ($id-1)*5, $_REQUEST['search']);
             else
                $this->template->content = $this->goods->getgoods(5, ($id-1)*5);
             
             $this->template->pagination = $this->pagination;
             $this->template->opt = 'goods';   
            }
        }
        else if($page != 'index')
        {
            if($page == 'addbasket')
            {
                $id = $this->request->param('id');
                
                if(empty($id))
                    $this->template->content->err = 'Не выбран товар';
                else
                {
                    $get = $this->goods->getbyid($id);
                    
                    if(!empty($get['id']))
                    {
                        $session = Session::instance()->get('orders');
                        $session[] = array('id' => $get['id'], 'name' => $get['name'], 'price' => $get['price'], 'count' => 1, 'select' => 'kg');
                        
                        Session::instance()->set('orders', $session);
                        $this->template->content = 'Товар добавлен в '.html::anchor('basket', 'корзину');
                    }
                }
            }
            elseif($page == 'order')
            {
                $this->template->content = $this->page->getpage('order');
                
                /*$id = $this->request->param('id');
                
                if(empty($id) and empty($_POST['orderid']))
                    $this->template->content->err = 'Не выбран товар';
                
                if(!empty($id))
                {
                    $get = $this->goods->getbyid($id);
                    
                    if(!empty($get['id']))
                        $this->template->content->order = $get;
                        
                    else
                        $this->template->content->err = 'Неверный номер товара';
                }*/
                
                if(!empty($_POST['submit']))
                {
                    if(Captcha::valid($_POST['captcha']))
                    {
                        $send = $this->goods->sendorder();
                    
                        if($send === TRUE)
                            $this->template->content->err = 'Заказ успешно отправлен!';
                        else
                            $this->template->content->err = $send;
                    }
                    else
                        $this->template->content->err = 'Неверно введена капча';
                }
            }
            elseif($page == 'editbasket')
            {
                if(!empty($_POST['del_id']))
                {
                    $this->goods->delbasket();
                    $this->template->content = $this->page->getpage('basket');
                    $this->template->content->err = 'Товар(ы) успешно удален(ы)';
                    $this->template->content->all_price = $this->goods->all_price();
                }
                elseif(!empty($_POST['basket_id']) and isset($_POST['count']) and isset($_POST['select']))
                {
                    $this->template->content = $this->page->getpage('basket');
                    $this->template->content->err = $this->goods->editbasket();
                    $this->template->content->all_price = $this->goods->all_price();
                }
            }
            elseif($page == 'clearbasket')
            {
                Session::instance()->delete('orders');
                
                $this->request->redirect('basket');
            }
            elseif(Kohana::find_file('views', $page) == FALSE)
                $this->request->redirect('');
            else
            {
                $this->template->content = $this->page->getpage($page);
                
                if($page == 'basket')
                {
                    $this->template->content->all_price = $this->goods->all_price();
                }
            }
        }
        else
        {
            $this->template->content = $this->news->getnews();
            $this->template->opt = 'news';
        }
    }
}