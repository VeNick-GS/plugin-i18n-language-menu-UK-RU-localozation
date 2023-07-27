<?php
// Get user parametrs from Settings Form
if (isset($_POST['submit-settings'])){
    
    unset($_POST['submit-settings']);
    $config->class=$_POST['li-class'];
	$config->output=$_POST['flags'];
	$config->sizes=$_POST['img-size'];
	$config->position=$_POST['position'];
	$config->icons=$_POST['icons'];
	$config->hidecurr=$_POST['hidecurr'];
    unset($_POST['img-size']);
	unset($_POST['flags']);
	unset($_POST['position']);
	unset($_POST['icons']);
	unset($_POST['hidecurr']);
	unset($_POST['li-class']);
    
    foreach($_POST as $code=>$caption){
		$config->languages->$code->text=$caption['text'];
		$config->languages->$code->sort=$caption['sort'];
    }
}

?>