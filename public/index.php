<?php
 require('config.php');
 $err = '';
 if(isset($_REQUEST['action']) and ($_REQUEST['action']=='order_upgrade') and isset($_REQUEST['domain']) and !empty($_REQUEST['domain'])){
    if(isset($_SESSION['email']) and !empty($_SESSION['email'])){
        $output = Functions::formOrderRequest($_POST,$_SESSION['email']);
        Functions::sendOrderMain(Constants::$ADMIN_URL,"New Order",$output);
        $err = "Order created. Our manager will contact you shortly.";
    }else{
        $err = "Registration required";
    }
 }
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>SEOTools</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
        <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.dropotron.min.js"></script>
        <script src="js/jquery.scrollgress.min.js"></script>
        <script src="js/jquery.scrolly.min.js"></script>
        <script src="js/jquery.slidertron.min.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-layers.min.js"></script>
        <script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="landing">

		<!-- Header -->
			<header id="header" class="alt skel-layers-fixed">
				<h1><a href="index.php">SEOTools</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
                        <?php if(!isset($_SESSION['email'])){ ?>
						<li>
							<a href=""  class="icon fa-angle-down">Sign IN</a>
							<ul id="submenu" style="display:none;" onclick="event.stopPropagation();" class="menuform">
								<li><input type="text" placeholder="Email" name="loginlogin" value="" class="head_input" id="loginlogin" /></li>
								<li><input type="password" placeholder="Password" name="loginpass" class="head_input" value="" id="loginpass" /></li>
                                <li><button onclick="loginUser()" class="button special fit" style="line-height: 3.5em;margin-top:10px;">Sign In</button></li>
							</ul>
						</li>
                        <li>
                            <a href="#signup" class="icon ">Sign UP</a>

                        </li>
                        <?php }else{ ?>
                        <li>Welcome, <?=$_SESSION['email'];?></li>
                            <li><a href="?logout" >Logout</a></li>
                        <?php } ?>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner" >
				<div class="inner"  align="center">
					<h2>SEOTools</h2>
					<p>Complex Tool for Site Analytics</p>
                    <?php if(!isset($_SESSION['email'])){ ?>
                        <ul class="actions">
                            <li><a  href="#signup" class="button big ">Free Registration</a></li>
                        </ul>
                    <?php }else{ ?>
                    <input type="text" name="test_url" id="test_url" value="" style="width:40%;border:1px solid #fff;color:#fff" placeholder="http://yoursite.com"/><br>
					<ul class="actions">
						<li><a id="run_test" href="#" onclick="runTest();" class="button big ">Run Test</a></li>
					</ul>
                    <?php } ?>
				</div>
			</section>
            <section id="results_container" style="display:none;" class="wrapper style1" >
                <h2 align="center" >Site Test Results:</h2>
                <form  id="order_form" method="POST" action="">
                    <input style="display:none;" type="hideen" name="action" value="order_upgrade"/>
                    <input style="display:none;" type="hideen" id="domain_value" name="domain" value=""/>
                    <div class="table-wrapper" style="width:80%;margin-left:10%;">
                        <table class="alt">
                            <thead>
                                <tr>
                                    <th>Option</th>
                                    <th width="10%">Result</th>
                                    <th>Comment</th>
                                    <th width="10%">Order</th>
                                </tr>
                            </thead>
                            <tbody id="test_res_container">

                            </tbody>
                        </table>
                    </div>
                </form>
            </section>
            <?php if(!isset($_SESSION['email'])){ ?>
            <section id="signup" >
                <div style="width:50%;margin-left:25%;margin-top:40px;"  class="menuform">
                    <h2 align="center">Registration</h2>
                    <div>Email:</div>
                    <div><input type="email" class="head_input" id="reglogin" /></div>
                    <div>Password</div>
                    <div><input type="password" class="head_input" id="regpass" /></div>
                    <div>Password Again</div>
                    <div><input type="password" class="head_input" id="regpass2" /></div>
                    <div><button onclick="createUser();return false;" class="button special fit" style="line-height: 3.5em;margin-top:10px;">Sign Up</button></div>
                </div>

            </section>
			<?php } ?>
		<!-- Footer -->
			<footer id="footer">
				<ul class="icons">
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
					<li><a href="#" class="icon fa-envelope"><span class="label">Envelope</span></a></li>
				</ul>
				<ul class="menu">
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Terms of Use</a></li>
					<li><a href="#">Privacy</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<span class="copyright">
					&copy; Copyright. SEOTools</a>
				</span>
			</footer>

	</body>
</html>
<?php
if(!empty($err)){ ?>
<script>alert('<?=$err;?>');</script>
<?php }
?>