<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 19.08.15
 * Time: 19:00
 */

namespace Acme\Bundle\EventManagerBundle\Util;


use Acme\Bundle\EventManagerBundle\Model\ParticipantsProvider;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CSVExportHandler
{
    private $entityManager;
    private $participantsProvider;
    private $eventParticipantsParameters;

    public function __construct(EntityManager $entityManager, ParticipantsProvider $participantsProvider)
    {
        $this->entityManager = $entityManager;
        $this->participantsProvider = $participantsProvider;
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
        $facultyList = $query->getArrayResult();

        $handle = fopen('php://output', 'w+');
        foreach ($facultyList as $faculty) {
            fputcsv($handle, $faculty);
        }
        fclose($handle);
        return $handle;
    }

    public function exportUniversityList()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('university.name')
            ->from('AcmeEventManagerBundle:University', 'university');
        $query = $qb->getQuery();
        $universityList = $query->getArrayResult();

        $handle = fopen('php://output', 'w+');
        foreach ($universityList as $university) {
            fputcsv($handle, $university);
        }
        fclose($handle);
        return $handle;
    }

    public function setParametersForEventParticipantsExport(array $parameters)
    {
        $this->eventParticipantsParameters = $parameters;
    }

    public function exportEventParticipantsList()
    {
        $event = $this->entityManager->getRepository('AcmeEventManagerBundle:Event')->find($this->eventParticipantsParameters['id']);

        if (!$event) {
            throw new NotFoundHttpException('Unable to found event with provided id');
        }

        $participants = $this->participantsProvider->provideParticipants($event, $this->eventParticipantsParameters['type'], $this->eventParticipantsParameters['period']);

        $handle = fopen('php://output', 'w+');
        foreach ($participants as $participant) {
            fputcsv($handle, array($participant['username'],
                $participant['email'],
                $participant['name'],
                $participant['surname'],
                $participant['gender'],
                $participant['nationality'],
                $participant['fieldOfStudies'],
                $participant['yearOfStudies'],
                $participant['phoneNumber'],
                $participant['isVegetarian'],
                $participant['needsVisa'],));
        }
        fclose($handle);
        return $handle;
    }
}