<?php

namespace ThreeWS\PDFTools;

use ThreeWS\PDFTools\Exceptions\OpenOutputException;
use ThreeWS\PDFTools\Exceptions\OpenPDFException;
use ThreeWS\PDFTools\Exceptions\OtherException;
use ThreeWS\PDFTools\Exceptions\PDFPermissionException;

class Text
{
    protected $file;
    protected $text_path;

    public function __construct($file, $text_path = '-')
    {
        $this->file = $file;
        $this->text_path = $text_path;
    }

    public function convert()
    {
        $cmd = escapeshellarg('pdftotext');
        $file = escapeshellarg($this->file);
        $text_path = escapeshellarg($this->text_path);
        exec("$cmd $file $text_path", $output, $returnVar);

        switch ($returnVar) {
            case 1:
                throw new OpenPDFException();
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

        return $output;
    }
}