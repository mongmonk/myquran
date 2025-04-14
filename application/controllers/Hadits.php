<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Quran controller
 */
class Hadits extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model("quran_model", 'quran');
		$this->load->library('pagination');
	}

	public function bukhari()
	{
		$config['base_url'] = base_url('hadits/bukhari');
        $config['total_rows'] = $this->quran->getHadits('bukhari');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('bukhari', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Bukhari Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Bukhari";

		$this->load->view('amp/hadits', $data);
	}

	public function muslim()
	{
		$config['base_url'] = base_url('hadits/muslim');
        $config['total_rows'] = $this->quran->getHadits('muslim');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('muslim', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Muslim Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Muslim";

		$this->load->view('amp/hadits', $data);
	}

	public function abudaud()
	{
		$config['base_url'] = base_url('hadits/abudaud');
        $config['total_rows'] = $this->quran->getHadits('abu-daud');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('abu-daud', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Abu Daud Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Abu Daud";

		$this->load->view('amp/hadits', $data);
	}

	public function ahmad()
	{
		$config['base_url'] = base_url('hadits/ahmad');
        $config['total_rows'] = $this->quran->getHadits('ahmad');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('ahmad', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Ahmad Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Ahmad";

		$this->load->view('amp/hadits', $data);
	}

	public function darimi()
	{
		$config['base_url'] = base_url('hadits/darimi');
        $config['total_rows'] = $this->quran->getHadits('darimi');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('darimi', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Darimi Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Darimi";

		$this->load->view('amp/hadits', $data);
	}

	public function ibnumajah()
	{
		$config['base_url'] = base_url('hadits/ibnumajah');
        $config['total_rows'] = $this->quran->getHadits('ibnu-majah');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('ibnu-majah', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Ibnu Majah Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Ibnu Majah";

		$this->load->view('amp/hadits', $data);
	}

	public function malik()
	{
		$config['base_url'] = base_url('hadits/malik');
        $config['total_rows'] = $this->quran->getHadits('malik');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('malik', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Malik Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Malik";

		$this->load->view('amp/hadits', $data);
	}

	public function nasai()
	{
		$config['base_url'] = base_url('hadits/nasai');
        $config['total_rows'] = $this->quran->getHadits('nasai');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('nasai', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Nasa`i Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Nasa`i";

		$this->load->view('amp/hadits', $data);
	}

	public function tirmidzi()
	{
		$config['base_url'] = base_url('hadits/tirmidzi');
        $config['total_rows'] = $this->quran->getHadits('tirmidzi');
        $config['per_page'] = 1;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'NEXT &raquo;';
        $config['prev_link']        = '&laquo; PREV';
        $config['full_tag_open']    = '<nav aria-label="Page navigation" class="my3">';
        $config['full_tag_close']   = '</nav><div class="dash"></div>';
        $config['next_tag_open']    = '<span class="mx2 btn">';
        $config['next_tagl_close']  = '</span>';
        $config['prev_tag_open']    = '<span class="mx2 btn">';
        $config['prev_tagl_close']  = '</span>';
        $config['display_pages']	= FALSE;
 
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['pagination'] = $this->pagination->create_links();
		$data['data'] = $this->quran->getHadits('tirmidzi', $data['page']);
        $halaman = $data['page']+1;
		$data['title'] = "Hadits Riwayat Imam Tirmidzi Hal. {$halaman} ~ ". SITE_NAME;
		$data['perowi'] = "Imam Tirmidzi";

		$this->load->view('amp/hadits', $data);
	}

    public function search($book)
    {        
        $query = $this->input->get('query');
        $perawi = ucwords(str_replace('-', ' ', $book));
        $data['data'] = $this->quran->searchHadits($book, $query);
        $data['title'] = "Hadits Riwayat {$perawi} Tentang `{$query}` ~ ". SITE_NAME;
        $data['perowi'] = "Imam {$perawi}";
        $data['pagination'] = false;

        $this->load->view('amp/hadits', $data);
    }
}