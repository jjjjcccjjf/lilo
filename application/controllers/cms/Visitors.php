<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends Admin_core_controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('cms/cesbie_model', 'cesbie_model');
    $this->load->model('cms/visitor_model', 'visitor_model');
    $this->load->model('cms/division_model', 'division_model');
    $this->load->helper('url');
    $this->load->library("pagination");
  }

  public function index()
  {
    $this->cesbie_visitors();
  }

  public function cesbie_visitors()
  {
    $data = [];
    $data['cesbie_visitors'] = $this->visitor_model->all();
    $data['place_of_origin'] = $this->visitor_model->get_cities();

    # Pagination
    $pag_conf['base_url'] = base_url("/cms/visitors/index");
    $pag_conf['total_rows'] = $this->visitor_model->all_total();
    $pag_conf['per_page'] = $this->cesbie_model->per_rows;

    // next (>) link
    $pag_conf['next_tag_open'] = '<li>';
    $pag_conf['next_tag_close'] = '</li>';
    // prev (<) link
    $pag_conf['prev_tag_open'] = '<li>';
    $pag_conf['prev_tag_close'] = '</li>';
    // current active pagination
    $pag_conf['cur_tag_open'] = '<li class="active"><a href="#">';
    $pag_conf['cur_tag_close'] = '</a></li>';

    $pag_conf['num_tag_open'] = '<li>';
    $pag_conf['num_tag_close'] = '</li>';
    $pag_conf['reuse_query_string'] = true;
    $this->pagination->initialize($pag_conf);
    $data["pagination"] = $this->pagination->create_links();
    ### / Pagination

    $data['page_of'] = $this->visitor_model->displayPageData($pag_conf['total_rows']);
    $data['count_of'] = $this->visitor_model->displayCountingData($pag_conf['total_rows']);

    $url = '';
    $data['x_clear_stat'] = '';
    $data['x_clear_keyword'] = $this->cesbie_model->strip_param_from_url($url, 'name', base_url('cms/visitors'));
    $data['x_clear_cat'] = $this->cesbie_model->strip_param_from_url($url, 'v_type', base_url('cms/visitors'));
    $data['x_clear_origin'] = $this->cesbie_model->strip_param_from_url($url, 'origin', base_url('cms/visitors'));
    $data['x_clear_date_range'] = $this->cesbie_model->strip_param_from_url($url, 'from', base_url('cms/visitors'));
    ### SORTING BUTTONS
    $data['order'] = $this->cesbie_model->strip_param_from_url($url, 'order', base_url('cms/visitors'));
    $data['order_by'] = $this->cesbie_model->strip_param_from_url($url, 'order_by', base_url('cms/visitors'));
    ### / SORTING BUTTONS


    $this->wrapper('cms/all-visitors', $data);
  }
}