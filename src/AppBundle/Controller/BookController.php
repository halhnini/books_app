<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Form\BookType;
use AppBundle\Manager\BookManagerInterface;
use AppBundle\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/book")
 */
class BookController extends Controller
{
    /**
     * @var BookManagerInterface
     */
    private $bookManager;

    /**
     * BookController constructor.
     * @param BookManagerInterface $bookManager
     */
    public function __construct(BookManagerInterface $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->bookManager->getAllBooks(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        if ($request->isMethod('POST')) {
            try {
                $book = $this->bookManager->createBook($request->request->all());
                $this->bookManager->saveBook($book, true);

                return $this->redirectToRoute('book_index');
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);

        if ($request->isMethod('POST')) {
            try {
                $book = $this->bookManager->editBook($book, $request->request->all());
                $this->bookManager->saveBook($book, true);

                return $this->redirectToRoute('book_index');
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }
}
