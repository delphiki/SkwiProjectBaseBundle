<?php

namespace Skwi\Bundle\ProjectBaseBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Abstract class extended by managers.
 * Provides construction w/ Dependency Injection and
 * universal methods uesfull to most managers.
 **/
abstract class BaseManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager $om
     */
    protected $om;

    /**
     * @var string $bundleName
     */
    protected $bundleName;

    /**
     * @var string $bundleName
     */
    protected $bundleNamespace;

    /**
     * @var string $objectName
     */
    protected $objectName;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository $repository
     */
    protected $repository;

    /**
     * @var string $stateProperty
     */
    protected $stateProperty;

    /**
     * @var integer $stateActiveValue
     */
    protected $stateActiveValue;

    /**
     * Number of max item on paginated pages
     * @var integer
     */
    protected $pagerMaxPerPage = 10;

    /**
     * Application kernel root directory
     * @var integer
     */
    protected $kernelRootDir;

    /**
     * Tells whether Documents or Entities are managed
     * @return string "Document" or "Entity"
     */
    protected function getManagedType()
    {
        $type = substr(get_class($this->om), strrpos(get_class($this->om), '\\') + 1);
        $type = str_replace('Manager', '', $type);

        return $type;
    }

    /**
     * Set the Application kernel root directory
     * @param string $kernelRootDir     Application kernel root directory
     */
    public function setKernelRootDir($kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    /**
     * Set the Doctrine Object Manager
     * @param ObjectManager $om     Doctrine Object Manager
     */
    public function setObjectManager(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Set the managed Object config
     * @param string $object The object Name
     */
    public function setObject($object)
    {
        $this->decodeObjectName($object, 'objectName', 'repository');
    }

    /**
     * Set the managed object Bundle Name
     * @param string $bundleName     The bundle Name
     */
    public function setBundleName($bundleName)
    {
        $this->bundleName = $bundleName;
    }

    /**
     * Set the managed object Bundle Namespace
     * @param string $bundleNamespace     The bundle Namespace
     */
    public function setBundleNamespace($bundleNamespace)
    {
        $this->bundleNamespace = $bundleNamespace;
    }

    /**
     * Set the name of the property defining entity state, and its ctive value
     * @param string $stateProperty     The name of the property
     * @param string $stateActiveValue     The value for state "active"
     */
    public function setStateProperty($stateProperty, $stateActiveValue = null)
    {
        $this->stateProperty = $stateProperty;
        $this->stateActiveValue = $stateActiveValue;
    }

    /**
     * Gets the name of the state property
     * @return string The name of the property (NULL if no state property)
     */
    public function getStateProperty()
    {
        $object = $this->createNew();

        switch (true)
        {
            case $this->stateProperty && method_exists($object, 'get'.ucwords($this->stateProperty)):
                return $this->stateProperty;
            case method_exists($object, 'getState'):
                return 'state';
            case method_exists($object, 'getStatus'):
                return 'status';
            default:
                return null;
        }
    }

    /**
     * Gets the active value for the state property
     * @return mixed The active value (default : TRUE)
     */
    public function getStateActiveValue()
    {
        return $this->stateActiveValue !== null ? $this->stateActiveValue : true;
    }

    /**
     * Decode ObjectName according to the Bundle, and store linked properties
     *
     * @param  string $objectName     The Bundle coded Object Name
     * @param  string $objectProperty The property where the name will be stored
     * @param  string $repoProperty   The property where the related repository will be stored
     * @return void
     */
    protected function decodeObjectName($objectName, $objectProperty = null, $repoProperty = null)
    {
        foreach (array($objectProperty, $repoProperty) as $property) {
            if ($property && !property_exists($this, $property)) {
                throw new NoSuchPropertyException(
                    sprintf(
                        'The property %s does not exist for class %s',
                        $property,
                        get_class($object)
                    )
                );
            }
        }

        $matchTest = sprintf('#^%s:([a-z]+)$#i', $this->bundleName);
        if (preg_match($matchTest, $objectName, $match)) {
            if ($objectProperty) {
                $this->$objectProperty = $match[1];
            }
            if ($repoProperty) {
                $this->$repoProperty = $this->om->getRepository($objectName);
            }
        }
    }

    /**
     * Saves the specified instance of an object
     *
     * @param  mixed $object The object to save
     * @return mixed The saved object
     */
    public function save($object)
    {
        return $this->persistAndFlush($object);
    }

    /**
     * Deletes the specified instance of an object
     *
     * @param  mixed $object The object to save
     * @return void
     */
    public function delete($object)
    {
        $this->om->remove($object);
        $this->flush();

        return 1;
    }

    /**
     * Remove the specified instance of an object
     *
     * @param  mixed $object The object to save
     * @return void
     */
    public function remove($object)
    {
        $this->om->remove($object);
    }

    /**
     * Retruns the object matching a specific Id optionnaly
     * for a specific type of Object handled by this manager
     *
     * @param int    $id         The id of the object
     * @param string $objectName The object name
     *
     * @return mixed The matching object
     */
    public function find($id, $objectName = null)
    {
        $repositoryAttr = !is_null($objectName) ? lcfirst($objectName) . 'Repository' : 'repository';

        return $this->$repositoryAttr->find($id);
    }

    /**
     * Base query filtering activated objects
     * @param  boolean $onlyActive Set to FALSE to retrun also inactive objects
     * @return Doctrine\ORM\QueryBuilder        A doctrine query builder
     */
    protected function createBaseQueryBuilder($onlyActive = true)
    {
        $qb = $this->repository->createQueryBuilder('o');

        $activeField = $this->getStateProperty();
        $activeValue = $this->getStateActiveValue();

        if ($onlyActive && $activeField) {
            if ($this->getManagedType() === 'Document') {
                $qb->field($activeField)->equals($activeValue);
            } else {
                $qb->andWhere(sprintf('o.%s = %s', $activeField, $activeValue));
            }
        }

        return $qb;
    }

    /**
     * Retruns all the objects
     *
     * @return Doctrine Collection all the objects
     */
    public function findAll($onlyActive = true)
    {
        if ($this->getManagedType() == 'Document') {
            return $this->createBaseQueryBuilder($onlyActive)->getQuery()->execute();
        } else {
            return $this->createBaseQueryBuilder($onlyActive)->getQuery()->getResult();
        }
    }

    /**
     * Retruns all the objects in a range between $offset and ($offset + $limit)
     *
     * @return Doctrine Collection all the objects
     */
    public function findAllInRange($offset, $limit, $onlyActive = true)
    {
        if ($this->getManagedType() == 'Document') {
            return $this->createBaseQueryBuilder($onlyActive)->limit($limit)->skip($offset)->getQuery()->execute();
        } else {
            return $this->createBaseQueryBuilder($onlyActive)->setMaxResults($limit)->setFirstResult($offset)->getQuery()->getResult();
        }
    }

    /**
     * Retruns all the objects, paginated with PagerFanta
     *
     * @return PagerFanta Pager
     */
    public function findAllPaginated($page, $maxPerPage = null, $onlyActive = true)
    {
        $maxPerPage = $maxPerPage > 0 ? $maxPerPage : $this->pagerMaxPerPage;

        $qb = $this->createBaseQueryBuilder($onlyActive);
        $pager = $this->getPagerFromQueryBuilder($qb, $maxPerPage);
        $pager->setCurrentPage($page);

        return $pager;
    }

    /**
     * Return the full class name
     * @param  string $className A basic class name (null = managed objects)
     * @return string            The full class name
     */
    protected function getFullClassname($className = null)
    {
        return sprintf(
            '%s\\%s\\%s',
            $this->bundleNamespace,
            $this->getManagedType(),
            ($className ? $className : $this->objectName)
        );
    }

    /**
     * Creates a new Instance of the specific Object
     *
     * @param string $className  A specific object class name. If null, managed Object Will be used
     * @param array  $parameters Parameters required for object instanciation
     * @return mixed The created Object
     **/
    public function createNew($className = null, array $parameters = array())
    {
        $fullClassname = $this->getFullClassname($className);
        if (empty($parameters)) {
            return new $fullClassname();
        }

        $constructorParameters = implode(', ', array_map(function($key) {
            return sprintf('$parameters[\'%s\']', $key);
        }, array_keys($parameters)));

        return eval("return new $fullClassname($constructorParameters);");
    }

    /**
     * Persist an object and flush the Doctrine Object Manager
     *
     * @param  mixed $object The object to persist
     * @return mixed The persisted object
     */
    protected function persistAndFlush($object)
    {
        $this->persist($object);
        $this->flush();

        return $object;
    }

    /**
     * Persist an object
     *
     * @param  mixed $object The object to persist
     * @return mixed The persisted object
     */
    public function persist($object)
    {
        if (method_exists($object, 'setUpdatedAt')) {
            $object->setUpdatedAt(new \Datetime());
        }
        $this->om->persist($object);

        return $object;
    }

    /**
     * flush the Doctrine Object Manager
     *
     */
    public function flush()
    {
        $this->om->flush();
    }

    /**
    * Toggle state and save
    * @param  mixed $object The object to persist
    */
    public function toggleState($object)
    {
        $stateProperty = $this->getStateProperty();
        if (!$stateProperty) {
            throw new NoSuchPropertyException(
                sprintf(
                    'Can find property holding state for class %s',
                    get_class($object)
                )
            );
        }

        $setter = 'set'.ucfirst($stateProperty);
        $getter = 'get'.ucfirst($stateProperty);

        $object->$setter(!$object->$getter());
        $this->save($object);

        return $object->$getter();
    }

    /**
    * Tells if an object is new
    *
    * @param   mixed   $object The object to test
    * @return  boolean TRUE if new, FALSE otherwise
    */
    public function isNew($object)
    {
        $UnitOfWorkObjectState = $this->om->getUnitOfWork()->getObjectState($object);

        return $UnitOfWorkObjectState === \Doctrine\ORM\UnitOfWork::STATE_NEW;
    }

    /**
     * Retrieve an object matching the criteria in the array
     * @param  Array  $criteria criteria to be matched
     * @return Object
     */
    public function getByField($criteria, $onlyActive = true)
    {
        if ($onlyActive && $this->getStateProperty()) {
            $criteria = array_merge($criteria, array($this->getStateProperty() => 1));
        }
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Retrieve objects matching the criteria in the array
     *
     * @param  Array $criteria criteria to be matched
     * @return Array
     */
    public function getAllByField($criteria, $onlyActive = true)
    {
        if ($onlyActive && $this->getStateProperty()) {
            $criteria = array_merge($criteria, array($this->getStateProperty() => 1));
        }

        return $this->repository->findBy($criteria);
    }

    /**
     * Retrieve paginated object list matching the criteria in the array
     *
     * @param  Array $criteria criteria to be matched
     * @return PagerFanta
     */
    public function getAllByFieldPaginated($criteria, $page, $maxPerPage = null, $onlyActive = true)
    {
        $qb = $this->createBaseQueryBuilder($onlyActive);

        foreach ($criteria as $key => $value) {
            $qb->andWhere(sprintf('o.%1$s = :%1$s', $key))
               ->setParameter($key, $value);
        }

        $pager = $this->getPagerFromQueryBuilder($qb, $maxPerPage);
        $pager->setCurrentPage($page);

        return $pager;
    }

    /**
     * Retrieve paginated and sorted object list matching the criteria in the array
     *
     * @param  Array $criteria criteria to be matched
     * @return PagerFanta
     */
    public function getAllByFieldPaginatedAndSorted($criteria, $page, $maxPerPage = null, $sortField = null, $sortDirection = 'ASC', $onlyActive = true)
    {
        $qb = $this->createBaseQueryBuilder($onlyActive);

        foreach ($criteria as $key => $value) {
            $qb->andWhere(sprintf('o.%1$s = :%1$s', $key))
               ->setParameter($key, $value);
        }

        if ($sortField) {
            $qb->orderBy(sprintf('o.%s', $sortField), $sortDirection);
        }

        $pager = $this->getPagerFromQueryBuilder($qb, $maxPerPage);
        $pager->setCurrentPage($page);

        return $pager;
    }

    /**
     * Check if an object is an instance of the managed object
     *
     * @param  mixed   $object The object to test
     * @param  string  $className The className to check (null = default managed class)
     * @return boolean True if the instance is a match, false otherwise
     */
    public function checkInstance($object, $className = null)
    {
        $fullClassname = $this->getFullClassname($className);

        return is_a($object, $fullClassname);
    }

    /**
     * Gets the scalar value of a field, for a specific object
     *
     * @param  integer $objectId  The target object Id
     * @param  string  $fieldName The target field
     * @return misc    The scalar result
     */
    public function getSingleScalarField($objectId, $fieldName)
    {
        $query = $this->repository->createQueryBuilder('e')
                      ->select('e.'.$fieldName)
                      ->where('e.id = :id')
                      ->setParameter('id', $objectId)
                      ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * Sets the max per page for paginated display
     * @param integer $pagerMaxPerPage The max item per page
     */
    public function setPagerDefaultMaxPerPage($pagerMaxPerPage)
    {
        $this->pagerMaxPerPage = $pagerMaxPerPage;
    }

    /**
     * Init pager with the query builder
     * @param QueryBuilder $queryBuilder The query builder to paginate
     * @return PagerFanta The pager
     */
    public function getPagerFromQueryBuilder(\Doctrine\ORM\QueryBuilder $queryBuilder, $maxPerPage = null)
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);

        $maxPerPage = $maxPerPage > 0 ? $maxPerPage : $this->pagerMaxPerPage;
        $pagerfanta->setMaxPerPage($maxPerPage);

        return $pagerfanta;
    }

    /**
     * Creates a new Instance of the specific Object and load data form an array
     * The object should have a "loadFromArray" method
     *
     * @param array  $dataArray  The data to load within the object
     * @param string $className  A specific object class name. If null, managed Object Will be used
     * @param array  $parameters Parameters required by the "$className" object
     * @return mixed The created Object
     **/
    public function loadFromArray($dataArray, $className = null, array $parameters = array())
    {
        $object = $this->createNew($className, $parameters);
        if (method_exists($object, 'loadFromArray')) {
            $object->loadFromArray($dataArray);
        }

        return $object;
    }
}
