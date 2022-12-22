<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends AbstractController
{
  /**
   * This is the route the user can use to logout.
   *
   * But, this will never be executed. Symfony will intercept this first
   * and handle the logout automatically. See logout in config/packages/security.yaml
   */
  #[Route('/logout', name: 'security_logout')]
  public function logout(): void
  {
    throw new \Exception('This should never be reached!');
  }
}