<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 08.10.15
 * Time: 09:06
 */

namespace Acme\Bundle\EventManagerBundle\Util;


use Spraed\PDFGeneratorBundle\PDFGenerator\PDFGenerator;
use Symfony\Component\HttpFoundation\Response;

class PdfExportHandler
{
    private $pdfGenerator;
    private $fileName = 'papers-content-export';

    public function __construct(PDFGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function exportToMultiplePagesPdf(array $htmlCollection, $filename = null)
    {
        if ($filename != null)
            $this->fileName = $filename;

        return new Response($this->pdfGenerator->generatePDFs($htmlCollection, 'UTF-8'),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $this->fileName . '"'
            )

        );
    }
}