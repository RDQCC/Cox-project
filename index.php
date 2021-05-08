<?php
session_start(); 
$_SESSION['User_ID'] = 'PUBLIC_USER';
$_SESSION['ERR_MSG'] = '';

/* Jiashen Start Get Total Page View, Part I */


$iPV_SQL = "SELECT COUNT(RN) AS tGuest FROM `Guest_Log` WHERE Guest_City<>'' AND Memo LIKE '%GMT%'";  //for human visitor only AND Memo LIKE '%GMT%'

$Total_PV = mysqli_query($con, $iPV_SQL);

while($Total_PV_Row = mysqli_fetch_assoc($Total_PV)) 
	{
		$Total_tPV = $Total_PV_Row['tGuest'];	//Include Robot
	}
	
mysqli_close($con);	
	
/* Jiashen End of Get Total Page View, Part I */


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="Images/x-icon" href="Images/RdPDM.ico"/>
<title>Risk Intelligent Engine</title>

<!-- Bootstrap core CSS -->
<!-- <link rel="stylesheet" href="CSS/bootstrap-3.3.7.css"> cant replace below-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<link rel="stylesheet" href="CSS/style.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> 

	
<!-- <link rel="stylesheet" type="text/css" href="CSS/font-awesome.min.css"> -->
<link rel="stylesheet" type="text/css" href="CSS/ShowRoom.css">

