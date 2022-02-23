<?php
  session_start();
  include 'class.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>

<body>
  <?php
  if(isset($_SESSION["login"]) && $_SESSION["login"] != ""){


   ?>
<a href="log.php">Logout</a>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->


<head>
<meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />

<script>try{Typekit.load({ async: true });}catch(e){}</script>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'><link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>

 <link rel="stylesheet" href="asssets/css/style.css">
</head><body>
  <div class="group">
    <input type="text" name="Gname" class="Gname" placeholder="name"><br>
    <input type="text" name="Gpw" class="Gpw" placeholder="pass"><br>
    <?php
    $obj = new main();
    $obj->showMembers();
     ?>
     <input type="button" name="sub" id="Gsub_create" value="Create">

  </div>
<!--

A concept for a chat interface.

Try writing a new message! :)


Follow me here:
Twitter: https://twitter.com/thatguyemil
Codepen: https://codepen.io/emilcarlsson/
Website: http://emilcarlsson.se/

-->

<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
				<p>
          <?php echo $_SESSION["login"]?></p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>

				<div id="expanded">
					<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mikeross" />
					<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="ross81" />
					<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mike.ross" />
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts">
			<ul  class="groups_contacts"></ul>
		</div>
		<div id="bottom-bar">
			<button id="addcontact" class="addgroup"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add Group</span></button>
			<button id="settings" class="commandline"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Commandline</span></button>
      	<button id="data" class="datas"><i class="fa fa-cog far fa-clone" aria-hidden="true"></i> <span>Data</span></button>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
      <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p class="nameGroup">Commandline</p>
			<div class="social-media">
				<i class="fa fa-facebook" aria-hidden="true"></i>
				<i class="fa fa-twitter" aria-hidden="true"></i>
				 <i class="fa fa-instagram" aria-hidden="true"></i>
			</div>
		</div>
		<div class="messages">
			<ul class="messagesUL"></ul>
		</div>
    <div class="message-input">
			<div class="wrap">
        <form   onsubmit="return false" method="post">


			<input type="text" id="type"  class="idosss" placeholder="Write your message..." />

			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>

      <button class="submit" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
<input type="file" name="zip_file" class="idoss" placeholder="Write your message..." />
      <!--<input type="button" name="submit" value="Upload" onclick="uploadZip()" />-->
        </form>
			</div>
		</div>
	</div>

</div>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://code.jquery.com/jquery-2.2.4.js'></script>
<script >$(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");

	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};

	$("#status-options").removeClass("active");
});



//# sourceURL=pen.js
</script>
<script>

</script>
<div class="readid"></div>
<div class="groupSelected"></div>
<script src="asssets/js/master.js" charset="utf-8"></script>

<?php
}else{
  echo '<a href="login.php">Login</a>';
}
 ?>


</body>

</html>
