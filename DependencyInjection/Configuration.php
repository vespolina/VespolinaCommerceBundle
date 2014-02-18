<?php

/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\CommerceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vespolina_commerce');
        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        $this->addIdentifierSetSection($rootNode);
        $this->addOptionGroupSection($rootNode);
        $this->addConfiguredOptionGroupSection($rootNode);
        $this->addOptionSection($rootNode);
        $this->addOrderManagerSection($rootNode);
        $this->addOrderSection($rootNode);
        $this->addProductManagerSection($rootNode);
        $this->addProductSection($rootNode);
        $this->addAttributeSection($rootNode);
        $this->addMerchandiseSection($rootNode);
        $this->addPartnerSection($rootNode);
        $this->addFulfillmentMethodsSection($rootNode);
        $this->addPaymentGateways($rootNode);

        return $treeBuilder;
    }

    private function addIdentifierSetSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('identifier_set')
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOptionGroupSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('option_group')
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addConfiguredOptionGroupSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('configured_option_group')
                    ->children()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOptionSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('option')
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOrderSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('order')
                    ->children()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addOrderManagerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product_manager')
                    ->children()
                        ->scalarNode('class')->end()
                ->end()
            ->end()
        ;
    }


    private function addProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product')
                    ->children()
                        ->scalarNode('class')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->end()
                                ->scalarNode('handler_class')->end()
                                ->scalarNode('handler_service')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addProductManagerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product_manager')
                    ->children()
                        ->scalarNode('class')->end()
                        ->arrayNode('identifiers')
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->scalarNode('image_manager')->defaultNull()->end()
                ->end()
            ->end()
        ;
    }

    private function addAttributeSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('attribute')
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('data_class')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addMerchandiseSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('merchandise')
                    ->children()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }


    private function addPartnerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('partnerClassMap')
                    ->children()
                        ->scalarNode('partner')->end()
                        ->scalarNode('partnerContact')->end()
                        ->scalarNode('partnerAddress')->end()
                        ->scalarNode('partnerPersonalDetails')->end()
                        ->scalarNode('partnerOrganisationDetails')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    protected function addFulfillmentMethodsSection(ArrayNodeDefinition $node)
    {
        $node->children()
                ->arrayNode('fulfillment_methods')
                    ->children()
                        ->arrayNode('shipment')
                        ->prototype('array')
                        ->children()
                        ->scalarNode('class')->end()
                        ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addPaymentGateways(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('payment_gateways')
                    ->children()
                        ->arrayNode('PayPal_Express')
                            ->children()
                                ->scalarNode('class')->defaultValue('Omnipay\PayPal\ExpressGateway')->end()
                                ->scalarNode('username')->isRequired()->end()
                                ->scalarNode('password')->isRequired()->end()
                                ->scalarNode('signature')->isRequired()->end()
                                ->scalarNode('testMode')->defaultValue(false)->end()
                            ->end()
                        ->end()
                        ->arrayNode('PayPal_Pro')
                            ->children()
                                ->scalarNode('class')->defaultValue('Omnipay\PayPal\ProGateway')->end()
                                ->scalarNode('username')->isRequired()->end()
                                ->scalarNode('password')->isRequired()->end()
                                ->scalarNode('signature')->isRequired()->end()
                                ->scalarNode('testMode')->defaultValue(false)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
