<?php
class ControllerApiLogin extends Controller {
	public function index() {
		$this->load->language('api/login');

		$json = array();

		$this->load->model('account/api');        

		$rawData = file_get_contents("php://input");    

		$inputData = json_decode($rawData, true);

		$username = $this->request->post['username'] ?? $inputData['username'] ?? false;
		$key = $this->request->post['key'] ?? $inputData['key'] ?? false;

        if($username !== false && $key !== false){
			// Login with API Key
			$api_info = $this->model_account_api->login($username, $key);

			if ($api_info) {
				// Check if IP is allowed
				$ip_data = array();
		
				$results = $this->model_account_api->getApiIps($api_info['api_id']);
		
				foreach ($results as $result) {
					$ip_data[] = trim($result['ip']);
				}
		
				if (!in_array('*', $ip_data) && !in_array($this->request->server['REMOTE_ADDR'], $ip_data)) {
					$json['error']['ip'] = sprintf($this->language->get('error_ip'), $this->request->server['REMOTE_ADDR']);
				}				
					
				if (!$json) {
					$json['success'] = $this->language->get('text_success');
					
					$session = new Session($this->config->get('session_engine'), $this->registry);
					$session->start();
					
					$this->model_account_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);
					
					$session->data['api_id'] = $api_info['api_id'];
					
					// Create Token
					$json['api_token'] = $session->getId();
				} else {
					$json['error']['key'] = $this->language->get('error_key');
				}
			}
        } else {
			$json['error']['username'] = 'Wrong username';
			$json['error']['key'] = 'Wrong key';
        }

		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
