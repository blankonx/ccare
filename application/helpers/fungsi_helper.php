<?php
function removeKotaKab($name) {
	return str_replace(" Kab", "", str_replace("Kota ", "", str_replace(" Kota", "", $name)));
}
function addKotaKab($name) {
    $temp = str_replace(" Kab", "", str_replace("Kota ", "", str_replace(" Kota", "", $name)));
	if(eregi(" Kab", $name)) return "Kabupaten " . $temp;
    else return "Kota " . $temp;
}

function addExtraZero($data, $len) {
	$y = $len - strlen($data);
	while(strlen($x) < $y) {
		$x .= "0";
	}
	return $x . $data;
}

function tanggalIndo($waktu, $format) { //{tanggalIndoTiga tgl=0000-00-00 00:00:00 format="l, d/m/Y H:i:s"}
	if($waktu == "0000-00-00" || !$waktu || $waktu == "0000-00-00 00:00:00") {
		$rep = "";
	} else {
		if(eregi("-", $waktu)) {
			$tahun = substr($waktu,0,4);
			$bulan = substr($waktu,5,2);
			$tanggal = substr($waktu,8,2);
		} else {
			$tahun = substr($waktu,0,4);
			$bulan = substr($waktu,4,2);
			$tanggal = substr($waktu,6,2);
		}

		$jam = substr($waktu,11,2);
		$menit= substr($waktu,14,2);
		$detik = substr($waktu,17,2);
		$hari_en = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$hari_id = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
		$bulan_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$bulan_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$ret = @date($format, @mktime($jam, $menit, $detik, $bulan, $tanggal, $tahun));

		$replace_hari = str_replace($hari_en, $hari_id, $ret);
		$rep = str_replace($bulan_en, $bulan_id, $replace_hari);
		$rep = nl2br($rep);
	}
	return $rep;
}

function bulanIndo($waktu, $format) {
	if(!$waktu) {
		$waktu = date("m");
	}
	$tahun = date("Y");
	$bulan_en = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	$bulan_id = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	$ret = date($format, mktime(1, 1, 1, $waktu, 1, $tahun));
	$replace_bulan = str_replace($bulan_en, $bulan_id, $ret);
	return $replace_bulan;
}

function datediff($interval, $date1, $date2) {
	$interval = strtolower($interval);
	// Function roughly equivalent to the ASP "DateDiff" function

	//convert the dates into timestamps
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);   
	$seconds = $date2 - $date1;

	//if $date1 > $date2
	//change substraction order
	//convert the diff to +ve integer
	if ($seconds < 0)
	{
		$tmp = $date1;
		$date1 = $date2;
		$date2 = $tmp;
		$seconds = 0-$seconds; 
	}

	//reconvert the timestamps into dates
	if ($interval =='y' || $interval=='m') {
		$date1 = @date("Y-m-d h:i:s", $date1);
		$date2=  @date("Y-m-d h:i:s", $date2);   
	}

	switch($interval) {
		case "y":
			list($year1, $month1, $day1) = split('-', $date1);
			list($year2, $month2, $day2) = split('-', $date2);
			$time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
			$time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
			$diff = $year2 - $year1;

			if($month1 > $month2) {
				$diff -= 1;
			} elseif($month1 == $month2) {
				if($day1 > $day2) {
				$diff -= 1;
				} elseif($day1 == $day2) {
					if($time1 > $time2) {
						$diff -= 1;
					}
				}
			}
		break;
		case "m":       
			list($year1, $month1, $day1) = split('-', $date1);
			list($year2, $month2, $day2) = split('-',$date2);
			$time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
			$time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
			$diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
			if($day1 > $day2) {
				$diff -= 1;
			} elseif($day1 == $day2) {
				if($time1 > $time2) {
					$diff -= 1;
				}
			}
		break;
		case "w":
			// Only simple seconds calculation needed from here on
			$diff = floor($seconds / 604800);
		break;
		case "d":
			$diff = floor($seconds / 86400);
		break;
		case "h":
			$diff = floor($seconds / 3600);
		break;
		case "i":
			$diff = floor($seconds / 60);
		break;
		case "s":
			$diff = $seconds;
		break;
	}
	return $diff;
}

