<?php
global $SITEURL;
?>	
<style>
.lang-settings {
    margin: 10px 0px 20px;
    display: inline-block;
    border: 1px solid #AAAAAA;
    padding: 10px;
    border-radius: 3px;
}
.flags-output, .position {
	padding-left: 4px;
	margin-right: 20px;
}
.imgage-size {
    margin: 0px 10px;
}
</style>
<form method="POST">
<h3><?php i18n('i18n_lang_menu/TITLE');?></h3>
<label>
    <?php i18n('i18n_lang_menu/LI_CLASS_LABEL'); ?>
    <input type="text" class="text" style="width: 200px;" name="li-class" value="<?php echo $config->class;?>">
</label>
<table id="lang-table">
    <tr>
        <th><?php i18n('i18n_lang_menu/LANG_CODE');?></th>
        <th><?php i18n('i18n_lang_menu/LANG_TEXT');?></th>
		<th><?php i18n('i18n_lang_menu/LANG_SORT');?></th>
    </tr>
    <?php foreach($config->languages->children() as $lang): ?>
        <tr>
            <td><?php echo $lang->code;?></td>
            <td><input type="text" class="text" style="width: 100px;" name="<?php echo $lang->code;?>[text]" value="<?php echo $lang->text;?>"></td>
			<td><input type="text" class="text" style="width: 25px;" name="<?php echo $lang->code;?>[sort]" value="<?php echo $lang->sort;?>"></td>
        </tr>
    <?php endforeach;?>
</table>
<div class="flags lang-settings">
	<?php if(!isset($config->output)) $config->output=0; ?>
	<?php if(!isset($config->sizes)) $config->sizes='16x12'; $img_size=explode("x",$config->sizes); ?>
	<?php if(!isset($config->position)) $config->position=0; ?>
	<label style="margin-bottom: 5px">
		<?php i18n('i18n_lang_menu/LANG_OUTPUT'); ?>
	</label>
	<input type="radio" name="flags" value=0 <?php echo ($config->output==0?"checked":"")?>><span class="flags-output"><?php i18n('i18n_lang_menu/LANG_OUTPUT_EMPTY');?></span>
	<input type="radio" name="flags" value=1 <?php echo ($config->output==1?"checked":"")?>><span class="flags-output"><?php i18n('i18n_lang_menu/LANG_OUTPUT_A');?></span>
	<input type="radio" name="flags" value=2 <?php echo ($config->output==2?"checked":"")?>><span class="flags-output"><?php i18n('i18n_lang_menu/LANG_OUTPUT_B');?></span>
	<input type="radio" name="flags" value=3 <?php echo ($config->output==3?"checked":"")?>><span class="flags-output"><?php i18n('i18n_lang_menu/LANG_OUTPUT_C');?></span>
</div>
<div class="lang-position lang-settings">
	<label style="margin-bottom: 5px">
		<?php i18n('i18n_lang_menu/LANG_POZ_DESC'); ?>
	</label>
	<input type="radio" name="position" value=0 <?php echo ($config->position==0?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_POZ_VERT');?></span>
	<input type="radio" name="position" value=1 <?php echo ($config->position==1?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_POZ_HORZ');?></span>
	<input type="radio" name="position" value=2 <?php echo ($config->position==2?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_POZ_DROP');?></span>
	<input type="radio" name="position" value=3 <?php echo ($config->position==3?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_POZ_NONE');?></span>
</div>
<div class="lang-icons lang-settings">
	<label style="margin-bottom: 5px">
		<?php i18n('i18n_lang_menu/LANG_ICONS_DESC'); ?>
	</label>
	<input type="radio" name="icons" value=0 <?php echo ($config->icons==0?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_ICO_2D');?></span><span class="position"><img src="<?php echo $SITEURL.'plugins/i18n_lang_menu/flags/en.png'; ?>" border="0" title="<?php i18n('i18n_lang_menu/LANG_ICO_2D');?>" width="32px" height="22px"></span>
	<input type="radio" name="icons" value=1 <?php echo ($config->icons==1?"checked":"")?> style="margin-left: 20px;"><span class="position"><?php i18n('i18n_lang_menu/LANG_ICO_3D');?></span><span class="position"><img src="<?php echo $SITEURL.'plugins/i18n_lang_menu/flags/3d/en.png'; ?>" border="0" title="<?php i18n('i18n_lang_menu/LANG_ICO_3D');?>" width="32px" height="32px"></span>
</div>
<div class="imgage-size lang-settings">
	<label style="margin-bottom: 5px">
		<?php i18n('i18n_lang_menu/LANG_IMG_SIZE'); ?>
	</label>
	<input class="i-sizes" type="text" name="img-size" value="<?php echo $config->sizes; ?>" style="width:80px">
</div>
<div class="lang-hidecurr lang-settings">
	<label style="margin-bottom: 5px">
		<?php i18n('i18n_lang_menu/LANG_HIDE_CURR_DESC'); ?>
	</label>
	<input type="radio" name="hidecurr" value=0 <?php echo ($config->hidecurr==0?"checked":"")?>><span class="position"><?php i18n('i18n_lang_menu/LANG_SHOW_CURR');?></span>
	<input type="radio" name="hidecurr" value=1 <?php echo ($config->hidecurr==1?"checked":"")?> style="margin-left: 20px;"><span class="position"><?php i18n('i18n_lang_menu/LANG_HIDE_CURR');?></span>
</div>
<input type="submit" class="submit" name="submit-settings" value="<?php i18n('BTN_SAVESETTINGS');?>" style="display:block;">
</form>
