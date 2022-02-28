<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Form\Admin\FilmType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/film")
 */
class FilmController extends AbstractController
{
	/**
	 * @Route("/", name="admin.film.index", methods={"GET"})
	 */
	public function index(FilmRepository $filmRepository): Response
	{
		return $this->render('admin/film/index.html.twig', [
			'films' => $filmRepository->findAll(),
		]);
	}


	/**
	 * @Route("/new", name="admin.film.new", methods= {"GET","POST"})
	 */
	public function new(Request $request): Response
	{
		$film = new Film();
		$form = $this->createForm(FilmType::class, $film);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($film);
			$entityManager->flush();

			return $this->redirectToRoute('admin.film.index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('admin/film/new.html.twig', [
			'film' => $film,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}/edit", name="admin.film.edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Film $film): Response
	{
		$form = $this->createForm(FilmType::class, $film);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('admin.film.index', [], Response::HTTP_SEE_OTHER);
		}

		return $this->renderForm('admin/film/edit.html.twig', [
			'film' => $film,
			'form' => $form,
		]);
	}

	/**
	 * @Route("/{id}", name="admin.film.delete", methods={"POST"})
	 */
	public function delete(Request $request, Film $film): Response
	{
		if ($this->isCsrfTokenValid('delete' . $film->getId(), $request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($film);
			$entityManager->flush();
		}

		return $this->redirectToRoute('admin.film.index', [], Response::HTTP_SEE_OTHER);
	}
}
