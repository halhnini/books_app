<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Book;

/**
 * Interface BookFactory
 */
class BookFactory
{
    /**
     * @return Book
     */
    public static function create(): Book
    {
        return new Book();
    }
}