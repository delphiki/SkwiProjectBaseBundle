<?php

namespace Skwi\Bundle\ProjectBaseBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;

/**
 * Abstract class extended by managers.
 * Provides construction w/ Dependency Injection and
 * universal methods uesfull to most managers.
 **/
abstract class BaseManager
{
    /**
     * @var \Doctrine\ORM\EntityManager $em entity manager
     */
    protected $em;

    /**
     * @var string $bundleName
     */
    protected $bundleName;

    /**
     * @var string $bundleName
     */
    protected $bundleNamespace;

    /**
     * @var string $entityName
     */
    protected $entityName;

    /**
     * @var \Doctrine\ORM\EntityRepository $em repository
     */
    protected $repository;

    /**
     * Manager Construct
     * Override this method to inject more dependencies
     *
     * @param string        $entity Entity name, with Symfony formated Namespace
     */
    public function __construct($entity)
    {

    }

    /**
     * Set the Doctrine Entity Manager
     * @param EntityManager $em     Doctrine Entity Manager
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Set the managed Entity config
     * @param string $entity The entity Name
     */
    public function setEntity($entity)
    {
        $this->decodeEntityName($entity, 'entityName', 'repository');
    }

    /**
     * Set the managed entity Bundle Name
     * @param string $bundleName     The bundle Name
     */
    public function setBundleName($bundleName)
    {
        $this->bundleName = $bundleName;
    }

    /**
     * Set the managed entity Bundle Namespace
     * @param string $bundleNamespace     The bundle Namespace
     */
    public function setBundleNamespace($bundleNamespace)
    {
        $this->bundleNamespacespace = $bundleName;
    }

    /**
     * Decode EntityName according to the Bundle, and store linked properties
     *
     * @param  string $entityName     The Bundle coded Entity Name
     * @param  string $entityProperty The property where the name will be stored
     * @param  string $repoProperty   The property where the related repository will be stored
     * @return void
     */
    protected function decodeEntityName($entityName, $entityProperty = null, $repoProperty = null)
    {
        foreach (array($entityProperty, $repoProperty) as $property) {
            if ($property && !property_exists($this, $property)) {
                throw new NoSuchPropertyException(
                    sprintf('The property %s does not exist for class %s',
                        $property,
                        get_class($entity)
                    )
                );
            }
        }

        if (preg_match('#^NovawayCrmBundle:([a-z]+)$#i',$entityName,$match)) {
            if ($entityProperty) {
                $this->$entityProperty = $match[1];
            }
            if ($repoProperty) {
                $this->$repoProperty = $this->em->getRepository($entityName);
            }
        }
    }

    /**
     * Saves the specified instance of an entity
     *
     * @param  mixed $entity The entity to save
     * @return mixed The saved entity
     */
    public function save($entity)
    {
        return $this->persistAndFlush($entity);
    }

    /**
     * Deletes the specified instance of an entity
     *
     * @param  mixed $entity The entity to save
     * @return void
     */
    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();

        return 1;
    }

    /**
     * Remove the specified instance of an entity
     *
     * @param  mixed $entity The entity to save
     * @return void
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
    }

    /**
     * Retruns the entity matching a specific Id;
     *
     * @param  int   $id The id of the entity
     * @return mixed The matching entity
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Retruns all the entities
     *
     * @return Doctrine Collection all the entities
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Creates a new Instance of the specific Entity
     *
     * @param $className A specific entity class name. If null, managed Entity Will be used
     * @return mixed The created Entity
     **/
    public function createNew($className = null)
    {
        $class = 'Novaway\\Bundle\\CrmBundle\\Entity\\'.($className ? $className : $this->entityName);

        return new $class();
    }

    /**
     * Persist an entity and flush the Doctrine Entity Manager
     *
     * @param  mixed $entity The entity to persist
     * @return mixed The persisted entity
     */
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * Persist an entity
     *
     * @param  mixed $entity The entity to persist
     * @return mixed The persisted entity
     */
    public function persist($entity)
    {
        $this->em->persist($entity);

        return $entity;
    }

    /**
     * flush the Doctrine Entity Manager
     *
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
    * Toggle state and save
    * @param  mixed $entity The entity to persist
    */
    public function toggleState($entity)
    {
        if (!method_exists($entity, 'getState')) {
            throw new NoSuchPropertyException(
                sprintf('The method %s does not exist for class %s',
                    'getState',
                    get_class($entity)
                    )
            );
        }
        $entity->setState(!$entity->getState());
        $this->save($entity);

        return $entity->getState();
    }

    /**
    * Tells if an entity is new
    *
    * @param   mixed   $entity The entity to test
    * @return  boolean TRUE if new, FALSE otherwise
    */
    public function isNew($entity)
    {
     $state = $this->em->getUnitOfWork()->getEntityState($entity);

     return $state === \Doctrine\ORM\UnitOfWork::STATE_NEW;
 }

    /**
     * Retrieve an entity matching the criteria in the array
     * @param  Array  $criteria criteria to be matched
     * @return Entity
     */
    public function getByField($criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Retrieve an entity matching the criteria in the array
     *
     * @param  Array $criteria criteria to be matched
     * @return Array
     */
    public function getAllByField($criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Check if an object is an instance of the managed entity
     *
     * @param  mixed   $entity The object to test
     * @return boolean True if the instance is a match, false otherwise
     */
    public function checkInstance($entity)
    {
        return is_a($entity, 'Novaway\\Bundle\\CrmBundle\\Entity\\'.$this->entityName);
    }

    /**
     * Switch the state of an entity
     *
     * @param  mixed   $entity The entity on withc the switch will be applied
     * @return integer The new state
     */
    public function switchState($entity)
    {
        if (is_string($entity) || is_integer($entity)) {
            $entity = $this->find($entity);
        }

        if ($this->checkInstance($entity)) {
            $entity->setState($entity->getState() === 1 ? 0 : 1);
            $entity = $this->save($entity);

            return $entity->getState();
        }

        throw new \Exception('Entity is not an instance of '.$this->entityName);
    }

    protected function slug($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);

        return $str;
    }

    /**
     * Gets the scalar value of a field, for a specific entity
     *
     * @param  integer $entityId  The target entity Id
     * @param  string  $fieldName The target field
     * @return misc    The scalar result
     */
    public function getSingleScalarField($entityId, $fieldName)
    {
        $query = $this->repository->createQueryBuilder('e')
                      ->select('e.'.$fieldName)
                      ->where('e.id = :id')
                      ->setParameter('id', $entityId)
                      ->getQuery();

        return $query->getSingleScalarResult();
    }
}
