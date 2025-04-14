<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quran controller
 */
class Quran extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("quran_model", 'quran');
	}

	public function index()
	{
		$data['title'] = SITE_NAME;

		$this->load->view('amp/index', $data);
	}

	public function daftarjuz()
	{
		$data['title'] = "Daftar Juz ~ ". SITE_NAME;

		$this->load->view('amp/daftarjuz', $data);
	}

	public function daftarsurah()
	{		
		$get = $this->quran->surahListStatis();
		$data['data'] = $get;
		$data['title'] = "Daftar Surah ~ ".SITE_NAME;

		$this->load->view('amp/daftarsurah', $data);
	}

	public function daftartafsir()
	{		
		$get = $this->quran->surahListStatis();
		$data['data'] = $get;
		$data['title'] = "Daftar Tafsir ~ ".SITE_NAME;

		$this->load->view('amp/daftartafsir', $data);
	}

	public function daftarruku()
	{		
		$get = $this->quran->getAllRukuStatis();
		$data['data'] = $get;
		$data['title'] = "Daftar Ruku` ~ ".SITE_NAME;

		$this->load->view('amp/daftarruku', $data);
	}

	public function daftarayat()
	{		
		$get = $this->quran->getQuran();
		$data['data'] = $get->data->surahs;
		$data['title'] = "Daftar Ayat` ~ ".SITE_NAME;

		$this->load->view('amp/daftarayat', $data);
	}

	public function daftarsajdah()
	{		
		$get = $this->quran->getSajdah();
		$data['data'] = $get;
		$data['title'] = "Daftar Ayat Sajdah ~ ".SITE_NAME;

		$this->load->view('amp/daftarsajdah', $data);
	}

	public function juz($juz)
	{
		$get = $this->quran->getJuzStatis((int)$juz);
		$data['data'] = $get;
		$data['title'] = "Juz ". $juz ." ~ ".SITE_NAME;

		$this->load->view('juz', $data);
	}

	public function surah($surah)
	{		
		$get = $this->quran->getSurah((int)$surah);
		$data['data'] = $get;
		$data['title'] = "Surah ". $get[0]->surahEn ." ~ ".SITE_NAME;

		$this->load->view('surah', $data);
	}

	public function ruku($ruku)
	{		
		$get = $this->quran->getRuku((int)$ruku);
		$data['data'] = $get;
		$data['meta'] = $this->quran->getAllRukuStatis();
		$data['title'] = "Ruku` ke {$ruku} Surah {$get[0]->surahEn} ~ ".SITE_NAME;

		$this->load->view('ruku', $data);
	}

	public function page($page=1)
	{		
		$get = $this->quran->getPage((int)$page);
		$data['data'] = $get;
		$data['meta'] = $this->quran->getAllRukuStatis();
		$data['title'] = "Hal {$page} ~ ".SITE_NAME;

		$this->load->view('page', $data);
	}

	public function ayah($number)
	{
		$get = $this->quran->getAyah((int)$number);
		$surah = $get[0]->surahNum;
		$ayah = $get[0]->ayat;
		$data['data'] = $get;
		$namasurah = $get[0]->surahEn;
		$data['title'] = "Surat {$namasurah} Ayat {$ayah} ~ ".SITE_NAME;
		$data['surah'] = $surah;
		$data['ayah'] = $ayah;
		$data['tafsir'] = $this->quran->tafsirSurah($surah)->tafsir[$ayah-1];
		$prev = $number-1;
		$next = $number+1;
		if ($get=$this->input->get('audio')) {
			$data['prev'] = $number != 1 ? '<a href="/ayah/'.$prev.'?audio='.$get.'" class="btn">◄ PREV</a>' : false;
			$data['next'] = $number != 6236 ? '<a href="/ayah/'.$next.'?audio='.$get.'" class="btn">NEXT ►</a>' : false;
		} else {
			$data['prev'] = $number != 1 ? '<a href="/ayah/'.$prev.'" class="btn">◄ PREV</a>' : false;
			$data['next'] = $number != 6236 ? '<a href="/ayah/'.$next.'" class="btn">NEXT ►</a>' : false;
		}		

		$this->load->view('amp/ayah', $data);		
	}

	public function tafsir($surah)
	{		
		$get = $this->quran->tafsirSurah($surah);
		$data['data'] = $get;
		$data['title'] = "Tafsir Surah ". $get->nama_latin ." ~ ".SITE_NAME;

		$this->load->view('amp/tafsir', $data);
	}

	public function jadwalsholat()
	{		
		$kota = $this->input->get('id') ? $this->input->get('id'):1603;
		$data['data'] = $this->quran->getJadwal($kota);
		$data['kota'] = $this->quran->getKota();
		$data['title'] = "Jadwal Sholat ~ ".SITE_NAME;
		$tgl = $data['data']->data->jadwal[0]->date;
		$data['bulanprev'] = date('m', strtotime('-1 month', strtotime($tgl)));
		$data['tahunprev'] = date('Y', strtotime('-1 month', strtotime($tgl)));
		$data['bulannext'] = date('m', strtotime('+1 month', strtotime($tgl)));
		$data['tahunnext'] = date('Y', strtotime('+1 month', strtotime($tgl)));
		$asli = ['january', 'february', 'march', 'may', 'june', 'July', 'august', 'october', 'december'];
		$ganti = ['Januari', 'Februari', 'Maret', 'Mei', 'Juni', 'Juli', 'Agustus', 'Oktober', 'Desember'];
		$data['bulan'] = str_ireplace($asli, $ganti, date("F Y", strtotime($tgl)));

		$this->load->view('jadwalsholat', $data);
	}

	public function jadwalsholatharian($masjid=false)
	{		
		if ($masjid) {
			$dataMasjid = $this->quran->getMasjid($masjid);
			$nama = $dataMasjid ? $dataMasjid->nama_masjid : "Masjid Shodiqul Akbar";
			$data['chat_id'] = $dataMasjid ? $dataMasjid->chat_id : 'default';
			$data['url'] = $dataMasjid ? $dataMasjid->url : false;
			$data['alamat'] = $dataMasjid ? $dataMasjid->alamat_masjid : "Dsn. Bakulan Ds. Bendosewu Kec. Talun Kab. Blitar";
			$data['img'] = $dataMasjid ? $dataMasjid->foto_masjid : 'BQACAgUAAxkDAAMGYzBna6t7xL3IA3ZGSLk2yg8PvNoAAkIJAAI8w4BVpzRz_Hlh4bcpBA';
			$data['adzan'] = $dataMasjid ? $dataMasjid->audio_alarm : base_url('inc/adzan/adzan1.mp3');
			$data['pesan1'] = $dataMasjid ? $dataMasjid->pesan_1 : "Informasi infaq bulan ".date("F Y").", sebesar Rp 1.855.000,- Semoga kita senantiasa dilancarkan dalam segala urusan sehari-hari. Aamiin";
			$data['pesan2'] = $dataMasjid ? $dataMasjid->pesan_2 : "Waktu khutbah selain Khatib DILARANG BICARA! Luruskan shaf dan rapatkan barisan!";
			$data['id'] = $dataMasjid ? $dataMasjid->id_kota : 1603;
			$data['nama'] = $nama;
			$data['title'] = "Jadwal Sholat {$nama} ~ ".SITE_NAME;		

			$this->load->view('jadwalsholatharian_view', $data);
		} else {

			if($this->quran->isNotLogin()) redirect(base_url('login'));

			$data['title'] = "Input Jadwal Sholat Masjid Baru";
			$data['kota'] = $this->quran->getKota();
			$data['masjid'] = $this->quran->getListMasjid();
			if ($save = $this->quran->saveMasjid()) {
				redirect(base_url("quran/jadwalsholatharian"));
			}

			$this->load->view('savemasjid', $data);
		}
		
	}

	public function editjadwal($masjid)
	{
		if($this->quran->isNotLogin()) redirect(base_url('login'));

		$dataMasjid = $this->quran->getMasjid($masjid);
		if (!$dataMasjid || $dataMasjid->chat_id != LOGGED) {
			die("Maaf!!! Hanya pembuat yang bisa edit");
		}
		$nama = $dataMasjid->nama_masjid;
		$data['alamat'] = $dataMasjid->alamat_masjid;
		$data['img'] = $dataMasjid->foto_masjid;
		$data['adzan'] = $dataMasjid->audio_alarm;
		$data['pesan1'] = $dataMasjid->pesan_1;
		$data['pesan2'] = $dataMasjid->pesan_2;
		$data['id'] = $dataMasjid->id_kota;
		$data['nama'] = $nama;
		$data['title'] = "Edit Jadwal Sholat {$nama} ~ ".SITE_NAME;
		$data['masjid'] = $this->quran->getListMasjid();
		$data['kota'] = $this->quran->getKota();

		if ($this->quran->editMasjid($masjid)) {
			redirect(base_url("jadwal/{$masjid}"));
		}

		$this->load->view('editjadwal', $data);
	}

	public function tahlil()
	{
		$data['title'] = "Do`a Tahlil ~ ". SITE_NAME;
		$data['data'] = $this->quran->getTahlil();

		$this->load->view('amp/tahlil', $data);
	}

	public function about()
	{
		$data['title'] = "Tentang ". SITE_NAME;
		$this->load->view('about', $data);
	}

	public function privacy()
	{
		$data['title'] = "Tentang ". SITE_NAME;
		$this->load->view('privacy', $data);
	}

	public function partnerapi()
	{
		$data['title'] = "API Partner ". SITE_NAME;
		$this->load->view('partnerapi', $data);
	}

	public function contact()
	{
		$data['title'] = "Hubungi ". SITE_NAME;
		$data['pesan'] = false;
		if ($post = $this->input->post()) {
			$nama = $post['nama'];
			$email = $post['email'];
			$wa = $post['wa'];
			$pesan = $post['pesan'];
			$site = SITE_NAME;
			$text = "<b>PESAN BARU DARI {$site}</b>\n\nNAMA: {$nama}\nEMAIL: {$email}\nNO.WA: {$wa}\nPESAN: {$pesan}";
			$this->quran->kirimTelegram($text);
			$data['pesan'] = "<div class='alert alert-success'>Terimakasih sudah menghubungi kami.<br>Pesan berhasil terkirim ke admin {$site}. Insyaallah secepatnya akan kami kabari lewat WhatsApp</div>";
		}

		$this->load->view('contact', $data);
	}

	public function search()
    {        
        $query = $this->input->get('query');
        $data['data'] = $this->quran->searchQuran($query);
        $data['title'] = "Mencari Ayat Tentang `{$query}` ~ ". SITE_NAME;

        $this->load->view('amp/daftarsajdah', $data);
    }

	public function doa()
    {      
        $data['data'] = $this->quran->getDoa();
        $data['title'] = "Do`a Harian ~ ". SITE_NAME;

        $this->load->view('amp/doa', $data);
    }

	public function masjid($masjidid=false)
	{
		$id = $masjidid ? $masjidid : 1603;
		echo $this->quran->getJadwal($id, date('d'));
	}

	public function meta()
	{
		$get = $this->quran->getMeta();
		// $get = $this->quran->getQuranApi(1);
		echo "<pre>";
		print_r($get);
	}
}