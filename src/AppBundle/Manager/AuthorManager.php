<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Author;
use AppBundle\Exception\AuthorException;
use AppBundle\Factory\AuthorFactory;
use AppBundle\Form\AuthorType;
use AppBundle\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorManager implements AuthorManagerInterface
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
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * AuthorManager constructor.
     *
     * @param FormFactoryInterface   $formFactory
     * @param ValidatorInterface     $validator
     * @param EntityManagerInterface $entityManager
     * @param AuthorRepository       $authorRepository
     */
    public function __construct(FormFactoryInterface $formFactory, ValidatorInterface $validator, EntityManagerInterface $entityManager, AuthorRepository $authorRepository)
    {
        $this->formFactory = $formFactory;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->authorRepository = $authorRepository;
    }


    /**
     * @inheritDoc
     */
    public function createAuthor(array $authorData): Author
    {
        $author = AuthorFactory::create();
        $authorForm = $this->formFactory->create(AuthorType::class, $author);
        $authorForm->submit($authorData);
        $this->validateAuthor($author);

        return $author;
    }

    /**
     * @inheritDoc
     */
    public function saveAuthor(Author $author, bool $flush = false): void
    {
        $this->entityManager->persist($author);

        if($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @inheritDoc
     */
    public function editAuthor(Author $author, array $authorData): Author
    {
        $authorForm = $this->formFactory->create(AuthorType::class, $author, [
            'method' => Request::METHOD_PATCH,
        ]);
        $authorForm->submit($authorData);
        $this->validateAuthor($author);

        return $author;
    }

    /**
     * @param Author $author
     *
     * @throws AuthorException
     */
    private function validateAuthor(Author $author): void
    {
        $errors = $this->validator->validate($author);
        if (0 === $errors->count()) {
            return;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAllAuthors() : array
    {
        return $this->authorRepository->findAll();
    }
}