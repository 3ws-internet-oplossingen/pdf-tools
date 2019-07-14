<?php

namespace ThreeWS\PDFTools;

class Separate
{
    protected $file;
    protected $pattern;

    public function __construct($file, $pattern)
    {
        $this->file = $file;
        $this->pattern = $pattern;
    }

    public function separate()
    {
        $cmd = escapeshellarg('pdfseparate');
        $file = escapeshellarg($this->file);
        $pattern = escapeshellarg($this->pattern);
        exec("$cmd $file $pattern", $output, $returnVar);
    }
}