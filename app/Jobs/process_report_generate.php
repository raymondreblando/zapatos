<?php

require("./config/system_config.php");

use App\Utils\Utilities;
use App\Utils\PdfCreator;

$report_id = Utilities::sanitize($id);
$action_type = Utilities::sanitize($type);

$helper->query("SELECT * FROM `reports` WHERE `report_id` = ?", [$report_id]);
$report_data = $helper->fetch();

$type = $report_data->report_type." Report";
$startDate = Utilities::formatDate($report_data->start_date, "Y-m-d");
$endDate = Utilities::formatDate($report_data->end_date, "Y-m-d");
$title = Utilities::formatDate($startDate, "M d")."-".Utilities::formatDate($endDate, "M d, Y")." ".$type;

$helper->query("SELECT * FROM `system_settings`");
$settings = $helper->fetch();

$pdf = new PdfCreator("P", "A4");

$logo = __DIR__."/../../public/images/icon.png";
$total_sales = 0;

$pdf->pdf->SetTitle($title);
$pdf->setHeaderFooter(false);
$pdf->pdf->SetMargins(25, 20, 25);

$pdf->pdf->AddPage();
$pdf->pdf->Image($logo, 25, 15, 15, 15);
$pdf->pdf->SetFont('Courier', 'B', 12);
$pdf->write(42, 17, "Mr. Moussetache Milk Tea Shop", false, false);
$pdf->pdf->SetFont('Courier', '', 12);
$pdf->write(42, 22, $settings->address, false, false);

$pdf->pdf->SetFont('Courier', 'B', 11);
$pdf->write(25, 36, strtoupper($type), false, false);
$pdf->pdf->SetFont('Courier', '', 10);
$pdf->write(25, 41, "This document contains the ".strtolower($report_data->report_type)." information from ".Utilities::formatDate($startDate, "M d")." to ".Utilities::formatDate($endDate, "M d, Y").".", false, false);

$ths = $report_data->report_type == "Sales" ? ["Date", "Item Sold", "Sales", "Total"] : ["Product", "Stocks", "Price", "Remaining Stocks"];

$table = '<table cellpadding="5" style="text-align: center;border-collapse: collapse">';
$thead = '<tr>';

foreach($ths as $th){
  $thead .= '<th><b>'.$th.'</b></th>';
}

$thead .= '</tr>';
$table .= $thead;

$tbody = '<tbody>';
$tr = '<tr>';

$dates = Utilities::getDatesBetween($startDate, $endDate);
foreach($trs as $table_row){
  $tr .= '<td border="0.1" class="cell-padding" style="letter-spacing: 1px;">P'.$table_row.'.00</td>';
}

$tr = '</tr>';
$tbody .= $tr;
$tbody .= '</tbody>';
$table .= $tbody;

$pdf->pdf->SetXY(25, 55);
$pdf->pdf->SetFont('Courier', '', 10);
$pdf->pdf->writeHTML($table, true, false, true, false, '');

ob_start();
$pdf->generatePdfFile("Report", "I");
$pdfData = ob_get_clean();

header('Content-Type: application/pdf');
header('Content-Length: ' . strlen($pdfData));
header('Content-Disposition: inline; filename="sample.pdf"');

echo $pdfData;