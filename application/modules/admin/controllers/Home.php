<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Admin_Controller {
    

	public function index()
	{
		$this->load->model('user_model', 'users');
		$this->mViewData['count'] = array(
			'users' => $this->users->count_all(),
		);
		$this->render('home');
	}
// Grocery CRUD - Home - Homepage Categories       
        public function categories()
	{
		$crud = $this->generate_crud('homepage_categories');
                $crud->columns('id','cat_identifier','category_name','status', 'image_url','bg_color', 'added_on');
                $this->mPageTitle = 'Homepage Categories';
                $crud->set_field_upload('image_url', 'assets/uploads/homepage/categories');
                $crud->callback_column('bg_color',array($this,'renderColor'));  
                $crud->callback_add_field('path',array($this,'addCategoryPath'));
                $crud->callback_edit_field('path',array($this,'addCategoryPath'));
                $crud->callback_column('image_url',array($this,'renderCategory'));
                  	$this->mPageTitle = 'Homepage Categories';
				$this->render_crud();
				}

                function renderColor($value,$row){
                   $color_code = $row->bg_color;
             return "<div style='background-color:$color_code;width: 105px;height: 115px;'>$row->image_url</div>";
                }
                function addCategoryPath($value){
            $value = 'assets/uploads/homepage/categories/';
            $return = '<input type="text" name="path" value="'.$value.'" /> ';
            return $return;
      		  }  
            public function renderCategory($value, $row){
             $site_url = $this->config->base_url();
             
             return "<img src='$site_url$row->path$row->image_url' width=100 >";      
      		  }
        

        
        

}
