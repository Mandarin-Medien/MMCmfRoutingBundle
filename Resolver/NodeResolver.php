<?php

namespace MandarinMedien\MMCmfRoutingBundle\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRouteInterface;
use MandarinMedien\MMCmfRoutingBundle\Entity\RoutableNodeInterface;


/**
 * Class NodeResolver
 *
 * This class loads RoutableNodeInterfaces by a given NodeRouteInterface
 *
 * @package MandarinMedien\MMCmfRoutingBundle\Routing
 */
class NodeResolver
{

    protected $manager;

    protected $classes;


    /**
     * NodeResolver constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

        $this->classes = $this->getRoutableNodeClasses();
    }


    /**
     * loads the Node by the given NodeRouteInterface
     * @param NodeRouteInterface $route
     * @return mixed|null
     */
    public function resolve(NodeRouteInterface $route)
    {

        foreach($this->classes as $class) {
            $qb = $this->manager->createQueryBuilder()
                ->select('n')
                ->from($class, 'n')
                ->join('n.routes', 'r')
                ->where('r.id = :route')
                ->setParameter('route', $route->getId());

            $node = $qb->getQuery()->getSingleResult();

            if($node) return $node;
        }

        return null;
    }


    /**
     * builds a list of all classes implementing RoutableNodeInterface
     * @return array
     */
    protected function getRoutableNodeClasses()
    {
        $metadata = $this->manager->getClassMetadata(Node::class);
        $routables = array_values(array_filter($metadata->subClasses, function($subNode) {
            $reflection = new \ReflectionClass($subNode);
            return $reflection->implementsInterface(RoutableNodeInterface::class);
        }));

        return $routables;
    }

}