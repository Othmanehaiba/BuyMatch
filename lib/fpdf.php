<?php
/*
 Minimal FPDF drop-in for generating simple PDFs while avoiding external deps.
 This is a compact subset to support basic ticket generation for this project.
*/
class FPDF
{
    protected $pages = [];
    protected $current_page = null;

    public function __construct() {}

    public function AddPage()
    {
        $this->current_page = [];
        $this->current_page['contents'] = '';
        $this->pages[] = &$this->current_page;
    }

    public function SetFont($family, $style = '', $size = 12)
    {
        // no-op for this minimal implementation
    }

    public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->current_page['contents'] .= $txt . "\n";
    }

    public function Ln($h = null)
    {
        $this->current_page['contents'] .= "\n";
    }

    protected function _escape($s) {
        return str_replace(["\\","(",")"],["\\\\","\\(","\\)"],$s);
    }

    public function Output($dest='I', $name='document.pdf')
    {
        // Very small PDF generator using a single text block per page.
        $objOffsets = [];
        $pdf = "%PDF-1.4\n";

        // F1 Font
        $objOffsets[] = strlen($pdf);
        $pdf .= "1 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

        $cnt = 2;
        $pageObjs = [];
        foreach ($this->pages as $p) {
            $lines = explode("\n", rtrim($p['contents'], "\n"));
            $content = "BT /F1 12 Tf 50 760 Td (" . $this->_escape(implode(' - ', $lines)) . ") Tj ET\n";
            $objOffsets[] = strlen($pdf);
            $pdf .= "$cnt 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "endstream\nendobj\n";
            $pageObjs[] = $cnt;
            $cnt++;
        }

        // Pages object
        $objOffsets[] = strlen($pdf);
        $kids = '';
        foreach ($pageObjs as $p) $kids .= $p . " 0 R ";
        $pdf .= "$cnt 0 obj\n<< /Type /Pages /Kids [ $kids] /Count " . count($pageObjs) . " >>\nendobj\n";
        $pagesId = $cnt;
        $cnt++;

        // Catalog
        $objOffsets[] = strlen($pdf);
        $pdf .= "$cnt 0 obj\n<< /Type /Catalog /Pages $pagesId 0 R >>\nendobj\n";

        $startxref = strlen($pdf);
        $pdf .= "xref\n0 " . ($cnt+1) . "\n0000000000 65535 f \n";
        foreach ($objOffsets as $off) {
            $pdf .= sprintf('%010d 00000 n \n', $off);
        }
        $pdf .= "trailer\n<< /Size " . ($cnt+1) . " /Root " . $cnt . " 0 R >>\nstartxref\n" . $startxref . "\n%%EOF";

        // Return PDF as string
        if ($dest === 'S') {
            return $pdf;
        }

        // Output to browser
        $disposition = ($dest === 'D') ? 'attachment' : 'inline';
        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . $disposition . '; filename="' . $name . '"');
        echo $pdf;
    }
}
