<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 23/10/2017
 * Time: 10:09 AM
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

trait BaseControllerTrait
{
    /**
     * @return int|null
     */
    protected function getUserId()
    {
        /**@var $this Controller */
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        /**@var $user User */
        return $user->getId();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getDbManager()
    {
        return $this->getDoctrine()->getManager();
    }
}