<?php

namespace ThreeWS\PdfTools;

use ThreeWS\PdfTools\Exceptions\OpenOutputException;
use ThreeWS\PdfTools\Exceptions\OpenPDFException;
use ThreeWS\PdfTools\Exceptions\OtherException;
use ThreeWS\PdfTools\Exceptions\PDFPermissionException;

class Jpg
{
    protected $file;
    protected $quality;
    protected $progressive;

    public function __construct($file, $quality = '60', $progressive = 'y')
    {
        $this->file = $file;
        $this->quality = $quality;
        $this->progressive = $progressive;
    }

    public function convert()
    {
        exec("pdftocairo -jpeg -jpegopt quality=$this->quality,progressive=$this->progressive -singlefile $this->file $this->file", $output, $returnVar);

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
