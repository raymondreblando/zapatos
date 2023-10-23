<?php

namespace App\Controllers;

use App\Utils\DbHelper;
use App\Utils\Utilities;
use App\Utils\PdfCreator;
use stdClass;

class ReportController extends PdfCreator
{
  private $helper;
  private $pdf;
  private $tableTr;

  public function __construct(DbHelper $helper)
  {
    parent::__construct([]);
    $this->helper = $helper;
  }

  public function show(string $filter = null): array
  {
    if (!empty($filter)) {
      $reportParams = [$filter];
      $selectReportQuery = 'SELECT * FROM `reports` WHERE `report_type` = ? ORDER BY `id` DESC';
    } else {
      $reportParams = [];
      $selectReportQuery = 'SELECT * FROM `reports` ORDER BY `id` DESC';
    }

    $this->helper->query($selectReportQuery, $reportParams);
    return $this->helper->fetchAll();
  }

  public function insert(array $payload): string
  {
    if (Utilities::isArrayValueEmpty($payload)) {
      return Utilities::response('error', 'Provide necessary report data');
    }

    $reportId = Utilities::uuid();
    $currentDate = Utilities::getCurrentDate();

    $isReportExistParams = [
      $payload['type'],
      $payload['start_date'],
      $payload['end_date']
    ];

    $isReportExistQuery = 'SELECT * FROM `reports` WHERE `report_type` = ? AND `report_start_date` = ? AND `report_end_date` = ?';
    $this->helper->query($isReportExistQuery, $isReportExistParams);

    if ($this->helper->rowCount() > 0) {
      return Utilities::response('error', 'Report already generated');
    }

    $insertReportParams = [
      $reportId,
      $payload['type'],
      $payload['start_date'],
      $payload['end_date'],
      $currentDate
    ];

    $insertReportQuery = 'INSERT INTO `reports` (`report_id`, `report_type`, `report_start_date`, `report_end_date`, `date_created`) VALUES (?, ?, ?, ?, ?)';
    $this->helper->query($insertReportQuery, $insertReportParams);

    if ($this->helper->rowCount() > 1) {
      return Utilities::response('error', 'Failed to generate report'); 
    }

    return Utilities::response('success', 'Report generated successfully');
  }

  public function generatePdfReport(string $reportId): string
  {
    if (empty($reportId)) {
      return Utilities::response('error', 'An error occur. Try again');
    }

    $selectReportQuery = 'SELECT * FROM `reports` WHERE `report_id` = ?';
    $this->helper->query($selectReportQuery, [$reportId]);

    if ($this->helper->rowCount() < 1) {
      return Utilities::response('error', 'An error occur. Try again'); 
    }

    $reportDetails = $this->helper->fetch();
    
    if ($reportDetails->report_type === 'Sales') {
      $reportContent = $this->salesReport($reportDetails);
    } else {
      $reportContent = $this->inventoryReport($reportDetails);
    }

    $styles = file_get_contents('../../public/template/report.css');
    $reportStartDate = Utilities::formatDate($reportDetails->report_start_date, 'M d');
    $reportEndDate = Utilities::formatDate($reportDetails->report_end_date, 'M d, Y');
    $reportPeriod = $reportStartDate . ' - ' . $reportEndDate;
    $reportTitle = $reportPeriod . ' ' . $reportDetails->report_type . ' Report';

    $this->setTitle($reportTitle);
    $this->writeHTML($styles, 'css');
    $this->writeHTML($reportContent);

    ob_start();
    $this->generatePdf($reportTitle);
    $pdfReport = ob_get_clean();

    return $pdfReport;
  }