<link href="SCRIPTS/video-js.css" rel="stylesheet">	<!--file path, from root directory-->
<script src="SCRIPTS/video.js"></script> 
 
  <style>
   .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
	    /* Formatting search box */
    .search-box{
        width: 100%;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
	
/* for cox project */
	  .bookend_right
	  {
			border:1px steelblue solid;
	  	    width;1px;
			height:14px;
		    position:absolute;
		    bottom:2%;
			right:0;
			opacity:60%;
	  }
	  .bookend_left
	  {
			border:1px steelblue solid;
	  	    width;1px;
			height:14px;
		    position:absolute;
		    bottom:2%;
			left:0;
			opacity:60%;
	  }
	  .severity_box
	  {
	  	border:0px tan dotted;
		width:14px;
		height:60px;
		margin:auto;
  	    overflow-y:auto;
		border-radius:6px; 
		padding:8px;
		position:absolute;
		top:0;
		right:0;
	  }
	  .content_box
	  {
	  	border:0px tan dotted;
		width:180px;
		height:60px;
		margin-left:10px;
  	    overflow-y:auto;
		border-radius:6px; 
		padding:8px;
	  }
	  .probbar
	  {
			border:1px tan solid;
	  	    width:96%;
			height:8px;
		    position:absolute;
		    bottom:2%;
			right:2%;
			opacity:60%;
		    border-radius:3px; 
	  }
	  .shell
	  {
	    height:80px;  /* 110px */
		width:250px;
	    border: 2px solid white;
	  	position:relative;
		border-radius:19px; 
	  }
	  .cell
	  {
		background: white;
		height:72px;       /* 102px */
		width:244px;
		border: 0px solid steelblue; 
		border-radius:3px; 
		word-wrap:normal; 
		alpha:.4;
		margin-bottom:4px;
		margin-left:3px;
		position:absolute;
		border-left:1px tan solid;
		border-right:1px tan solid;
		bottom:0;
	  }
      .captured 
	  { 
	  	color: black; 
		background-color:white;
		border-bottom:1px solid #e75480;
	  }
	  
  </style>
  
  <style typestyletype="text/css"> 		
/* video CSS */
  .vjs-default-skin .vjs-control-bar,
  .vjs-default-skin .vjs-big-play-button { background: rgba(238,238,238,0.7) }
  .vjs-default-skin .vjs-slider { background: rgba(238,238,238,0.2333333333333333) }
</style> 
  
<!------------------------------------------------------------------------->
<!-------------------Step 1: javascrip functions--------------------------->
<!------------------------------------------------------------------------->

<script>
/* Jiashen Start Set Local GMT, Part II */
		
	var Guest_LocalTime = new Date();
	
	var Current_URL = window.location.href;
	if (Current_URL == "https://www.risk-discovery.com/") // !!! need Check the URL https://www.risk-discovery.com/
		{
			window.location.href = "index.php?Guest_LocalTime=" + Guest_LocalTime;
		}
		
/* Jiashen End of Set Local GMT, Part II */
</script>


<script src="SCRIPTS/jquery-3.3.1.js"></script>				<!-- required by Bootstrap-->
<script src="SCRIPTS/jquery.dataTables.min.js"></script>	<!-- required by Bootstrap-->
<script src="SCRIPTS/dataTables.bootstrap4.min.js"></script>
<!--script src="SCRIPTS/jquery-3.2.1.slim.min.js"></script>	<!-- required by Bootstrap-->
<!-- <script src="SCRIPTS/bootstrap-3.3.7.js"></script> can not replace below-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>


<script>

	var initial_statement = '';
	var cascade = new Array();
	var targets = new Array();
	var scored = 0;
	targets['fmode']     = 'hazard'
	targets['hazard']    = 'situation'
	targets['situation'] = 'harm'
	targets['harm']      = 'no_target'

	num_cells = new Array();
	num_cells['fmode']     = 20
	num_cells['hazard']    = 20
	num_cells['situation'] = 20
	num_cells['harm']      = 20

	numcells               = 20;
	selected_cell = 0;

	
	// INITIALIZE REGISTRY
	// create it in global scope
	columns = ['ccid', 'parent', 'cat', 'contents', 'selected_child', 'child_scroll_pos', 'probability'];
	statement_row = [0, -1, 'statement', initial_statement, 0, 0, 0];
	db            = [statement_row];
	
		// make it easy to clear it
	function reset_registry()
	{
		columns = ['ccid', 'parent', 'cat', 'contents', 'selected_child', 'child_scroll_pos', 'probability'];
		statement_row = [0, -1, 'statement', initial_statement, 0, 0, 0];
		db            = [statement_row];
	}
	reset_registry();
	
	/* Jiashen Set Favorite Action into DB */
	
	function Set_Favorite_DB(X_Favorite)	/* this function is called from text-Backendsearch.php when clicked on 'star' only*/
		{
			var GC_Action = "Favorite";
			
			var searchTerm = $.trim($("#id_objective_details").val());
			
			var Favorite_Item = $.trim($("#FavoText_ID"+X_Favorite).text());
			var Favorite_Item = Favorite_Item.replace(/\s+/g, '_s_p_')
			
			//alert(Favorite_Item);alert(searchTerm);alert(X_Favorite);

			$.get("Text_Add.php", {GC_Action_Type: GC_Action, GC_Action_Detail: Favorite_Item, GC_Action_Parent: searchTerm}).done(function(data){		

			});
		}
		
	/* Jiashen End of Set Favorite Action into DB */
/*	
function clearAll(){
		$('.example').DataTable().destroy();
		//$('.nav-list-main-content').remove();
		$('.listing-main-text').empty();
	} */
	
function resetCharacterCount() {
		$('.nav-list-main-content').remove();
		$('.listing-main-text').empty();
		$('#id_char_count').text(0);
		$('#id_objective_details').val('');
		$('#id_popup_details').val('');
		$('#bottom_window').hide();			// remove the down table
		$('#blinds').hide();
	}

function focusTextArea() {
		$('#id_objective_details').focus();
		$('#id_popup_details').focus();
	}
	
	//---display "pencil", "left arrow", "right arrow"
	//---nav-item-edit uses to display
	//---nav-item-favourite uses to non-display
	//---class="fa fa-bar-chart"
	
//function displayPencil(searchTerm, mm){
//	jQuery("#top_table").append('<div class="nav-list-main-content">'+
//					'<ul class="nav-item-list" >'+
//						'<li class="nav-item"><div class="ni-sub nav-item-edit" ><i class="fa fa-android" aria-hidden="true"></i></div><div class="ni-sub nav-item-edit" style="height:10px;"><button type="button" class="open-AddDialog btn btn-primary" data-toggle="modal" data-target="#myModal" data-key="'+searchTerm+'"><i class="fa fa-pencil" aria-hidden="true"></i></button></div></li>'+
//					'</ul>'
//				  +'</div>'
//				+'</div>');	
//	}
	
function displayPencil(searchTerm){
	jQuery("#top_table").append('<div class="nav-list-main-content">'+
					'<ul class="nav-item-list" >'+
						'<li class="nav-item"><div class="ni-sub nav-item-edit" ><i class="fa fa-android" aria-hidden="true"></i></div><div class="ni-sub nav-item-edit" style="height:10px;"><button type="button" class="open-AddDialog btn btn-primary" data-toggle="modal" data-target="#myModal" data-key="'+searchTerm+'"><i class="fa fa-pencil" aria-hidden="true"></i></button></div></li>'+
					'</ul>'
				  +'</div>'
				+'</div>');
}

//title="'+mm'"

function hint_submit() {

var	table_data = "<table border=0 style='margin-top:-5px; width:500px;' align='center'>";
	table_data += "<tr><td valign='middle' style='border:1px solid orange; width:25%; padding-left:5px;'><b>Users</b></td>";
	table_data += "<td valign='top' style='border:1px solid orange; width:75%'><div class='engine_popup_content'>-Public users can predict failure modes and hazards (free).<br>-Registered users have their customized ML model to predict hazardous situations and harms ($100/year).</div></td></tr>";

	table_data += "<tr><td valign='middle' style='border:1px solid orange; width:25%; padding-left:5px;'><b>Structure</b></td>";
	table_data += "<td valign='top' style='border:1px solid orange; width:75%'><div class='engine_popup_content'>-this engine consists of two tabs<br>-'Text' tab works on sentence(s) or paragraph(s)<br>-'Document' tab deals with one report in word,excel,or pdf</div></td></tr>";
		
	table_data += "<tr><td valign='middle' style='border:1px solid orange; width:25%; padding-left:5px;'><b>'Text' Tab</b></td>";
	table_data += "<td valign='top' style='border:1px solid orange; width:75%'><div class='engine_popup_content'>-pick up a category from drop-down window<br>-type sentence(s) or paragraph(s) at left table<br>-click on parse button '>'<br>-review results at right table<br>-click on 'show' to review rest of results</div></td></tr>";
	
	//table_data += "<tr><td valign='middle' style='border:1px solid orange; width:25%; padding-left:5px;'><b>Your Favorite</b></td>";
	//table_data += "<td valign='top' style='border:1px solid orange; width:75%'><div class='engine_popup_content'>-in order to providing better service in future<br>-you may 'star' one favorite result(option)<br>-or you may 'pencil' a customized result(option)</div></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid orange; width:25%; padding-left:5px;'><b>'Document' Tab</b></td>";
	table_data += "<td valign='top' style='border:1px solid orange; width:75%'><div class='engine_popup_content'>-click on 'Document' tab to switch webpage<br>-choose one report type(e.g. requirement, specification)<br>-upload one file from desktop<br>-click on parse button '>' to get results on screen<br>-download results to desktop(option)</div></td></tr>";
	
table_data += "</table>";

jQuery("#hintuploadpane").modal()			//$("#hintuploadpane"): has errors
jQuery('#hinttable').html(table_data);
}

function feedback_submit() {
			
var table_data = "<table border=0 style='margin-top:-5px; width:500px;' align='center'>";
	table_data += "<tr><td valign='middle' style='border:1px solid green; width:25%; padding-left:5px;'><b>user name:</b></td>";
	table_data += "<td valign='top' style='border:1px solid green; width:75%'><input type='text' id='User_Name' name='User_Name' value='' style='width:100%; border-style:none; padding-left:5px'/></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid green; width:25%; padding-left:5px;'><b>email address:</b></td>";
	table_data += "<td valign='top' style='border:1px solid green; width:75%'><input type='text' id='User_Position' name='User_Position' value='' style='width:100%; border-style:none; padding-left:5px'/></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid green; width:25%; padding-left:5px;'><b>feedback:</b></td>";
	table_data += "<td valign='top' style='border:1px solid green; width:75%'><textarea rows='8' id='User_Feedback' name='User_Feedback' style='width:100%; border-style:none; padding-left:5px;'></textarea></td></tr>";
	
	table_data += "<tr><td colspan='2' valign='middle' style='line-height:12px'>&nbsp;</td></tr>";	
	table_data += "<tr style='margin-bottom:10px;'><td colspan='2' valign='middle'><button id='feedback_click' name='feedback_click' class='parse_Button' style='height:28px; float:right;'>Submit</button></td></tr>";
	
	table_data += "</table>";
			
jQuery("#feedbackuploadpane").modal()		//$("#hintuploadpane"): has errors
jQuery('#feedbacktable').html(table_data);
}



function privacy_submit() {

var table_data = "<table border=0 style='margin-top:-5px; width:500px;' align='center'>";
	table_data += "<tr><td valign='middle' style='border:1px solid blue; width:25%; padding-left:5px;'><b>your location</b></td>";
	table_data += "<td valign='top' style='border:1px solid blue; width:75%'><div class='engine_popup_content'>-include date, time, IP address<br>-protect against abuse<br>-you can turn off your location on or off from settings</div></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid blue; width:25%; padding-left:5px;'><b>your activity</b></td>";
	table_data += "<td valign='top' style='border:1px solid blue; width:75%'><div class='engine_popup_content'>-Terms you search for<br>-your preference by clicked on star<br>-your inputs by using pencil</div></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid blue; width:25%; padding-left:5px;'><b>your email</b></td>";
	table_data += "<td valign='top' style='border:1px solid blue; width:75%'><div class='engine_popup_content'>-interact with you directly<br>-receive feedback from you<br>-reply your questions or concerns</div></td></tr>";
	
	table_data += "<tr><td valign='middle' style='border:1px solid blue; width:25%; padding-left:5px;'><b>our purposes</b></td>";
	table_data += "<td valign='top' style='border:1px solid blue; width:75%'><div class='engine_popup_content'>-we use your information to build better servcies<br>-we use your search for to ensure our services are working as intended<br>-we use your preference in order to return better results</div></td></tr>";
	
table_data += "</table>";

jQuery("#privacyuploadpane").modal()		//$("#hintuploadpane"): has errors
jQuery('#privacytable').html(table_data);
}
	/* Jiashen End of Set Favorite Action into DB */
	

//-------- click on 'submit' at popup feedback window to provide feedback----

$(document).on("click", "#feedback_click", function()
	{
	var UserName = document.getElementById('User_Name').value;
	var UserPosition = document.getElementById('User_Position').value;
	var UserFeedback = document.getElementById('User_Feedback').value;
	$.ajax(
    	{
       		type:'post',
       		url:'AI_Feedback.php',		
       		data: { 'User_Name': UserName, 'User_Position': UserPosition, 'User_Feedback': UserFeedback},	//send filename and filepath to document_execute_parse.php at server
       		cache: false,
       		async: 'asynchronous',
       		dataType:'text',
       		success:function(data)						//returned data --> _riskuser_24_user_need_report.docx
       		{			
		  		console.log('execute invoked '+data);	// (Fn+F12) console.log() --> is a modern way of debugging JavaScript code and is also much more elegant and less annolying
				window.location.href="index_document.php"; 
       		},
       		error: function(request, status, error) { console.log('save error: '+error); }	//it is changed from 'alert'. we need to figure out why has error
    	});
	});
	
//-----------------------------------------------------------------------------------------------------
//-------------------Step 2: javascript click submit, visible the failure mode column------------------
//-----------------------------------------------------------------------------------------------------

	$(document).ready(function()
	{

    	$('button.submit-arr').click(function() 
		{ 
		console.log('after click:')
			$('#fmode_span').css("border", "2px solid tan");

		    // put up the focus div
		    $('#focus').html($('#senbox').val())
			//$('#focus').html(db[0][3]);
		    $('#focus').css('visibility', 'visible')
		    $('#focus').css('background-color', 'PeachPuff')
		    $('#focus').css('display', 'flex')
		    $('#focus').css('justify-contents', 'center')
		    $('#focus').css('align-items', 'center')
		    $('#focus').css('padding', '20px')

			generate_failure_modes(); 
		});
	});

		
			// character count (X/500)
	$('#id_objective_details').keyup(function(){								//for search table
		$('#id_char_count').text($('#id_objective_details').val().length);
	});
	
	$('#id_popup_details').keyup(function(){									//for popup table
		$('#pp_id_char_count').text($('#id_popup_details').val().length);
	});
		
	$('#slide_up').click(function() { $('#blinds').slideUp("slow"); });           // when clicked on 'show more', the bottom window displays
   	$('#slide_down').click(function() { $('#blinds').slideDown("slow"); });		// when clicked on 'hide', the bottom window non-displays
	  
	  //clearAll();
			
	// ------------------------------------2.3 when clicked on star  ----------------------------------------
	//-----------2.3.1. add the starred failure mode/user sentence to database-------------------------------
	//-----------2.3.2 if removed the highlighted star, all saved info shall be erased from database---------

	$(document).on('click', '.listing-main-text .listing-item .li-sub.item-text-favourite i', function() {							
	    $( this ).toggleClass( "fa-star-o fa-star" );
		});
	
	// ----------------------2.4 when clicked on 'Document' -------------------------
	//-----------2.4.1. direct to 'index-document.php' -------------------------------
	$(document).on("click", "#pills-Graph-tab", function(){
	window.location.href="index_document.php";   
    });		   
	
	
	
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('#id_objective_details').val($(this).text());
        $(this).parent(".result").empty();
    });	
	

