function shake(cl){
 
	setTimeout(function(){
		$(cl).css('display','none');
	},10000);
}

 
function enableStartBtn(){
	if($('#accept-terms').prop('checked')==true){
		$('#startBtn').css('display','block');
	}else{
	$('#startBtn').css('display','none');
	}
}


function selectOption(e,cl){
	
	$(e).find('input').prop('checked',true);
	$(cl).removeClass('sqm-selected');	
	$(e).addClass('sqm-selected');	
	
}



function postResponse(){
	var url=base_url+"index.php?page=writeResponse";
	$.post(url, $( "#testform" ).serialize() )
	.done(function( data ) {
		if(data.trim()=="DONE"){
			$('#savedResponse').html("<span class=''>Response Saved</span>");
		}else{
			$('#savedResponse').html("<span class='red-color'>Unable to Save. Check connection</span>");
		}
		setTimeout(function(){
		$('#savedResponse').html("");
		},3500);
	})
	.fail(function(xhr, status, error) {
        
    });
  
}

function postLogs(){
	var url=base_url+"index.php?page=logResponse";
	$.post(url, $( "#testform" ).serialize() )
	.done(function( data ) {
	
	})
	.fail(function(xhr, status, error) {
        
    });
  
}

var cq=0;
function showq(id,qn){
	cq=qn;
	$('.sqm-question-content').css('display','none');
	$(id).css('display','block');
		btnhideshow();
}

function backQuestion(){
	 
		btnColor();
 var nqno=parseInt(cq)-1;
 var qele="#qno-"+nqno;
 if($(qele).html() != undefined){
	 cq-=1;
	 $('.sqm-question-content').css('display','none');
	$(qele).css('display','block');
	  
 }else{
	 console.log('undefined'); 
 }
 btnhideshow();
}


function nextQuestion(){
		btnColor();
 var nqno=parseInt(cq)+1;
 var qele="#qno-"+nqno;
 if($(qele).html() != undefined){
	 cq+=1;
	 $('.sqm-question-content').css('display','none');
	$(qele).css('display','block');
	  
 }else{
	 console.log('defined'); 
 }
 btnhideshow();
 postResponse();
 postLogs();
}



function submitQuiz(){
	
$('#bg_blur').css('display','block');
$('#submit_warning').css('display','block');
	
	
}

function timeOver(){
	
$('#bg_blur').css('display','block');
$('#timeover_warning').css('display','block');
	submitNow();
	
}

function submitCancel(){
	
$('#bg_blur').css('display','none');
$('#submit_warning').css('display','none');

	
	
}


function submitNow(){
	$('#quiz_statrus').val('Close');
	var url=base_url+"index.php?page=writeResponse";
	$.post(url, $( "#testform" ).serialize() )
	.done(function( data ) {
		if(data.trim()=="DONE"){
			postLogs();
			$('#mainQuizContainer').html("");
			$('#quiz_submit_status').html("<b>Quiz submitted successfully.</b><br>Redirect you shortly...");
 
setTimeout(function(){
	window.location=base_url+"index.php?page=thankyoupage";
},6000);
 
		}else{
			$('#quiz_submit_status').html("Unable to submit quiz.. Check connection. System will try again in 10 seconds");
			setTimeout(function(){
				submitNow();
			},6000);

		}
		 
	})
	.fail(function(xhr, status, error) {
        
    });
	
}


function btnhideshow(){

	if(cq==0){
	$('#backBtn').addClass('sqm-disabled');	
	}else{
	$('#backBtn').removeClass('sqm-disabled');	
	}
	if(cq >= (totalQuestions-1)){
	// $('#nextBtn').addClass('sqm-disabled');	
	$('#nextBtn').html('Save');	
	}else{
	$('#nextBtn').removeClass('sqm-disabled');	
	$('#nextBtn').html("Save & Next");	
	
	}
}


function btnColor(){
		var qbtnele="#qbtn-"+cq;
		
		  $(qbtnele).removeClass('sqm-reviewed');
		
	if($(qbtnele).hasClass('sqm-unviewed')){
		$(qbtnele).removeClass('sqm-unviewed');
		$(qbtnele).addClass('sqm-unattempted');
		
	}
	
var qele="#qno-"+cq;
var inputop=".inputop-"+cq;
var clik=0;
$(inputop).each(function(){
	
	if($(this).prop('checked')==true){
		console.log('checked');
		clik=1;	
	}
if(clik==1){
		$(qbtnele).removeClass('sqm-unviewed');
		$(qbtnele).removeClass('sqm-unattempted');
		$(qbtnele).addClass('sqm-answered');
	
}else{
		$(qbtnele).removeClass('sqm-unviewed');
		$(qbtnele).addClass('sqm-unattempted');	
}
});



	
}



function reviewLater(){
	var qbtnele="#qbtn-"+cq;
		$(qbtnele).removeClass('sqm-unviewed');
	 	$(qbtnele).removeClass('sqm-unattempted');
		$(qbtnele).removeClass('sqm-answered');
		$(qbtnele).addClass('sqm-reviewed');
		
	var nqno=parseInt(cq)+1;
	var qele="#qno-"+nqno;
	if($(qele).html() != undefined){
	 cq+=1;
	 $('.sqm-question-content').css('display','none');
	$(qele).css('display','block');
	  
	}else{
	 console.log('defined'); 
	}
 btnhideshow(); 
	
}

function clearResponse(){
	var inputop=".inputop-"+cq;
	$(inputop).each(function(){
	
	if($(this).prop('checked')==true){

		$(this).prop('checked',false); 
		$(this).parent().removeClass('sqm-selected');	
	}
});

}



function changelanguage(v){
	
	$('.language').css('display','none');
	
	$(v).css('display','block');
	
	
}




function secondsToHms(d) {
    d = Number(d);
    var h = Math.floor(d / 3600);
    var m = Math.floor(d % 3600 / 60);
    var s = Math.floor(d % 3600 % 60);

    var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
    var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
    var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
    return hDisplay + mDisplay + sDisplay; 
}
