<?php

namespace App\Controller\Admin;

use App\Entity\Seance;
use App\Form\Admin\SeanceType;
use App\Repository\SeanceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/seance")
 */
class SeanceController extends AbstractController
{
	/**
	 * @Route("/", name="admin.seance.index", methods={"GET"})
	 */
	public function index(Request $request, SeanceRepository $seanceRepository, PaginatorInterface $paginator): Response
	{
		$seances = $paginator->paginate(
			$seanceRepository->getQuerySeances(),
			$request->get('page', '1'),
			20);
		return $this->render('admin/seance/index.html.twig', [
			'seances' => $seances,
		]);
	}

	/**
	 * @Route("/new", name="admin.seance.new", methods={"GET", "POST"})
	 */
	public function new(Request $request): Response
	{
		$seance = new Seance();
		$form = $this->createForm(SeanceType::class, $seance);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($seance);
			$entityManager->flush();

			return $this->redirectToRoute('admin.seance.index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('admin/seance/new.html.twig', [
			'seance' => $seance,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}/edit", name="admin.seance.edit", methods={"GET", "POST"})
	 */
	public function edit(Request $request, Seance $seance): Response
	{
		$form = $this->createForm(SeanceType::class, $seance);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('admin.seance.index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('admin/seance/edit.html.twig', [
			'seance' => $seance,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}", name="admin.seance.delete", methods={"POST"})
	 */
	public function delete(Request $request, Seance $seance): Response
	{
		if ($this->isCsrfTokenValid('delete' . $seance->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($seance);
			$entityManager->flush();
		}

		return $this->redirectToRoute('admin.seance.index', [], Response::HTTP_SEE_OTHER);
	}
}
