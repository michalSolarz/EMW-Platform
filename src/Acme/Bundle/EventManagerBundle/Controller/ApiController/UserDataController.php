<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 03.08.15
 * Time: 15:37
 */

namespace Acme\Bundle\EventManagerBundle\Controller\ApiController;


use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

class UserDataController extends FOSRestController
{
    /**
     * Search for countries with passed letters.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the resource is not found"
     *   }
     * )
     * @Annotations\QueryParam(name="searchTerm",
     *                          requirements="[a-zA-Z]+",
     *                          nullable=true,
     *                          description="Search for countries with that letters.")
     * @Annotations\QueryParam(name="limit",
     *                          requirements="\d+",
     *                          default="5",
     *                          description="How many countries to return.")
     * @Annotations\QueryParam(name="order",
     *                          requirements="(ASC|DESC)",
     *                          default="ASC",
     *                          description="Ascending or descending order.")
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getCountriesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $apiRequestHandler = $this->get('acme_event_manager.api_request_handler');
        $searchTerm = $paramFetcher->get('searchTerm');
        $limit = $paramFetcher->get('limit');
        $order = $paramFetcher->get('order');

        $data = $apiRequestHandler->searchForCountries($searchTerm, $limit, $order);
        $view = $this->view($data, 200);
        if (empty($data)) {
            $view->setStatusCode(404);
        }
        return $this->handleView($view);
    }

    /**
     * Search for faculties with passed letters.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the resource is not found"
     *   }
     * )
     * @Annotations\QueryParam(name="searchTerm",
     *                          requirements="[a-zA-Z]+",
     *                          nullable=true,
     *                          description="Search for faculties with that letters.")
     * @Annotations\QueryParam(name="limit",
     *                          requirements="\d+",
     *                          default="5",
     *                          description="How many faculties to return.")
     * @Annotations\QueryParam(name="order",
     *                          requirements="(ASC|DESC)",
     *                          default="ASC",
     *                          description="Ascending or descending order.")
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getFacultiesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $apiRequestHandler = $this->get('acme_event_manager.api_request_handler');
        $searchTerm = $paramFetcher->get('searchTerm');
        $limit = $paramFetcher->get('limit');
        $order = $paramFetcher->get('order');

        $data = $apiRequestHandler->searchForFaculties($searchTerm, $limit, $order);
        $view = $this->view($data, 200);
        if (empty($data)) {
            $view->setStatusCode(404);
        }
        return $this->handleView($view);
    }

    /**
     * Search for universities with passed letters.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the resource is not found"
     *   }
     * )
     * @Annotations\QueryParam(name="searchTerm",
     *                          requirements="[a-zA-Z]+",
     *                          nullable=true,
     *                          description="Search for universities with that letters.")
     * @Annotations\QueryParam(name="limit",
     *                          requirements="\d+",
     *                          default="5",
     *                          description="How many universities to return.")
     * @Annotations\QueryParam(name="order",
     *                          requirements="(ASC|DESC)",
     *                          default="ASC",
     *                          description="Ascending or descending order.")
     *
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getUniversitiesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $apiRequestHandler = $this->get('acme_event_manager.api_request_handler');
        $searchTerm = $paramFetcher->get('searchTerm');
        $limit = $paramFetcher->get('limit');
        $order = $paramFetcher->get('order');

        $data = $apiRequestHandler->searchForUniversities($searchTerm, $limit, $order);
        $view = $this->view($data, 200);
        if (empty($data)) {
            $view->setStatusCode(404);
        }
        return $this->handleView($view);
    }
}