<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    var $data;
    var $id;
    var $sess_user_id;

    function __construct() {
        parent::__construct();

        //Check if any user logged in else redirect to login
        /*$is_logged_in = $this->common_lib->is_logged_in();
        if ($is_logged_in == FALSE) {
			$this->session->set_userdata('sess_post_login_redirect_url', current_url());
            if($this->data['is_admin'] === TRUE){
                redirect($this->router->directory.'admin/login');
            }else{
                redirect($this->router->directory.'user/login');
            }
        }*/

        // Get logged  in user id
        $this->sess_user_id = $this->common_lib->get_sess_user('id');

        //Render header, footer, navbar, sidebar etc common elements of templates
        $this->common_lib->init_template_elements('site');

        // Load required js files for this controller
        $javascript_files = array();
        $this->data['app_js'] = $this->common_lib->add_javascript($javascript_files);

        $this->load->model('home_model');
        $this->load->model('cms_model');
        $this->load->model('upload_model');
        $this->id = $this->uri->segment(3);
        $this->data['page_title'] = $this->router->class.' : '.$this->router->method;

        $this->data['content_type'] = array(
            'news'=>array('text'=>'News', 'css'=>'text-warning'),
            'policy'=>array('text'=>'Policy', 'css'=>'text-success'),
            'notice'=>array('text'=>'Notice', 'css'=>'text-primary')
        );
		
		// load Breadcrumbs
		$this->load->library('breadcrumbs');
		// add breadcrumbs. push() - Append crumb to stack
		$this->breadcrumbs->push('Home', '/');		
		$this->data['breadcrumbs'] = $this->breadcrumbs->show();

    }

    function index() {
        // Check user permission by permission name mapped to db
        // $this->common_lib->is_auth('cms-list-view');
		
		// Check user permission by permission name mapped to db
        // $this->common_lib->is_auth('cms-list-view');
			
		$this->breadcrumbs->push('View','/');
		$this->data['breadcrumbs'] = $this->breadcrumbs->show();

        // Display using CI Pagination: Total filtered rows - check without limit query. Refer to model method definition		
		$result_array = $this->cms_model->get_contents(NULL, NULL, NULL, FALSE, FALSE);
		$total_num_rows = $result_array['num_rows'];
		
		//pagination config
		$additional_segment = $this->router->directory.$this->router->class.'/index';
		$per_page = 15;
		$config['uri_segment'] = 4;
		$config['num_links'] = 1;
		$config['use_page_numbers'] = TRUE;
		//$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4)-1) : 0;
		$offset = ($page*$per_page);
		$this->data['pagination_link'] = $this->common_lib->render_pagination($total_num_rows, $per_page, $additional_segment);
		//end of pagination config
        

        // Data Rows - Refer to model method definition
        $result_array = $this->cms_model->get_contents(NULL, $per_page, $offset, FALSE, TRUE);
        $this->data['data_rows'] = $result_array['data_rows'];		
		
		//Carousel Slider
		$this->data['sliders'] = $this->upload_model->get_slider();
		//print_r($sliders);
		$this->data['page_title'] = 'Welcome to '.$this->config->item('app_company_product');
        $this->data['maincontent'] = $this->load->view($this->router->class.'/index', $this->data, TRUE);
        $this->load->view('_layouts/layout_home', $this->data);
    }

    function details() {
        // Check user permission by permission name mapped to db
        // $this->common_lib->is_auth('cms-list-view');
		
		// Check user permission by permission name mapped to db
        // $this->common_lib->is_auth('cms-list-view');
			
		$this->breadcrumbs->push('View','/');
		$this->data['breadcrumbs'] = $this->breadcrumbs->show();
        $id = $this->uri->segment(3);		
		$result_array = $this->cms_model->get_contents($id, NULL, NULL, FALSE, FALSE);
        $this->data['data_rows'] = $result_array['data_rows'];        
		$this->data['page_title'] = 'Welcome';
        $this->data['maincontent'] = $this->load->view($this->router->class.'/details', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function dashboard() {
        //Render header, footer, navbar, sidebar etc common elements of templates
        $this->common_lib->init_template_elements('admin');

        //Check if any user logged in else redirect to login
        $is_logged_in = $this->common_lib->is_logged_in();
        if ($is_logged_in == FALSE) {
			$this->session->set_userdata('sess_post_login_redirect_url', current_url());
            redirect($this->router->directory.'admin/login');
        }

        //Has logged in user permission to access this page or method?        
        $this->common_lib->is_auth(array(
            'default-super-admin-access',
            'default-admin-access'
        ));

		$this->breadcrumbs->push('View','/');
        $this->data['breadcrumbs'] = $this->breadcrumbs->show();
        
        // Display using CI Pagination: Total filtered rows - check without limit query. Refer to model method definition		
		$result_array = $this->cms_model->get_contents(NULL, NULL, NULL, FALSE, FALSE);
		$total_num_rows = $result_array['num_rows'];
		
		//pagination config
		$additional_segment = $this->router->directory.$this->router->class.'/index';
		$per_page = 4;
		$config['uri_segment'] = 3;
		$config['num_links'] = 1;
		$config['use_page_numbers'] = TRUE;
		//$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4)-1) : 0;
		$offset = ($page*$per_page);
		$this->data['pagination_link'] = $this->common_lib->render_pagination($total_num_rows, $per_page, $additional_segment);
        //end of pagination config
        
        // Data Rows - Refer to model method definition
        $result_array = $this->cms_model->get_contents(NULL, $per_page, $offset, FALSE, TRUE);
        $this->data['data_rows'] = $result_array['data_rows'];
		
        // Dashboard Stats
        $this->load->model('home_model');
        $this->data['user_count'] = $this->home_model->get_user_count();
        $this->data['post_count'] = $this->home_model->get_post_count();
        $this->data['order_count'] = $this->home_model->get_order_count();
        // Dashboard Stats
		
		$this->data['page_title'] = "Dashboard";
        $this->data['maincontent'] = $this->load->view($this->router->class.'/dashboard', $this->data, TRUE);
        $this->load->view('_layouts/layout_admin_default', $this->data);
    }
}
?>