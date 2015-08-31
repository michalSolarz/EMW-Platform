<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 21.08.15
 * Time: 13:55
 */

namespace Acme\Bundle\EventManagerBundle\Model;


use Doctrine\ORM\EntityManager;

class ApiRequestHandler
{
    private $entityManager;
    private $queryBuilder;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
    }

    /**
     * @param string $searchTerm
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function searchForCountries($searchTerm, $limit, $order)
    {
        $query = $this->queryBuilder->select('country.name')
            ->from('AcmeEventManagerBundle:Country', 'country')
            ->where(
                $this->queryBuilder->expr()
                    ->like('country.name', ':countryName')
            )
            ->orderBy('country.name', $order)
            ->setParameter('countryName', '%' . $searchTerm . '%')
            ->setMaxResults($limit)
            ->getQuery();
        $rawResults = $query->getArrayResult();

        $results = array();
        foreach ($rawResults as $country) {
            $results[] = $country['name'];
        }

        return $results;
    }

    /**
     * @param string $searchTerm
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function searchForFaculties($searchTerm, $limit, $order)
    {
        $query = $this->queryBuilder->select('faculty.name')
            ->from('AcmeEventManagerBundle:Faculty', 'faculty')
            ->where(
                $this->queryBuilder->expr()
                    ->like('faculty.name', ':facultyName')
            )
            ->orderBy('faculty.name', $order)
            ->setParameter('facultyName', '%' . $searchTerm . '%')
            ->setMaxResults($limit)
            ->getQuery();
        $rawResults = $query->getArrayResult();

        $results = array();
        foreach ($rawResults as $faculty) {
            $results[] = $faculty['name'];
        }

        return $results;
    }

    /**
     * @param string $searchTerm
     * @param int $limit
     * @param string $order
     * @return array
     */
    public function searchForUniversities($searchTerm, $limit, $order)
    {
        $query = $this->queryBuilder->select('university.name, university.address')
            ->from('AcmeEventManagerBundle:University', 'university')
            ->where(
                $this->queryBuilder->expr()
                    ->like('university.name', ':universityName')
            )
            ->orderBy('university.name', $order)
            ->setParameter('universityName', '%' . $searchTerm . '%')
            ->setMaxResults($limit)
            ->getQuery();
        $rawResults = $query->execute();

        $results = array();
        foreach ($rawResults as $university) {
            $temporaryArray = array();
            $temporaryArray['value'] = $university['name'];
            $temporaryArray['address'] = $university['address'];
            $results[] = $temporaryArray;
        }

        return $results;
    }
}