# PDF Tools

## Requirements

This library depends on poppler utils which can be installed by the following.

Debian / Ubuntu
```bash
apt install poppler-utils
apt install ghostscript
```

OSX
```bash
brew install poppler
```

## Installation

```bash
composer require 3ws-internet-oplossingen/pdf-tools
```

## Usage of the package

### Info

Gather all information about a PDF file like Page count.


```php
$pdf = new ThreeWS\PdfTools\Info('location_to_pdf.pdf');
var_dump($pdf->toArray());
```

### Jpg

Convert a PDF page to a JPG file.

```php
$pdf = new ThreeWS\PdfTools\Jpg('location_to_pdf.pdf', 60, 'y');
var_dump($pdf->convert());
```

### Separate

Convert a PDF file with multiple pages into multiple single page PDF's using a pattern with replacement of %d.

```php
$pdf = new ThreeWS\PdfTools\Separate('location_to_pdf.pdf', 'location_to_paged_%d_pdf.pdf');
```

### Text

Extract Text from a PDF file.

```php
$pdf = new ThreeWS\PdfTools\Text('location_to_pdf.pdf');
var_dump($pdf->convert());
```
