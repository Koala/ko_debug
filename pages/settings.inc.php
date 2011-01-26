<?php




if (rex_post('func', 'string') == 'update') 
{
  require_once $REX['INCLUDE_PATH'] .'/addons/ko_debug/classes/class.ko_debug_manager.inc.php';

  $settings = (array)rex_post('settings','array',array());
  $msg = '';
  
  if ($msg == '')
  {
    $old_dir = $REX['ADDON']['settings']['developer']['dir'];
    if (ko_debug_manager::saveSettings($settings) === FALSE)
    {
      echo rex_warning($I18N->msg('ko_debug_error'));
    }
  }
}

$debug = '';
if ($REX['ADDON']['settings']['ko_debug']['debug'] == '1') {
  $debug = ' checked="checked"';
  $aktvieren_debug = $I18N->msg('ko_debug_debug').' '.$I18N->msg('ko_debug_deaktivieren');
} else {
  $aktvieren_debug = $I18N->msg('ko_debug_debug').' '.$I18N->msg('ko_debug_aktivieren');
}
$krumo = '';
if ($REX['ADDON']['settings']['ko_debug']['krumo'] == '1') {
  $krumo = ' checked="checked"';
  $aktvieren_krumo = $I18N->msg('ko_debug_krumo').' '.$I18N->msg('ko_debug_deaktivieren');
} else {
  $aktvieren_krumo = $I18N->msg('ko_debug_krumo').' '.$I18N->msg('ko_debug_aktivieren');
}


echo '

<div class="rex-addon-output">

<h2 class="rex-hl2">'. $I18N->msg('ko_debug_settings') .'</h2>

<div class="rex-area">
  <div class="rex-form">
	
  <form action="index.php?page=ko_debug&subpage=settings" method="post">

		<fieldset class="rex-form-col-1">
      <div class="rex-form-wrapper">
			  <input type="hidden" name="func" value="update" />
        
        <div class="rex-form-row">
          <p class="rex-form-checkbox rex-form-label-right">
            <input type="hidden" name="settings[debug]" value="0" />
            <input class="rex-form-checkbox" type="checkbox" id="debug" name="settings[debug]" value="1"'.$debug.' />
            <label for="debug">'.$aktvieren_debug.'</label>
          </p>
        </div>
        
        <div class="rex-form-row">
          <p class="rex-form-checkbox rex-form-label-right">
            <input type="hidden" name="settings[krumo]" value="0" />
            <input class="rex-form-checkbox" type="checkbox" id="krumo" name="settings[krumo]" value="1"'.$krumo.' />
            <label for="krumo">'.$aktvieren_krumo.'</label>
          </p>
        </div>
        
        <div class="rex-form-row">
				  <p>
            <input type="submit" class="rex-form-submit" name="FUNC_UPDATE" value="'.$I18N->msg('ko_debug_save').'" />
          </p>
			  </div>
        
			</div>
    </fieldset>
  </form>
  </div>
</div>

</div>
  ';

