<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 18.08.15
 * Time: 21:59
 */

namespace Acme\Bundle\EventManagerBundle\Util;


class CSVParser
{
    public function parseUniqueEntriesCSV($file)
    {
        $results = array();
        if (($handle = fopen($file, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, $file->getClientSize(), ',')) !== FALSE) {
                if (!in_array($data, $results)) {
                    $results[] = $data;
                }
            }
            fclose($handle);
        }
        return $results;
    }
}