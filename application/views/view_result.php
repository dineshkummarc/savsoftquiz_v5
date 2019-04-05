 <style>
@media print {
   
   .navbar{
   display:none;
   }
   #footer{
   display:none;
   } 
   .printbtn{
	  display:none; 
   }
   #social_share{
	   display:none;
   }
   
   #page_break2{
	   
   page-break-after: always;
	}
	
.noprint{
	
	display:none; 
}
}
@media screen {
.onlyprint{
	display:none; 
	
}
}
 td{
		color:#212121;
		font-size:14px;
		padding:4px;
	}
	
	
	
	
	
	.circle_result{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #0b8d6f;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
		float:left;
}


.circle_ur{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #ffcc66;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
	float:left;
}


.circle_l{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #ff3300;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
	float:right;
}

.td_line{
	background:url('<?php echo base_url('images/rankbar.png');?>');background-repeat: repeat-x;
}
</style>
 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
?>
   
    
 
<?php 

function ordinal($number) {	//number为no_attempt参与测试试卷的次数，判断要添加的英文数字后缀
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
/////////////////////////////////////////////////////////////////////////////////
//	假设有三个科目，分别有3，2，2数量的题目，这里$key是题目在整份试卷中的顺序，从0开始计算。
//	c_range的每一项则是每一个科目下 题目的顺序所在的范围。
//  例如：科目一的题目顺序范围是[0,2],科目二的题目顺序范围是[3,4],科目三的题目顺序范围是[5,6]
//  那么根据$key处于$c_range的哪个位置，即可判断 题目是属于什么科目的了
//////////////////////////////////////////////////////////////////////////////////
function questioninwhichcategory($key,$c_range){	//question in which category 根据返回的值，判断问题属于哪一个科目。
	foreach($c_range as $k => $cv){
		
		if($key >= $cv[0] && $key <= $cv[1]){
			return $k;
		}
	}
	
}




function cia_cat($narray,$c_range,$c_score,$inc_score){	//按照得分、未得分、未作答分类，记录了每一个科目下的得分情况
	$unattempted=array();
	$correct=array();
	$incorrect=array();
	// $c_score = explode(',',$result['correct_score']);
	// $inc_score = explode(',',$result['incorrect_score']);
	foreach($narray as $k => $val){	//$narray为每道题 的得分情况
		//isset是否定义过 $correct,$incorrect,$unattempted的每一个索引 代表着 每一个科目下的编号
	if($val==0){	//未参与
		if(isset($unattempted[questioninwhichcategory($k,$c_range)])){
		$unattempted[questioninwhichcategory($k,$c_range)]+=1;
		}else{
		$unattempted[questioninwhichcategory($k,$c_range)]=1;	
		}
	}else if($val==1){
// $correct+=1;
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
			$correct[questioninwhichcategory($k,$c_range)]+=$c_score[$k];
		}else{
			$correct[questioninwhichcategory($k,$c_range)]=$c_score[$k];	
		}
	}else if($val==2){
// $incorrect+=1;
		if(isset($incorrect[questioninwhichcategory($k,$c_range)])){
			$incorrect[questioninwhichcategory($k,$c_range)]+=$inc_score[$k];
		}else{
			$incorrect[questioninwhichcategory($k,$c_range)]=$inc_score[$k];	
		}
	}else{
		//cloze test 4=$marks
		$cm = explode('-',$val);	//$cm[1] = score;
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
			$correct[questioninwhichcategory($k,$c_range)]+=floatval($cm[1])*$c_score[$k];
		}else{
			$correct[questioninwhichcategory($k,$c_range)]=floatval($cm[1])*$c_score[$k];
		}
	}
	 
		 
	 
	}
	
	return array($correct,$incorrect,$unattempted);
}





