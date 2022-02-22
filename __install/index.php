<?php 
error_reporting(0);
session_start(); 

function checkExtension($name){
	if (extension_loaded($name)) {
		return true;
	}
	return false;
}

function folderPermission($name){
	$perm = substr(sprintf('%o', fileperms($name)), -4);
	if ($perm >= '0775') {
		return true;
	}
	return false;
}

function checkSqlVersion($dbinfo){
	$engine =  explode('-',$dbinfo);
	$version =  explode('.',$dbinfo);
	if(strtolower(@$engine[1]) == 'mariadb'){
		$res['engine'] = 'MariaDB';
		$res['version'] = @$version[0].'.'.@$version[1];
		if($res['version']<10.3){
			$res['error'] = true;
		}
	}else{
		$res['engine'] = 'MySQL';
		$res['version'] = @$version[0].'.'.@$version[1];
		if($res['version']<5.7){
			$res['error'] = true;
		}
	}
	return $res;
}

function appUrl(){
	$current = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
	$exp = explode('?action',$current);
	$url = str_replace('index.php','',$exp[0]);
	$url = substr($url,0,-8);
	return  $url;
}

function curlPostContent($url, $arr){
	$params = http_build_query($arr);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function getStatus($arr){
	$url = 'https://verify.thesoftking.com/install/request';
	$arr['product'] = 'jetescrow';
	$arr['server'] = $_SERVER;
	return curlPostContent($url,$arr); 
}

function acknowledgeInstall($val){
	$call = 'https://verify.thesoftking.com/install/done/';
	$arr['code'] = $val->installcode;
	return curlPostContent($url,$arr); 
}

function importDatabase($arr){
	$db = new PDO("mysql:host=$arr[db_host];dbname=$arr[db_name]", $arr['db_user'], $arr['db_pass']);
	$query = file_get_contents("database.sql");
	$stmt = $db->prepare($query);
	if ($stmt->execute()){
		return true;
	}
	return false;
}

function replaceCode($val,$arr){
	foreach ($arr as $key => $value) {
		$val = str_replace('{{'.$key.'}}', $value, $val);
	}
	return $val;
}

function setEnvironmentData($data,$location){
	$file = fopen($location, 'w');
	fwrite($file, $data);
	fclose($file);
}

function attemptInstall($response,$alldata){
	$alldata['key'] = base64_encode(random_bytes(32));
	setEnvironmentData(replaceCode($response->data->body,$alldata),$response->data->location);
	return true;
}

function setAdminEmail($alldata){
	$db = new PDO("mysql:host=$alldata[db_host];dbname=$alldata[db_name]", $alldata['db_user'], $alldata['db_pass']);
	$res = $db->query("UPDATE admins SET email='".$alldata['email']."', username='".$alldata['admin_user']."', password='".password_hash($alldata['admin_pass'], PASSWORD_DEFAULT)."' WHERE username='admin'");
	if ($res){
		return true;
	}
	return false;
}

$extensions = ['BCMath', 'Ctype', 'cURL','fileinfo', 'gd', 'gmp', 'JSON', 'Mbstring', 'OpenSSL', 'PDO','pdo_mysql', 'Tokenizer', 'XML'];

$folders = ['../core/bootstrap/cache/', '../core/storage/', '../core/storage/app/', '../core/storage/framework/', '../core/storage/logs/'];
$files = ['../install/database.sql', '../index.php', '../.htaccess', '../core/.env', '../core/composer.json', '../core/server.php'];
$action = isset($_GET['action']) ? $_GET['action'] : null;
$preloader = '';

$actions = [
	'php' => [
		'step'=> 1,
		'pageTitle'=>'PHP Version',
		'stepName'=>'PHP'
	],
	'extensions' => [
		'step'=> 2,
		'pageTitle'=>'PHP Extensions',
		'stepName'=>'Extensions'
	],
	'permissions'=>[
		'step'=> 3,
		'pageTitle'=>'Permissions',
		'stepName'=>'Permissions'
	],
	'files'=>[
		'step'=> 4,
		'pageTitle'=>'Files',
		'stepName'=>'Files'
	],
	'dbconfig'=>[
		'step'=> 5,
		'pageTitle'=>'Database Credential',
		'stepName'=>'Database'
	],
	'dbvalidate'=>[
		'step'=> 5,
		'pageTitle'=>'Validate Database',
		'stepName'=>'Database',
		'noStep' => true
	],
	'information'=>[
		'step'=> 6,
		'pageTitle'=>'Information',
		'stepName'=>'Information'
	],
	'complete'=>[
		'step'=> 7,
		'pageTitle'=>'Complete',
		'stepName'=>'Complete'
	]
];

function getStepTab($action){
	global $actions;
	$res = '';
	$actdata = isset($actions[$action]) ? $actions[$action] : null;
	if($actdata){
		$st = 0;
		$step = $actdata['step'];
		foreach($actions as $act){
			if(!isset($act['noStep'])){
				$step--;
				$st++;
				if($step>0){
					$class = 'active';
				}elseif($step == 0){
					$class = 'current';
				}else{
					$class = '';
				}
				$res .= '<li class="'.$class.'"><span class="level">'.$st.'</span> <span class="caption">'.$act['stepName'].'</span></li>';
			}
		}
	}
	return $res;
}
$pageTitle  = isset($actions[$action]['pageTitle']) ? $actions[$action]['pageTitle'] : ' Terms of Use';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>THESOFTKING Software Setup Wizard</title>
	<link rel="shortcut icon" type="image/png" href="https://verify.thesoftking.com/cdn/installassets/images/favicon.png">
	<link rel="stylesheet" href="https://verify.thesoftking.com/cdn/installassets/css/lib/bootstrap.min.css">
	<link rel="stylesheet" href="https://verify.thesoftking.com/cdn/installassets/css/line-awesome.min.css"> 
	<link rel="stylesheet" href="https://verify.thesoftking.com/cdn/installassets/css/main.css">
</head> 
<body>
	<header class="header">
		<div class="header-bottom">
			<div class="container-fluid">
				<div class="row justify-content-between align-items-center">
					<div class="col-lg-4 text-lg-start text-center">
						<img src="https://verify.thesoftking.com/cdn/installassets/images/logo.png" alt="main logo" class="site-logo">
					</div>
					<div class="col-lg-8 text-lg-end text-center mt-lg-0 mt-3">
						<h4 class="header-text">SOFTWARE SETUP WIZARD</h4>
					</div>
				</div>
			</div>
		</div>


		<?php
		if(isset($actions[$action])){
			if($action != 'complete'){
				$preloader = 'card--preloader';
			}
			?>
			<div class="step-area mt-4">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<ul class="step-tab">
								<?php echo getStepTab($action); ?>
							</ul>
						</div>
					</div>
				</div>
			</div> 

			<?php 
		}
		?>

	</header>
	<div class="main-wrapper">
		<section class="pt-100 pb-100">
			<div class="container">
				<div class="custom--card <?php echo $preloader; ?> ">
					<div class="card-header text-center">
						<h2><?php echo $pageTitle; ?></h2>
					</div>
					<div class="card-body">



						<?php
						if ($action=='complete') {
							echo '<div class="text-center">';
							if ($_POST) {
								$alldata = array_merge($_POST,$_SESSION['db']);
								$response = json_decode(getStatus($alldata));
								if ($response->error=='ok') {
									echo '<div id="hide"><h2 class="text--danger mb-5">Please check your database server! <br> Either your database server not responding or your credential is not valid.1<h2>
									<a href="?action=dbconfig" class="btn btn--warning preloader-btn"><i class="las la-arrow-left"></i> Go Back</a></div>';
									if(!importDatabase($alldata)){
										echo '<h2 class="text--danger mb-5">Please check your database server! <br> Either your database server not responding or your credential is not valid.2<h2>
										<a href="?action=dbconfig" class="btn btn--warning preloader-btn"><i class="las la-arrow-left"></i> Go Back</a>';
									}else{
										if(!attemptInstall($response,$alldata)){
											echo "<h2 class='text--danger'>An unexpected error occurred during the installation process. Please contact THESOFTKING TEAM for support.<h2>";
										}else{
											echo '<h2 class="text--success mb-5">Your system has been installed successfully!</h2>';
											if(setAdminEmail($alldata)){
												echo '<p class="text--success my-5"> <i class="las la-check"></i> Admin credential has been set successfully!</p>';
												acknowledgeInstall($response);
											}else{
												echo '<p class="text--danger my-5"> <i class="las la-times"></i> Admin credential has not been set!</p>';
											}
											echo '<div class="my-2">
											<p class="text--danger lead my-3">Please delete the "install" folder for security concerns.</p>
											</div>';
											echo '
											<div class="mt-5">
											<a href="'.appUrl().'" class="btn btn--base preloader-btn mb-3"> <i class="las la-globe"></i> Website <i class="las la-arrow-right"></i></a>
											<a href="'.appUrl().'admin" class="btn btn--warning preloader-btn mb-3"><i class="las la-cog"></i>  Admin Panel <i class="las la-arrow-right"></i></a>
											</div>';
										}
									}
								}else{
									echo $response->message;
								}
							}else{
								echo '<div class="text-center"><h2 class="text--danger mb-5">Something went wrong!<h2>
								<a href="?action=php" class="btn btn--warning preloader-btn"><i class="las la-arrow-left"></i> Go Back</a></div>';
							}
							echo '</div>';
							?>

							<?php
						}elseif($action=='information') {
							?>
							<form action="?action=complete" method="post">
								<div class="row justify-content-center">
									<div class="col-lg-12">
										<div class="row gy-4">
											<h6 class="form-title"><span>Application</span></h6>
											<div class="col-lg-6">
												<input type="text" name="app_url" class="form--control" placeholder="App URL" value="<?php echo appUrl(); ?>" required>
											</div>
											<div class="col-lg-6">
												<input type="text" name="file_path" class="form--control" placeholder="File Path" value="<?php echo str_replace('install/index.php','', $_SERVER['SCRIPT_FILENAME']) ; ?>" required>
											</div>
										</div>
										<div class="row gy-4 mt-5">
											<h6 class="form-title"><span>Purchase Verification</span></h6>
											<div class="col-lg-6">
												<input type="text" name="user" class="form--control" placeholder="Your username at THESOFTKING" required>
											</div>
											<div class="col-lg-6">
												<input type="text" name="code" class="form--control" placeholder="Your Purchase Code" required>
											</div>
										</div>
										<div class="row gy-4 mt-5">
											<h6 class="form-title"><span>Admin Credential</span></h6>
											<div class="col-lg-4">
												<input type="text" name="admin_user" class="form--control" placeholder="Admin username" required>
											</div>
											<div class="col-lg-4">
												<input type="text" name="admin_pass" class="form--control" placeholder="Admin Password" required>
											</div>
											<div class="col-lg-4">
												<input type="email" name="email" class="form--control" placeholder="Admin Email address" required>
											</div>
										</div>
									</div>
								</div>
								<div class="text-center mt-5">
									<button type="submit" class="btn btn--base preloader-btn"> Next Step <i class="las la-arrow-right"></i></button>
								</div>
							</form>
							<?php
						}elseif($action=='dbvalidate') {
							if($_POST){
								unset($_SESSION["db"]); 
								$_SESSION["db"] = $_POST;
							}
							$dbinfo = $_SESSION["db"];
							try{
								$db = new PDO("mysql:host=$dbinfo[db_host];dbname=$dbinfo[db_name]", $dbinfo['db_user'], $dbinfo['db_pass']);
								$sqlVersion = checkSqlVersion($db->query('SELECT VERSION()')->fetchColumn());
							}catch(Exception $e) {
								$sqlVersion['error'] = true;
								$sqlVersion['message'] = 'Database Credential is Not Valid';
							}
							$error = 0;
							$statusClass = '';
							if(isset($sqlVersion['error'])){
								$error += 1;
								$statusClass = 'not--matched';
							}
							?>

							<div class="row justify-content-center">
								<div class="col-lg-10">
									<div class="php-version-area style--two">
										<div class="left">
											<h6 class="title fw-normal">Required</h6>
											<div class="row gy-4 justify-content-center position-relative">
												<div class="col-xl-5 col-lg-6">
													<div class="content">
														<h6 class="mb-2 top-caption">MariaDB</h6>
														<div class="version">10.3</div>
														<p>Or Higher</p>
													</div>
												</div>
												<div class="col-xl-5 col-lg-6">
													<div class="content">
														<h6 class="mb-2 top-caption">MySQL</h6>
														<div class="version">5.7</div>
														<p>Or Higher</p>
													</div>
												</div>
											</div>
										</div>
										<div class="right <?php echo $statusClass; ?>">
											<h6 class="title fw-normal">Current</h6>
											<div class="content">
												<?php 
												if(isset($sqlVersion['message'])){
													?>
													<h5 class="mt-5 text--danger"><?php echo $sqlVersion['message']; ?></h5>
													<?php 
												}else{
													?>
													<h6 class="mb-2 top-caption"><?php echo $sqlVersion['engine']; ?></h6>
													<div class="version"><?php echo $sqlVersion['version']; ?></div>
													<?php 
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="text-center mt-5">
								<?php
								if(isset($sqlVersion['message'])){
									echo '<a href="?action=dbconfig" class="btn btn--warning preloader-btn"><i class="las la-arrow-left"></i> Go Back</a>';
								}elseif($error) {
									echo '<a href="?action=dbvalidate&nocache='.time().'" class="btn btn--warning preloader-btn">ReCheck <i class="las la-redo-alt"></i></a>';
								}else{
									echo '<a href="?action=information" class="btn btn--base preloader-btn auto-next">Next Step <i class="las la-arrow-right"></i></a>';
								}
								?>
							</div>

							<?php
						}elseif($action=='dbconfig') {
							?>
							<form action="?action=dbvalidate" method="post">
								<div class="row justify-content-center">
									<div class="col-lg-12">
										<div class="row gy-4">
											<div class="col-lg-6">
												<label>Database Name</label>
												<input type="text" name="db_name" class="form--control" placeholder="Enter Database Name" required>
											</div>
											<div class="col-lg-6">
												<label>Database Host</label>
												<input type="text" name="db_host" class="form--control" placeholder="Enter Database Host" required>
											</div>
											<div class="col-lg-6">
												<label>Database User</label>
												<input type="text" name="db_user" class="form--control" placeholder="Enter Database User" required>
											</div>
											<div class="col-lg-6">
												<label>Database Password</label>
												<input type="text" name="db_pass" class="form--control" placeholder="Enter Database Password">
											</div>
										</div>
									</div>
								</div>
								<div class="text-center mt-5">
									<button type="submit" class="btn btn--base preloader-btn"> Next Step <i class="las la-arrow-right"></i></button>
								</div>
							</form>

							<?php
						}elseif ($action=='files') {
							?>
							<div class="row justify-content-center gy-4 mb-5">
								<?php
								$error = 0;
								foreach ($files as $key) {
									$isExist = file_exists($key);
									if ($isExist) {
										$class = 'success';
										$text = './'.str_replace("../", "", $key).' is Available';
									}else{
										$error += 1;
										$class = 'danger';
										$text = './'.str_replace("../", "", $key).' is Required';
									}
									$permHead = end(explode('/',$key)); 
									?>
									<div class="col-lg-4 col-sm-6">
										<div class="custom--card text-center card--<?php echo $class; ?>">
											<div class="card-body">
												<h3><i class="la la-file-alt"></i> <?php echo $permHead; ?></h3>
											</div>
											<div class="card-footer">
												<p class="fs--14px"><?php echo $text; ?></p>
											</div>
										</div>
									</div>
									<?php 
								}
								?>
							</div>

							<div class="text-center mt-5">
								<?php
								if($error) {
									echo '<a href="?action=files&nocache='.time().'" class="btn btn--warning preloader-btn">ReCheck <i class="las la-redo-alt"></i></a>';
								}else{
									echo '<a href="?action=dbconfig" class="btn btn--base preloader-btn auto-next">Next Step <i class="las la-arrow-right"></i></a>';
								}
								?>
							</div>

							<?php
						}elseif ($action=='permissions') {
							?>
							<div class="row justify-content-center gy-4 mb-5">
								<?php
								$error = 0;
								foreach ($folders as $key) {
									$folderPerm = folderPermission($key);
									if ($folderPerm) {
										$class = 'success';
										$text = '0775 Permission Given for <br>./'.str_replace("../", "", $key);
									}else{
										$error += 1;
										$class = 'danger';
										$text = '0775 Permission Required for <br>./'.str_replace("../", "", $key);
									}
									$permHead = end(explode('/',substr($key,0,-1))); 
									?>
									<div class="col-lg-4 col-sm-6">
										<div class="custom--card text-center card--<?php echo $class; ?>">
											<div class="card-body">
												<h3><i class="la la-folder-open"></i> <?php echo $permHead; ?></h3>
											</div>
											<div class="card-footer">
												<p class="fs--14px"><?php echo $text; ?></p>
											</div>
										</div>
									</div>
									<?php 
								}
								?>
							</div>

							<div class="text-center mt-5">
								<?php
								if($error) {
									echo '<a href="?action=permissions&nocache='.time().'" class="btn btn--warning preloader-btn">ReCheck <i class="las la-redo-alt"></i></a>';
								}else{
									echo '<a href="?action=files" class="btn btn--base preloader-btn auto-next">Next Step <i class="las la-arrow-right"></i></a>';
								}
								?>
							</div>

							<?php
						}elseif ($action=='extensions') {
							?>
							<div class="row justify-content-center gy-4 mb-5">
								<?php
								$error = 0;
								foreach ($extensions as $key) {
									$extension = checkExtension($key);
									if ($extension) {
										$class = 'success';
										$text = 'PHP Extension is Installed';
									}else{
										$error += 1;
										$class = 'danger';
										$text = 'PHP Extension is Required';
									}
									?>
									<div class="col-lg-3 col-sm-6">
										<div class="custom--card text-center card--<?php echo $class; ?>">
											<div class="card-body">
												<h3><?php echo $key; ?></h3>
											</div>
											<div class="card-footer">
												<p class="fs--14px"><?php echo $text; ?></p>
											</div>
										</div>
									</div>
									<?php 
								}
								$extra['PHP CURL'] = ['name'=> 'curl via php', 'status'=>function_exists('curl_version') ? true : false];
								$extra['File Read'] =  ['name'=> 'file_get_contents()', 'status'=>file_get_contents(__FILE__) ? true : false];
								$extra['Remote URL'] =  ['name'=> 'allow_url_fopen()', 'status'=>ini_get('allow_url_fopen') ? true : false];

								foreach ($extra as $exk => $exv) {
									if ($exv['status']) {
										$class = 'success';
										$text = $exv['name'].' is Enabled';
									}else{
										$error += 1;
										$class = 'danger';
										$text = $exv['name'].' is Required';
									}
									?>
									<div class="col-lg-3 col-sm-6">
										<div class="custom--card text-center card--<?php echo $class; ?>">
											<div class="card-body">
												<h3><?php echo $exk; ?></h3>
											</div>
											<div class="card-footer">
												<p class="fs--14px"><?php echo $text; ?></p>
											</div>
										</div>
									</div>
									<?php 
								}
								?>
							</div>

							<div class="text-center mt-5">
								<?php
								if($error) {
									echo '<a href="?action=extensions&nocache='.time().'" class="btn btn--warning preloader-btn">ReCheck <i class="las la-redo-alt"></i></a>';
								}else{
									echo '<a href="?action=permissions" class="btn btn--base preloader-btn auto-next">Next Step <i class="las la-arrow-right"></i></a>';
								}
								?>
							</div>
							<?php
						}elseif ($action=='php') {
							$error = 0;
							$requiredPHP = 7.4;
							$currentPHP = explode('.',PHP_VERSION)[0].'.'.explode('.',PHP_VERSION)[1];
							$statusClass = '';
							if($requiredPHP !=  $currentPHP){
								$error += 1;
								$statusClass = 'not--matched';
							}
							?>

							<div class="row justify-content-center">
								<div class="col-lg-8">
									<div class="php-version-area">
										<div class="left">
											<h6 class="title fw-normal">Required</h6>
											<div class="content">
												<div class="version">7.4</div>
												<p>php version</p>
											</div>
										</div>
										<div class="right <?php echo $statusClass; ?>">
											<h6 class="title fw-normal">Current</h6>
											<div class="content">
												<div class="version"><?php echo $currentPHP; ?></div>
												<p>php version</p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="text-center mt-5">
								<?php
								if($error) {
									echo '<a href="?action=php&nocache='.time().'" class="btn btn--warning preloader-btn">ReCheck <i class="las la-redo-alt"></i></a>';
								}else{
									echo '<a href="?action=extensions" class="btn btn--base preloader-btn auto-next">Next Step <i class="las la-arrow-right"></i></a>';
								}
								?>
							</div>

							<?php
						}else{
							?>
							<h5>License to be used on one (1) domain only!</h5>
							<p class="mt-3 lead">The Regular license is for one website / domain only. If you want to use it on multiple websites / domains you have to purchase more licenses (1 website = 1 license).</p>

							<h5 class="mt-5">YOU CAN:</h5>
							<ul class="mt-3">
								<li><i class="las la-check text--base"></i> Use on one (1) domain only.</li>
								<li><i class="las la-check text--base"></i> Modify or edit as you want.</li>
								<li><i class="las la-check text--base"></i> Translate languages as you want.</li>
							</ul>
							<p class="mt-5"><i class="las la-exclamation-triangle text--warning"></i> If any error occurred after your edit on code/database, we are not responsible for that.</p>

							<h5 class="mt-5">YOU CANNOT:</h5>
							<ul class="mt-3">
								<li><i class="las la-times text--danger"></i> Resell, distribute, give away or trade by any means to any third party or individual without permission.</li>
								<li><i class="las la-times text--danger"></i> Include this product in other products sold on any market or affiliate websites.</li>
								<li><i class="las la-times text--danger"></i> Use on more than one (1) domain.</li>
							</ul>
							<p class="mt-5">For more information, Please Check <a href="https://thesoftking.com/licences-info" target="_blank" class="text--base">Our License Info</a>.</p>

							<div class="mt-4 text-end">
								<a href="?action=php" class="btn btn--base preloader-btn">I Agree. Next Step <i class="las la-arrow-right"></i></a>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
	<footer class="footer">
		<p><i class="lar la-copyright"></i> <?php echo Date('Y') ?> <a href="https://thesoftking.com/" target="_blank" class="text--base">THESOFTKING LIMITED</a>. All Rights Reserved.</p>
	</footer>
	<script src="https://verify.thesoftking.com/cdn/installassets/js/app.js"></script>
	<style>
		#hide{
			display: none;
		}
	</style>
</body>
</html>