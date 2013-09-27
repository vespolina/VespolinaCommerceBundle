<?php

/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Vespolina\Exception\InvalidConfigurationException;

/**
 * @author Richard D Shank <develop@zestic.com>
 */
class VespolinaCommerceExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $dbDriver = strtolower($config['db_driver']);

        if (!in_array($dbDriver, array('orm', 'mongodb'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }

        $configurationFiles = array(
            //Persistence specific configurations
            sprintf('order_%s.xml', $dbDriver),
            sprintf('invoice_%s.xml', $dbDriver),
            sprintf('product_%s.xml', $dbDriver),
            sprintf('partner_%s.xml', $dbDriver),
            sprintf('taxonomy_%s.xml', $dbDriver),
            sprintf('action_%s.xml', $dbDriver),
            //Generic configurations
            'commerce.xml',
            'fulfillment.xml',
            'partner.xml',
            'process.xml',
            'pricing.xml',
            'product_identifiers.xml',
            'product_attributes.xml',
            'product_options.xml',
            'product_form.xml',
            'order.xml',
            'order_rest.xml',
            'twig.xml',
            'action.xml'
        );

        foreach ($configurationFiles as $configurationFile) {
            $loader->load($configurationFile);
        }

        if (isset($config['identifier_set'])) {
            $this->configureIdentifierSet($config['identifier_set'], $container);
        }
        if (isset($config['attribute'])) {
            $this->configureAttribute($config['attribute'], $container);
        }
        if (isset($config['option_group'])) {
            $this->configureOptionGroup($config['option_group'], $container);
        }
        if (isset($config['configured_option_group'])) {
            $this->configureConfiguredOptionGroup($config['configured_option_group'], $container);
        }
        if (isset($config['option'])) {
            $this->configureOption($config['option'], $container);
        }
        if (isset($config['product_manager'])) {
            $this->configureProductManager($config['product_manager'], $container);
        }
        if (isset($config['product'])) {
            $this->configureProduct($config['product'], $container);
        }
        if (isset($config['merchandise'])) {
            $this->configureMerchandise($config['merchandise'], $container);
        }
        if (isset($config['fulfillment_methods'])) {
            $this->configureFulfillmentMethods($config['fulfillment_methods'], $container);
        }

        if (isset($config['classMapping']) && is_array($config['classMapping'])) {
            $this->configureEntityClassMapping($container, $config['classMapping']);
        }
    }

    protected function configureIdentifierSet(array $config, ContainerBuilder $container)
    {
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['type'])) {
                $container->setParameter('vespolina_commerce.identifier_set.form.type.class', $formConfig['type']);
            }
            if (isset($formConfig['name'])) {
                $container->setParameter('v_identifier_set', $formConfig['name']);
            }
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.identifier_set.form.entity.data_class.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureAttribute(array $config, ContainerBuilder $container)
    {
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['type'])) {
                $container->setParameter('vespolina_commerce.attribute.form.type.class', $formConfig['type']);
            }
            if (isset($formConfig['name'])) {
                $container->setParameter('v_attribute', $formConfig['name']);
            }
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.attribute.form.entity.data_class.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureOptionGroup(array $config, ContainerBuilder $container)
    {
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['type'])) {
                $container->setParameter('vespolina_commerce.option_group.form.type.class', $formConfig['type']);
            }
            if (isset($formConfig['name'])) {
                $container->setParameter('v_option_group', $formConfig['name']);
            }
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.option_group.form.entity.data_class.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureConfiguredOptionGroup(array $config, ContainerBuilder $container)
    {
        if (isset($config['class'])) {
            $container->setParameter('vespolina_commerce.entity.configured_option_group.class', $config['class']);
        }
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.configured_option_group.form.entity.data_class.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureOption(array $config, ContainerBuilder $container)
    {
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['type'])) {
                $container->setParameter('vespolina_commerce.option.form.type.class', $formConfig['type']);
            }
            if (isset($formConfig['name'])) {
                $container->setParameter('vespolina_commerce.option', $formConfig['name']);
            }
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.option.form.entity.data_class.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureProductManager(array $config, ContainerBuilder $container)
    {
        if (isset($config['class'])) {
            $container->setParameter('vespolina_commerce.product_manager.class', $config['class']);
        }
        if (isset($config['identifiers'])) {
            $container->setParameter('vespolina_commerce.product_manager.identifiers', $config['identifiers']);
        }
        if (isset($config['image_manager'])) {
            $container->setAlias('vespolina_commerce.image_manager', $config['image_manager']);
        }
    }

    protected function configureProduct(array $config, ContainerBuilder $container)
    {
        if (isset($config['class'])) {
            $container->setParameter('vespolina_commerce.entity.product.class', $config['class']);
        }
        if (isset($config['form'])) {
            $formConfig = $config['form'];
            if (isset($formConfig['type'])) {
                $container->setParameter('vespolina_commerce.form.type.class', $formConfig['type']);
            }
            if (isset($formConfig['handler_class'])) {
                $container->setParameter('vespolina_commerce.form.handler.class', $formConfig['handler_class']);
            }
            if (isset($formConfig['handler_service'])) {
                $container->setAlias('vespolina_commerce.form.handler', $formConfig['handler_service']);
            }
            if (isset($formConfig['name'])) {
                $container->setParameter('vespolina_commerce.form', $formConfig['name']);
            }
            if (isset($formConfig['data_class'])) {
                $container->setParameter('vespolina_commerce.form.entity.check_product.class', $formConfig['data_class']);
            }
        }
    }

    protected function configureMerchandise(array $config, ContainerBuilder $container)
    {
        if (isset($config['class'])) {
            $container->setParameter('vespolina_commerce.entity.merchandise.class', $config['class']);
        }
    }

    protected function configureEntityClassMapping(ContainerBuilder $container, array $classMapping)
    {
        foreach ($classMapping as $name => $class) {
            if (!class_exists($class)) {
                throw new InvalidConfigurationException(sprintf(
                    "Class '%s' not found for entity '%s'",
                    $class,
                    $name
                ));
            }

            switch ($name) {
                case 'partner':
                    $container->setParameter('vespolina_commerce.entity.partner.class', $class);
                    break;
                case 'partnerContact':
                    $container->setParameter('vespolina_commerce.entity.partner_contact.class', $class);
                    break;
                case 'partnerAddress':
                    $container->setParameter('vespolina_commerce.entity.partner_address.class', $class);
                    break;
                case 'partnerPersonalDetails':
                    $container->setParameter('vespolina_commerce.entity.partner_personal_details.class', $class);
                    break;
                case 'partnerOrganisationDetails':
                    $container->setParameter('vespolina_commerce.entity.partner_organisation_details.class', $class);
                    break;
            }
        }
    }

    protected function configureFulfillmentMethods(array $config, ContainerBuilder $container)
    {
        $container->setParameter('vespolina_commerce.fulfillment_method_resolver.configuration', $config);
    }
}
