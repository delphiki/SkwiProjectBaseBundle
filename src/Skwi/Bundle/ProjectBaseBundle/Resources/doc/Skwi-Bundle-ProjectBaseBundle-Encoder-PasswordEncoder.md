Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder
===============






* Class name: PasswordEncoder
* Namespace: Skwi\Bundle\ProjectBaseBundle\Encoder
* This class implements: Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface




Properties
----------


### $algorithm

```
private string $algorithm
```

Algorithm to use for password encoding



* Visibility: **private**


Methods
-------


### \Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::__construct()

```
mixed Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::\Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::__construct()(string $algorithm)
```

Class constructor



* Visibility: **public**

#### Arguments

* $algorithm **string** - &lt;p&gt;Algorithm to use for password encoding&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::encodePassword()

```
string Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::\Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::encodePassword()(string $raw, string $salt)
```

Encode password



* Visibility: **public**

#### Arguments

* $raw **string** - &lt;p&gt;The raw password&lt;/p&gt;
* $salt **string** - &lt;p&gt;The encoding salt&lt;/p&gt;



### \Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::isPasswordValid()

```
boolean Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::\Skwi\Bundle\ProjectBaseBundle\Encoder\PasswordEncoder::isPasswordValid()(string $encoded, string $raw, string $salt)
```

Check if a raw password matches an encoded one



* Visibility: **public**

#### Arguments

* $encoded **string** - &lt;p&gt;The encoded password&lt;/p&gt;
* $raw **string** - &lt;p&gt;The raw password&lt;/p&gt;
* $salt **string** - &lt;p&gt;The encoding salt&lt;/p&gt;


