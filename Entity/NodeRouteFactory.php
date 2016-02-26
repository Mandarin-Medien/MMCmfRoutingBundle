<?php

namespace MandarinMedien\MMCmfRoutingBundle\Entity;

use Doctrine\ORM\EntityManager;

/**
 * Class NodeRouteFactory
 * @package MandarinMedien\MMCmfRoutingBundle\Entity
 */
class NodeRouteFactory
{

    private $manager;
    private $factory_class = NodeRoute::class;
    private $meta;


    /**
     * NodeRouteFactory constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
        $this->meta = $this->manager->getClassMetadata(
            $this->factory_class
        );
    }


    /**
     * create a new NodeRoute instance by discrimator value
     * @param string $discrimator
     * @return NodeRouteInterface
     * @throws \Exception
     */
    public function createNodeRoute($discrimator = 'default')
    {
        $reflection = new \ReflectionClass($this->getClassByDiscrimator($discrimator));
        return $reflection->newInstance();
    }


    /**
     * get all available discrimator values of NodeRoute entity
     * @param array $exclude exclude specific discrimators
     * @return array
     */
    public function getDiscrimators($exclude = array('default', 'auto'))
    {
        return array_diff(array_keys($this->meta->discriminatorMap), $exclude);
    }


    /**
     * get the discrimator value by the given instance
     * @param NodeRouteInterface $nodeRoute
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getDiscrimatorByClass(NodeRouteInterface $nodeRoute)
    {
        return $this->manager->getClassMetadata(get_class($nodeRoute))->discriminatorValue;
    }


    /**
     * get the NodeRoute subclass by discrimator value
     * @param string $discrimator
     * @return NodeRouteInterface
     * @throws \Exception
     */
    protected function getClassByDiscrimator($discrimator)
    {
        if($class = ($this->meta->discriminatorMap[$discrimator])) {
            return $class;
        } else {
            throw new \Exception('class not found');
        }
    }
}