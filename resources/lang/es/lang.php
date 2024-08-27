<?php

use App\Models\Languages;

$languages = Languages::where('lang', 'es')->get();
$translations = [];
foreach ($languages as $language) :
	$translations[$language->field_name] = $language->translation;
endforeach;
return  $translations;
