<?php
defined('BASEPATH') OR exit("No direct script access allowed!");

/**
 * Alquran engine parser
 */
class Quran_model extends CI_Model
{
	protected $masjid = 'masjid';

	function __construct()
	{
		define('SITE_NAME', 'My QUR`AN');
		define('LOGGED', $this->session->userdata('user_logged'));
	}
	
	public function _Curl($url, $attempt=10)
	{
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$md5 = md5($url);
		if ($cache = $this->cache->get($md5)) {
		   return @json_decode($cache);
		}

		$ch =  curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		$result = curl_exec($ch);
		$attempt--;
		if(curl_errno($ch) && $attempt > 0 ) {
			sleep(3);
	        return $this->_Curl($url, $attempt);
	    }
	    if(!curl_errno($ch)){
	    	$this->cache->save($md5, $result, 60*60*24*365);
	    }
		
		return @json_decode($result);
	}

	public function getQuran($type='quran-uthmani')
	{
		$data = $this->_Curl("https://api.alquran.cloud/v1/quran/{$type}");
		return $data;
	}

	public function getQuranApi($surat)
	{
		$data = $this->_Curl("https://quranapi.idn.sch.id/surah/{$surat}");
		return $data;
	}

	public function getQuranStatis()
	{
		$filePath = 'inc/quran.json';
		if (file_exists($filePath)) {
			return json_decode(file_get_contents($filePath));
		}

		$usmani = $this->getQuran('quran-uthmani');
		$indonesia = $this->getQuran('id.indonesian');
		$english = $this->getQuran('en.asad');
		foreach ($usmani->data->surahs as $k => $arab) {
			$idSurat = $this->getQuranApi($arab->number);
			foreach ($arab->ayahs as $i => $ayat) {
				$data[] = ['juz' => $ayat->juz, 'surahAr' => $arab->name, 'surahEn' => $arab->englishName, 'surahNum' => $arab->number, 'ruku' => $ayat->ruku, 'sajdah' => $ayat->sajda, 'numList' => $ayat->number, 'manzil' => $ayat->manzil, 'page' => $ayat->page, 'hizbQuarter' => $ayat->hizbQuarter, 'ayat' => str_replace(" ", "", $ayat->numberInSurah), 'ar' => $idSurat->ayahs[$i]->ayahText, 'id' => $indonesia->data->surahs[$k]->ayahs[$i]->text, 'en' => $english->data->surahs[$k]->ayahs[$i]->text, 'numberOfAyahs' => $idSurat->numberOfAyahs];
			}
		}

		$json = json_encode($data);
		file_put_contents($filePath, $json);

		return json_decode($json);
	}

	public function surahListStatis()
	{
		$data = $this->getQuranStatis();
		return $this->uniqueGroup($data, 'surahNum');
	}

	public function getJuzStatis($juz)
	{
		$data = $this->getQuranStatis();
		return $this->listGroup($data, 'juz', $juz);
	}

	public function getSurah($surah)
	{
		$data = $this->getQuranStatis();
		return $this->listGroup($data, 'surahNum', $surah);
	}

	public function getRuku($ruku)
	{
		$data = $this->getQuranStatis();
		return $this->listGroup($data, 'ruku', $ruku);
	}

	public function getPage($page)
	{
		$data = $this->getQuranStatis();
		return $this->listGroup($data, 'page', $page);
	}

	public function getAllRukuStatis()
	{
		$data = $this->getQuranStatis();
		return $this->uniqueGroup($data, 'ruku');
	}

	public function getSajdah()
	{
		$data = $this->getQuranStatis();
		foreach ($data as $key => $value) {
			if (!empty($value->sajdah)) {
				$result[] = $value;
			}
		}
		return $result;
	}

	public function getAyah($number)
	{
		$data = $this->getQuranStatis();
		return $this->listGroup($data, 'numList', $number);
	}

	public function searchQuran($search)
	{
		$data = [];
		$json = $this->getQuranStatis();
		foreach($json as $key => $value) {
		    if (strpos($value->id, $search) !== false) {
		       $data[] = $value;
		    }
		}
		return $data;
	}

	public function getMeta()
	{
		$data = $this->_Curl("http://api.alquran.cloud/v1/meta");
		return $data;
	}

	public function getJuzAyah($juz)
	{
		$list = [1 => 1, 2 => 22, 3 => 42, 4 => 62, 5 => 82, 6 => 102, 7 => 121, 8 => 142, 9 => 162, 10 => 182, 11 => 201, 12 => 222, 13 => 242, 14 => 262, 15 => 282, 16 => 302, 17 => 322, 18 => 342, 19 => 362, 20 => 382, 21 => 402, 22 => 422, 23 => 442, 24 => 462, 25 => 482, 26 => 502, 27 => 522, 28 => 542, 29 => 562, 30 => 582];
		return $list[$juz];
	}

