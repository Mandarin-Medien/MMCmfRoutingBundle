<?php

namespace MandarinMedien\MMCmfRoutingBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class NodeRouteUniqueValidator extends ConstraintValidator
{
    private $repositoryClass    = 'MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute';

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @param mixed $nodeRoute
     * @param Constraint $constraint
     */
    public function validate($nodeRoute, Constraint $constraint)
    {

        /**
         * @var NodeRoute $nodeRoute
         */
        $qb = $this->manager->createQueryBuilder()
            ->select('r')
            ->from('MMCmfRoutingBundle:NodeRoute', 'r')
            ->where("r.route = ?1")
            ->andWhere('r.id != ?2')
            ->setParameter('1', $nodeRoute->getRoute())
            ->setParameter("2", $nodeRoute->getId())
            ->setMaxResults(1);

        $existing = $qb->getQuery()->execute();

        if(count($existing)>0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $nodeRoute->getRoute())
                ->addViolation();
        }
    }

    /**
     * @param EntityManager $manager
     */
    public function setManager(EntityManager $manager)
    {
        $this->manager = $manager;
    }
}