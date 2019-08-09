<?php

namespace ThreeWS\PdfTools;

use ThreeWS\PdfTools\Exceptions\OpenOutputException;
use ThreeWS\PdfTools\Exceptions\OpenPDFException;
use ThreeWS\PdfTools\Exceptions\OtherException;
use ThreeWS\PdfTools\Exceptions\PDFPermissionException;

class PageExtractor
{
    protected $file;
    protected $outputfile;
    protected $page;

    public function __construct($file, $page, $outputfile = null)
    {
        $this->file = $file;
        $this->outputfile = $outputfile;
        $this->page = $page;
    }

    public function convert()
    {
        if (is_null($this->outputfile)) {
            if (strtolower(substr($this->file, -4)) == '.pdf') {
                $parts = explode('.pdf', $this->file);
                $outputfile = $parts[0].'-'.escapeshellarg($this->page).'.pdf';
            } else {
                $outputfile = escapeshellarg($this->file).'-'.escapeshellarg($this->page);
            }
        } else {
            $outputfile = escapeshellarg($this->outputfile);
        }

        $file = escapeshellarg($this->file);
        $page = escapeshellarg($this->page);

        exec("ps2pdf -dFirstPage=$page -dLastPage=$page -dPDFSETTINGS=/ebook -dUseFlateCompression=true -dOptimize=true $file $outputfile", $output, $returnVar);

        switch ($returnVar) {
            case 1:
                throw new OpenPDFException("Error opening PDF file: {$this->file}.");
                break;
            case 2:
                throw new OpenOutputException();
                break;
            case 3:
                throw new PDFPermissionException();
                break;
            case 99:
                throw new OtherException();
                break;
            default:
                break;
        }

        return $returnVar;
    }
}
