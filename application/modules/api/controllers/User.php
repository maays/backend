<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Demo Controller with Swagger annotations
 * Reference: https://github.com/zircote/swagger-php/
 */

/**
 * [IMPORTANT] 
 * 	To allow API access without API Key ("X-API-KEY" from HTTP Header), 
 * 	remember to add routes from /application/modules/api/config/rest.php like this:
 * 		$config['auth_override_class_method']['dummy']['*'] = 'none';
 */
class User extends API_Controller {

	/**
	 * @SWG\Post(
	 * 	path="/user/create",
	 * 	tags={"user"},
	 * 	summary="Create User",
	 * @SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="User info",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/UserSignUp")
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Create User",
	 * 	)
	 * )
	 */
	public function create_post()
	{		
			$this->load->model('User_model');
			$data = elements(array('username','email','password','first_name','last_name','phone'), $this->post());
			// passed validation
			$username = $data['username'];
			$email = $data['email'];
			$password = $data['password'];
			$identity = empty($username) ? $email : $username;
			$additional_data = array(
				'first_name'	=> $data['first_name'],
				'last_name'		=> $data['last_name'],
				'phone'			=> $data['phone'],
			);
			$check_user = $this->User_model->checkUser($data);
			if($check_user == 'user_exists'){
				$result['status'] = "false";
				$result['message'] = "user already exist";
				$this->response($result);
			}
			else{
			$result['status'] = "true";
			$result['message'] = "account created successfully";
			$user_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups = array());
			$this->response($result);
			}
						
			
	}

	/**
	 * @SWG\Post(
	 * 	path="/user/login",
	 * 	tags={"user"},
	 * 	summary="Login User",
	 * @SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="User Credentials",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/UserLogin")
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Login User",
	 * 	)
	 * )
	 */
	public function login_post(){

		//$this->load->model('User_model');
		$data = elements(array('username','email','phone','password'), $this->post());
		if($data['username']!=''){
			$identity = $data['username']; 
		}
		if($data['email']!=''){
			$identity = $data['email']; 
		}
		if($data['phone']!=''){
			$identity = $data['phone']; 
		}
		
		$password = $data['password'];	
			if ($this->ion_auth->login($identity, $password, $remember=FALSE))
			{
				// login succeed
				$messages = $this->ion_auth->messages();
			}
			else
			{
				// login failed
				$messages = $this->ion_auth->errors();
			}
			$this->response($messages);

	}

	
}