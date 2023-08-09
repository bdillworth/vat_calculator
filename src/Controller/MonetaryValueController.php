<?php

namespace App\Controller;

use App\Entity\MonetaryValue;
use App\Repository\MonetaryValueRepository;
use App\Form\MonetaryValueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MonetaryValueController extends AbstractController
{

  private $em;
  private $monetaryValueRepository;
  public function __construct(MonetaryValueRepository $monetaryValueRepository, EntityManagerInterface $em)
  {
    $this->monetaryValueRepository = $monetaryValueRepository;
    $this->em = $em;
  }

  #[Route('/', name: 'index')]
  public function index(Request $request): Response
  {
    $monetaryValue = new MonetaryValue();

    $form = $this->createForm(MonetaryValueType::class, $monetaryValue);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $amount = $form->get('originalAmount')->getData();
      $vatStatus = $form->get('vatStatus')->getData();
      $vatRate = $form->get('vatRate')->getData();
      if ($vatStatus == 'including') {
        $monetaryValue->setIncludingVat($amount);
        $vatDiv = 1 + ($vatRate / 100);
        $monetaryValue->setExcludingVat(number_format($amount / $vatDiv, 2));
      } else {
        $monetaryValue->setExcludingVat($amount);
        $vat = ($amount / 100) * $vatRate;
        $monetaryValue->setIncludingVat(number_format($amount + $vat, 2));
      }

      $this->em->persist($monetaryValue);
      $this->em->flush();

      return $this->redirectToRoute('history');
    }

    return $this->render('vat_calculator/index.html.twig', [
      'form' => $form,
    ]);
  }

  #[Route('/history', name: 'history')]
  public function history(): Response
  {
    $monetaryValues = $this->monetaryValueRepository->findAll();

    return $this->render('vat_calculator/history.html.twig', [
      'monetaryValues' => $monetaryValues
    ]);
  }


  #[Route('/clear')]
  public function clearHistory(): Response
  {
    $this->em->createQuery('DELETE FROM App\Entity\MonetaryValue')->execute();

    return $this->redirectToRoute('index');
  }


  #[Route('/export', name: 'export')]
  public function exportToCSV(): Response
  {

    $monetaryValues = $this->monetaryValueRepository->findAll();

    $response = new StreamedResponse();
    $response->setCallback(
      function () use ($monetaryValues) {
        $handle = fopen('php://output', 'r+');
        $data = array('Ref.', 'Original Amount', 'Excluding VAT', 'Including VAT', 'VAT Rate');
        fputcsv($handle, $data);
        foreach ($monetaryValues as $row) {
          $data = array(
            $row->getId(),
            $row->getOriginalAmount(),
            $row->getExcludingVat(),
            $row->getIncludingVat(),
            $row->getVatRate()
          );
          fputcsv($handle, $data);
        }
        fclose($handle);
      }
    );
    $response->headers->set('Content-Type', 'application/force-download');
    $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');

    return $response;
  }
}