function getAge($tgl_start, $tgl_end = '') {
	if(!$tgl_end || $tgl_end == '') $tgl_end = date("Y-m-d");
    //echo $tgl_start . '++' . $tgl_end;
    if(eregi("/", $tgl_start)) {
        $tgl_start = explode("/", $tgl_start);
        $tgl_start = date("Y-m-d", mktime(1,1,1, $tgl_start[1], $tgl_start[0], $tgl_start[2]));
    }
    if(eregi("/", $tgl_end)) {
        $tgl_end = explode("/", $tgl_end);
        $tgl_end = date("Y-m-d", mktime(1,1,1, $tgl_end[1], $tgl_end[0], $tgl_end[2]));
    }

    //echo $tgl_start;
	$start_time = strtotime($tgl_start);
	$end_time = strtotime($tgl_end);
	if($end_time <= $start_time) {
		$umur['year'] = 0;
		$umur['month'] = 0;
		$umur['day'] = 0;
	} else {
		$umur['year'] = datediff('y', $tgl_start, $tgl_end);
		
		$selisih_month = datediff('m', $tgl_start, $tgl_end);
		$umur['month'] = $selisih_month % 12;

		$arr_tgl_start = explode("-", $tgl_start);
		$tgl_start_thn = $arr_tgl_start[0] + $umur['year'];
		$tgl_start_bln = $arr_tgl_start[1] + $umur['month'];
		$new_tgl_start = date("Y-m-d", mktime(1,1,1,$tgl_start_bln, $arr_tgl_start[2], $tgl_start_thn));
		$selisih_day = datediff('d', $new_tgl_start, $tgl_end);
		$umur['day'] = $selisih_day;
	}
	return $umur;
}

function getOneAge($tgl_start, $tgl_end = '') {
	//$this->tgl_end=curdate();
	$arr = getAge($tgl_start, $tgl_end);
	if(!$arr['year'] && !$arr['month']) {
		return $arr['day'] . ' hr';
	} elseif($arr['year']) {
		return $arr['year'] . ' th';
	} 
	return $arr['month'] . ' bl';
}
function getYMD($date) {
	//$date = dd/mm/yy
    if(!$date) return '';
	$arr = explode("/", $date);
	return @date("Y-m-d", @mktime(1, 1, 1, $arr[1], $arr[0], $arr[2]));
}

function unYMD($date) {
	//$date = dd/mm/yy
    if(!$date) return '';
    //strip the time
    $curr = current(explode(" ", $date));
	$arr = explode("-", $curr);
    return $arr[2] . '/' . $arr[1] . '/' . $arr[0];
}

function uangIndo($uang) {
    return number_format($uang, 2, '.', ',');
}
/*
function numericToRom($num) {
	switch $num {
		case 1 : $rom = "I"; break;
		case 2 : $rom = "II"; break;
		case 3 : $rom = "III"; break;
		case 4 : $rom = "IV"; break;
		case 5 : $rom = "V"; break;
		case 6 : $rom = "VI"; break;
		case 7 : $rom = "VII"; break;
		case 8 : $rom = "VIII"; break;
		case 9 : $rom = "IX"; break;
		case 10 : $rom = "X"; break;
		case 11 : $rom = "X1"; break;
		case 12 : $rom = "X11"; break;
	}
	return $rom;
}
*/
function get_menu($data, $parent = 0) {
	static $i = 1;
	$tab = str_repeat("\t\t", $i);
	if ($data[$parent]) {
		$html = "\n$tab<ul class=\"sf-menu\">";
		$i++;
		foreach ($data[$parent] as $v) {
			$child = get_menu($data, $v['id']);
			$html .= "\n\t$tab<li>";
			$html .= '<a href="'.site_url($v['url']).'">'.$v['name'].'</a>';
			if ($child) {
				$i--;
				$html .= $child;
				$html .= "\n\t$tab";
			}
			$html .= '</li>';
		}
		$html .= "\n$tab</ul>";
		return $html;
	} else {
		return false;
	}
}
    
    function terbilang($x) {
      $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
      if ($x < 12)
        return " " . $abil[$x];
      elseif ($x < 20)
        return Terbilang($x - 10) . "Belas";
      elseif ($x < 100)
        return Terbilang($x / 10) . " Puluh" . terbilang($x % 10);
      elseif ($x < 200)
        return " seratus" . Terbilang($x - 100);
      elseif ($x < 1000)
        return Terbilang($x / 100) . " Ratus" . terbilang($x % 100);
      elseif ($x < 2000)
        return " seribu" . Terbilang($x - 1000);
      elseif ($x < 1000000)
        return Terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
      elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
    }
