<?php

i18n_merge('i18n_lang_menu') || i18n_merge('i18n_lang_menu','en_US');

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# register plugin
register_plugin(
	$thisfile,								//Plugin id
	'I18N Language menu ',					//Plugin name
	'0.6',									//Plugin version
	'Alexey Rehov + Andrejus Semionovas',	//Plugin author (nickname: Zorato)
	'http://pigios-svetaines.eu',		//author website
	'Language menu generator with flags',	//Plugin description
	'pages',								//page type - on which admin tab to display
	'i18n_lang_menu_settings'				//main function (administration)
);

add_action('pages-sidebar','createSideMenu',array($thisfile,i18n_r('i18n_lang_menu/MENU_TEXT')));


function i18n_lang_menu_settings(){
	//check reguared parameters and recreate it defaults on errors
	if (!plugin_check('i18n_base')) {
		?> <div class="fancy-message error" style="border: 1px solid; padding: 20px 10px 10px 10px; border-radius: 4px; margin-bottom: 20px; background: #F2DEDE; color: #A94442;"><p><?php i18n('i18n_lang_menu/NOT_INTERNALISATON'); ?></p></div> <?php
		exit;
	}
	if (!file_exists(GSPLUGINPATH.'i18n_lang_menu/config.xml')) {
		?> <div class="fancy-message error" style="border: 1px solid; padding: 20px 10px 10px 10px; border-radius: 4px; margin-bottom: 20px; background: #F2DEDE; color: #A94442;"><p><?php i18n('i18n_lang_menu/LANG_NOT_SETTINGS'); i18n('i18n_lang_menu/LANG_DEFAULT'); ?></p></div> <?php
		$all_languages=return_i18n_available_languages();
		$new_config=new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><config></config>');
		foreach ($all_languages as $lang){
			$new_config->languages->$lang->text=$lang;
			$new_config->languages->$lang->code=$lang;
			$new_config->languages->$lang->sort=0;
		}
		$new_config->class="current_language";
		$new_config->output=0;
		$new_config->sizes="16x12";
		$new_config->position=0;
		$new_config->icons=0;
		$new_config->hidecurr=0;
		set_config($new_config);
		unset($new_config);
		unset($all_languages);
	}
	
	$config=get_config();
    include GSPLUGINPATH.'i18n_lang_menu/settings_handler.php';
    set_config($config);
    // Save configuration and re-load it 
    $config=getXML(GSPLUGINPATH.'i18n_lang_menu/config.xml');
    include GSPLUGINPATH.'i18n_lang_menu/settings_viewer.php';
}

function get_i18n_lang_menu(){
    //check if XML file exist, if not - send error message to users
	if (!file_exists(GSPLUGINPATH.'i18n_lang_menu/config.xml')) {
		?> <div class="fancy-message error" style="border: 1px solid; padding: 20px 10px 10px 10px; border-radius: 4px; margin-bottom: 20px; background: #F2DEDE; color: #A94442; position: absolute;top: 100px;z-index: 999;"><p><?php i18n('i18n_lang_menu/LANG_NOT_SETTINGS'); ?></p></div> <?php
	}
	else {
	$config=getXML(GSPLUGINPATH.'i18n_lang_menu/config.xml');
	global $SITEURL;
	if(isset($config->icons) && $config->icons==0) {
		$flags_path = $SITEURL.'plugins/i18n_lang_menu/flags/';
	} elseif(isset($config->icons) && $config->icons==1) {
		$flags_path = $SITEURL.'plugins/i18n_lang_menu/flags/3d/';
	}
	else $flags_path = $SITEURL.'plugins/i18n_lang_menu/flags/';
	$img_size=explode("x",$config->sizes);
	if(isset($config->position) && $config->position==1) $style='style="list-style-type:none;padding:4px;display:inline-block;"';
	else $style='style="list-style-type:none;padding:4px;display:block;"';
    
    $langs_arr=return_i18n_languages();
    $current_language=$langs_arr[0];
	if(isset($config->position) && $config->position==2) { 
		$style='';
		echo '<li class="dropdown lang-menu">';
		if(isset($config->output) && $config->output == 1) {
			echo '<a href="'.htmlspecialchars(return_i18n_setlang_url($current_language)).'" class="dropdown-toggle" data-toggle="dropdown"><img src="'.$flags_path.$current_language.'.png" title="'.$config->languages->$current_language->text.'" style="width: '.$img_size[0].'px; height:'.$img_size[1].'px;"><span class="caret"></span></a>';
		}
		elseif(isset($config->output) && $config->output == 2) {
			echo '<a href="'.htmlspecialchars(return_i18n_setlang_url($current_language)).'" class="dropdown-toggle" data-toggle="dropdown"><div class="image-holder"><img src="'.$flags_path.$current_language.'.png" title="'.$config->languages->$current_language->text.'" style="width: '.$img_size[0].'px; height:'.$img_size[1].'px;"> <span style="margin-left:6px">'.$config->languages->$current_language->text.'</span><span class="caret"></span></div></a>';
		}
		elseif(isset($config->output) && $config->output == 3) {
			echo '<a href="'.htmlspecialchars(return_i18n_setlang_url($current_language)).'" class="dropdown-toggle" data-toggle="dropdown"><span>'.$config->languages->$current_language->text.'</span><img src="'.$flags_path.$current_language.'.png" title="'.$config->languages->$current_language->text.'" style="margin-left:6px; width: '.$img_size[0].'px; height:'.$img_size[1].'px;"><span class="caret"></span></a>';
		}
		else {
			echo '<a href="'.htmlspecialchars(return_i18n_setlang_url($current_language)).'" class="dropdown-toggle" data-toggle="dropdown"><span>'.$config->languages->$current_language->text.'</span><span class="caret"></span></a>';
		}
		echo '<ul class="dropdown-menu">';
	}
	else {
	?> <ul id="language-menu"> <?php
	}
    foreach($config->languages->children() as $lang){
        if(isset($config->hidecurr) && $config->hidecurr == 1 && $lang->code == $current_language) continue;
		if(isset($config->output) && $config->output == 1) {
			echo '<li '.($lang->code==$current_language?'class="'.$config->class.'"':'').$style.'"><a href="'.htmlspecialchars(return_i18n_setlang_url($lang->code)).'"><img src="'.$flags_path.$lang->code.'.png" title="'.$lang->text.'" style="width: '.$img_size[0].'px; height:'.$img_size[1].'px;"></a></li>';
		}
		elseif(isset($config->output) && $config->output == 2) {
			echo '<li '.($lang->code==$current_language?'class="'.$config->class.'"':'').$style.'><a href="'.htmlspecialchars(return_i18n_setlang_url($lang->code)).'"><img src="'.$flags_path.$lang->code.'.png" title="'.$lang->text.'" style="width: '.$img_size[0].'px; height:'.$img_size[1].'px;"><span style="margin-left:6px">'.$lang->text.'</span></a></li>';
		}
		elseif(isset($config->output) && $config->output == 3) {
			echo '<li '.($lang->code==$current_language?'class="'.$config->class.'"':'').$style.'><a href="'.htmlspecialchars(return_i18n_setlang_url($lang->code)).'"><span style="float: left;">'.$lang->text.'</span><img src="'.$flags_path.$lang->code.'.png" title="'.$lang->text.'" style="margin-left:6px; width: '.$img_size[0].'px; height:'.$img_size[1].'px;"></a></li>';
		}
		else {
			echo '<li '.($lang->code==$current_language?'class="'.$config->class.'"':'').$style.'><a href="'.htmlspecialchars(return_i18n_setlang_url($lang->code)).'"><span>'.$lang->text.'</span></a></li>';
		}
    }
	?> </ul> <?php
	if(isset($config->position) && $config->position==2) { echo '</li>'; }
	}
}

