<?php

namespace App\Controller;


use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
	/** @var integer */
	const POST_LIMIT = 10;

	/** @var EntityManagerInterface */
	private $entityManager;

	/** @var ObjectRepository */
	private $userRepository;

	/** @var ObjectRepository */
	private $articleRepository;


	/**
	 * @param EntityManagerInterface $entityManager
	 */
	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
		$this->articleRepository = $entityManager->getRepository('App:Article');
		$this->userRepository = $entityManager->getRepository('App:User');
	}

	/**
	 * @Route("/", name="homepage")
	 * @param Request $request
	 * @return
	 */
    public function index(Request $request)
    {
        return $this->render('main/index.html.twig', [
            'article' => $this->articleRepository->findAllWithOrderAndLimit('DESC', 1, 1)
        ]);
    }

	/**
	 * @Route("/articles", name="article")
	 * @param Request $request
	 * @return Response
	 */
	public function articlesAction(Request $request)
	{
		$page = 1;

		if ($request->get('page')) {
			$page = $request->get('page');
		}
		return $this->render('main/articles.html.twig', [
			'articles' => $this->articleRepository->findAllWithOrderAndLimit('DESC', $page, self::POST_LIMIT),
			'totalArticle' => $this->articleRepository->getCount(),
			'page' => $page,
			'entryLimit' => self::POST_LIMIT
		]);
	}
}
