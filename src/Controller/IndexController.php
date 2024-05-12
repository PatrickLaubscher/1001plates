<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $finder = new Finder();
        $finder->files()->in('/../data/')->name('liste_ville.json');

        foreach ($finder as $file) {
            $jsonContent = $file->getContents();
            $villes = json_decode($jsonContent, true);
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'Accueil'
        ]);
    }
}
