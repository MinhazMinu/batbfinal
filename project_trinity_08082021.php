<?php
session_start();
$role = isset($_COOKIE['derbyrole']) ? $_COOKIE['derbyrole'] : false;
if (!$role) {
	header("location:index.html");
}

#error handler ..
error_reporting(error_reporting() & ~E_NOTICE);
#time zone setup..
date_default_timezone_set('Asia/Dhaka');

#db connection...
mysql_connect('localhost', 'root', '') or die('ERROR: ' . mysql_error());
mysql_select_db('bat_ob') or die('ERROR: ' . mysql_error());
$sl = $_POST['sl'];

if ($sl) {
	$searchquery = mysql_query("SELECT * FROM project_trinity_08082021 WHERE sl='$sl'");
	$rowupdata = mysql_fetch_array($searchquery);
}
mysql_close();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Bat Outbound</title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/bootstrap.min.js"></script>



</head>

<body>
	<nav class="navbar navbar-default crmnav">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="../../img/logo.png" class="logo">
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="project_trinity_08082021.php">Home</a></li>

				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Administration
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../../campaignchoose.php">Change Campaign</a></li>
						<li><a href="../../pwdchangeform.php">Change Password</a></li>
					</ul>
				</li>

				<li class="dropdown" id="evaluate">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Report
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="project_trinity_08082021_evaluate.php">Call Evaluate</a></li>
						<li><a href="project_trinity_08082021_report.php">Report</a></li>
					</ul>
				</li>
			</ul>
			<h4 class="header">Project Kartos Campaign</h4>
			<h4 align="right" class="logout"><a href="../../logout.php"> <?php echo $_COOKIE['derbyusername']; ?></a></h4>
		</div>

	</nav>
	<div id="mainbody">

		<div class="container number" align="center">
			<form class="form-inline" action="" method="POST">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" id="sl" name="sl" placeholder="Serial Number">
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Search</button>
			</form>
		</div>
		<br />
		<div class="container">
			<div class="form-group col-md-3">
				<label for="">BR CODE</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['BRCode']; ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="">BR Name</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['BRName']; ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="">BR Brand</label>
				<input type="text" class="form-control" id="brBrand" placeholder="" readonly value="<?php echo $rowupdata['PrimarySmokingBrand']; ?>">
			</div>
			<div class="form-group col-md-3">
				<label for="">Contact date</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['ContactDate']; ?>">
			</div>
			<div class="form-group col-md-2">
				<label for="">Consumer Name</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['ConsumerName']; ?>">
			</div>
			<div class="form-group col-md-2">
				<label for="">Consumer Age</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['ConsumerAge']; ?>">
			</div>
			<div class="form-group col-md-2">
				<label for="">Consumer Brand</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['PrimarySmokingBrand']; ?>">
			</div>



			<div class="form-group col-md-2">
				<label for="">Swapping</label>
				<input type="text" class="form-control" id="Swapping" placeholder="" readonly value="<?php echo $rowupdata['Swapping']; ?>">
			</div>


			<div class="form-group col-md-2">
				<label for="">PTR</label>
				<input type="text" class="form-control" id="ptr_item_status" placeholder="" readonly value="<?php echo $rowupdata['PTRPurchase']; ?>">
			</div>
			<div class="form-group col-md-2">
				<label for="">PTR Item</label>
				<input type="text" class="form-control" id="" placeholder="" readonly value="<?php echo $rowupdata['ptr_item_status']; ?>">
			</div>


		</div>
		<br />
		<hr><br />

		<div class="container">
			<form action="project_trinity_08082021_submit.php" method="post">
				<div class="form-group col-md-3">
					<label for="">MSISDN</label>
					<input type="text" class="form-control" id="msisdn" placeholder="" name="msisdn" readonly value="<?php echo $rowupdata['ConsumerNumber']; ?>" required>
				</div>
				<div class="form-group col-md-3">
					<label for="">Serial</label>
					<input type="text" class="form-control" id="code" placeholder="" name="code" readonly value="<?php echo $rowupdata['sl']; ?>">
				</div>
				<div class="form-group col-md-3">
					<label for="">Name Verified</label>
					<select class="form-control" id="nameverified" name="nameverified">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="">Age Verified</label>
					<select class="form-control" id="ageverified" name="ageverified">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
						<option value="Under 18">Under 18</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label for="">Conducted By Representative</label>
					<select class="form-control" id="brcontact" name="cbr">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>

				<div class="form-group col-md-4">
					<label for="">Full flavoured smoke</label>
					<select class="form-control" id="full_flavoured_somke" name="full_flavoured_somke">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>

				<div class="form-group col-md-5">
					<label for="">Blueberry and lemon flavour</label>
					<select class="form-control" id="blueberry_and_lemon_flavour" name="blueberry_and_lemon_flavour">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>


				<div class="form-group col-md-3">
					<label for="">Consumer Primary Brand</label>
					<select class="form-control" id="current_primary_brand" name="current_primary_brand">
						<option value="">Select</option>
						<option value="B & H">B & H</option>
						<option value="Capstan">Capstan</option>
						<option value="Derby">Derby</option>
						<option value="Derby Style">Derby Style</option>
						<option value="Hollywood">Hollywood</option>
						<option value="JPGL">JPGL</option>
						<option value="Marise">Marise</option>
						<option value="Marlboro">Marlboro</option>
						<option value="Navy">Navy</option>
						<option value="Pilot">Pilot</option>
						<option value="Real">Real</option>
						<option value="Sheikh">Sheikh</option>
						<option value="Star">Star</option>
						<option value="Royals">Royals</option>
						<option value="Brighton">Brighton</option>
						<option value="Black">Black</option>
						<option value="Rally">Rally</option>
						<option value="Winston">Winston</option>
						<option value="Top 10">Top 10</option>
						<option value="Do not Smoke">Do not Smoke</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="form-group col-md-5" id="current_primary_brand_other_div" style="display: none;">
					<label for="">Other Brand</label>
					<input type="text" name="current_primary_brand_other" id="current_primary_brand_other" class="form-control" placeholder="">
				</div>
				<div class="form-group col-md-3">
					<label for="">Consumer Secondary Brand</label>
					<select class="form-control" id="current_secon_brand" name="current_secon_brand">
						<option value="">Select</option>
						<option value="B & H">B & H</option>
						<option value="Capstan">Capstan</option>
						<option value="Derby">Derby</option>
						<option value="Derby Style">Derby Style</option>
						<option value="Hollywood">Hollywood</option>
						<option value="JPGL">JPGL</option>
						<option value="Marise">Marise</option>
						<option value="Marlboro">Marlboro</option>
						<option value="Navy">Navy</option>
						<option value="Pilot">Pilot</option>
						<option value="Real">Real</option>
						<option value="Sheikh">Sheikh</option>
						<option value="Star">Star</option>
						<option value="Royals">Royals</option>
						<option value="Brighton">Brighton</option>
						<option value="Black">Black</option>
						<option value="Rally">Rally</option>
						<option value="Winston">Winston</option>
						<option value="Top 10">Top 10</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="form-group col-md-5" id="current_secon_brand_other_div" style="display: none;">
					<label for="">Other Brand</label>
					<input type="text" name="current_secon_brand_other" id="current_secon_brand_other" class="form-control" placeholder="">
				</div>

				<div class="form-group col-md-3">
					<label for="">Profession</label>
					<input type="text" name="profession" id="profession" class="form-control" placeholder="">
				</div>

				<div class="form-group col-md-3">
					<label for="">Job_Business_Study</label>
					<input type="text" name="job_business_study" id="job_business_study" class="form-control" placeholder="">
				</div>


				<div class="form-group col-md-3">
					<label for="">Express thanks</label>
					<select class="form-control" id="express_thanks" name="express_thanks">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>




				<div class="form-group col-md-3">
					<label for="">Call Status</label>
					<select class="form-control" id="callstatus" required name="callstatus">
						<option value="">Select</option>
						<option value="Ringing">Ringing</option>
						<option value="Not Reached">Not Reached</option>
						<option value="Call received">Call received</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label for="">Call Remarks</label>
					<select class="form-control" id="callremarks" required name="callremarks">
						<option value="">Select</option>
						<option value="Test">Test</option>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label for="">Call Check</label>
					<select class="form-control" id="chk_call" name="chk_call">
						<option value="">Select</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>


				<button type="submit" class="btn btn-primary btnsubmit col-sm-offset-5 col-md-2" id="btnsubmit">Submit</button>
			</form>
		</div>
		<br />
		<br />
		<div class="container-fluid navbar navbar-default foot">
			<h4 align="center">MIS & WFM</h4>
		</div>
	</div>


