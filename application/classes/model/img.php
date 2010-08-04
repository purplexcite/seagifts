<?php defined('SYSPATH') or die('No direct script access.');

Class Model_Img extends Model
{   
    function index()
    {
        if(!empty($_GET['img']) and !empty($_GET['h']) and !empty($_GET['w']))
        {
            $img = Image::factory('media/images/'.$_GET['img'])->resize($_GET['w'], $_GET['h'], Image::NONE)->render('jpg', 60);

            return $img;
        }
    }
}