//-----------------------------------preidct functions-------------
//-----------------------------------------------------------------

	function clear_tray(category)
	{
		target = '#'+category+'_span'
		$(target).html('')

		capture_div_id = '#captured_'+category
		$(capture_div_id).css('visibility', 'hidden');
		cap = $(capture_div_id).html()
	}

	function fill_tray(category)
	{
		capture_div_id = '#captured_'+category
		$(capture_div_id).css('visibility', 'visible');

		tray_div_id = '#'+category+'_span'
		$(tray_div_id).css('visibility', 'visible');
	}

	function generate_failure_modes()
	{
	console.log('after generate_fm:')
		sessionValue = 'me';
		searchTerm = $('#senbox').val()
		db[0][3] = searchTerm;
        $(document).ajaxStart(function() { $(document.body).css({'cursor' : 'wait'}); }).ajaxStop(function() { $(document.body).css({'cursor' : 'default'}); });
        $.ajax(
        {
           type:'get',
           url:'AI_PASSTHROUGH.php',
           data: { 'termAll': searchTerm, 'usr': sessionValue, 'column':'fmode'},
           cache: false,
           async: 'asynchronous',
           dataType:'text',
           success:function(data)
           {
			  console.log(data)
			  failure_modes = data.split('::')
			  process_failure_modes(failure_modes)

			  // hide focus
			  $( "#focus" ).fadeOut( "slow", function() { });
		   },
		   error:function(data) { console.log(data) }
		})
	};

	function generate_hazards(statement, failure_mode, CCID, target_cat)
	{
		// seems like the best place to put this
		divname = '#'+target_cat
		$(divname).css("border", "steelblue");

		sessionValue = 'me';
		searchTerm = $('#senbox').val()
		db[0][3] = searchTerm;
        $(document).ajaxStart(function() { $(document.body).css({'cursor' : 'wait'}); }).ajaxStop(function() { $(document.body).css({'cursor' : 'default'}); });
        $.ajax(
        {
           type:'get',
           url:'AI_PASSTHROUGH.php',
           data: { 'termAll': searchTerm, 'usr': sessionValue, 'column':'hazard', 'failure_mode':failure_mode},
           cache: false,
           async: 'asynchronous',
           dataType:'text',
           success:function(data)
           {
			  hazards = data.split('::')

			  process_circular(hazards, CCID, target_cat)
		   }
		})
	};

	function generate_situations(statement, current_fm, current_hz)
	{
		// seems like the best place to put this
		divname = '#'+target_cat
		$(divname).css("border", "steelblue");

		// situations = ['sit1', 'sit2', 'sit3', 'sit4', 'sit5', 'sit6', 'sit7', 'sit8']
		// return situations;
		sessionValue = 'me';
		searchTerm = $('#senbox').val()
		db[0][3] = searchTerm;
        $(document).ajaxStart(function() { $(document.body).css({'cursor' : 'wait'}); }).ajaxStop(function() { $(document.body).css({'cursor' : 'default'}); });
        $.ajax(
        {
           type:'get',
           url:'AI_PASSTHROUGH.php',
           data: { 'termAll': searchTerm, 'usr': sessionValue, 'column':'situation', 'failure_mode':current_fm, 'hazard':current_hz},
           cache: false,
           async: 'asynchronous',
           dataType:'text',
           success:function(data)
           {
			  cdata = data;
			  sval  = data.search('::')
			  var situations = new Array();
			  if(sval > 0) { situations = data.split('::') }
			  else         { situations = [cdata]; }

			  process_circular(situations, CCID, target_cat)
		   }
		})
	};

	function get_severity_for(thisharm, sev_id)
	{
	    sev_id = '#'+sev_id;
        $.ajax(
        {
           type:'get',
           url:'game_actions.php',
           data: { 'severity': 'severity', 'harm': thisharm },
           cache: false,
           async: 'asynchronous',
           dataType:'text',
           success:function(data)
           {
			   $(sev_id).html(data)
		   }
		})
	};

    function generate_harms(statement, current_fm, current_hz, current_sit)
	{
		// seems like the best place to put this
		divname = '#'+target_cat
		$(divname).css("border", "steelblue");

		// harms = ['harmsev1', 'harmsev2', 'harmsev3', 'harmsev4', 'harmsev5', 'harmsev6', 'harmsev7', 'harmsev8']
		// return harms
		sessionValue = 'me';
		searchTerm = $('#senbox').val()
		db[0][3] = searchTerm;
        $(document).ajaxStart(function() { $(document.body).css({'cursor' : 'wait'}); }).ajaxStop(function() { $(document.body).css({'cursor' : 'default'}); });
        $.ajax(
        {
           type:'get',
           url:'AI_PASSTHROUGH.php',
           data: { 'termAll': searchTerm, 'usr': sessionValue, 'column':'harm', 'failure_mode':current_fm, 'hazard':current_hz, 'situation':current_sit},
           cache: false,
           async: 'asynchronous',
           dataType:'text',
           success:function(data)
           {
			  harms = data.split('::')
			  process_circular(harms, CCID, target_cat)
		   }
		})
	};
	
	
	function process_failure_modes(failure_modes)
	{

			cascade = [] // clear the cascade
			reset_registry();

			clear_tray('fmode');
			clear_tray('hazard');
			clear_tray('situation');
			clear_tray('harm');

			fill_tray('fmode');

			// get back 4 failure modes
			// failure_modes = generate_failure_modes();
			// console.log('returned_modes:', failure_modes);

			// add them to the dataframe
			jQuery.each(failure_modes, function(i, line)
			{
				console.log('line:', line)
			  	bits         = line.split('||')
				val          = bits[0]
				probability  = bits[1]
				probability = Number(probability)

				cell_parent = 0;
				category    = "fmode";
				contents    =  val;
				selected_child = 0;

				dblen = db.length;
				ccid = dblen;

				if(i <= 4)
				{
					newrow = [ccid, cell_parent, category, contents, selected_child, probability];
					db.push(newrow);
	
					// xdata is a placeholder needed beause other calls to place_cell use it
					current_fm  = contents
					current_hz  = ''
					current_sit = ''
					xdata = [current_fm, current_hz, current_sit]

			        place_cell(newrow, xdata);
				}
				numcells = num_cells['fmode']
				if(i > (numcells - 2)) { return false; }

	            // df = new dfd.DataFrame(db);
            	// df.print();
			});
			$('#fmode_span').css("border", "white");

			// ? WHITE
			// $('#fmode').css("border", "2px solid white");
	};
	
	
	function place_cell(celldata, xdata)
	{
		current_fm  = xdata[0]
		current_hz  = xdata[1]
		current_sit = xdata[2]

		ccid           = celldata[0];
		cell_parent    = celldata[1];
		category       = celldata[2];
		contents       = celldata[3];
		selected_child = celldata[4];

		pfactor = 300
		if(category == "fmode")    { pfactor = 800; }
		if(category == "harm")     { pfactor = 500; }
		if(category == "situation"){ pfactor = 800; }
		console.log('--------->', category, pfactor)

		probability    = celldata[5];
		console.log('prob 1:', probability)

		probabiltiy    = Number(probability)

		probability = probability * pfactor
	    if(probability < 1) { probability = "10"; }
		if(probability >= 100)
		{
			probability = 99
		}
		probability = (Math.round(probability * 100) / 100).toFixed(6)
		probability = probability.replace(/0\./, '')
		if(probability == "00") { probability = "0"; }
		probabiltiy    = String(probability)
		probability    = probability.substring(0,2)

		transition_endpoint = Number(probability)
		if(transition_endpoint < 80) { transition_endpoint = transition_endpoint + 5 }
		transition_endpoint = String(transition_endpoint)

		probability = probability.replace('.', '')
		transition_endpoint = transition_endpoint.replace('.', '')

		probability    = probability+'%'
		fade           = transition_endpoint+'%'
		console.log('prob 2:', probability)

		severity = ''
		sev_id   = "sev_"+ccid
		severity = ''; // for the non-harm cases
		if(category == "harm")
		{
			// for the game, cuz severity is bound to harm and can't be known in advance
			//-------------------------------------------------------------------------//
            //severity = '<img src=Images/tiny_spinner.gif></img>'                     //
            //get_severity_for(contents, sev_id)                                       //
			//-------------------------------------------------------------------------//

			//parts = contents.split('||');
			//if(parts.length > 0)
			//{
				//contents = parts[0]
				//severity = parts[1]
			//}
			//bits = contents.split(/-----/)
			bits        = contents.split('||')
			contents    = bits[0]
			severity    = bits[2]
		}
		else
		{
			bits        = contents.split('||')
			contents    = bits[0]
		}

		barletleft = '<div class="bookend_left"></div>'
		barletright = '<div class="bookend_right"></div>'

		severity_box = '<div class="severity_box">'+severity+'</div>'
		content_box = '<div class="content_box">'+contents+severity_box+'</div>'

		//ppp = '60%'
		//pplus = '68%'
		//endpoint = '100%'
        pline = '<br><input class="probbar" type="button" style="background: linear-gradient(to right, #c19a6b, '+probability+', tan, '+fade+', #FFFFFF)"; padding:3px; float:right;" value=""></input>'
		if(category == "harm")
		{
//		   pline = '<br><input class="probbar" type="button" style="height:18px; background: linear-gradient(to right, steelblue, '+probability+', steelblue, '+fade+', #FFFFFF)"; padding:3px; float:right;" value="'+probability+'"></input>'
		}
		if(category == "hazard")
		{
//		   pline = '<br><input class="probbar" type="button" style="height:15px; background: linear-gradient(to right, steelblue, '+probability+', lightblue, '+fade+', #FFFFFF)"; padding:3px; float:right;" value=""></input>'
		}
		if(category == "situation")
		{
//		   pline = '<br><input class="probbar" type="button" style="height:11px; background: linear-gradient(to right, steelblue, '+probability+', steelblue, '+fade+', #FFFFFF)"; padding:3px; float:right;" value=""></input>'
		}
//		//if(category == "harm") { }

		divcode = ('<div class="shell">'
		                +'<div  class="cell" name="'+ccid+'" id="'+ccid+'">'
				            +content_box
							+pline
							+'</p>'
				       +'</div>'
				   +'</div>');

		dlocation = '#'+category+'_span'

		current_contents = $(dlocation).html();
		new_contents     = current_contents + divcode;
		$(dlocation).html(new_contents);

		cascade[ccid] = 1 // add it to the cascade to it doesn't get placed twice
	}


	// CELL INTERACTIONS
	$(document).on('mouseenter', '.shell', function(event) 
	{ 
	});

	$(document).on('mouseleave', '.shell', function(event) 
	{ 
	});

	$(document).on('mouseenter', '.cell', function(event) 
	{ 
		$(this).css("border-bottom", "1px solid tan");
		$(this).css("border-top", "1px solid tan");
	});
	$(document).on('mouseleave', '.cell', function(event) 
	{ 
		$(this).css("border-bottom", "1px solid white");
		$(this).css("border-top", "1px solid white");
	});


	//// CLICK ////
	$(document).on('click', '.cell', function(event) { clickme(this.id); });

	// put the action in a separate function so it
	// can be accessed without clicking

	function clickme(this_id)
	{
		// if(scored === 1) { return; }
	    // clear all answer values on every click, regardless of other logic

		// THESE HOLD THE ANSWERS FOR GAMES
	    //$('#answers_fmode_div').css('visibility', 'hidden');
	    //$('#answers_hazard_div').css('visibility', 'hidden');
	    //$('#answers_situation_div').css('visibility', 'hidden');
	    //$('#answers_harm_div').css('visibility', 'hidden');

		var cleared_cats = new Array();

		// THIS IS THE ONE THAT WAS CLICKED ON
		selected_cell  = this_id

		celldata       = db[selected_cell];
		CCID           = celldata[0];
		cell_parent    = celldata[1];
		category       = celldata[2];
		contents       = celldata[3];
		selected_child = celldata[4];

		target_cat = targets[category]
		target_div_id = '#'+target_cat+'_span'
		target_capture_id = '#captured_'+target_cat

		// tell the parent that this is now the selected child
		// and reset higlights
		db[cell_parent][4] = CCID
		reset_highlights(0);

		// clear the target tray and any tray after it
		// target cat will automatically get regenerated below
		// but subsequent categories only get generated if
		// something is selected that points to them
		$(target_div_id).html('');
		$(target_capture_id).html('');

		// if target_cat is situation, also clear harm
		if(target_cat == 'situation')
		{
			clear_tray('harm')
			cleared_cats.push('harm');
		}
		// if target_cat is hazard, also clear harm and situation
		if(target_cat == 'hazard')
		{
			clear_tray('harm')
			clear_tray('situation')
			cleared_cats.push('harm');
			cleared_cats.push('situation');
		}

		// find out if it has any pre-generated children of its own
		var res  = $.grep(db, function(v,i) { return v[1] === CCID; });
		reslen   = res.length;
		circular = res          // this is an initial value that will be replaced below if appropriate

//---------------------------------------


		current_fm  = ''
		current_hz  = ''
		current_sit = ''
		if(target_cat == "hazard") // clicking on failure mode
		{
			statement  = db[cell_parent][3]
			current_fm = contents

			cfmlist = current_fm.split('|')
			cfm = cfmlist[0]

			// generate the contents if needed
			if(reslen <= 0) { circular  = generate_hazards(statement, cfm, CCID, target_cat) }
		}
		else if(target_cat == "situation") // clicking on hazard
		{
			grandparent = db[cell_parent][1]
			statement   = db[0][3]
			current_fm  = db[cell_parent][3]
			current_hz  = contents

			cfmlist = current_fm.split('|')
			cfm = cfmlist[0]

			chzlist = current_hz.split('|')
			chz = chzlist[0]

			// generate the contents if needed
			if(reslen <= 0) { circular  = generate_situations(statement, cfm, chz) }
		}
		else if(target_cat == "harm") // clicking on hazard
		{
			grandparent       = db[cell_parent][1] // hazard
			great_grandparent = db[grandparent][1] // fmode
			statement         = db[0][3]
			current_fm        = db[grandparent][3]
			current_hz        = db[cell_parent][3]
			current_sit       = contents

			// generate the contents if needed
			cfmlist = current_fm.split('|')
			cfm = cfmlist[0]

			chzlist = current_hz.split('|')
			chz = chzlist[0]

			csitlist = current_sit.split('|')
			csit = csitlist[0]

			if(reslen <= 0) { circular  = generate_harms(statement, cfm, chz, csit) }
		}
	
		/// DISPLAY CHILDREN IN TARGET CATEGORY
		if(reslen > 0) // displaying previously existing cells
		{
			jQuery.each(res, function(i, val)
			{
				xdata = [current_fm, current_hz, current_sit]
				place_cell(val, xdata);
			});
		}
		else
		{
			// new ones are being handled by the ajax call that recieves the data
			// so reslen is always > 0
		}
		clicked = reset_highlights(0);
		fill_tray(target_cat)

		// check to see if the save button should be enabled
		cansave = check_choices()
		if(cansave == 1) 
		{ 
			//$('#save_choices').prop('disabled', false); 
            $('#begin').prop('disabled', false);
		}
		else { $('#save_choices').prop('disabled', true); }
	};
	
	function reset_highlights(doeval)
	{
		// unhighlight all cells
		clicked = []
		$('.cell').each(function(i, obj) 
		{
			this_celldata       = db[this.id];
			THIS_CID            = this_celldata[0];
			this_cell_parent    = this_celldata[1];
			this_category       = this_celldata[2];
			this_contents       = this_celldata[3];
	
			this_parent_data    = db[this_cell_parent]
			this_selected_child = this_parent_data[4]

			$(this).css("background-color", "white");
			if(this_selected_child == THIS_CID)
			{
				$(this).css("background-color", "#e3dac9");
				clicked.push(this.id);
				capture_div_id = '#captured_'+this_category

			    bits = this_contents.split('||')
				if(this_category == 'harm')
				{
					cap_value = bits[0]
			    	$(capture_div_id).html(cap_value);
				}
				else
				{
					cap_value = bits[0]
			    	$(capture_div_id).html(cap_value);
				}
			}
			else
			{
			console.log("NOT SEL")
			}
		});
		return(clicked);
	}
	
	function check_choices()
	{
		captured_fmode     = $('#captured_fmode').html();
		captured_hazard    = $('#captured_hazard').html();
		captured_situation = $('#captured_situation').html();
		captured_harm      = $('#captured_harm').html();
		filled = 1
		if(captured_fmode === '') { filled = 0; }
		if(captured_hazard === '') { filled = 0; }
		if(captured_situation === '') { filled = 0; }
		if(captured_harm === '') { filled = 0; }

		if(filled === 1)
		{
			clicked = reset_highlights(1); // 1 for doeval
			//$('#score').html(score);
			$('#console').css('visibility', 'visible');
			scored = 1;
		}
		return(filled)
	}
	
	function process_circular(circular, CCID, target_cat)
	{
		// circular = curcular.slice(0, 8);
		jQuery.each(circular, function(i, val)
		{
			my_cell_parent    = CCID;
			my_category       = target_cat;
			my_contents       = val;

			bits        = val.split('||')
			probability = bits[1]

			my_selected_child = 0;

			dblen   = db.length;
			childid = dblen;


			// deal with unwanted data
			skip = 0
			if(my_category == 'harm')
			{
				//console.log('harm')
			}
			if(my_category == "hazard") // unwanted hazards
			{
			}
			if(i <= 4)
			{
				newrow = [childid, my_cell_parent, my_category, my_contents, my_selected_child, probability];
				db.push(newrow);
				xdata = [current_fm, current_hz, current_sit]
				celldata = newrow
	    		place_cell(newrow, xdata);
			}

			numcells = num_cells[my_category]
			if(i > (numcells - 2)) { return false; }
		});
		divname = '#'+target_cat+'_span'
	}
