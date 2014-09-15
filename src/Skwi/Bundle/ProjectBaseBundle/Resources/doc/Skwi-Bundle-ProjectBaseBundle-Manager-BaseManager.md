Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager
===============

Abstract class extended by managers.

Provides construction w/ Dependency Injection and
universal methods uesfull to most managers.


* Class name: BaseManager
* Namespace: Skwi\Bundle\ProjectBaseBundle\Manager
* This is an **abstract** class





Properties
----------


### $om

```
protected \Doctrine\Common\Persistence\ObjectManager $om
```





* Visibility: **protected**


### $bundleName

```
protected string $bundleName
```





* Visibility: **protected**


### $bundleNamespace

```
protected string $bundleNamespace
```





* Visibility: **protected**


### $objectName

```
protected string $objectName
```





* Visibility: **protected**


### $repository

```
protected \Doctrine\Common\Persistence\ObjectRepository $repository
```





* Visibility: **protected**


### $stateProperty

```
protected string $stateProperty
```





* Visibility: **protected**


### $stateActiveValue

```
protected integer $stateActiveValue
```





* Visibility: **protected**


### $pagerMaxPerPage

```
protected integer $pagerMaxPerPage = 10
```

Number of max item on paginated pages



* Visibility: **protected**


### $kernelRootDir

```
protected integer $kernelRootDir
```

Application kernel root directory



* Visibility: **protected**


Methods
-------


### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getManagedType()

```
string Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getManagedType()()
```

Tells whether Documents or Entities are managed



* Visibility: **protected**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setKernelRootDir()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setKernelRootDir()(string $kernelRootDir)
```

Set the Application kernel root directory



* Visibility: **public**

#### Arguments

* $kernelRootDir **string** - &lt;p&gt;Application kernel root directory&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setObjectManager()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setObjectManager()(\Doctrine\Common\Persistence\ObjectManager $om)
```

Set the Doctrine Object Manager



* Visibility: **public**

#### Arguments

* $om **Doctrine\Common\Persistence\ObjectManager** - &lt;p&gt;Doctrine Object Manager&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setObject()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setObject()(string $object)
```

Set the managed Object config



* Visibility: **public**

#### Arguments

* $object **string** - &lt;p&gt;The object Name&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setBundleName()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setBundleName()(string $bundleName)
```

Set the managed object Bundle Name



* Visibility: **public**

#### Arguments

* $bundleName **string** - &lt;p&gt;The bundle Name&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setBundleNamespace()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setBundleNamespace()(string $bundleNamespace)
```

Set the managed object Bundle Namespace



* Visibility: **public**

#### Arguments

* $bundleNamespace **string** - &lt;p&gt;The bundle Namespace&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setStateProperty()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setStateProperty()(string $stateProperty, string $stateActiveValue)
```

Set the name of the property defining entity state, and its ctive value



* Visibility: **public**

#### Arguments

* $stateProperty **string** - &lt;p&gt;The name of the property&lt;/p&gt;
* $stateActiveValue **string** - &lt;p&gt;The value for state &quot;active&quot;&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getStateProperty()

```
string Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getStateProperty()()
```

Gets the name of the state property



* Visibility: **public**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getStateActiveValue()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getStateActiveValue()()
```

Gets the active value for the state property



* Visibility: **public**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::decodeObjectName()

```
void Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::decodeObjectName()(string $objectName, string $objectProperty, string $repoProperty)
```

Decode ObjectName according to the Bundle, and store linked properties



* Visibility: **protected**

#### Arguments

* $objectName **string** - &lt;p&gt;The Bundle coded Object Name&lt;/p&gt;
* $objectProperty **string** - &lt;p&gt;The property where the name will be stored&lt;/p&gt;
* $repoProperty **string** - &lt;p&gt;The property where the related repository will be stored&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::save()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::save()(mixed $object)
```

Saves the specified instance of an object



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to save&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::delete()

```
void Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::delete()(mixed $object)
```

Deletes the specified instance of an object



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to save&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::remove()

```
void Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::remove()(mixed $object)
```

Remove the specified instance of an object



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to save&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::find()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::find()(integer $id, string $objectName)
```

Retruns the object matching a specific Id optionnaly
for a specific type of Object handled by this manager



* Visibility: **public**

#### Arguments

* $id **integer** - &lt;p&gt;The id of the object&lt;/p&gt;
* $objectName **string** - &lt;p&gt;The object name&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::createBaseQueryBuilder()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\Doctrine\ORM\QueryBuilder Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::createBaseQueryBuilder()(boolean $onlyActive)
```

Base query filtering activated objects



* Visibility: **protected**

#### Arguments

* $onlyActive **boolean** - &lt;p&gt;Set to FALSE to retrun also inactive objects&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAll()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\Doctrine Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAll()($onlyActive)
```

Retruns all the objects



* Visibility: **public**

#### Arguments

* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAllInRange()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\Doctrine Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAllInRange()($offset, $limit, $onlyActive)
```

