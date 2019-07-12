<?php

namespace ThreeWS\PDFTools;

use ThreeWS\PDFTools\Exceptions\CommandNotFoundException;
use ThreeWS\PDFTools\Exceptions\OpenOutputException;
use ThreeWS\PDFTools\Exceptions\OpenPDFException;
use ThreeWS\PDFTools\Exceptions\OtherException;
use ThreeWS\PDFTools\Exceptions\PDFPermissionException;

class Info
{
    protected $file;
    public $output;
    public $title;
    public $author;
    public $creator;
    public $producer;
    public $creationDate;
    public $modDate;
    public $tagged;
    public $form;
    public $pages;
    public $encrypted;
    public $pageSize;
    public $fileSize;
    public $optimized;
    public $PDFVersion;

    public function __construct($file)
    {
        $this->file = $file;
        $this->loadOutput();
        $this->parseOutput();
    }

    private function loadOutput()
    {
        $cmd = escapeshellarg('pdfinfo');
        $file = escapeshellarg($this->file);
        exec("$cmd $file", $output, $returnVar);
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
            case 127:
                throw new CommandNotFoundException();
                break;
            default:
                break;
        }

        $this->output = $output;
    }

    private function parseOutput()
    {
        $this->title = $this->parse('Title');
        $this->author = $this->parse('Author');
        $this->creator = $this->parse('Creator');
        $this->producer = $this->parse('Producer');
        $this->creationDate = $this->parse('CreationDate');
        $this->modDate = $this->parse('ModDate');
        $this->tagged = $this->parse('Tagged');
        $this->form = $this->parse('Form');
        $this->pages = $this->parse('Pages');
        $this->encrypted = $this->parse('Encrypted');
        $this->pageSize = $this->parse('Page size');
        $this->fileSize = $this->parse('File size');
        $this->optimized = $this->parse('Optimized');
        $this->PDFVersion = $this->parse('PDF version');
        $this->pageRot = $this->parse('Page rot');
    }

    private function parse($attribute)
    {
        $result = null;
        foreach ($this->output as $op) {
            // Extract the number
            if (preg_match("/".$attribute.":\s*(.+)/i", $op, $matches) === 1) {
                $result = $matches[1];
                break;
            }
        }

        return $result;
    }
}