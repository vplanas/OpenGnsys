<?php

/*
 * This file is part of the Opengnsys Project package.
 *
 * Created by Miguel Angel de Vega on 18/03/16. <miguelangel.devega@sic.com>
 * Copyright (c) 2015 Opengnsys. All rights reserved.
 *
 */
 
namespace Opengnsys\ServerBundle\Controller\Api;

use FOS\RestBundle\Context\Context;
use Opengnsys\ServerBundle\Entity\SoftwareProfile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\FormTypeInterface;


use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Opengnsys\CoreBundle\Exception\InvalidFormException;
use Opengnsys\CoreBundle\Controller\ApiController;

/**
 * @RouteResource("SoftwareProfile")
 */
class SoftwareProfileController extends ApiController
{	
	
	/**
	 * Options a SoftwareProfile from the submitted data.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Options SoftwareProfile",
	 * )
	 *
	 * @param Request $request the request object
	 *
	 * @return Response
	 */
	public function optionsAction(Request $request)
    {
        $request->setRequestFormat($request->get('_format'));
		$array = array();
		$array['class'] = SoftwareProfile::class;
		$array['options'] = array();
		
		$options = $this->container->get('nelmio_api_doc.parser.form_type_parser')->parse($array);
		return $options;
	}
	
	/**
	 * List all SoftwareProfile.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   statusCodes = {
	 *     200 = "Returned when successful"
	 *   }
	 * )
	 *
	 * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing objects.")
	 * @Annotations\QueryParam(name="limit", requirements="\d+", nullable=true, description="How many objects to return.")
	 *
	 * @Annotations\View(templateVar="SoftwareProfile", serializerGroups={"opengnsys_server__software_profile_cget"})
	 *
	 * @param Request               $request      the request object
	 * @param ParamFetcherInterface $paramFetcher param fetcher service
	 *
	 * @return array
	 */
	public function cgetAction(Request $request, ParamFetcherInterface $paramFetcher)
	{
        $request->setRequestFormat($request->get('_format'));
		$offset = $paramFetcher->get('offset');
		$offset = null == $offset ? 0 : $offset;
		$limit = $paramFetcher->get('limit');
		
		$matching = $this->filterCriteria($paramFetcher);
		
		$objects = $this->container->get('opengnsys_server.software_profile_manager')->searchBy($limit, $offset, $matching);
			
		return $objects;
	}
	
	/**
	 * Get single SoftwareProfile.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Gets a SoftwareProfile for a given id",
	 *   output = "Opengnsys\ServerBundle\Entity\SoftwareProfile",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the softwareProfile is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="softwareProfile", serializerGroups={"opengnsys_server__software_profile_get"})
	 *
	 * @param int     $slug      the softwareProfile id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when softwareProfile not exist
	 */
	public function getAction(Request $request, $slug)
	{
        $request->setRequestFormat($request->get('_format'));
        $object = $this->getOr404($slug);

        $groups = array();
        $groups[] = 'opengnsys_server__software_profile_get';
        $groups[] = 'opengnsys_server__software_cget';

        $response = $this->view($object);
        $context = new Context();
        $context->addGroups($groups);
        $response->setContext($context);

        return $response;
	}
	
	/**
	 * Create a SoftwareProfile from the submitted data.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Creates a new object from the submitted data.",
	 *   input = {"class" = "Opengnsys\ServerBundle\Form\Type\Api\SoftwareProfileType", "name" = ""},
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(
	 *  template = "object",
	 *  serializerGroups={"opengnsys_server__software_profile_get"},
	 *  statusCode = Response::HTTP_CREATED
	 * )
	 *
	 * @param Request $request the request object
	 *
	 * @return FormTypeInterface|View
	 */
	public function cpostAction(Request $request)
	{
        $request->setRequestFormat($request->get('_format'));
		try {
			$object = $this->container->get('opengnsys_server.software_profile_manager')->post(
					$request->request->all()
			);	
			
			/*
			if (is_object($this->getUser()))
			{
				$admin = $this->container->get('globunet_api.admin.object');
				$admin->createObjectSecurity($object);
			}
			*/
	
			return $object;
	
		} catch (InvalidFormException $exception) {
	
			return $exception->getForm();
		}
	}
	
	/**
	 * Update existing SoftwareProfile from the submitted data or create a new SoftwareProfile at a specific location.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   input = {"class" = "Opengnsys\ServerBundle\Form\Type\Api\SoftwareProfileType", "name" = ""},
	 *   statusCodes = {
	 *     204 = "Returned when successful",
	 *     400 = "Returned when the form has errors"
	 *   }
	 * )
	 *
	 * @Annotations\View(
	 *  template = "object",
	 *  serializerGroups={"opengnsys_server__software_profile_get"},
	 *  statusCode = Response::HTTP_OK
	 * )
	 *
	 * @param Request $request the request object
	 * @param int     $slug      the softwareProfile id
	 *
	 * @return FormTypeInterface|View
	 *
	 * @throws NotFoundHttpException when SoftwareProfile not exist
	 */
	public function patchAction(Request $request, $slug)
	{
        $request->setRequestFormat($request->get('_format'));
		try {
			$object = $this->container->get('opengnsys_server.software_profile_manager')->patch(
					$this->getOr404($slug),
					$request->request->all()
			);
	
			return $object;
			
		} catch (InvalidFormException $exception) {
	
			return $exception->getForm();
		}
	}
	
	/**
	 * Delete single SoftwareProfile.
	 *
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Delete a SoftwareProfile for a given id",
	 *   output = "Opengnsys\ServerBundle\Entity\SoftwareProfile",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     404 = "Returned when the softwareProfile is not found"
	 *   }
	 * )
	 *
	 * @Annotations\View(templateVar="delete")
	 *
	 * @param int $slug the object id
	 *
	 * @return array
	 *
	 * @throws NotFoundHttpException when object not exist
	 */
	public function deleteAction(Request $request, $slug)
	{
        $request->setRequestFormat($request->get('_format'));
		$object = $this->getOr404($slug);
		$object = $this->container->get('opengnsys_server.software_profile_manager')->delete($object);
	
		return $this->view(null, Response::HTTP_NO_CONTENT);
	}
	
	/**
	 * Fetch a SoftwareProfile or throw an 404 Exception.
	 *
	 * @param mixed $slug
	 *
	 * @return SoftwareProfile
	 *
	 * @throws NotFoundHttpException
	 */
	protected function getOr404($slug)
	{
		if (!($object = $this->container->get('opengnsys_server.software_profile_manager')->get($slug))) {
			throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$slug));
		}
	
		return $object;
	}
}