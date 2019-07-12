<?php

namespace ThreeWS\PDFTools;

class Text
{
    protected $file;
    protected $text_path;

    public function __construct($file, $text_path = null)
    {
        $this->file = $file;
        $this->text_path = $text_path;
        $this->convert();
    }

    private function convert()
    {
        $cmd = escapeshellarg('pdftotext');
        $file = escapeshellarg($this->file);
        $text_path = escapeshellarg($this->text_path);
        exec("$cmd $file $text_path", $output, $returnVar);
    }
}