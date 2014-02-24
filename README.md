VespolinaCommerceBundle
=======================

[![Build Status](https://secure.travis-ci.org/vespolina/VespolinaCommerceBundle.png?branch=master)](http://travis-ci.org/Vespolina/VespolinaCommerceBundle)
[![Total Downloads](https://poser.pugx.org/vespolina/commerce-bundle/downloads.png)](https://packagist.org/packages/vespolina/commerce-bundle)
[![Latest Stable Version](https://poser.pugx.org/vespolina/commerce-bundle/v/stable.png)](https://packagist.org/packages/vespolina/commerce-bundle)

Vespolina Ecommerce integration with Symfony2

The admin page has javascript dependencies that can be handled by [bower](http://bower.io) using the [SpBowerBundle](https://github.com/Spea/SpBowerBundle).
If you don't have bower installed, you can install it using npm
``` bash
$ npm install -g bower
```

### 1) Install VespolinaCommerceBundle

Install using composer.phar or composer binary:

``` bash
$ php composer.phar require vespolina/commerce-bundle dev-master
```

### 2) Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\RestBundle\FOSRestBundle(),
        new Sp\BowerBundle\SpBowerBundle(),
        new Vespolina\CommerceBundle\VespolinaCommerceBundle(),
    );
}
```

### 3) Required configuration:
```yml
# app/config/config.yml
sp_bower:
    bundles:
        VespolinaCommerceBundle: ~

vespolina_commerce:
    db_driver: mongodb # mongodb or orm
```

### 4) Routing options
```yml
# app/config/routing.yml
vespolina_admin:
    resource: "@VespolinaCommerceBundle/Resources/config/routing/admin.yml"
    prefix:   /admin/

vespolina_commerce_checkout:
    resource: "@VespolinaCommerceBundle/Resources/config/routing/checkout.xml"
    prefix:   /

vespolina_commerce_cart:
    resource: "@VespolinaCommerceBundle/Resources/config/routing/cart.xml"
    prefix:   /

vespolina_commerce_product:
    resource: "@VespolinaCommerceBundle/Resources/config/routing/product.xml"
    prefix:   /

vespolina_taxonomy:
    resource: "@VespolinaCommerceBundle/Resources/config/routing/taxonomy.xml"
    prefix:   /
```
