<?php
Class Result_model extends CI_Model
{
	
 
 function result_list($limit,$status='0'){
	$result_open=$this->lang->line('open');
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
	  
		
	if($this->input->post('search')){
		 $search=$this->input->post('search');
<<<<<<< HEAD
		 $this->db->or_where('users.email',$search);
		 $this->db->or_where('users.student_code',$search);
		 $this->db->or_where('users.first_name',$search);
		 $this->db->or_where('users.last_name',$search);
		 $this->db->or_where('users.contact_no',$search);
		 $this->db->or_where('result.rid',$search);
		 $this->db->or_where('quiz.quiz_name',$search);
 
	 }else{
		 $this->db->where('result.result_status !=',$result_open);
	 }
	 	if($logged_in['su']=='0'){
			$this->db->where('result.uid',$uid);
		}
		
	 	if($status !='0'){
			$this->db->where('result.result_status',$status);
=======
		 $this->db->or_where('savsoft_users.email',$search);
		 $this->db->or_where('savsoft_users.first_name',$search);
		 $this->db->or_where('savsoft_users.last_name',$search);
		 $this->db->or_where('savsoft_users.contact_no',$search);
		 $this->db->or_where('savsoft_result.rid',$search);
		 $this->db->or_where('savsoft_quiz.quiz_name',$search);
 
	 }else{
		 $this->db->where('savsoft_result.result_status !=',$result_open);
	 }
	 	if($logged_in['su']=='0'){
			$this->db->where('savsoft_result.uid',$uid);
		}
		
	 	if($status !='0'){
			$this->db->where('savsoft_result.result_status',$status);
>>>>>>> savsoftquiz_v4.0_advance-master/master
		}
		
		
		
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('rid','desc');
<<<<<<< HEAD
		$this->db->join('users','users.uid=result.uid');
		$this->db->join('quiz','quiz.quid=result.quid');
		$query=$this->db->get('result');
=======
		$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
>>>>>>> savsoftquiz_v4.0_advance-master/master
		return $query->result_array();
		
	 
 }
 
 function quiz_list(){
	 $this->db->order_by('quid','desc');
<<<<<<< HEAD
$query=$this->db->get('quiz');	
=======
$query=$this->db->get('savsoft_quiz');	
>>>>>>> savsoftquiz_v4.0_advance-master/master
return $query->result_array();	 
 }
 
 
 function no_attempt($quid,$uid){
	 
<<<<<<< HEAD
	$query=$this->db->query(" select * from result where uid='$uid' and quid='$quid' ");
=======
	$query=$this->db->query(" select * from savsoft_result where uid='$uid' and quid='$quid' ");
>>>>>>> savsoftquiz_v4.0_advance-master/master
		return $query->num_rows(); 
 }
 
 
 function remove_result($rid){
	 
<<<<<<< HEAD
	 $this->db->where('result.rid',$rid);
	 if($this->db->delete('result')){
		  $this->db->where('rid',$rid);
		  $this->db->delete('answers');
=======
	 $this->db->where('savsoft_result.rid',$rid);
	 if($this->db->delete('savsoft_result')){
		  $this->db->where('rid',$rid);
		  $this->db->delete('savsoft_answers');
>>>>>>> savsoftquiz_v4.0_advance-master/master
		 return true;
	 }else{
		 
		 return false; 
	 }
	 
	 
	 
 }
 
 
 function generate_report($quid,$gid){
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
	$date1=$this->input->post('date1');
	 $date2=$this->input->post('date2');
		
		if($quid != '0'){
<<<<<<< HEAD
			$this->db->where('result.quid',$quid);
		}
		if($gid != '0'){
			$this->db->where('users.gid',$gid);
		}
		if($date1 != ''){
			$this->db->where('result.start_time >=',strtotime($date1));
		}
		if($date2 != ''){
			$this->db->where('result.start_time <=',strtotime($date2));
		}

	 	$this->db->order_by('rid','desc');
		$this->db->join('users','users.uid=result.uid');
		$this->db->join('group','group.gid=users.gid');
		$this->db->join('quiz','quiz.quid=result.quid');
		$query=$this->db->get('result');
=======
			$this->db->where('savsoft_result.quid',$quid);
		}
		if($gid != '0'){
			$this->db->where('savsoft_users.gid',$gid);
		}
		if($date1 != ''){
			$this->db->where('savsoft_result.start_time >=',strtotime($date1));
		}
		if($date2 != ''){
			$this->db->where('savsoft_result.start_time <=',strtotime($date2));
		}

	 	$this->db->order_by('rid','desc');
		$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_group','savsoft_group.gid=savsoft_users.gid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
>>>>>>> savsoftquiz_v4.0_advance-master/master
		return $query->result_array();
 }
 
 
 
 
 
 function get_result($rid){
	$logged_in=$this->session->userdata('logged_in');
	$uid=$logged_in['uid'];
		if($logged_in['su']=='0'){
<<<<<<< HEAD
			$this->db->where('result.uid',$uid);
		}
		$this->db->where('result.rid',$rid);
	 	$this->db->join('users','users.uid=result.uid');
		$this->db->join('group','group.gid=users.gid');
		$this->db->join('quiz','quiz.quid=result.quid');
		$query=$this->db->get('result');
=======
			$this->db->where('savsoft_result.uid',$uid);
		}
		$this->db->where('savsoft_result.rid',$rid);
	 	$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid');
		$this->db->join('savsoft_group','savsoft_group.gid=savsoft_users.gid');
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
>>>>>>> savsoftquiz_v4.0_advance-master/master
		return $query->row_array();
	 
	 
 }
 
 
 function last_ten_result($quid){
		$this->db->order_by('percentage_obtained','desc');
		$this->db->limit(10);		
<<<<<<< HEAD
	 	$this->db->where('result.quid',$quid);
	 	$this->db->join('users','users.uid=result.uid'); 
		$this->db->join('quiz','quiz.quid=result.quid');
		$query=$this->db->get('result');
=======
	 	$this->db->where('savsoft_result.quid',$quid);
	 	$this->db->join('savsoft_users','savsoft_users.uid=savsoft_result.uid'); 
		$this->db->join('savsoft_quiz','savsoft_quiz.quid=savsoft_result.quid');
		$query=$this->db->get('savsoft_result');
>>>>>>> savsoftquiz_v4.0_advance-master/master
		return $query->result_array();
 }
 
 
 
   function get_percentile($quid,$uid,$score){
  $logged_in =$this->session->userdata('logged_in');
$gid= $logged_in['gid'];
$res=array();
<<<<<<< HEAD
	$this->db->where("result.quid",$quid);
	 $this->db->group_by("result.uid");
	 $this->db->order_by("result.score_obtained",'DESC');
	$query = $this -> db -> get('result');
	$res[0]=$query -> num_rows();

	
	$this->db->where("result.quid",$quid);
	$this->db->where("result.uid !=",$uid);
	$this->db->where("result.score_obtained <=",$score);
	$this->db->group_by("result.uid");
	 $this->db->order_by("result.score_obtained",'DESC');
	$querys = $this -> db -> get('result');
=======
	$this->db->where("savsoft_result.quid",$quid);
	 $this->db->group_by("savsoft_result.uid");
	 $this->db->order_by("savsoft_result.score_obtained",'DESC');
	$query = $this -> db -> get('savsoft_result');
	$res[0]=$query -> num_rows();

	
	$this->db->where("savsoft_result.quid",$quid);
	$this->db->where("savsoft_result.uid !=",$uid);
	$this->db->where("savsoft_result.score_obtained <=",$score);
	$this->db->group_by("savsoft_result.uid");
	 $this->db->order_by("savsoft_result.score_obtained",'DESC');
	$querys = $this -> db -> get('savsoft_result');
>>>>>>> savsoftquiz_v4.0_advance-master/master
	$res[1]=$querys -> num_rows();
		
   return $res;
  
  
 }
 
 
 
 
 
 
 
 
 
 
 
 
 

}












?>