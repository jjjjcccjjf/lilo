<?php

class Guest_model extends Crud_model
{   
    public function __construct()
    {
        parent::__construct();
        $this->table = 'guest_visitors';
        $this->staffs = 'staffs';
        $this->division = 'division';
        $this->feedbacks = 'feedbacks';
        $this->per_rows = 5;
    }
    public function all()
  	{
  		$where = ' WHERE 1=1 ';
	    if (isset($_GET['name']) && $_GET['name'] != ''):
	      $where .= "AND {$this->table}.fullname LIKE '%{$_GET['name']}%' ";
	    endif;
	    if (isset($_GET['cat']) && $_GET['cat'] != ''):
	      $where .= "AND {$this->table}.division_to_visit = '{$_GET['cat']}' ";
	    endif;

	    if (isset($_GET['origin']) && $_GET['origin'] != ''):
	    	$where .= "AND {$this->table}.place_of_origin = '{$_GET['origin']}' ";
	    endif;

	    if ((isset($_GET['from']) && $_GET['from'] != '') || (isset($_GET['to']) && $_GET['to'] != '')):
	       	if((isset($_GET['from']) && $_GET['from'] != '') && (!isset($_GET['to']) || $_GET['to'] == '' )): #from only
	       		$from = $_GET['from'] .' 00:00:00';
		    	$to = $_GET['from'] .' 23:59:59';
		    	$where .= "AND {$this->table}.created_at >= '{$from}' AND {$this->table}.created_at <= '{$to}'";
	    	elseif((isset($_GET['to']) && $_GET['to'] != '') && (!isset($_GET['from']) || $_GET['from'] == '' )): #to only
	    		$from = $_GET['to'] .' 00:00:00';
		    	$to = $_GET['to'] .' 23:59:59';
		    	$where .= "AND {$this->table}.created_at >= '{$from}' AND {$this->table}.created_at <= '{$to}'";
	    	else: #from and to
		    	if ($_GET['from'] <= $_GET['to']) {
			    	$from = $_GET['from'] .' 00:00:00';
			    	$to = $_GET['to'] .' 23:59:59';
		    	}else{
		    		$from = $_GET['to'] .' 00:00:00';
		    		$to = $_GET['from'] .' 23:59:59';
		    	}
		    	$where .= "AND {$this->table}.created_at >= '{$from}' AND {$this->table}.created_at <= '{$to}'";
	    	endif;
	    endif;

	    $order_str = '';

	    $order_by = "{$this->table}.created_at";
	    if (isset($_GET['order_by']) && $_GET['order_by']):
	      switch ($_GET['order_by']) {
	        case 'name':
	          $order_by = "{$this->staffs}.fullname";
	          break;
	        case 'date_reg':
	        default:
	          $order_by = "{$this->table}.created_at";
	          break;
	          break;
	      }
	    endif;

	    $order = 'DESC';
	    if (isset($_GET['order']) && $_GET['order']):
	      if ($_GET['order'] == 'asc'):
	        $order = 'ASC';
	      endif;
	    endif;

	    $order_str = "ORDER BY {$order_by} {$order}";

	    $limit_str = '';

	    $limit = 0;
	    if($this->uri->segment(5) !== NULL){
	      $limit = $this->uri->segment(5);
	    }
	    $limit_str = "LIMIT {$this->per_rows} OFFSET {$limit}";	
    	return $this->db->query("
      		SELECT {$this->table}.*, 
            	DATE_FORMAT({$this->table}.created_at, '%M %d, %Y <br>%l:%i:%S %p') as f_created_at,
            	{$this->staffs}.fullname as person_fullname_visited,
            	{$this->division}.name as division_name_visited,
            	CASE
				    WHEN {$this->feedbacks}.created_at != '' THEN DATE_FORMAT({$this->feedbacks}.created_at, '%M %d, %Y <br>%l:%i:%S %p')
				    ELSE '-'
				END as logout_timestamp
      		FROM {$this->table}
      		LEFT JOIN {$this->staffs} ON {$this->staffs}.id={$this->table}.person_to_visit
      		LEFT JOIN {$this->division} ON {$this->division}.id={$this->table}.division_to_visit
      		LEFT JOIN {$this->feedbacks} ON {$this->feedbacks}.pin_code={$this->table}.pin_code
      		{$where} {$order_str} {$limit_str}
      	")->result();
  	}
  	public function all_total()
  	{
  		$where = ' WHERE 1=1 ';
	    if (isset($_GET['name']) && $_GET['name'] != ''):
	      $where .= "AND {$this->table}.fullname LIKE '%{$_GET['name']}%' ";
	    endif;
	    if (isset($_GET['cat']) && $_GET['cat'] != ''):
	      $where .= "AND {$this->table}.division_to_visit = '{$_GET['cat']}' ";
	    endif;

	    if (isset($_GET['origin']) && $_GET['origin'] != ''):
	    	$where .= "AND {$this->table}.place_of_origin = '{$_GET['origin']}' ";
	    endif;

    	return $this->db->query("
      		SELECT {$this->table}.*, 
            	DATE_FORMAT({$this->table}.created_at, '%M %d, %Y <br>%l:%i:%S %p') as f_created_at
      		FROM {$this->table}
      		LEFT JOIN {$this->staffs} ON {$this->staffs}.id={$this->table}.person_to_visit
      		LEFT JOIN {$this->division} ON {$this->division}.id={$this->table}.division_to_visit
      		{$where}
      	")->num_rows();
  	}
  	public function get_cities()
	{
		return $this->db->query("
      		SELECT {$this->table}.place_of_origin
      		FROM {$this->table}
      		GROUP BY {$this->table}.place_of_origin
      		ORDER BY {$this->table}.place_of_origin ASC
      	")->result();
	}
}