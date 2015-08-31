<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.08.15
 * Time: 19:00
 */

namespace Acme\Bundle\EventManagerBundle\Util;


use Doctrine\ORM\EntityManager;

class CSVExportHandler
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function exportCountryList()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('country.name')
            ->from('AcmeEventManagerBundle:Country', 'country');
        $query = $qb->getQuery();
        $countryList = $query->getArrayResult();

        $handle = fopen('php://output', 'w+');
        foreach ($countryList as $country) {
            fputcsv($handle, $country);
        }
        fclose($handle);
        return $handle;
    }

    public function exportFacultyList()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('faculty.name')
            ->from('AcmeEventManagerBundle:Faculty', 'faculty');
        $query = $qb->getQuery();
        $countryList = $query->getArrayResult();

        $handle = fopen('php://output', 'w+');
        foreach ($countryList as $country) {
            fputcsv($handle, $country);
        }
        fclose($handle);
        return $handle;
    }
}