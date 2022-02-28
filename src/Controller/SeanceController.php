<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Seance;
use App\Form\SearchForm;
use App\Repository\SeanceRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeanceController extends AbstractController
{
	/**
	 * @param SeanceRepository $seanceRepository
	 * @param Request          $request
	 * @return Response
	 * @Route("/", name="seance")
	 */
	public function index(SeanceRepository $seanceRepository, Request $request): Response
	{
		$data = new SearchData();
		$data->page = $request->get('page', 1);

		$form = $this->createForm(SearchForm::class, $data);
		$form->handleRequest($request);

		[$min, $max] = $seanceRepository->findMinMax($data);

		$seances = $seanceRepository->findSearch($data);

		if ($request->get('ajax')) {
			return new JsonResponse([
				'content' => $this->renderView('seance/_seances.html.twig', ['seances' => $seances]),
				'sorting' => $this->renderView('seance/_sorting.html.twig', ['seances' => $seances]),
				'pagination' => $this->renderView('seance/_pagination.html.twig', ['seances' => $seances])
			]);
		}

		return $this->renderForm('seance/index.html.twig', [
			'seances' => $seances,
			'form' => $form,
			'min' => $min,
			'max' => $max
		]);
	}

	/**
	 * @Route("/generate/{min}/{max}/{date?}", name="pdf.generate")
	 */
	public function generate($min, $max, ?\DateTime $date, SeanceRepository $repository)
	{
		$search = new SearchData();
		$search->showingDate = $date;
		$search->minPrice = $min;
		$search->maxPrice = $max;

		$seances = $repository->findSearch($search);


		$pdfOptions = new Options();
		$pdfOptions->set('defaultFont', 'Arial');

		$dompdf = new Dompdf($pdfOptions);

		$html = $this->renderView('seance/pdf.html.twig', [
			'seances' => $seances
		]);

		$dompdf->loadHtml($html);

		$dompdf->setPaper('A4', 'portrait');

		$dompdf->render();

		$dompdf->stream("file.pdf", [
			"Attachment" => true
		]);
	}

	/**
	 * @Route("/seance/{id}", name="seance.show", methods={"GET"})
	 */
	public function show(Seance $seance): Response
	{
		$films = $seance->getFilms();
		return $this->render('seance/show.html.twig', [
			'seance' => $seance,
			'films' => $films
		]);
	}
}
