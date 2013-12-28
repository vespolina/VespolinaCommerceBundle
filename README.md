VespolinaCommerceBundle
=======================

[![Build Status](https://secure.travis-ci.org/vespolina/VespolinaCommerceBundle.png?branch=master)](http://travis-ci.org/Vespolina/VespolinaCommerceBundle)
[![Total Downloads](https://poser.pugx.org/vespolina/commerce-bundle/downloads.png)](https://packagist.org/packages/vespolina/commerce-bundle)
[![Latest Stable Version](https://poser.pugx.org/vespolina/commerce-bundle/v/stable.png)](https://packagist.org/packages/vespolina/commerce-bundle)

Vespolina Ecommerce integration with Symfony2

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
        new Vespolina\CommerceBundle\VespolinaCommerceBundle(),
    );
}
```

### 3) Required configuration:

    vespolina_commerce:
        db_driver: mongodb # mongodb or orm

### 4) Routing options

    vespolina_admin:
        resource: @VespolinaAdminBundle/Resources/config/routing/admin.xml
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
    
    vespolina_store:
        resource: "@VespolinaStoreBundle/Resources/config/routing/store.xml"
        prefix:   /