Retruns all the objects in a range between $offset and ($offset + $limit)



* Visibility: **public**

#### Arguments

* $offset **mixed**
* $limit **mixed**
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAllPaginated()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\PagerFanta Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::findAllPaginated()($page, $maxPerPage, $onlyActive)
```

Retruns all the objects, paginated with PagerFanta



* Visibility: **public**

#### Arguments

* $page **mixed**
* $maxPerPage **mixed**
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getFullClassname()

```
string Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getFullClassname()(string $className)
```

Return the full class name



* Visibility: **protected**

#### Arguments

* $className **string** - &lt;p&gt;A basic class name (null = managed objects)&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::createNew()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::createNew()(string $className)
```

Creates a new Instance of the specific Object



* Visibility: **public**

#### Arguments

* $className **string** - &lt;p&gt;A specific object class name. If null, managed Object Will be used&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::persistAndFlush()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::persistAndFlush()(mixed $object)
```

Persist an object and flush the Doctrine Object Manager



* Visibility: **protected**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to persist&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::persist()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::persist()(mixed $object)
```

Persist an object



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to persist&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::flush()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::flush()()
```

flush the Doctrine Object Manager



* Visibility: **public**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::toggleState()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::toggleState()(mixed $object)
```

Toggle state and save



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to persist&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::isNew()

```
boolean Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::isNew()(mixed $object)
```

Tells if an object is new



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to test&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getByField()

```
Object Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getByField()(Array $criteria, $onlyActive)
```

Retrieve an object matching the criteria in the array



* Visibility: **public**

#### Arguments

* $criteria **Array** - &lt;p&gt;criteria to be matched&lt;/p&gt;
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByField()

```
Array Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByField()(Array $criteria, $onlyActive)
```

Retrieve objects matching the criteria in the array



* Visibility: **public**

#### Arguments

* $criteria **Array** - &lt;p&gt;criteria to be matched&lt;/p&gt;
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByFieldPaginated()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\PagerFanta Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByFieldPaginated()(Array $criteria, $page, $maxPerPage, $onlyActive)
```

Retrieve paginated object list matching the criteria in the array



* Visibility: **public**

#### Arguments

* $criteria **Array** - &lt;p&gt;criteria to be matched&lt;/p&gt;
* $page **mixed**
* $maxPerPage **mixed**
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByFieldPaginatedAndSorted()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\PagerFanta Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getAllByFieldPaginatedAndSorted()(Array $criteria, $page, $maxPerPage, $sortField, $sortDirection, $onlyActive)
```

Retrieve paginated and sorted object list matching the criteria in the array



* Visibility: **public**

#### Arguments

* $criteria **Array** - &lt;p&gt;criteria to be matched&lt;/p&gt;
* $page **mixed**
* $maxPerPage **mixed**
* $sortField **mixed**
* $sortDirection **mixed**
* $onlyActive **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::checkInstance()

```
boolean Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::checkInstance()(mixed $object, string $className)
```

Check if an object is an instance of the managed object



* Visibility: **public**

#### Arguments

* $object **mixed** - &lt;p&gt;The object to test&lt;/p&gt;
* $className **string** - &lt;p&gt;The className to check (null = default managed class)&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getSingleScalarField()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\misc Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getSingleScalarField()(integer $objectId, string $fieldName)
```

Gets the scalar value of a field, for a specific object



* Visibility: **public**

#### Arguments

* $objectId **integer** - &lt;p&gt;The target object Id&lt;/p&gt;
* $fieldName **string** - &lt;p&gt;The target field&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setPagerDefaultMaxPerPage()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::setPagerDefaultMaxPerPage()(integer $pagerMaxPerPage)
```

Sets the max per page for paginated display



* Visibility: **public**

#### Arguments

* $pagerMaxPerPage **integer** - &lt;p&gt;The max item per page&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getPagerFromQueryBuilder()

```
\Skwi\Bundle\ProjectBaseBundle\Manager\PagerFanta Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::getPagerFromQueryBuilder()(\Skwi\Bundle\ProjectBaseBundle\Manager\QueryBuilder $queryBuilder, $maxPerPage)
```

Init pager with the query builder



* Visibility: **public**

#### Arguments

* $queryBuilder **Skwi\Bundle\ProjectBaseBundle\Manager\QueryBuilder** - &lt;p&gt;The query builder to paginate&lt;/p&gt;
* $maxPerPage **mixed**



### \Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::loadFromArray()

```
mixed Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::\Skwi\Bundle\ProjectBaseBundle\Manager\BaseManager::loadFromArray()($dataArray, $className)
```

Creates a new Instance of the specific Object and load data form an array
The object should have a "loadFromArray" method



* Visibility: **public**

#### Arguments

* $dataArray **mixed** - &lt;p&gt;The data to load within the object&lt;/p&gt;
* $className **mixed** - &lt;p&gt;A specific object class name. If null, managed Object Will be used&lt;/p&gt;


