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
        $is_logged_in = $this->common_lib->is_logged_in();
        if ($is_logged_in == FALSE) {
            redirect('admin/user/login');
        }

        //Has logged in user permission to access this page or method?        
        $this->common_lib->check_user_role_permission(array(
            'default-super-admin-access',
            'default-admin-access'
        ));

        // Get logged  in user id
        $this->sess_user_id = $this->common_lib->get_sess_user('id');

        //Render header, footer, navbar, sidebar etc common elements of templates
        $this->common_lib->init_template_elements('admin');

        //add required js files for this controller
        $app_js_src = array('assets/data/morris-data.js');
        $this->data['app_js'] = $this->common_lib->add_javascript($app_js_src);

        $this->load->model('home_model');
        $this->data['alert_message'] = NULL;
        $this->data['alert_message_css'] = NULL;
        $this->id = $this->uri->segment(4);

        //View Page Config
        $this->data['page_heading'] = $this->router->class.' : '.$this->router->method;
        $this->data['datatable']['dt_id']= array('heading'=>'Data Table','cols'=>array());
		
		// load Breadcrumbs
		$this->load->library('breadcrumbs');
		// add breadcrumbs. push() - Append crumb to stack
		$this->breadcrumbs->push('Dashboard', '/admin');		
		$this->data['breadcrumbs'] = $this->breadcrumbs->show();

    }

    function index() {
        // Check user permission by permission name mapped to db
        // $is_granted = $this->common_lib->check_user_role_permission('cms-list-view');

        $this->data['alert_message'] = $this->session->flashdata('flash_message');
        $this->data['alert_message_css'] = $this->session->flashdata('flash_message_css');
		$this->data['page_heading'] = 'Dashboard';
        $this->data['maincontent'] = $this->load->view('admin/home/index', $this->data, true);
        $this->load->view('admin/_layouts/layout_authenticated', $this->data);
    }

}

?>
