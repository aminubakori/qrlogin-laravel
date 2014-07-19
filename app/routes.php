<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('login');
});

Route::post('/signup', function()
{
	//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = 'temp/';
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';  
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
 
    $filename = $PNG_TEMP_DIR.'test.png';
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level']; 

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);






	$email = Input::get('email');
	$password = Input::get('password');
	$password = Hash::make('password');
	$qrdata = Hash::make($email."".$password);

	if( !empty($email) && !empty($password )) {
		$records = User::where('email', '=', $email)->first();
		if( $records ) {
			echo '<div class="alert alert-warning alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>You are already regisered. Save your qrcode</div>';
			//display qrcode
			QRcode::png($records->qrdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
    		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />'; 
    		die();
		} 
		//Add if check fails
		$_userToDB = new User;
		$_userToDB->email = $email;
		$_userToDB->password = $password;
		$_userToDB->qrdata = $qrdata;

		if( $_userToDB->save() ) {
			echo '<div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>Registration successful save your qrcode.</div>';
			//display qrcode
			QRcode::png($_userToDB->qrdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
    		echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />'; 
    		die();
		}else {
			echo '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>Data was not successfully saved.</div>';
			die();
		}
	}else {
		echo '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>All feilds are required.</div>';
		die();
	}
});

Route::post('/login', function()
{
	$qrdata = Input::get('qrdata');

	if(!empty( $qrdata )) {
		$records = User::where('qrdata', '=', $qrdata)->first();

		if( $records ) {
			echo "<h1>Welcome ". $records->email ."</h1> <span>You are in the users area.</span>";
			echo "<style>.loginform { display: none; }</style>";
		}else {
			echo '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>Sorry user does not exist.</div>';
			die();
		}
	}else {
		echo '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>Reload and recapture please.</div>';
		die();
	}
});