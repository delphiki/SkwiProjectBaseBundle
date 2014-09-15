#SkwiProjectBaseBundle
[![Build Status](https://travis-ci.org/skwi/SkwiProjectBaseBundle.svg)](https://travis-ci.org/skwi/SkwiProjectBaseBundle)

This is a bundle with some basic code I often use in my projects.
Feel free to use it or enhance it.

##Compatibility
The current version of the bundle is only compatible with Symfony 2.5+ Version 1.0 provides compatibility with older versions of Symfony
##Setup

### Install SkwiProjectBaseBundle

Simply run assuming you have installed composer (composer.phar or composer binary) :
``` bash
$ php composer.phar require skwi/project-base-bundle "dev-master"
```

### Configuration

Register the bundle in `app/AppKernel.php`:

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new \Skwi\Bundle\ProjectBaseBundle\SkwiProjectBaseBundle(),
    );
}
```
In your *app/config.yml* file, you may need to set up several parameters

``` yaml
skwi_project_base:
    entity_bundle_name: FooBarBundle # Default bundle when extending BaseManager (see below)
    entity_bundle_namespace: \Foo\Bundle\BarBundle # Default bundle namespace 
    password_encoder: sha512 # Password encoder method
    pager_max_per_page: 10 # Default max items per page when using paginator in the BaseManager
    kernel_root_dir: %kernel.root_dir%
```

##Usage
###Base Manager
The BaseManager is a useful abstract class, especially when working with object managed by an ORM. It provide several methods described in a [dedicated documentation](https://github.com/skwi/SkwiProjectBaseBundle/blob/master/src/Skwi/Bundle/ProjectBaseBundle/Resources/doc/BaseManager.md).
###Password encoder
The password encoder class provides an implementation of Symfony's [PasswordEncoderInterface](http://api.symfony.com/master/Symfony/Component/Security/Core/Encoder/PasswordEncoderInterface.html) using the algorithm defined in the *app/config.yml* file

It's available as a service in the container.

``` php
$encoder = $this->getContainer()->get('skwi.projectbase.password_encoder');
$encodedPassword = $encoder->encodePassword($rawPassword, $salt);
$isPasswordValid = $encoder->isPasswordValid($encodedPassword, $rawPassword, $salt);
```

###Text helper
The text helper is a static class.

``` php
# Slug a string
$sluggedString = TextHelper::slug($rawString);
```

> **Note :** The slug method is quite basic at the moment, it might be enhance in a future update.
> Make sure to use 1.* version for compatibility. 

###Base view
A base twig view is provided y the bundle.

``` twig
{% extends 'SkwiProjectBaseBundle::base.html.twig' %}
``` 

It loads the libraries for
- [Twitter Bootstrap 3](http://getbootstrap.com/)
- [jQuery 1.10](http://jquery.com/)
> **Note : ** The libraries are loaded form the CDN, with a local fallback for IE version inferior to IE9.

####Form templates
The bundle also provide preset form templates for Bootstrap 3.
```twig
{% form_theme form 'SkwiProjectBaseBundle:Form:fields.html.twig' %}
{# or #}
{% form_theme form 'SkwiProjectBaseBundle:Form:fields-horizontal.html.twig' %}
```
###Twig extensions
####TextExtension
The TextExtension provides the following Twig filters
```twig
{{ string|slug # will slug the string using the bundle's TextHelper }} 
{{ string|striptags # will apply the strip_tags php method to the string }} 
```
## Testing
Unit tests are written using [atoum](https://github.com/atoum/atoum). You will get atoum, among other dependencies, when
running `composer install`. To run tests, you will need to run the following command :
``` sh
$ vendor/bin/atoum
```
##ToDo
- Remove or enhance the data format helper
- Enhance the slug method in text helper
- Remove twig encoder extension not very usefull
- See with last version of PHP for password encoding
- Update to symfony 2.5 with the property accessor

##Known issues