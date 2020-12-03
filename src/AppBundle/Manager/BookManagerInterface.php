<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Book;
use AppBundle\Exception\BookException;
use Doctrine\ORM\ORMException;

/**
 * Interface BookManagerInterface
 */
interface BookManagerInterface
{
    /**
     * @param array $bookData
     *
     * @return Book
     */
    public function createBook(array $bookData): Book;

    /**
     * @param Book $book
     * @param bool $flush
     *
     * @throws ORMException
     * @throws \InvalidArgumentException
     */
    public function saveBook(Book $book, bool $flush = false): void;

    /**
     * @param Book  $book
     * @param array $bookData
     *
     * @return Book
     *
     * @throws BookException
     */
    public function editBook(Book $book, array $bookData): Book;

    /**
     * @return Book[]
     */
     public function getAllBooks() : array;
}