	public function getSuratAyah($ayat)
	{
		$list = [1 => 1, 2 => 2, 3 => 50, 4 => 77,  5 => 106, 6 => 128, 7 => 151, 8 => 177, 9 => 187, 10 => 208, 11 => 221, 12 => 235, 13 => 249, 14 => 255, 15 => 262, 16 => 267, 17 => 282, 18 => 293, 19 => 305, 20 => 312, 21 => 322, 22 => 332, 23 => 342, 24 => 350, 25 => 359, 26 => 367, 27 => 377, 28 => 385, 29 => 396, 30 => 404, 31 => 411, 32 => 415, 33 => 418, 34 => 428, 35 => 434, 36 => 440, 37 => 446, 38 => 453, 39 => 458, 40 => 467, 41 => 477, 42 => 483, 43 => 489, 44 => 496, 45 => 499, 46 => 502, 47 => 507, 48 => 511, 49 => 515, 50 => 518, 51 => 520, 52 => 523, 53 => 526, 54 => 528, 55 => 531, 56 => 534, 57 => 537, 58 => 542, 59 => 545, 60 => 549, 61 => 551, 62 => 553, 63 => 554, 64 => 556, 65 => 558, 66 => 560, 67 => 562, 68 => 564, 69 => 566, 70 => 568, 71 => 570, 72 => 572, 73 => 574, 74 => 575, 75 => 577, 76 => 578, 77 => 580, 78 => 582, 79 => 583, 80 => 585, 81 => 586, 82 => 587, 83 => 587, 84 => 589, 85 => 590, 86 => 591, 87 => 591, 88 => 592, 89 => 593, 90 => 594, 91 => 595, 92 => 595, 93 => 596, 94 => 596, 95 => 597, 96 => 597, 97 => 598, 98 => 598, 99 => 599, 100 => 599, 101 => 600, 102 => 600, 103 => 601, 104 => 601, 105 => 601, 106 => 602, 107 => 602, 108 => 602, 109 => 603, 110 => 603, 111 => 603, 112 => 604, 113 => 604, 114 => 604];
		return $list[$ayat];
	}

	public function tafsirSurah($surah)
	{
		$data = $this->_Curl("https://equran.id/api/tafsir/{$surah}");
		return $data;
	}

	/* HADIS FUNCTION */

	public function getHadits($book, $num=false)
	{
		$file = @file_get_contents("inc/books/{$book}.json");
		$json = @json_decode($file);
		if ($num !== false) {
			$chunk = @array_chunk($json, 25);
			return @$chunk[$num];
		}
		return count($json);
	}

	public function searchHadits($book, $search)
	{
		$book = str_ireplace(['abudaud','ibnumajah'], ['abu-daud','ibnu-majah'], $book);
		$file = @file_get_contents("inc/books/{$book}.json");
		$json = @json_decode($file);
		$data= [];
		foreach($json as $key => $value) {
		    if (strpos($value->id, $search) !== false) {
		       $data[] = $value;
		    }
		}
		return $data;
	}

	/* DOA FUNCTION */

	public function getDoa()
	{
		$file = @file_get_contents("inc/doa.json");
		$json = @json_decode($file);
		return $json;
	}

	public function getTahlil()
	{
		$file = @file_get_contents("inc/tahlil.json");
		$json = @json_decode($file);
		return $json;
	}

	/* JADWAL SHOLAT FUNCTION */

	public function getKota()
	{
		$file = @file_get_contents("inc/lokasi.json");
		$json = @json_decode($file);
		return $json;
	}

