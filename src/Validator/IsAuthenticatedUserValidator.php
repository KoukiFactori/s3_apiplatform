<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\ConstraintValidator;

class IsAuthenticatedUserValidator extends ConstraintValidator
{
    public function __construct(private Security $security) { }

    /**
     * @param User $value
     * @param IsAuthenticatedUser $constraint
     * */
    public function validate($value, Constraint $constraint)
    {   

        if (null === $value || '' === $value) {
            return;
        }

        if ($value == $this->security->getUser()) return;

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value->getLogin())
            ->addViolation();
    }
}
