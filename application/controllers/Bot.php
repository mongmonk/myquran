<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quran controller
 */
class Bot extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("quran_model", 'quran');
	}

	public function index()
	{
		$page = $this->input->get('page') ? $this->input->get('page'):1;		
		$get = $this->quran->getPage((int)$page);
		$data['data'] = $get;
		$data['meta'] = $this->quran->getAllRukuStatis();
		$data['title'] = "Hal {$page} ~ ".SITE_NAME;

		$this->load->view('bot/index', $data);
	}

	public function juz()
	{
		$juz = $this->input->get('juz') ? $this->input->get('juz'):1;
		$get = $this->quran->getJuzStatis((int)$juz);
		$data['data'] = $get;
		$data['title'] = "Juz ". $juz ." ~ ".SITE_NAME;
		$data['currentJuz'] =$juz;

		$this->load->view('bot/juz', $data);
	}

	public function surah()
	{		
		$surah = $this->input->get('surah') ? $this->input->get('surah'):1;
		$get = $this->quran->getSurah((int)$surah);
		$data['data'] = $get;
		$data['title'] = "Surah ". $get[0]->surahEn ." ~ ".SITE_NAME;
		$data['currentSurah'] =$surah;

		$this->load->view('bot/surah', $data);
	}

	public function ayah()
	{
		$number = $this->input->get('number') ? $this->input->get('number'):1;
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
			$data['prev'] = $number != 1 ? '<a href="?number='.$prev.'&audio='.$get.'" class="btn">◄ PREV</a>' : false;
			$data['next'] = $number != 6236 ? '<a href="?number='.$next.'&audio='.$get.'" class="btn">NEXT ►</a>' : false;
		} else {
			$data['prev'] = $number != 1 ? '<a href="?number='.$prev.'" class="btn">◄ PREV</a>' : false;
			$data['next'] = $number != 6236 ? '<a href="?number='.$next.'" class="btn">NEXT ►</a>' : false;
		}		

		$this->load->view('bot/ayah', $data);		
	}

	public function updatecounter()
	{
		$userid=$this->input->get('id');
		$this->db->set("counter", "`counter`+1", FALSE);
		$this->db->where('chat_id', $userid);
		$this->db->update("users");
	}

	public function tafsir()
	{
		$userid=$this->input->get('id');
		$this->db->set("tafsir", "`tafsir`+1", FALSE);
		$this->db->where('chat_id', $userid);
		$this->db->update("users");
	}

	public function persurah()
	{
		$userid=$this->input->get('id');
		$this->db->set("persurah", "`persurah`+1", FALSE);
		$this->db->where('chat_id', $userid);
		$this->db->update("users");
	}

	public function perjuz()
	{
		$userid=$this->input->get('id');
		$this->db->set("perjuz", "`perjuz`+1", FALSE);
		$this->db->where('chat_id', $userid);
		$this->db->update("users");
	}
}