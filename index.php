<?php include 'lib/constants.php'; ?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Notes - by vinigomescunha</title>
</head>
<body>
	<div class="row top large-12">
		<div class="large-8 medium-8 columns">
			<h3>Notes Elasticsearch, PHP and JQuery Example</h3>
			<div class="callout">
				<div id="container" class="row">
					<div class="large-4 medium-4 columns">
						<p> Welcome </p>
					</div>
				</div>
				<ul id="pagination" class="pagination"></ul>
			</div>
		</div>
		<div class="large-4 medium-4 columns">
			<h5>Add a new note:</h5>
			<div class="callout">
				<p><form id="send">
					<label>Title</label>
					<input type="text" id="title" placeholder="Title here...">
					<label>Note</label>
					<textarea id="text" placeholder="Write here..."></textarea>					
				</p>
				<button class="float-right small button">Send</button>
			</form>
			<form id="search">
				<input type="text" id="search" placeholder="Search...">
			</form>
		</div>
	</div>
</div>
</div>
<!--Foundation css see http://foundation.zurb.com/ -->
<link rel="stylesheet" href="vendor/foundation/css/foundation.css" />
<link rel="stylesheet" href="vendor/foundation/css/app.css" />
<link rel="stylesheet" href="vendor/foundation/css/custom.css" />
<!--jquery http://jquery.com/ -->
<script src="vendor/jquery/jquery.min.js"></script>
<!--Sweetalert see http://t4t5.github.io/sweetalert/ -->
<link rel="stylesheet" href="vendor/sweetalert/css/sweetalert.css" />
<script src="vendor/sweetalert/js/sweetalert-dev.js"></script>
<script>
defHost = "<?php echo DEFAULT_HOST; ?>";
defIndex = "<?php echo INDEX; ?>";
defType = "<?php echo TYPE; ?>";
page=0;
params = {size:<?php echo PER_PAGE; ?>};//per page items list
</script>
<script src="js/main.js"></script>
</body>
</html>
