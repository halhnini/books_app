<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Book;
use AppBundle\Exception\BookException;
use AppBundle\Factory\BookFactory;
use AppBundle\Form\BookType;
use AppBundle\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookManager implements BookManagerInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * AuthorManager constructor.
     *
     * @param FormFactoryInterface   $formFactory
     * @param ValidatorInterface     $validator
     * @param EntityManagerInterface $entityManager
     * @param BookRepository         $bookRepository
     */
    public function __construct(FormFactoryInterface $formFactory, ValidatorInterface $validator, EntityManagerInterface $entityManager, BookRepository $bookRepository)
    {
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->bookRepository = $bookRepository;
    }


    /**
     * @inheritDoc
     */
    public function createBook(array $BookData): Book
    {
        $book = BookFactory::create();
        $authorForm = $this->formFactory->create(BookType::class, $book);
        $authorForm->submit($BookData);
        $this->validateBook($book);

        return $book;
    }

    /**
     * @inheritDoc
     */
    public function saveBook(Book $book, bool $flush = false): void
    {
        $this->entityManager->persist($book);

        if($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function editBook(Book $book, array $bookData): Book
    {
        $authorForm = $this->formFactory->create(BookType::class, $book, [
            'method' => Request::METHOD_PATCH,
        ]);
        $authorForm->submit($bookData);
        $this->validateAuthor($book);

        return $book;
    }

    /**
     * @param Book $book
     *
     * @throws BookException
     */
    private function validateBook(Book $book): void
    {
        $errors = $this->validator->validate($book);
        if (0 === $errors->count()) {
            return;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAllBooks() : array
    {
        return $this->bookRepository->findAll();
    }
}