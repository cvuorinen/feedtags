<?php

namespace Feedtags\ApplicationBundle\Service\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Abstract Validation Exception that can store a list of validation errors
 *
 * @package Feedtags\ApplicationBundle\Service\Exception
 */
abstract class AbstractValidationException extends \Exception
{
    const STRING_SEPARATOR = "\n";

    /**
     * @var ConstraintViolationListInterface
     */
    private $validationErrors;

    /**
     * @param ConstraintViolationListInterface $errors The list of validation errors.
     * @param string|null                      $error  The errors represented as a string (optional)
     */
    public function __construct(ConstraintViolationListInterface $errors, $error = null)
    {
        $this->validationErrors = $errors;

        if (null === $error) {
            $error = $this->violationListToString($errors);
        }

        parent::__construct($error);
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    /**
     * Convert ConstraintViolationList to a plain array of violation messages
     *
     * @param ConstraintViolationListInterface $violations
     *
     * @return array
     */
    private function violationListToArray(ConstraintViolationListInterface $violations)
    {
        $result = [];

        /** @var \Symfony\Component\Validator\ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $result[] = $violation->getMessage();
        }

        return $result;
    }

    /**
     * Convert ConstraintViolationList to a string
     *
     * @param ConstraintViolationListInterface $violations
     *
     * @return string
     */
    private function violationListToString(ConstraintViolationListInterface $violations)
    {
        return implode(self::STRING_SEPARATOR, $this->violationListToArray($violations));
    }
}
