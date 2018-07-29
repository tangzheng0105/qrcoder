<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id)
	{
		$this->load->model('Url_model');
		$result = $this->Url_model->getInfo($id);

		$data['pay_url'] = $result->pay_url;	
		$data['redbag_url'] = $result->redbag_url;	

		$this->load->view('welcome_message', $data);
	}

	public function input()
	{
		$this->load->view('input.html');
	}

	public function post()
	{
		$data['url1'] = $_POST['url1'];
		$data['url2'] = $_POST['url2'];
		var_dump($data);
		$this->load->model('Url_model');
		$this->Url_model->insertInfo();
		$this->load->view('success.html', $data);
	}


}
