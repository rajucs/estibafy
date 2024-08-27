<?php
//French
use App\Models\Languages;

$languages = Languages::where('lang', 'fr')->get();
$french_translations = [];
foreach ($languages as $language) :
	$french_translations[$language->field_name] = $language->translation;
endforeach;
return  $french_translations;
