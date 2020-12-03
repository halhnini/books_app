<?php
/*
 * This file is part of a Geniuses project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\Exception;

/**
 * Class AuthorException
 */
class AuthorException extends \Exception
{
    const FORM_VALIDATION_TRACE_CODE = 'FORM_VALIDATION_ERROR';
    const FORM_VALIDATION_MESSAGE = 'error.author.form_validation';
}
