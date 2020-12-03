<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Exception\AuthorException;
use AppBundle\Form\AuthorType;
use AppBundle\Manager\AuthorManagerInterface;
use AppBundle\Repository\AuthorRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AuthorController extends Controller
{
    /**
     * @var AuthorManagerInterface
     */
    private $authorManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AuthorController constructor.
     *
     * @param AuthorManagerInterface $authorManager
     * @param LoggerInterface        $logger
     */
    public function __construct(AuthorManagerInterface $authorManager, LoggerInterface $logger)
    {
        $this->authorManager = $authorManager;
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="author_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'books' => $this->authorManager->getAllAuthors(),
        ]);
    }

    /**
     * @Route("/new", name="author_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        if ($request->isMethod('POST')) {
            try {
                $author = $this->authorManager->createAuthor($request->request->all());
                $this->authorManager->saveAuthor($author, true);

                return $this->redirectToRoute('author_index');
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('author/new.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="author_show", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="author_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);

        if ($request->isMethod('POST')) {
            try {
                $author = $this->authorManager->editAuthor($author, $request->request->all());
                $this->authorManager->saveAuthor($author, true);

                return $this->redirectToRoute('author_index');
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }
}
