<?php 

function translateToAr($statment){
	return YandexTranslate::translate($statment, 'en', 'ar');
} 

function diffDate($start_date, $end_date){
	$date1 = $start_date;
	$date2 = $end_date;

	$diff = abs(strtotime($date2) - strtotime($date1)); // seconds
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	$diffInDays = $days + ($months * 31) + ($years * 365);

	return [
		'years'			=> $years,
		'months'		=> $months,
		'days'			=> $days,
		'diffInDays'	=> $diffInDays
	];
}
?>
