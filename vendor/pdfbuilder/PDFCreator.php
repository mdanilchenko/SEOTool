<?php

/**
 * Created by PhpStorm.
 * User: maksim
 * Date: 16.05.17
 * Time: 9:33
 */
class PDFCreator extends FPDF
{
    private $url;
    private $num = 0;

    public function __construct($url)
    {
        parent::__construct();
        $this->url = $url;
    }


    function Header()
    {
        // Logo
        $this->Image('images/logo.png',15,4,20);
        // Arial bold 15
        $this->SetFont('helvetica','',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'SEOTool report for '.$this->url,0,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('helvetica','',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function ChapterTitle( $label)
    {
        $this->Ln(4);
        $this->num++;
        // Arial 12
        $this->SetFont('Arial','',12);
        // Background color
        $this->SetFillColor(200,220,255);
        // Title
        $this->Cell(0,6,"Chapter ".$this->num." : $label",0,1,'L',true);
        // Line break
        $this->Ln(4);
    }
    function ChapterBody($txt)
    {
       // Times 12
        $this->SetFont('Times','',12);
        // Output justified text
        $this->MultiCell(0,5,$txt);
        // Line break
        $this->Ln();
        // Mention in italics
        //$this->SetFont('','I');
        //$this->Cell(0,5,'(end of excerpt)');
    }
    function printStatParam($name,$value,$priority,$recomendation=''){
        $this->SetFont('Times','',12);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,6,$name,0,0,'L');

        if($priority>0){
            $this->SetTextColor(220,50,50);
        }else{
            $this->SetTextColor(26,148,49);
        }
        $this->Cell(0,2,$value,0,1,'R');
        $this->Ln();
        if(!empty($recomendation)) {
            $this->SetFont('', 'I');
            $this->Cell(0, 6, $recomendation,0,1,'R');
        }
        $this->Ln();
        $this->SetTextColor(0,0,0);
    }
    function printTopParam($name,$value,$edge,$recomendation='',$formBytes = false){
        $this->SetFont('Times','',12);
        $this->SetTextColor(0,0,0);
        $this->Cell(0,6,$name,0,0,'L');

        if($value>$edge){
            $this->SetTextColor(220,50,50);
        }else{
            $this->SetTextColor(26,148,49);
        }
        if($formBytes){
            $value = $this->formatBytes($value,2);
        }
        $this->Cell(0,2,$value,0,1,'R');
        $this->Ln();
        if(($value>$edge) and !empty($recomendation)) {
            $this->SetFont('', 'I');
            $this->Cell(0, 6, "(".$recomendation.")",0,1,'R');
        }
        $this->Ln();
        $this->SetTextColor(0,0,0);
    }
    private function formatBytes($bytes, $precision = 1) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

}