	public function getJadwal($kota, $hari=false)
	{
		$tahun = $this->input->get('tahun');
		if (!$bulan = $this->input->get('bulan')) {
			$bulan = date("m");
			$tahun = date("Y");
		}

		$data = $this->_Curl("https://api.myquran.com/v2/sholat/jadwal/{$kota}/{$tahun}/{$bulan}");
		if ($hari) {
			include APPPATH.'third_party/hijri.class.php';
			$asli = ['january', 'february', 'march', 'may', 'june', 'July', 'august', 'october', 'december', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
			$ganti = ['Januari', 'Februari', 'Maret', 'Mei', 'Juni', 'Juli', 'Agustus', 'Oktober', 'Desember', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu'];
			foreach ($data->data->jadwal as $key => $get) {				
				if ($get->date === "{$tahun}-{$bulan}-{$hari}") {					
					$hijriyah = $this->quran->numConverter((new hijri\datetime($get->date))->format('D, _j _M _Yهـ '));	
					$result['date'] = $get->date;
					$result['tanggal'] = str_ireplace($asli, $ganti, date("l, d F Y", strtotime($get->date)));
					$result['hijriyah'] = $hijriyah;
					$result['lokasi'] = ucwords(strtolower($data->data->lokasi));
					$result['daerah'] = ucwords(strtolower($data->data->daerah));
					$result['imsak'] = $get->imsak;
					$result['subuh'] = $get->subuh;
					$result['terbit'] = $get->terbit;
					$result['dhuha'] = $get->dhuha;
					$result['dzuhur'] = $get->dzuhur;
					$result['ashar'] = $get->ashar;
					$result['maghrib'] = $get->maghrib;
					$result['isya'] = $get->isya;
					return json_encode($result);
				}
			}			
		}
		
		return $data;
	}

	public function saveMasjid()
	{
		if ($post = $this->input->post()) {			
			$query = [
				'chat_id'			=> LOGGED,
				'url'				=> url_title($post['nama'].LOGGED),
				'nama_masjid'		=> strip_tags($post['nama']),
				'alamat_masjid'		=> strip_tags($post['alamat']),
				'id_kota'			=> $post['id'],
				'foto_masjid'		=> $this->_uploadFile('img', LOGGED, 'fotoMasjid'),
				'audio_alarm'		=> $post['mp3'],
				'pesan_1'			=> strip_tags($post['pesan1']),
				'pesan_2'			=> strip_tags($post['pesan2'])
			];
			$this->db->insert($this->masjid, $query);
			return true;
		}
	}

	public function editMasjid($masjid)
	{
		if ($post = $this->input->post()) {			
			$query = [
				'nama_masjid'		=> strip_tags($post['nama']),
				'alamat_masjid'		=> strip_tags($post['alamat']),
				'id_kota'			=> $post['id'],
				'audio_alarm'		=> $post['mp3'],
				'pesan_1'			=> strip_tags($post['pesan1']),
				'pesan_2'			=> strip_tags($post['pesan2'])
			];
			if ($_FILES['img']['error'] == 0) {
				$query['foto_masjid'] = $this->_uploadFile('img', LOGGED, 'fotoMasjid');
			}
			
			$this->db->update($this->masjid, $query, ['url' => $masjid]);
			return true;
		}
	}

	public function getMasjid($masjid)
	{
		return $this->db->get_where($this->masjid, ['url' => $masjid])->row();
	}

	public function getListMasjid()
	{
		return $this->db->get($this->masjid)->result();
	}

	/* TOOLS FUNCTION */

	public function numConverter($num)
	{
		$western_arabic = array('0','1','2','3','4','5','6','7','8','9');
		$eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

		$str = str_replace($western_arabic, $eastern_arabic, $num);
		return $str;
	}

	public function botDetector()
	{
		if (preg_match('/apple|baidu|bingbot|facebookexternalhit|googlebot|-google|ia_archiver|msnbot|naverbot|pingdom|seznambot|slurp|teoma|twitter|yandex|bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit|Chrome-Lighthouse|Insights|yeti/i', $_SERVER['HTTP_USER_AGENT'])) {
			return true;
		}
	}

	public function kirimTelegram($pesan,$chatid=-588738304) 
	{
	    $pesan = urlencode($pesan);
	    $API = "https://api.telegram.org/bot5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU/sendmessage?chat_id=".$chatid."&text=".$pesan."&parse_mode=html";
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	    curl_setopt($ch, CURLOPT_URL, $API);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}

	public function uniqueGroup($array, $elm)
	{
		$unique_array = [];
		foreach($array as $element) {
		    $hash = $element->$elm;
		    $unique_array[$hash] = $element;
		}
		$result = array_values($unique_array);
		return $result;
	}

	public function listGroup($array, $elm, $val)
	{
		$result = [];
		foreach ($array as $key => $value) {
			if ($value->$elm === $val) {
				$result[] = $value;
			}
		}
		return $result;
	}

	public function _uploadFile($file, $chat_id, $namefile)
    {
    	$filename = "{$namefile}_{$chat_id}";
    	if($_FILES[$file]['error'] === 0){
            $this->load->library('upload');         
            $pathImg = './inc/';
            if(!is_dir($pathImg)) mkdir($pathImg);
            $imgpath = $pathImg.$filename;
            $config['upload_path'] = $pathImg;
            $config['allowed_types'] = '*';
            $config['overwrite'] = TRUE;
            $config['file_ext_tolower'] = TRUE;
            $config['file_name'] = $filename;
            $this->upload->initialize($config);
            $_FILES['variable'] = $_FILES[$file];
            if($this->upload->do_upload('variable')){
                $data = $this->upload->data();

                $chat_id = '-588738304';
			    $bot = '5503009933:AAG-bRNvM8XDP41eX09nunqWUmt9M4HqNuU';

			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot{$bot}/sendDocument?chat_id={$chat_id}&caption={$filename}");
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_POST, 1);
			    $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $pathImg.$data['file_name']);
			    $cFile = new CURLFile($pathImg.$data['file_name'], $finfo);
			    curl_setopt($ch, CURLOPT_POSTFIELDS, [
			        "document" => $cFile
			    ]);
			    $result = json_decode(curl_exec($ch));	    
			    curl_close($ch);
			    unlink($pathImg.$data['file_name']);
			    $fileid = $result->result->document->file_id;

				return $fileid;
            }
        }
        return 'NULL';        
    }

    // check status login
    public function isNotLogin()
    {        
        return $this->session->userdata('user_logged') === null;
    }
}