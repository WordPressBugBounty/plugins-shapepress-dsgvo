<?php

/**
 * Extension of TCPDF
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Extension of TCPDF
 *
 * @since 1.0.0
 * @package WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author Shapepress eU
 */
class SPDSGVOPDF extends DSGVOTCPDF
{

    public function coloredTable($data)
    {
        $this->SetFillColor(56, 64, 94);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        
        $width = array(
            60,
            110
        );
        //$this->Cell($width[0], 7, 'Typ', 1, 0, 'C', 1);
        //$this->Cell($width[1], 7, 'Daten', 1, 0, 'C', 1);
        
        $this->Ln();
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        
        $fill = 0;
        foreach ($data as $type => $d) {
            $data = array();
            //error_log('type: '.$type);
            $title = "<strong>" . $type . "</strong>";
            
            $this->writeHTML($title, true, false, true, false, '');
            
            if (is_array($d)) {
                foreach ($d as $value) {
                    if (! empty($value)) {
                        array_push($data, $value->data);
                        
                        $span = "<span>" . $value->data . "</span>";
                        $this->writeHTML($span, true, false, true, false, '');
                    }
                }
            }
            
            //$this->MultiCell($width[0], 6, $type, 'LR', 'L', $fill, 0, '', '', true, 0, false, true, 0);
            //$this->MultiCell($width[1], 6, implode(', ', $data), 'LR', 'L', $fill, 0, '', '', true, 0, false, true, 0);
            $this->Ln();
            $fill = ! $fill;
        }
        
        $this->Cell(array_sum($width), 0, '', 'T');
    }
}