function get_config(){
    //load current config
    $conf=getXML(GSPLUGINPATH.'i18n_lang_menu/config.xml');
    //create new one
    $new_conf=new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><config></config>');
    
    $all_languages=return_i18n_available_languages();
	foreach ($all_languages as $lang){
        
        $new_conf->languages->$lang->text=empty($conf->languages->$lang->text)? // language is new?
                                            $lang:                              // default value
                                            (string)$conf->languages->$lang->text;      // language was defined before, assign old value
        $new_conf->languages->$lang->code=$lang; //language code ( should be 2-symbol string)
		$new_conf->languages->$lang->sort=isset($conf->languages->$lang->sort)?
									(int)$conf->languages->$lang->sort:
									0;
    }

    $new_conf->class=(string)$conf->class?
                        (string)$conf->class: // class was defined before, assign old value
                        'current_language';   // if config file is empty, then it had no class
    // Extended section (add by Asemion)
	$new_conf->output=(int)$conf->output?
                        (int)$conf->output:
                        0;
	$new_conf->sizes=(string)$conf->sizes?
                        (string)$conf->sizes:
                        '16x12';
	$new_conf->position=(int)$conf->position?
                        (int)$conf->position:
                        0;
	$new_conf->icons=(int)$conf->icons?
                        (int)$conf->icons:
                        0;
	$new_conf->hidecurr=(int)$conf->hidecurr?
                        (int)$conf->hidecurr:
                        0;
					
    set_config($new_conf); //save config
    
    return $new_conf;
}

function __xsort(&$names,$key) {
	foreach ($names as $child){
		$sortavs[] = $child[$key]; // create sort parameters
	}
	array_multisort($sortavs, SORT_NUMERIC, $names);
    return $names;
}

// function defination to convert array to xml
function array_to_xml($array_info, &$xml_info) {
    foreach($array_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                $subnode = $xml_info->addChild("item$key");
                array_to_xml($value, $subnode);
            }
        }
        else {
            $xml_info->addChild("$key",htmlspecialchars("$value"));
        }
    }
}

function set_config(SimpleXMLExtended $c){ //function saves config
	$array = json_decode(json_encode($c), TRUE);
	unset($c);
	__xsort($array['languages'],"sort") ;
	$c = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><config></config>");
	array_to_xml($array,$c);
	XMLsave($c,GSPLUGINPATH.'i18n_lang_menu/config.xml'); 
}

function plugin_check($search_for) {
	if(!empty($search_for) && file_exists(GSDATAOTHERPATH.'plugins.xml')) {
		$data = getXML(GSDATAOTHERPATH.'plugins.xml');
        $aplugins = $data->item;
		if (count($aplugins) > 0) {
            foreach ($aplugins as $plugin) {
				if ($search_for == rtrim($plugin->plugin, ".php") && $plugin->enabled == 'true') {
					return true;
                    break;
                }
            }
        }
	}
    return false;
}
?>