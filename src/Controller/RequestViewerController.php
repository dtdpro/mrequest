<?php

namespace App\Controller;

use App\Entity\Bin;
use http\Cookie;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestViewerController extends AbstractController
{
    private $requestStack;
    private $bins;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        $session = $this->requestStack->getSession();

        if (!$this->bins = $session->get('bins')) {
            $this->bins = [];
            $session->set('bins',$this->bins);
        }

    }

    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('request_viewer/home.html.twig', ['bins'=>$this->bins]);
    }

    #[Route('/create', name: 'bin_create')]
    public function create(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $session = $this->requestStack->getSession();

        $bin = new Bin();
        $bin->setExtId(Uuid::uuid4());

        $entityManager->persist($bin);
        $entityManager->flush();

        $this->bins[] = $bin->getExtId();

        $session->set('bins',$this->bins);

        return $this->redirectToRoute('bin_view', ['id' => $bin->getExtId()]);
    }

    #[Route('/view/{id}', name: 'bin_view')]
    public function view($id): Response
    {
        $session = $this->requestStack->getSession();

        $binRepo = $this->getDoctrine()->getRepository(Bin::class);
        $bin = $binRepo->findOneBy(['ExtId'=>$id]);

        if (!$bin) {
            throw $this->createNotFoundException('The page does not exist');
        }

        if (!in_array($bin->getExtId(),$this->bins)) {
            $this->bins[] = $bin->getExtId();
            $session->set('bins',$this->bins);
        }

        $viewUrl = $this->generateUrl('request_bin_record', ['id' => $bin->getExtId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('request_viewer/view.html.twig', [
            'bin' => $bin,
            'viewUrl' => $viewUrl,
            'bins'=>$this->bins
        ]);
    }
}
