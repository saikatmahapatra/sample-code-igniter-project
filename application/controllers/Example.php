<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Example extends CI_Controller {

    var $data;

    function __construct() {
        parent::__construct();
        //Loggedin user details
        $this->sess_user_id = $this->common_lib->get_sess_user('id');
        
        //Render header, footer, navbar, sidebar etc common elements of templates
        $this->common_lib->init_template_elements('site');
        
        // Load required js files for this controller
        $javascript_files = array(
            $this->router->class
        );
        $this->data['app_js'] = $this->common_lib->add_javascript($javascript_files);
		
		// Status flag indicator for showing in table grid etc
		$this->data['status_flag'] = array(
            'Y'=>array('text'=>'Active', 'css'=>'text-success', 'icon'=>'<i class="fa fa-fw fa-bookmark-o text-success" aria-hidden="TRUE"></i>'),
            'N'=>array('text'=>'Inactive', 'css'=>'text-warning', 'icon'=>'<i class="fa fa-fw fa-bookmark-o text-warning" aria-hidden="TRUE"></i>'),
            'A'=>array('text'=>'Archived', 'css'=>'text-danger', 'icon'=>'<i class="fa fa-fw fa-bookmark-o text-danger" aria-hidden="TRUE"></i>')
        );
        
        
        
		$this->data['page_title'] = $this->router->class.' : '.$this->router->method;
        
    }

    function index() {
		$this->bootstrap();
        //$this->data['maincontent'] = $this->load->view($this->router->class.'/index', $this->data, TRUE);
        //$this->load->view('_layouts/layout_default', $this->data);
    }

    function form_helper() {
        $this->data['job_role_arr'] = array(
            '' => '-Select-',
            '1' => 'Software Enginner',
            '2' => 'Consultant',
        );

        $this->data['domain_arr'] = array(
            '' => '-Select-',
            'IT Software' => array('1' => 'Software Engineering',
                '2' => 'Software Development',
                '3' => 'Web,UI,UX Development',
                '4' => 'Product Quality Analysis',
                '5' => 'Operation Management',
                '6' => 'SDLC/Process Management',
            ),
            'IT Telecom Networking' => array('1' => 'Telecom Architect',
                '2' => 'Telecom Infrastructure Support',
                '3' => 'Core Telecom',
                '4' => 'Pack Core',
                '5' => 'Network Engineering',
            ),
            'ITES/BPO' => array('1' => 'BPO',
                '2' => 'Out Sourcing',
                '3' => 'Tele Calling',
            ),
        );

        if ($this->input->post('form_action') == 'add') {            
            if ($this->validate_form() == TRUE) {
                print_r($this->input->post());
                $this->common_lib->set_flash_message('<strong>Ok! </strong>Validated and Ready to Insert Data.', 'alert-info');
                redirect(current_url());
            }
        }
        $this->data['page_title'] = 'CI Form Syntax';
        $this->data['maincontent'] = $this->load->view($this->router->class.'/form_helper', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function validate_form() {
        $this->form_validation->set_rules('user_email', 'email', 'trim|required|valid_email');        
        $this->form_validation->set_rules('user_password', 'password', 'required|trim|min_length[6]|max_length[16]');
        $this->form_validation->set_rules('user_password_confirm', 'confirm password', 'required|matches[user_password]');
        $this->form_validation->set_rules('address', 'address', 'required');
        //$this->form_validation->set_rules('gender', 'gender', 'required');
        $this->form_validation->set_rules('job_role', 'job role selection', 'required');
        $this->form_validation->set_rules('functional_domain', 'functional domain', 'required');        
        //$this->form_validation->set_rules('userfile', 'resume upload', 'trim|required');
        $this->form_validation->set_rules('terms', 'terms & condition acceptance', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="validation-error">', '</div>');
        if ($this->form_validation->run() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_max_function_domain($functional_domain, $size) {
        //echo $size;die();
        //$this->form_validation->set_message('validate_max_function_domain', 'You can choose maximum 3 options');
        //return FALSE;
    }
    
    function download_as_pdf(){
       $this->load->view($this->router->class.'/dom_pdf_gen_pdf'); 
    }
            
    function dom_pdf_gen_pdf() {
        // Load all views as normal
        $this->load->view($this->router->class.'/dom_pdf_gen_pdf');
        // Get output html
        $html = $this->output->get_output();
        // Load library
        $this->load->library('dompdf_gen');
        // Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("mypdf_" . time() . ".pdf");
    }

    function date_helper() {
        $this->load->helper('date');

        $this->data['maincontent'] = $this->load->view($this->router->class.'/date_helper', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function directory_helper() {
        $this->load->helper('directory');
        $map = directory_map('./application/controllers', FALSE, TRUE);
        $this->data['read_dir'] = $map;

        $map = directory_map('./application/controllers', 1);
        $this->data['sub_folders'] = $map;

        $this->data['maincontent'] = $this->load->view($this->router->class.'/directory_helper', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function bootstrap() {
        $this->data['page_title'] = 'Bootstrap Style Guide';
        $this->data['maincontent'] = $this->load->view($this->router->class.'/bootstrap', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }
	
	function calendar_lib() {
		$year = $this->uri->segment(3) ? $this->uri->segment(3) : date('Y');
		$month = $this->uri->segment(4) ? $this->uri->segment(4) : date('m');
		$day = date('d');
		$template='';
		$template.='{table_open}<table class="table ci-calendar table-sm" border="0" cellpadding="" cellspacing="">{/table_open}';
		$template.='{heading_row_start}<tr class="mn">{/heading_row_start}';
		$template.='{heading_previous_cell}<th class="prevcell"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}';
		$template.='{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}';
		$template.='{heading_next_cell}<th class="nextcell"><a href="{next_url}" >&gt;&gt;</a></th>{/heading_next_cell}';
		$template.='{heading_row_end}</tr>{/heading_row_end}';
		$template.='{week_row_start}<tr class="wk_nm">{/week_row_start}';
		$template.='{week_day_cell}<td>{week_day}</td>{/week_day_cell}';
		$template.='{week_row_end}</tr>{/week_row_end}';
		$css_days_rows = ($month != date('m'))? 'disabled_m': 'allowed_m';
		$template.='{cal_row_start}<tr class="'.$css_days_rows.'">{/cal_row_start}';
		$template.='{cal_cell_start}<td class="day">{/cal_cell_start}';
		$template.='{cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}';
		$template.='{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}';
		$template.='{cal_cell_no_content}{day}{/cal_cell_no_content}';
		$template.='{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}';
		$template.='{cal_cell_blank}&nbsp;{/cal_cell_blank}';
		$template.='{cal_cell_end}</td>{/cal_cell_end}';
		$template.='{cal_row_end}</tr>{/cal_row_end}';
		$template.='{table_close}</table>{/table_close}';
		
		$prefs = array (
               'start_day'    => 'monday',
               'month_type'   => 'short',
               'day_type'     => 'short',
			   'show_next_prev'=>TRUE,			   
			   'template'	  =>  $template
             );
		$this->load->library('calendar',$prefs);
		
		$year = $this->uri->segment(3) ? $this->uri->segment(3) : date('Y');
		$month = $this->uri->segment(4) ? $this->uri->segment(4) : date('m');
		$day = date('d');		
		$this->data['entry_for'] = date('Y/m/d');
		$data = array();
		$this->data['cal'] = $this->calendar->generate($year,$month,$data);
		$this->data['page_title'] = 'Calendar';
        

        //Simulate Form Submit
        if ($this->input->post('form_action') == 'add') {
            if ($this->validate_form_calander_data('add') == TRUE) {
                $this->common_lib->set_flash_message('Validation Successful.', 'alert-success');
                redirect(current_url());
            }
        }

        $this->data['maincontent'] = $this->load->view($this->router->class.'/calendar_lib', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function validate_form_calander_data($action = NULL) {
        $this->form_validation->set_rules('selected_date', 'calendar date selection', 'required');
        $this->form_validation->set_error_delimiters('<div class="validation-error">', '</div>');
        if ($this->form_validation->run() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function contact_form() {
        if ($this->input->post('form_action') == 'send') {
            if ($this->validate_contact_form() == TRUE) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone_number = $this->input->post('phone_number');
                $message = $this->input->post('message');
                $from_name = $name;
                $from_email = $email;
                $html = '';
                $html.='<table align="center" width="100%" border="0" cellpadding="3" cellspacing="0">';
                $html.='<tr bgcolor="#EBEBEB">';
                $html.='<td valign="top" align="left" width="20%"><b>Name</b></td>';
                $html.='<td valign="top" width="2%" style="font-weight:bold;">:</td>';
                $html.='<td valign="top" width="78%">' . $name . '</td>';
                $html.='</tr>';
                $html.='<tr bgcolor="#F5F5F5">';
                $html.='<td valign="top" align="left"><b>Email</b></td>';
                $html.='<td valign="top" style="font-weight:bold;">:</td>';
                $html.='<td valign="top">' . $email . '</td>';
                $html.='</tr>';
                $html.='<tr bgcolor="#EBEBEB">';
                $html.='<td valign="top" align="left"><b>Phone Number</b></td>';
                $html.='<td valign="top" style="font-weight:bold;">:</td>';
                $html.='<td valign="top">' . $phone_number . '</td>';
                $html.='</tr>';
                $html.='<tr bgcolor="#F5F5F5">';
                $html.='<td valign="top" align="left"><b>Message</b></td>';
                $html.='<td valign="top" style="font-weight:bold;">:</td>';
                $html.='<td valign="top">' . $message . '</td>';
                $html.='</tr>';
                $html.='</table>';

                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->to($this->config->item('app_admin_email'));
                $this->email->from($from_email, $from_name);
                $this->email->subject($this->config->item('app_email_subject_prefix') . ' Contact Us Email');
                $this->email->message($html);
                $result = $this->email->send();
                //echo $this->email->print_debugger(); die($html);
                if ($result == TRUE) {
                    $this->common_lib->set_flash_message('Your message has been sent successfully.', 'alert-success');
                    redirect(current_url());
                } else {
                    $this->common_lib->set_flash_message('Error occured while sending your message.', 'alert-danger');
                    redirect(current_url());
                }
            } else {
                $data['error_message'] = validation_errors();
            }
        }
        //Create Captcha
        $this->load->helper('captcha');
        $data = array(
            //'word'          => 'Random word',
            'img_path'      => './assets/captcha/images/',
            'img_url'       => base_url('assets/captcha/images/'),
            'font_path'     => './assets/captcha/fonts/arialbd.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 90,
            'word_length'   => 6,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors' => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(192,192,192)
            )
        );

        $cap = create_captcha($data);
        $this->data['captcha_word'] = $cap['word'];
        $this->data['captcha_image'] = $cap['image'];
		
		$this->data['page_title'] = 'Contact Us';
        $this->data['maincontent'] = $this->load->view($this->router->class.'/contact_form', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

    function validate_contact_form() {
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone_number', 'mobile number', 'trim|is_natural|numeric|max_length[10]');
        $this->form_validation->set_rules('message', 'message', 'required');
        $this->form_validation->set_rules('captcha', 'captcha verification', 'required|trim|callback_validate_captcha');
        $this->form_validation->set_error_delimiters('<div class="validation-error">', '</div>');
        if ($this->form_validation->run() == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_captcha($str) {
        if ($str != $this->input->post('captcha_word')) {
            $this->form_validation->set_message('validate_captcha', 'Invalid CAPTCHA.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    
    function test_cron_job() {
        $this->data['maincontent'] = $this->load->view($this->router->class.'/test_cron_job', $this->data, TRUE);
        $this->load->view('_layouts/layout_default', $this->data);
    }

	function send_mail_cron_job(){
        /**
         * Command in cPanel
         * /usr/local/bin/php /home/xxxx/public_html/webportal/index.php example send_mail_cron_job
         */

        $from_name = 'Web Tester';
        $from_email = 'webuidevs@gmail.com';
        $html = 'Hello, Im testing croj job. Ok Google.';
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->to('webuidevs@gmail.com');
        $this->email->from($from_email, $from_name);
        $this->email->subject('Cron Job Test');
        $this->email->message($html);
        $result = $this->email->send();
        if($result === TRUE){
            echo "message sent";
        }else{
            echo "unable to send message";
        }
    }

}

?>
