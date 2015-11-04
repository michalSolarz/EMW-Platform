<?php

namespace Acme\Bundle\EventManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function manageUserRolesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $modifiedUser = $em->getRepository('AcmeEventManagerBundle:User')->find($id);

        if (!$this->getUser()->hasRole('ROLE_GOD') || $modifiedUser === $this->getUser()) {
            return $this->redirect($this->generateUrl('admin_list_users'));
        }

        $rolesInDatabase = array('ROLE_USER', 'ROLE_ADMIN', 'ROLE_GOD');

        $userRoles = $modifiedUser->getRoles();

        $availableRoles = array_diff($rolesInDatabase, $userRoles);

        if (($key = array_search('ROLE_USER', $userRoles)) !== false) {
            unset($userRoles[$key]);
        }

        if ($request->isMethod('POST')) {
            if ($request->get('removeRole') != null && in_array($request->get('removeRole'), $userRoles)) {
                if (!$modifiedUser->hasRole('ROLE_USER'))
                    $modifiedUser->addRole('ROLE_USER');
                $modifiedUser->removeRole($request->get('removeRole'));
            }
            if ($request->get('addRole') != null && in_array($request->get('addRole'), $availableRoles))
                $modifiedUser->addRole($request->get('addRole'));

            $em->flush();
            return $this->redirect($this->generateUrl('admin_list_users'));
        }
        return $this->render('AcmeEventManagerBundle:User:manageUserRoles.html.twig', array(
            'userRoles' => $userRoles,
            'availableRoles' => $availableRoles,
        ));
    }

}
