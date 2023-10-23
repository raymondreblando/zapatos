<?php

namespace App\Utils;

use Mpdf\Mpdf; 
use Mpdf\Output\Destination;
use Mpdf\HTMLParserMode;

class PdfCreator 
{
  private $pdf;
  private $basePath = '../../public/font/';

  public function __construct(array $options)
  {
    $this->pdf = new Mpdf([
      'mode' => 'c',
      'format' => $options['format'] ?? 'A4',
      'orientation' => $options['orientation'] ?? 'P',
      'default_font' => 'Arial',
      'margin_left' => $options['margin'] ?? 16,
      'margin_right' => $options['margin'] ?? 16,
      'margin_top' => $options['margin'] ?? 16,
      'margin_bottom' => $options['margin'] ?? 16
    ]);
  }

  public function enableScript(bool $isEnable): void
  {
    $this->pdf->autoScriptToLang = $isEnable;
    $this->pdf->autoLangToFont = $isEnable;
  }

  public function setCustomFont(array $fontData): void
  {
    $this->pdf->SetBasePath($this->basePath);
    $this->pdf->fontData = $fontData;
  }

  public function setTitle(string $title): void
  {
    $this->pdf->SetTitle($title);
  }

  public function setHeader(string $header): void
  {
    $this->pdf->setHTMLHeader($header);
  }

  public function setFooter(string $footer): void
  {
    $this->pdf->setHTMLFooter($footer);
  }

  public function addPage(string $orienation = null): void
  {
    $this->pdf->AddPage($orienation);
  }

  public function writeHTML(string $html, string $mode = 'default'): void
  {
    if ($mode === 'default') {
      $parseMode = HTMLParserMode::HTML_BODY;
    } else {
      $parseMode = HTMLParserMode::HEADER_CSS;
    }
    
    $this->pdf->WriteHTML($html, $parseMode);
  }

  public function addTableRow(array $rows): void
  {
    foreach($rows as $row){
      $this->pdf->WriteHTML('<td>'. $row .'</td>');
    }
  }

  public function generatePdf(string $filename, string $type = 'P'): void
  {
      if($type === 'P'){
        $outputDestination = Destination::INLINE;
      } else{
        $outputDestination = Destination::DOWNLOAD;
      }

      $this->pdf->Output($filename . '.pdf', $outputDestination);
  }
}