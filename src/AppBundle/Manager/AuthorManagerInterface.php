<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Author;
use AppBundle\Exception\AuthorException;
use Doctrine\ORM\ORMException;

/**
 * Interface AuthorManagerInterface
 */
interface AuthorManagerInterface
{
    /**
     * @param array $authorData
     *
     * @return Author
     */
    public function createAuthor(array $authorData): Author;

    /**
     * @param Author $author
     * @param bool   $flush
     *
     * @throws ORMException
     * @throws \InvalidArgumentException
     */
    public function saveAuthor(Author $author, bool $flush = false): void;

    /**
     * @param Author $author
     * @param array  $authorData
     *
     * @return Author
     *
     * @throws AuthorException
     */
    public function editAuthor(Author $author, array $authorData): Author;

    /**
     * @return Author[]
     */
    public function getAllAuthors() : array;
}