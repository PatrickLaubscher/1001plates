<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccessDeniedHandler extends AbstractController implements AccessDeniedHandlerInterface
{   
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {

        $content = $this->renderView('errors/access_denied.html.twig');

        return new Response($content, 403);

    }
}