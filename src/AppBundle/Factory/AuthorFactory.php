<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Author;

/**
 * Interface AuthorFactory
 */
class AuthorFactory
{
    /**
     * @return Author
     */
    public static function create(): Author
    {
        return new Author();
    }
}