  private function salesReport(stdClass $reportDetails): string
  {
    $salesReportTemplate = file_get_contents('../../public/template/sales-report-template.html');

    $totalSales = 0;
    $dates = Utilities::getDatesBetweenDates($reportDetails->report_start_date, $reportDetails->report_end_date);

    foreach ($dates as $date) {
      $selectOrderQuery = 'SELECT *, SUM(oi.quantity) AS unit_sold FROM `orderred_items` oi LEFT JOIN `shoes` s ON oi.shoe_id=s.shoe_id WHERE oi.date_added LIKE ? GROUP BY oi.shoe_id';
      $this->helper->query($selectOrderQuery, ['%'.$date.'%']);
      $orderDetails = $this->helper->fetchAll();
      
      foreach ($orderDetails as $orderDetail) {
        $tr = '<tr>';
        $totalSales += $orderDetail->shoe_price * $orderDetail->unit_sold;

        $tr .= '<td class="main-td">' . $date . '</td>';
        $tr .= '<td class="main-td">' . $orderDetail->shoe_name . '</td>';
        $tr .= '<td class="main-td">' . $orderDetail->unit_sold . '</td>';
        $tr .= '<td class="main-td">' . 'P' . number_format($orderDetail->shoe_price) . '</td>';
        $tr .= '<td class="main-td">' . 'P' . number_format($orderDetail->shoe_price * $orderDetail->unit_sold) . '</td>';
        
        $tr .= '</tr>';
  
        $this->tableTr .= $tr;
      }

    }

    $logoSrc = '../../public/icons/Email Logo.svg';
    $currentDate = Utilities::formatDate('now', 'M d, Y');
    $reportStartDate = Utilities::formatDate($reportDetails->report_start_date, 'M d');
    $reportEndDate = Utilities::formatDate($reportDetails->report_end_date, 'M d, Y');
    $reportPeriod = $reportStartDate . ' - ' . $reportEndDate;

    $salesReportTemplate = str_replace('%LOGOSRC%', $logoSrc, $salesReportTemplate);
    $salesReportTemplate = str_replace('%DATEGENERATED%', $currentDate, $salesReportTemplate);
    $salesReportTemplate = str_replace('%REPORTPERIOD%', $reportPeriod, $salesReportTemplate);
    $salesReportTemplate = str_replace('%TABLEROWS%', $this->tableTr, $salesReportTemplate);
    $salesReportTemplate = str_replace('%TOTALSALES%', number_format($totalSales), $salesReportTemplate);

    return $salesReportTemplate;
  }

  private function inventoryReport(stdClass $reportDetails): string
  {
    $inventoryReportTemplate = file_get_contents('../../public/template/inv-report-template.html');

    $selectShoeQuery = 'SELECT * FROM `shoes`';
    $this->helper->query($selectShoeQuery);
    $shoes = $this->helper->fetchAll();

    foreach ($shoes as $shoe) {
      $tr = '<tr>';

      $tr .= '<td class="main-td">' . $shoe->shoe_name . '</td>';
      $tr .= '<td class="main-td">' . $shoe->shoe_price . '</td>';
      $tr .= '<td class="main-td">' . $shoe->shoe_stocks . '</td>';
      $tr .= '<td class="main-td">' . $shoe->shoe_discount . '</td>';

      $tr .= '</tr>';
      $this->tableTr .= $tr;
    }

    $logoSrc = '../../public/icons/Email Logo.svg';
    $currentDate = Utilities::formatDate('now', 'M d, Y');
    $reportStartDate = Utilities::formatDate($reportDetails->report_start_date, 'M d');
    $reportEndDate = Utilities::formatDate($reportDetails->report_end_date, 'M d, Y');
    $reportPeriod = $reportStartDate . ' - ' . $reportEndDate;

    $inventoryReportTemplate = str_replace('%LOGOSRC%', $logoSrc, $inventoryReportTemplate);
    $inventoryReportTemplate = str_replace('%DATEGENERATED%', $currentDate, $inventoryReportTemplate);
    $inventoryReportTemplate = str_replace('%REPORTPERIOD%', $reportPeriod, $inventoryReportTemplate);
    $inventoryReportTemplate = str_replace('%TABLEROWS%', $this->tableTr, $inventoryReportTemplate);

    return $inventoryReportTemplate;
  }
}