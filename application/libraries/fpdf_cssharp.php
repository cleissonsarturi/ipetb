<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fpdf_cssharp {
		
	public function __construct() {
		
		require_once APPPATH.'third_party/fpdf/fpdf-1.8.php';
		
		$pdf = new FPDF();	
		$CI  =& get_instance();
		$CI->fpdf = $pdf;
		
	}
	
}