</body>

</html>

<script type="text/javascript">
	$(document).ready(function() {

		document.getElementById("full_flavoured_somke").disabled = true;
		document.getElementById("blueberry_and_lemon_flavour").disabled = true;
		document.getElementById("current_primary_brand").disabled = true;
		document.getElementById("current_secon_brand").disabled = true;
		document.getElementById("profession").disabled = true;
		document.getElementById("job_business_study").disabled = true;
		document.getElementById("express_thanks").disabled = true;


		$("#brcontact").change(function() {

			var el = $(this);
			var ageverified = $("#ageverified").val();

			if (el.val() == "Yes" && ageverified == "Yes") {

				document.getElementById("full_flavoured_somke").disabled = false;
				document.getElementById("full_flavoured_somke").required = true;

				document.getElementById("blueberry_and_lemon_flavour").disabled = false;
				document.getElementById("blueberry_and_lemon_flavour").required = true;


				document.getElementById("current_primary_brand").disabled = false;
				document.getElementById("current_primary_brand").required = true;



				$("#current_primary_brand").change(function() {

					var current_primary_brand = $("#current_primary_brand").val();
					if (current_primary_brand === "Do not Smoke") {

						document.getElementById("current_secon_brand").disabled = true;
						document.getElementById("profession").disabled = true;
						document.getElementById("job_business_study").disabled = true;
						document.getElementById("express_thanks").disabled = true;
						document.getElementById("current_primary_brand_other").disabled = true;
						document.getElementById("current_secon_brand_other").disabled = true;


					} else {

						document.getElementById("current_secon_brand").disabled = false;
						document.getElementById("current_secon_brand").required = true;

						document.getElementById("profession").disabled = false;
						document.getElementById("profession").required = true;

						document.getElementById("job_business_study").disabled = false;
						document.getElementById("job_business_study").required = true;

						document.getElementById("express_thanks").disabled = false;
						document.getElementById("express_thanks").required = true;



					}

				});



			} else {
				document.getElementById("current_primary_brand").disabled = true;
				document.getElementById("current_secon_brand").disabled = true;
				document.getElementById("profession").disabled = true;
				document.getElementById("job_business_study").disabled = true;
				document.getElementById("express_thanks").disabled = true;
			}



			if (el.val() !== "") {
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus").append("<option value=''>Select</option>");
				$("#callstatus").append("<option value='Call received'>Call received</option>");
			} else {
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus").append("<option value=''>Select</option>");
				$("#callstatus").append("<option value='Ringing'>Ringing</option>");
				$("#callstatus").append("<option value='Not Reached'>Not Reached</option>");
				$("#callstatus").append("<option value='Call received'>Call received</option>");
			}
		});

		$("#current_primary_brand").change(function() {

			var el = $(this);

			if (el.val() === "Other") {
				document.getElementById("current_primary_brand_other_div").style.display = 'block';
				document.getElementById("current_primary_brand_other").required = true;
			} else {
				document.getElementById("current_primary_brand_other_div").style.display = 'none';
				document.getElementById("current_primary_brand_other").required = false;
			}
		});


		$("#current_secon_brand").change(function() {

			var el = $(this);

			if (el.val() === "Other") {
				document.getElementById("current_secon_brand_other_div").style.display = 'block';
				document.getElementById("current_secon_brand_other").required = true;
			} else {
				document.getElementById("current_secon_brand_other_div").style.display = 'none';
				document.getElementById("current_secon_brand_other").required = false;
			}
		});


		/**/
		$("#callstatus").change(function() {

			var el = $(this);

			if (el.val() === "Ringing") {
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks").append("<option value=''>Select</option>");
				$("#callremarks").append("<option value='No Answer'>No Answer</option>");


			} else if (el.val() === "Not Reached") {

				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks option:last-child").remove();
				$("#callremarks").append("<option value=''>Select</option>");
				$("#callremarks").append("<option value='Mobile Off'>Mobile Off</option>");
				$("#callremarks").append("<option value='Invalid Number'>Invalid Number</option>");

			} else {

				if (($("#brcontact").val() === "") && ($("#callstatus").val() === "Call received")) {
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks").append("<option value=''>Select</option>");
					$("#callremarks").append("<option value='Call Received by Others'>Call Received by Others</option>");
					$("#callremarks").append("<option value='Call Later on'>Call Later on</option>");
					$("#callremarks").append("<option value='Not Interested'>Not Interested</option>");
				} else {
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks option:last-child").remove();
					$("#callremarks").append("<option value=''>Select</option>");
					$("#callremarks").append("<option value='Success'>Success</option>");

				}
			}
		});



	});