</script><!--------------------------------------------------------------------------------->
<!------------------------------Step 3: html layout ------------------------------->
<!--------------------------------------------------------------------------------->

</head>

<body style="height:100%;">



<div class="Trace_Directory" style="text-align:left; margin-top:5px;">
<td>&nbsp;</td>  <!-- Home / Architecture / AI Search(ML2)-->
</div>

<!-- new HTML -->
<div class="container">		<!-- Bootstrap: a responsive fixed width container -->

<div  style="margin-top:40px;">  	<!--class="col-sm-12 col-md-12"-->	
	<ul class="nav nav-pills mb-3" id="pills-tab-main" role="tablist">
			  				<!--bootstrap: class "active" shows the current page by background color bule-->
			  				<!--class="nav nav-pills" creates horizontal pills/tabs  -->
			  				<!--data-toggle defines its class (e.g pill)  -->
		<li class="nav-item-main  active">
		<a class="nav-link btn text-first-btn" id="pills-Text-tab" data-toggle="pill" href="#pills-Text" role="tab" aria-controls="pills-Text">Risk Analysis</a>
		</li>
		
		<li class="nav-item-main">
		<a class="nav-link btn graph-second-btn" id="pills-Graph-tab" data-toggle="pill" href="#pills-Graph" role="tab" aria-controls="pills-Graph">Root Cause Analysis</a>
		</li>
		
		<li class="nav-item-main">
		<a class="nav-link btn graph-third-btn" id="pills-Graph-tab" data-toggle="pill" href="#pills-Graph" role="tab" aria-controls="pills-Graph">Doc Remediation</a>
		</li>
		
		<li class="nav-item-main">
		<a class="nav-link btn graph-fourth-btn" id="pills-Graph-tab" data-toggle="pill" href="#pills-Graph" role="tab" aria-controls="pills-Graph">Risk Audit</a>
		</li>
		
		<li class="nav-item-main">
		<a class="nav-link btn graph-fifth-btn" id="pills-Graph-tab" data-toggle="pill" href="#pills-Graph" role="tab" aria-controls="pills-Graph">Risk Training</a>
		</li> 
	</ul>
	

			
	<div style="width:100%; margin-top:10px;">	<!--class="tab-content"-->	
		<div aria-labelledby="pills-Text-tab"> <!--id="pills-Text"  class="tab-pane fade in active"-->
		<div class="row tab-main-content">		<!-- the most outer frame, control outside border line thick -->
				
		<!-------Section 3.3.1: Left zone, inpurequirementsds) ----------------->							
		<div class="col-sm-12 col-md-3" style="margin-left:-15px;">
					<!--class="col-sm-12" Column sizing:  col-md-6;  column-sizeofdevice-widths; two device types-->
					<!--for small device, use the div displays full screen-->
					<!--for medium device, use the div displays half screen-->
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">	
					<!--style.css  font-size  control 2nd right outer block through ID class-->
					<!--class="nav nav-pills" creates horizontal pills/tabs  -->
					<!-- assitance only: role="tab" aria-controls="pills-text1" aria-selected="true"-->
					<!--class="nav-item active" used to congtrol the features after clicked  -->	  	
				  	<!-- Bootstrap: dropdown-toggle class (indication);  -->
				  	<!-- Open the dropdown: link a class .dropdown-toggle, attribute data-toggle="dropdown" -->
				  	<!-- help the accessiblity: role="xx", aria-*  role="button" aria-haspopup="true" aria-expanded="false"-->
				  	<!-- dat-toggle defines its class -->
				  	<!-- data-toggle="pill" controls to highlight the element if clicked-->
				<li style="height:28px;margin-top:-13px; padding-top:13px; padding-left:50px; position:absolute;"><span>STATEMENTS</span></li> 	
				
				<li class="nav-item" style="height: 28px; margin-top:-13px;">
					<a class="nav-link" id="pills-list-text3-tab" data-toggle="pill" href="#pills-list-text3" role="tab" aria-controls="pills-list-text3" aria-selected="false"></a> <!--push bottom-link down-->
				</li>
							  								  					  	
			</ul>

			<!--3.2: select one option from left title, hints rest of inputs in the field -->	
		<div class="tab-content" id="pills-tabContent"> 
			
				<!--3.2.1: select one a requirement  fade in active-->
			<div class="tab-pane fade in active" role="tabpanel">
                <div class="search-box" style="margin-left:5px;">
					<textarea style="width:95%;text-align:justify;resize:none;" cols="40" name='senbox' id='senbox' maxlength="5000" rows="10" placeholder="Type sentence(s) here."></textarea> 
                	<div class="result"></div>
                </div>                   
                   <!-- <i class="fa fa-microphone"  data-placement="bottom"></i> -->
				<div class="char-main-count" >
					<span id="id_char_count"></span><span> / 1,000 </span>
				</div>
					
					<!-- clear button 'x'-->
				<i id="id_icon_reset" class="blue_color icon_size20" style="margin-top:10px; margin-right:5px;" rel="tooltip" html="true" data-placement="top" onclick="resetCharacterCount();focusTextArea();" title="Clear"><i class="fa fa-times" aria-hidden="true"></i></i>
			</div>
												
		</div>
	</div>

					  	<!-- submit button -->							
		<!------Section 3.3: Right zone (titles, output fields) ------------------>
		
		<!--3.3.1: display right zone (highlight selected title option, display searched results, bar+scar, pencil, page scroll>-->	
	<div class="col-sm-12 col-md-9" style="margin-left:-30px;">
		<ul class="nav nav-pills mb-3" id="pills-list-tab" role="tablist">	<!--style.css  font-size  control 2nd right outer block col-sm-12 col-md-6-->
		
						  	<!-- submit button -->
			<li class="right-arr-submit" style="height: 22px; margin-top:-7px;"> <!-- style.css, control color and size style="margin-left:25px;"-->
			<button type="submit" class="submit-arr" style="margin-left:-100px;"><i class="fa fa-chevron-right" aria-hidden="true" title="Parse Button"></i></button>
			</li>
			
			<li class="Select_DocType" style="height: 28px; margin-top:-13px; margin-left:20px;">
			<span id="output_type" class="Select_DocType_Bottomline";>Failure_Mode</span>
			</li>
			
				
			<li class="Select_DocType" style="height: 28px; margin-top:-13px; margin-left:80px;">
			<span id="output_type" class="Select_DocType_Bottomline";>Hazard</span>
			</li>
			  
			<li class="Select_DocType" style="height: 28px; margin-top:-13px; margin-left:80px;">
			<span id="output_type" class="Select_DocType_Bottomline";>H._Situation</span>
			</li>  
			  
			<li class="Select_DocType" style="height: 28px; margin-top:-13px; margin-left:80px;">
			<span id="output_type" class="Select_DocType_Bottomline";>Harm_Severity</span>
			</li>  				  				  				  				  				  		  			  			
		</ul>
				
		<!--2.2: display the predicting -->			
		<div class="tab-content" id="pills-list-tabContent" style="background-color:#f2f2f2;margin-right:-60px;">					
			<!--2.2.1: output to up table of failure modes -->
			<div class="tab-pane fade in active" id="pills-list-text1" role="tabpanel" aria-labelledby="pills-list-text1-tab">
			 <span id="result_counter"></span>			 
				<table id="top_table" class="example table table-striped table-bordered" style="width:100%;">
		        	<tr>
  	    				<td name="fmode"     style="height: 608px; width:250px;"><div style="height:608px; overflow-y:auto;" id="fmode_span"></div></td>
  	    				<td name="hazard"    style="height: 608px; width:250px;"><div style="height:608px; overflow-y:auto;" id="hazard_span"></div></td>
      					<td name="situation" style="height: 608px; width:250px;"><div style="height:608px; overflow-y:auto;" id="situation_span"></div></td>
      					<td name="harm"      style="height: 608px; width:250px;"><div style="height:608px; overflow-y:auto;" id="harm_span"></div></td>
					</tr>   
				</table>
			</div>																		
		</div>												
	</div>   	<!-- right top window --> 
	
	</div> 						
	</div>
				
	</div>		<!-- Right two tables (title, data input) -->		
	</div> 		<!-- close the outer frame -->
	  
	
<div style="margin-top:5px;font-style:italic; float:right;"><a href="#" onclick="hint_submit()" style="color:grey;">Hints</a></div>
<div style="margin-top:5px;font-style:italic; float:right; margin-right:15px;"><a href="#" onclick="feedback_submit()" style="color:grey;">Feedback</a></div>
<div style="margin-top:5px;font-style:italic; float:right; margin-right:15px;"><a href="#" style="color:grey;" class="video" data-name='risk-discovery'>Demo</a></div>
<!--div style="margin-top:5px;font-style:italic; float:right; margin-right:15px;"><a href="#" onclick="privacy_submit()" style="color:grey;">privacy</a></div-->	
</div>		<!-- close top "class=container" -->					
				
<footer>

<!--------------------------------------------------------------------------------->
<!------------------------------Step 4: popup window------------------------------->
<!--------------------------------------------------------------------------------->
<!---------when clicked on pencil to add a new result (eg. failure mode) ---------->
              

<div class="modal fade" id="hintuploadpane" role="dialog" aria-labelledby="hintuploadpane" aria-hidden="true" style="margin-top:30px;">
  <div class="modal-dialog modal-lg" role="document" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel" style="margin-top:10px; color:darkgreen;">The purpose of this engine helps to explore and rank potential risks based on your inputs. </h5>
      </div> <!-- modal header -->
      <div class="modal-body">
         		                  <div id="hinttable" style=""> </div>
	  </div> <!-- modal body --> 
      
	</div>   <!-- modal-content -->
  </div>     <!-- modal-dialog -->
</div>       <!-- modal_fade -->

<div class="modal fade" id="feedbackuploadpane" role="dialog" aria-labelledby="feedbackuploadpane" aria-hidden="true" style="margin-top:30px;">
  <div class="modal-dialog modal-lg" role="document" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Feedback:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> <!-- modal header -->
      <div class="modal-body">
         		                  <div id="feedbacktable" style=""> </div>
	  </div> <!-- modal body --> 
      
	</div>   <!-- modal-content -->
  </div>     <!-- modal-dialog -->
</div>       <!-- modal_fade -->


<div class="modal fade" id="privacyuploadpane" role="dialog" aria-labelledby="privacyuploadpane" aria-hidden="true" style="margin-top:30px;">
  <div class="modal-dialog modal-lg" role="document" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Privacy Policy: <br>We want you to understand the types of information we collect as you use our services</h5>
      </div> <!-- modal header -->
      <div class="modal-body">
         		                  <div id="privacytable" style=""> </div>
	  </div> <!-- modal body --> 
      
	</div>   <!-- modal-content -->
  </div>     <!-- modal-dialog -->
</div>       <!-- modal_fade -->
		

</body>
</html>
<!-- END  HTML -->
         

<style>
	.RdQCC_Button_Small{ 
			font:100 12px/18px Tahoma, Geneva, sans-serif; color:#696969;
			padding: 2px 12px 3px 12px;
			/* background:url(overlay.png) repeat-x center #a7dd32; */
			background-color: rgba(255,255,255,1.00);/*rgba(91,173,255,1);*/
			border:1px solid #aaa;
			-moz-border-radius:24px; -webkit-border-radius:24px; border-radius:24px;
			/*rder-bottom:1px solid #aaa;
			-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5); -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5); box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);*/
			cursor:pointer;
		}
	/*.RdQCC_Button_Small:hover{background-color:rgba(91,173,255,0.6); color:#F60; cursor:pointer;}	*/
	.RdQCC_Button_Small:hover{background-color:#ccdde5; color:#F60; cursor:pointer;}
	
	/*.RdQCC_Button_Small:active{position:relative;top:1px;} */
	
</style>

