<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayAllController extends AbstractController
{
    #[Route(path: '/', name: 'display_all_index')]
    public function mainAction(): Response
    {
        return $this->render('product/display_all.html.twig');
    }
}