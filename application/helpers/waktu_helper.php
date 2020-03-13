<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tanggalShow($waktu){

	$tahun = substr($waktu, 0,4);
	$bulan = getBulan(substr($waktu, 5,2));
	$tanggal = substr($waktu, 8,2);

	$showTanggal = $tanggal." ".$bulan." ".$tahun;
	return $showTanggal;
}

function getBulan($bulan){
	switch ($bulan) {
		case '01':
			$showBulan = "Januari";
		break;
		case '02':
			$showBulan = "Februari";
		break;
		case '03':
			$showBulan = "Maret";
		break;
		case '04':
			$showBulan = "April";
		break;
		case '05':
			$showBulan = "Mei";
		break;
		case '06':
			$showBulan = "Juni";
		break;
		case '07':
			$showBulan = "Juli";
		break;
		case '08':
			$showBulan = "Agustus";
		break;
		case '09':
			$showBulan = "September";
		break;
		case '10':
			$showBulan = "Oktober";
		break;
		case '11':
			$showBulan = "November";
		break;
		case '12':
			$showBulan = "Desember";
		break;
		
		default:
			$showBulan = "Not Found";
		break;
	}


	return $showBulan;
}