</script>

<script type="text/javascript">
	$(document).ready(function() {

		var x = "<?php echo $_SESSION["Role"] ?>";
		if (x === "User") {
			document.getElementById("evaluate").style.display = 'none';
			document.getElementById("newuser").style.display = 'none';
			document.getElementById("pwdreset").style.display = 'none';
		} else {
			document.getElementById("evaluate").style.display = 'block';
			document.getElementById("newuser").style.display = 'block';
			document.getElementById("pwdreset").style.display = 'block';
		}


		if ($("#msisdn").val() === "") {
			document.getElementById("btnsubmit").disabled = true;
		} else {
			document.getElementById("btnsubmit").disabled = false;
		}

	});

	$("#ageverified").change(function() {
		var el = $(this);
		if (el.val() === "Under 18") {
			document.getElementById("full_flavoured_somke").disabled = true;
			document.getElementById("blueberry_and_lemon_flavour").disabled = true;
			document.getElementById("current_primary_brand").disabled = true;
			document.getElementById("current_secon_brand").disabled = true;
			document.getElementById("profession").disabled = true;
			document.getElementById("job_business_study").disabled = true;
			document.getElementById("express_thanks").disabled = true;
		} else if (el.val() === "No") {
			if ($("#nameverified").val() === "No") {

				document.getElementById("brcontact").value = "No";

				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus").append("<option value=''>Select</option>");
				$("#callstatus").append("<option value='Call received'>Call received</option>");



			}
			document.getElementById("full_flavoured_somke").disabled = true;
			document.getElementById("blueberry_and_lemon_flavour").disabled = true;
			document.getElementById("current_primary_brand").disabled = true;
			document.getElementById("current_secon_brand").disabled = true;
			document.getElementById("profession").disabled = true;
			document.getElementById("job_business_study").disabled = true;
			document.getElementById("express_thanks").disabled = true;
		} else {

			document.getElementById("brcontact").value = "";
		}
	});

	$("#nameverified").change(function() {
		var el = $(this);
		if (el.val() === "No") {
			if ($("#ageverified").val() === "No" || $("#ageverified").val() === "Under 18") {
				document.getElementById("brcontact").value = "No";

				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus option:last-child").remove();
				$("#callstatus").append("<option value=''>Select</option>");
				$("#callstatus").append("<option value='Call received'>Call received</option>");

				document.getElementById("full_flavoured_somke").disabled = true;
				document.getElementById("blueberry_and_lemon_flavour").disabled = true;
				document.getElementById("current_primary_brand").disabled = true;
				document.getElementById("current_secon_brand").disabled = true;
				document.getElementById("profession").disabled = true;
				document.getElementById("job_business_study").disabled = true;
				document.getElementById("express_thanks").disabled = true;


			} else {
				document.getElementById("brcontact").value = "";
			}
		}
	});

	$("#callremarks").change(function() {
		var el = $(this);
		if (el.val() === "Success") {
			document.getElementById("nameverified").required = true;
			document.getElementById("ageverified").required = true;
			document.getElementById("brcontact").required = true;
		} else {
			document.getElementById("nameverified").required = false;
			document.getElementById("ageverified").required = false;
			document.getElementById("brcontact").required = false;
		}



		if (el.val() === "Mobile Off" || el.val() === "Invalid Number" || el.val() === "Call Received by Others" || el.val() === "Call Later on" || el.val() === "Not Interested" || el.val() === "No Answer") {
			document.getElementById("nameverified").disabled = true;
			document.getElementById("ageverified").disabled = true;
			document.getElementById("brcontact").disabled = true;
			document.getElementById("full_flavoured_somke").disabled = true;
			document.getElementById("blueberry_and_lemon_flavour").disabled = true;
			document.getElementById("current_primary_brand").disabled = true;
			document.getElementById("current_secon_brand").disabled = true;
			document.getElementById("profession").disabled = true;
			document.getElementById("job_business_study").disabled = true;
			document.getElementById("express_thanks").disabled = true;
		} else {
			document.getElementById("nameverified").disabled = false;
			document.getElementById("ageverified").disabled = false;
			document.getElementById("brcontact").disabled = false;

			document.getElementById("nameverified").required = true;
			document.getElementById("ageverified").required = true;
			document.getElementById("brcontact").required = true;
		}
	});
</script>