function cia_tim_cate($narray,$tim,$c_range){	//narray为每道题的得分情况，tim为每道题的答题时间，c_range为每一个科目下对应的题目顺序范围
	$unattempted=array();
	$correct=array();
	$incorrect=array();
	foreach($narray as $k => $val){
	
	if($val==0){	//unattempted
		if(isset($unattempted[questioninwhichcategory($k,$c_range)])){
		$unattempted[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$unattempted[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}else if($val==1){
// $correct+=1;
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
		$correct[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$correct[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}else if($val==2){
// $incorrect+=1;
		if(isset($incorrect[questioninwhichcategory($k,$c_range)])){
		$incorrect[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$incorrect[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}else{
		//cloze_test	
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
			$correct[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
			$correct[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}
	
	}
		
	return array($correct,$incorrect,$unattempted);
}

function prezero($val){	//format 00 01 02 03...10 11...
	if($val <= 9){
	return '0'.$val;	
	}else{
		return $val;
	}
}
function secintomin($sec){	//sec to min
	if($sec >= 60){
	$splitin=explode('.',($sec/60));
	if(isset($splitin[1])){
		$secs=substr(intval((substr($splitin[1],0,2)*60)/100),0,2);
	}else{
		$secs=0;
	}
	return $splitin[0].':'.prezero($secs);
	}else{
	return '0:'.prezero($sec);	
	}
}


function per_nonzero($arr){	//return 100
	
	$totallen=count($arr);	//数组长度
	$filt=array_filter($arr);	//第一个参数数组，第二个参数callback函数，无第二个参数
	$per=(count($filt)/$totallen)*100;	//100
	return intval($per);	
}

$c_range=array();
$j=0;
$i=0;
foreach(explode(",",$result['category_range']) as $ck => $cv){	//category_range每个科目在试卷中对应题目的数量
	$c_range[]=array($i,($i+($cv-1)));
	$i+=$cv;
}
$correct_incorrect_unattempted=explode(",",$result['score_individual']);//每道题的答题情况 注意完形未满分的情况未4-marks
 
$c_score = explode(',',$result['correct_score']);
$inc_score = explode(',',$result['incorrect_score']);
$cia_cat=cia_cat($correct_incorrect_unattempted,$c_range,$c_score,$inc_score);
 
$cia_tim_cate=cia_tim_cate($correct_incorrect_unattempted,explode(",",$result['individual_time']),$c_range);



?>

<div class="row noprint" >
<div class="col-lg-12" style="background-image:url('<?php echo base_url('images/result_bg.jpg');?>');background-size:cover;font-size:18px;padding:20px;color:#ffffff;min-height:400px;">
<div class="col-lg-12" >
<center><h3><span style="color:#e39500;"> 
<?php echo $this->lang->line('hello');?> <?php echo $result['first_name'];?> 
<?php echo $result['last_name'];?>!</span>  <?php echo str_replace('{attempt_no}',ordinal($attempt),$this->lang->line('title_result'));?> </h3></center>
</div>
<div class="col-lg-12" >
<center>
<h2><span style="color:#e39500;"><?php echo $result['quiz_name'];?>   </span></h2>
</center>
</div>

<div class="col-lg-12" style="margin-top:20px;">

	<div class="col-lg-2" style="text-align:center;">
		<p><?php echo $this->lang->line('score_obtained');?></p>
		<p style="color:#e39500;" ><?php echo $result['score_obtained'];?></p>
	</div>

	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('time_spent');?></p>
		<p style="color:#e39500;" ><?php echo secintomin($result['total_time']);?> Min.</p>
	</div>

	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('attempt_time');?></p>
		<p style="color:#e39500;font-size:14px;" ><?php echo date('Y-m-d H:i:s',$result['start_time']);?></p>
	</div>

	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('percentage_obtained');?></p>
		<p style="color:#e39500;" ><?php echo $result['percentage_obtained'];?>%</p><!--百分制的得分-->
	</div>

  <div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('percentile_obtained');?></p>
		<p style="color:#e39500;" ><?php echo substr(((($percentile[1]+1)/$percentile[0])*100),0,5);   ?>%</p><!--在已参考人员中的成绩排名-->
  </div>
 
  <div class="col-lg-2"  style="text-align:center;"> 
		<p><?php echo $this->lang->line('status');?></p>
		<p style="color:#e39500;" ><?php echo $result['result_status'];?></p>
  </div>
 
</div>

<div class="col-lg-12" style="margin-top:20px;">
<center>
<?php 
if($result['view_answer']=='1' || $logged_in['su']=='1'){
	
?>
<a href="#answers_i" class="btn btn-info" style="margin-top:10px;"><?php echo $this->lang->line('answer_sheet');?></a>
<?php 
}
?>

<a href="javascript:print();" class="btn btn-success printbtn" style="margin-top:10px;"><?php echo $this->lang->line('print');?></a>

<?php
if($result['gen_certificate']=='1'){
?>
<a href="<?php echo site_url('result/generate_certificate/'.$result['rid']);?>" class="btn btn-warning printbtn" style="margin-top:10px;"><?php echo $this->lang->line('download_certificate');?></a>
	
<?php
}
?>



</center>
</div>

<div class="col-lg-12" style="margin-top:50px;color:#dddddd;font-size:14px;">
 
	
		 
		 <center>
		 <?php echo $this->lang->line('result_id');?> <?php echo $result['rid'];?> &nbsp;&nbsp;&nbsp;
		<?php echo $this->lang->line('user_id');?> <?php echo $result['uid'];?>&nbsp;&nbsp;&nbsp;
		<?php echo $this->lang->line('email');?>: <?php echo $result['email'];?>
		 </center>
		
		 

	 
  
 

	 
</div>


</div>



</div>




 


  <div class="row">
     
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default onlyprint"><!--onlyprint:display none-->
		<div class="panel-body"> 
	
	
	
		 
<table class="table table-bordered">
	<?php 
	if($result['camera_req']=='1'){
		?>
	<tr><td colspan='2'> <?php if($result['photo']!=''){ ?> <img src ="<?php echo base_url('photo/'.$result['photo']);?>" id="photograph" ><?php } ?></td></tr>
		
		<?php 
	}
	?>
	<tr><td><?php echo $this->lang->line('first_name');?></td><td><?php echo $result['first_name'];?></td></tr>
	<tr><td><?php echo $this->lang->line('last_name');?></td><td><?php echo $result['last_name'];?></td></tr>
	<tr><td><?php echo $this->lang->line('email');?></td><td><?php echo $result['email'];?></td></tr>
	<tr><td><?php echo $this->lang->line('quiz_name');?></td><td><?php echo $result['quiz_name'];?></td></tr>
	<tr><td><?php echo $this->lang->line('attempt_time');?></td><td><?php echo date('Y-m-d H:i:s',$result['start_time']);?></td></tr>
	<tr><td><?php echo $this->lang->line('time_spent');?></td><td><?php echo secintomin($result['total_time']);?></td></tr>
	<tr><td><?php echo $this->lang->line('percentage_obtained');?></td><td><?php echo $result['percentage_obtained'];?>%</td></tr>
	<tr><td><?php echo $this->lang->line('percentile_obtained');?></td><td><?php echo substr(((($percentile[1]+1)/$percentile[0])*100),0,5);   ?>%</td></tr>
	<tr><td><?php echo $this->lang->line('score_obtained');?></td><td><?php echo $result['score_obtained'];?></td></tr>
	<tr><td><?php echo $this->lang->line('status');?></td><td><?php echo $result['result_status'];?></td></tr>

</table>
  
 
		</div>
</div>
<br>

 <div class="col-md-12">
		 <h3><?php echo $this->lang->line('categorywise');//Categorywise Analysis?></h3>
					<table class="table table-bordered">
					 <thead> <tr>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('category_name');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('score_obtained');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('time_spent');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('correct');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('incorrect');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('notattempted');?></th> 
					</tr></thead>
					<tbody>
					  <?php 
					  $c=0;
					  $correct=0;
					 $incorrect=0;
					 $notattempted=0;
					  foreach(explode(',',$result['categories']) as $vk => $category){ //categories:试卷下的所有科目 cia_cat：在得分0、没有得分1、未参加2 下，每个科目的情况
							if(isset($cia_cat[0][$vk])){ $no_C=$cia_cat[0][$vk]; $correct+=$cia_cat[0][$vk]; }else{ $no_C=0; } //$no_C为$vk科目的得分，$correct为总正确得分
							if(isset($cia_cat[1][$vk])){ $no_iC=$cia_cat[1][$vk]; $incorrect+=$cia_cat[1][$vk]; }else{ $no_iC=0;  }//$no_iC为$vk科目的错误分，$incorrect为总错误得分
						?>
						<tr><td>
						<?php echo $category; //科目名称?>
						</td>
						
						<td><?php echo $no_C+$no_iC;//Score?></td>
						<td><?php echo secintomin($cia_tim_cate[0][$vk]+$cia_tim_cate[1][$vk]+$cia_tim_cate[2][$vk]);//Time Spent (Approx.)?> Min.</td>
						<td><?php echo $no_C;//Correct?></td>
						<td><?php echo $no_iC;//Incorrect  ?></td>
						<td><?php   if(isset($cia_cat[2][$vk])){ echo $cia_cat[2][$vk]; $notattempted+=$cia_cat[2][$vk]; }else{ echo '0';  } //未作答题数?></td>
						 
						</tr>
					 <?php 
					  }
					  ?>
					 </tbody>
						 <thead> 
						 <tr>
						 <th style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('total');//Total?></th>
						 <th  style="background:#337ab7;color:#ffffff;"><?php echo $result['score_obtained'];//Score?>
						 </th>
						 <th style="background:#337ab7;color:#ffffff;"><?php echo secintomin($result['total_time']);?> Min. <?php echo $this->lang->line('approx');//Time Spent (Approx.)?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $correct;//Correct?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $incorrect;//Incorrect?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $notattempted;//Not Attempted?></th> 
						 </tr>
						 </thead>
					
						</table>
						
		
	</div>
	
	<div class="col-lg-12 noprint">
	<h3><?php echo $this->lang->line('comparison_other');?></h3>
	</div>
	





<script>//////////////////////////////////////////////////////////////////////////////////////////////////调试
	// console.log( "<?php echo $no_C.' '.$no_iC; ?>" );
	// console.log(" <?php echo $cia_cat[0][0].' '.$cia_cat[0][1]       ;?>");
</script>







<div class="col-lg-12 noprint" style="margin-top:50px;"> 
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('rank').': '.$rank;?> </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>1</div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>2</div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>3</div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Rank" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%"><?php echo $rank;?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Rank"><?php echo $last_rank;?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Your Rank is Last"><?php echo $last_rank;?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
 
 
 
<div class="col-lg-12 noprint" style="margin-top:50px;">
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('score_obtained').': '.$result['score_obtained'];?> </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[0]['score_obtained'];?></div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[1]['score_obtained'];?></div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[2]['score_obtained'];?></div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Score" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%"><?php echo $result['score_obtained'];?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Lowest Score"><?php echo $looser['score_obtained'];?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Lowest Score is Your"><?php echo $looser['score_obtained'];?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
 
 
 <div class="col-lg-12 noprint" style="margin-top:50px;margin-bottom:50px;">
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('time').': '.secintomin($result['total_time']).' Min.';?>   </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[0]['total_time']);?></div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"   title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[1]['total_time']);?></div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"   title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[2]['total_time']);?></div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Time" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%" style="font-size:12px;padding-top:10px;"><?php echo secintomin($result['total_time']);?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Ranker's Time" style="font-size:12px;padding-top:10px;"><?php echo secintomin($looser['total_time']);?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Ranker's Time" style="font-size:12px;padding-top:10px;"><?php echo secintomin($looser['total_time']);?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
	 <div id="page_break"></div>
 <div class="col-md-12">

<?php
 
if($this->config->item('google_chart') == true ){ 
?> 


<!-- google chart starts--> <!--注释掉了2个script 1个div-->
<!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
 
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $value;?>);

        var options = {
          title: '<?php echo $this->lang->line('top_10_result');?> <?php echo $result['quiz_name'];?>',
          hAxis: {title: '<?php echo $this->lang->line('quiz');?>(<?php echo $this->lang->line('user');?>)', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
</script>
		 <div id="chart_div" style="width: 800px; height: 500px;"></div> -->
  

<!-- google chart starts --> <!--注释掉了1个script 1个div-->

    <!-- <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $qtime;?>);

        var options = {
          title: '<?php echo $this->lang->line('time_spent_on_ind');?>'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
		 <div id="chart_div2" style="width:800px; height: 500px;"></div> -->
<!-- google chart ends -->




 

<?php 
}
?>

<?php
$ind_score=explode(',',$result['score_individual']); 
// view answer
if($result['view_answer']=='1' || $logged_in['su']=='1'){
	
?>

<div class="login-panel panel panel-default">
		<div class="panel-body"> 
		<a name="answers_i"></a>
<h3><?php echo $this->lang->line('answer_sheet');?></h3>

<?php 
$abc=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'6'=>'F',
'7'=>'G',
'8'=>'H',
'9'=>'I',
'10'=>'J',
'11'=>'K'
);
foreach($questions as $qk => $question){
?>
 <hr>


<div class="col-md-12 " id="q<?php echo $qk;?>" class="" 
style="margin:10px;padding:10px;<?php if($ind_score[$qk]=='1'){ //right:green?>background-color:#71ba5d; color:#ffffff;<?php }else if($ind_score[$qk]=='2'){ //wrong:red?>background-color:#ff5e5e; color:#ffffff;<?php }else if($ind_score[$qk]=='3'){ //pending:yellow?>background-color:#fdfbcf;<?php }else if(explode('-',$ind_score[$qk])[0]=='4'){//cloze:blue?>background-color:#9fcdf4;<?php }else{ ?>background-color:#ffffff;<?php } ?>">
	<div class="col-md-2 col-sm-2">
		<div style="height:45px; width:45px; background-color:#ffffff;border-radius:50%;color:#4b7d42;
		margin-top:6px;padding:14px;"><b><?php echo $qk+1;?></b></div>
	</div>
	<div class="col-md-8 col-sm-8">
		<?php echo $question['question'];?><br>
		
		 <?php

		 // multiple single choice
		 if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
			 
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="1">
			 <?php
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			  <?php if(in_array($option['oid'],$save_ans)){   echo'<b>'.$this->lang->line('your_answer').'</b>:'.$option['q_option']; } ?>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}echo "<br>";
			echo "<b>".$this->lang->line('correct_options').'</b>: '.implode(', ',array_map('trim',($correct_options)));
		 }
			
// multiple_choice_multiple_answer	

		 if($question['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="2">
			 <?php echo '<b>'.$this->lang->line('your_answer').'</b>:';
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
						if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			 
		 <?php 

if(in_array($option['oid'],$save_ans)){   echo  trim($option['q_option']).', '; }?> 

			 
		 	 	 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}echo "<br>";
			echo "<b>".$this->lang->line('correct_options').'</b>: '.implode(', ',$correct_options);
		 }
			 
	// short answer	

		 if($question['question_type']==$this->lang->line('short_answer')){
			 			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="3"   >
			 
			 <?php

			 
			
			 ?>
			 
		<div class="op"> 
		<?php echo '<b>'.$this->lang->line('your_answer').'</b>:';?> 
		   <?php echo $save_ans;?>   
		</div>
			 
			 
			 <?php 
			 			 foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					 echo "<b>".$this->lang->line('correct_answer').'</b>: '.$option['q_option'];
			 }
			 }
			 
		 }
		 
		 
		 	// long answer	

		 if($question['question_type']==$this->lang->line('long_answer')){
			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
			 <input type="hidden"  name="question_type[]" id="q_type<?php echo $qk;?>" value="4">
			 <?php
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('answer');?> <br>
		<?php echo $this->lang->line('word_counts');?>  <?php echo str_word_count($save_ans);?>
		<textarea name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk;?>" style="width:100%;height:100%;color:#000;" onKeyup="count_char(this.value,'char_count<?php echo $qk;?>');"><?php echo $save_ans;?></textarea>
		</div>
		<?php 
		if($logged_in['su']=='1'){
			if($ind_score[$qk]=='3'){
			
		?>
		<div id="assign_score<?php echo $qk;?>">
		<?php echo $this->lang->line('evaluate');//提交计算题的分数?>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','1');"  class="btn btn-success" ><?php echo $this->lang->line('correct');?></a>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','2');"  class="btn btn-danger" ><?php echo $this->lang->line('incorrect');?></a>	
		</div>
		<?php 
			}
		}
		?>		
			 
			 <?php 
			//  here to show the suggested answer of long answer
				foreach($options as $ok => $option){
					if($option['qid']==$question['qid']){
						echo "<b>".$this->lang->line('suggested_answer').'</b>: '.$option['q_option'];
					}
			 	}
			 
			 
		 }
			 
		
		
		
		
		
		
		// matching	

		 if($question['question_type']==$this->lang->line('match_the_column')){
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					// $exp_match=explode('__',$saved_answer['q_option_match']);
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden" name="question_type[]" id="q_type<?php echo $qk;?>" value="5">
			 <?php
			$i=0;
			$match_1=array();
			$match_2=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					$match_1[]=$option['q_option'];
					$match_2[]=$option['q_option_match'];
			?>
			 
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			?>
			<div class="op">
						<table>
						<tr><td></td><td><?php echo "<b>".$this->lang->line('your_answer').'</b> ';?></td><td><?php echo "<b>".$this->lang->line('correct_answer').'</b> ';?></td></tr>
						<?php 
			 
			foreach($match_1 as $mk1 =>$mval){
						?>
						<tr><td>
						<?php echo $abc[$mk1];?>)  <?php echo $mval;?> 
						</td>
						<td>
						
							 
							 <?php 
							foreach($match_2 as $mk2 =>$mval2){
								?>
<?php $m1=$mval.'___'.$mval2; if(in_array($m1,$save_ans)){ echo $mval2; } ?>  
								<?php 
							}
							?>
							 

						</td>
						
						<td>
						<?php 
							echo $match_2[$mk1];
							?>
						</td>
						
						</tr>
				
						
						<?php 
			}
			
			
			?>
			</table>
			 </div>
			<?php
			
		 }






		// cloze

			if($question['question_type']==$this->lang->line('cloze_test')){
				$save_ans=array();
				foreach($saved_answers as $svk => $saved_answer){
					if($question['qid']==$saved_answer['qid']){
						$save_ans[]=$saved_answer['q_option'];	//已经作答的信息
					}
				}

			?>
			<input type="hidden" name="question_type[]" id="q_type<?php echo $qk;?>" value="6">
		<?php

				$i=0;
				$correct_answer = array();	//正确的答案，索引为子题目号，值为正确的答案
				foreach($options as $ok => $option){
					if($option['qid']==$question['qid']){
						$correct_answer[$option['q_option']] = explode(',',$option['q_option_match_option'])[$option['q_option_match']];
						$i+=1;
					}else{
						$i=0;	
					}
			}
		?>
			<div class="op">
				<table>
					<tr>
						<td></td>
						<td><?php echo "<b>".$this->lang->line('your_answer').'</b> ';?></td>
						<td><?php echo "<b>".$this->lang->line('correct_answer').'</b> ';?></td>
					</tr>
					<?php 

						foreach($save_ans as $sa_key =>$sa_val){
					?>
					<tr>
						<td>
							<?php echo $sa_key+1;?>)  
						</td>

						<td>
							<?php //echo $sa_val;
								echo str_replace(($sa_key+1).'___','',$sa_val);
							?>
						</td>


						<td>
							<?php 
							echo $correct_answer[($sa_key+1)];
							?>
						</td>
						
						<script>
							// console.log("<?php echo $sa_key.' '.$sa_val.' '; ?>");
							// console.log("<?php 
							// 	foreach($correct_answer as $ck => $cv){
							// 		if(isset($ck)){
							// 			echo $ck.' '.$cv.'/';
							// 		}
							// 	}
							// ?>");
						</script>
					
					</tr>

					<?php 
					}


					?>
				</table>
			</div>
<?php

}
			




		 ?>
	<p><?php 
 if($question['description']!='') {
				echo '<b>'.$this->lang->line('description').'</b>:';
				echo $question['description'];
			 }
			
?></p>
	
</div>
<div class="col-md-2 col-sm-2" id="q<?php echo $qk;?>"  style="font-size:30px;">

<?php if($ind_score[$qk]=='1'){ ?><i class="glyphicon glyphicon-ok"></i>  <?php }else if($ind_score[$qk]=='2'){ ?><i class="glyphicon glyphicon-remove"></i> <?php }  ?>


</div>
</div>


 <div id="page_break"></div>
 
 
 <?php
}
?>
</div>
</div>
<?php 
}
// view answer ends
?>





 
 
 
 
</div>
      
</div>

 



</div>

<input type="hidden" id="evaluate_warning" value="<?php echo $this->lang->line('evaluate_warning');?>">
 
 <script>
 $('.s_title').tooltip('show');
 </script>
