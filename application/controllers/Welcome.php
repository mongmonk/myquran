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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	/* tampilan buat register jne saat ini mencocokkan email */
	public function index()
	{		
		if ($tg_user = $this->getTelegramUserData()) {
			$this->session->set_userdata(['user_logged' => $tg_user['id']]);
			redirect(base_url('quran/jadwalsholatharian'));
		} else {
			$this->load->view('login_view');
		}
		
	}

	// authentication telegram, termasuk seting bila ada referal
	public function authorization()
	{
		$auth_data = $this->checkTelegramAuthorization($_GET);
		if($this->saveTelegramUserData($auth_data)){
			redirect(base_url('login'));
		}
	}

	// logout
	public function logout()
	{
		foreach ($_SESSION as $key => $value) {
		    unset($_SESSION[$key]);
		}

		redirect(base_url('login'));
	}

	// mendapatkan data dari telegram
	function getTelegramUserData() {
	  	if ($get = $this->session->userdata('tg_user')) {
		    $auth_data = json_decode($get, true);
		    return $auth_data;
	  	}
	  	return false;

	}

	// check api telegram
	function checkTelegramAuthorization($auth_data) {
		$allow_key= array('username' , 'auth_date' ,'first_name', 'last_name' ,'photo_url' ,'id');
		$check_hash = $auth_data['hash'];
		unset($auth_data['hash']);
		$data_check_arr = [];
		foreach ($auth_data as $key => $value) {
		  	if( in_array( $key , $allow_key)){
		        $data_check_arr[] = $key . '=' . $value;
		  	}
		}
		sort($data_check_arr);
		$data_check_string = implode("\n", $data_check_arr);
		$secret_key = hash('sha256', '5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU', true);
		$hash = hash_hmac('sha256', $data_check_string, $secret_key);
		if (strcmp($hash, $check_hash) !== 0) {
			throw new Exception('Data is NOT from Telegram');
		}
		if ((time() - $auth_data['auth_date']) > 86400) {
			throw new Exception('Data is outdated');
		}
		return $auth_data;
	}

	// simpan data api telegram
	function saveTelegramUserData($auth_data) {
	  	$auth_data_json = json_encode($auth_data);
	  	$this->session->set_userdata('tg_user', $auth_data_json);
	  	return $auth_data_json;
	}

	public function image($file_id)
	{
		$urltoken = "https://api.telegram.org/bot5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU/getFile?file_id={$file_id}";
		$curltoken = curl_init($urltoken);
		curl_setopt($curltoken, CURLOPT_URL, $urltoken);
		curl_setopt($curltoken, CURLOPT_POST, true);
		curl_setopt($curltoken, CURLOPT_RETURNTRANSFER, true);
		$headerstoken = array(
		   "Content-Type: application/json",
		);
		curl_setopt($curltoken, CURLOPT_HTTPHEADER, $headerstoken);
		curl_setopt($curltoken, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curltoken, CURLOPT_SSL_VERIFYPEER, false);

		$gettoken = curl_exec($curltoken);
		curl_close($curltoken);
		$tokenjson = @json_decode($gettoken);
		$getfile = $tokenjson->result->file_path;
		
		$imageContents = file_get_contents("https://api.telegram.org/file/bot5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU/{$getfile}");
		header('Content-Type: image/jpeg');
		echo $imageContents;
	}

	public function migrate()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS masjid(
			id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
			chat_id BIGINT(15),
			url VARCHAR(100) UNIQUE,
			nama_masjid VARCHAR(36),
			alamat_masjid VARCHAR(75),
			foto_masjid VARCHAR(255),
			audio_alarm VARCHAR(46),
			pesan_1 VARCHAR(150),
			pesan_2 VARCHAR(150),
			id_kota INT
		)ENGINE=MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci");
		redirect(base_url('login'));
	}
}
