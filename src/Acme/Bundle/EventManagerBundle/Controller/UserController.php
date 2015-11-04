<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function listUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->hasRole('ROLE_GOD'))
            $users = $em->getRepository('AcmeEventManagerBundle:User')->provideUsersAndAdmins($this->getUser());
        elseif ($this->getUser()->hasRole('ROLE_ADMIN'))
            $users = $em->getRepository('AcmeEventManagerBundle:User')->provideUsers($this->getUser());

        return $this->render('AcmeEventManagerBundle:User:listUsers.html.twig', array(
            'users' => $users,
        ));
    }

    public function displayUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AcmeEventManagerBundle:User')->find($id);
        if ($user === $this->getUser() || ($user->hasRole('ROLE_ADMIN') && !$this->getUser()->hasRole('ROLE_GOD'))) {
            return $this->redirect($this->generateUrl('admin_list_users'));
        }
        return $this->render('AcmeEventManagerBundle:User:displayUser.html.twig', array(
            'user' => $user,
        ));
    }

    public function manageUserRolesAction()
    {
        return $this->render('AcmeEventManagerBundle:User:manageUserRoles.html.twig', array(// ...
        ));
    }

}
