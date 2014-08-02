<?php

namespace Vespolina\CommerceBundle\JMSSerializer;

use JMS\Serializer\AbstractVisitor;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use Vespolina\Entity\Product\Product;

class ProductHandler implements SubscribingHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format'    => 'json',
                'type'      => 'Vespolina\Entity\Product\Product',
                'method'    => 'serialize',
            ]
        ];
    }

    public function serialize(AbstractVisitor $visitor, Product $product, $type, Context $context)
    {
        $formattedPrices = [];
        foreach ($product->getPrices() as $price) {
            $formattedPrices[$price['type']] = $product->getPrice($price['type']);
        }
        $root = $visitor->getRoot();

        $data = [
            'brands'        => $context->getNavigator()->accept($product->getBrands(), null, $context),
            'createdAt'     => $context->getNavigator()->accept($product->getCreatedAt(), null, $context),
            'id'            => $product->getId(),
            'name'          => $product->getName(),
            'optionGroups'  => $context->getNavigator()->accept($product->getOptionGroups(), null, $context),
            'prices'        => $formattedPrices,
            'productId'     => $product->getProductId(),
            'slug'          => $product->getSlug(),
            'taxonomies'    => $context->getNavigator()->accept($product->getTaxonomies(), null, $context),
            'updatedAt'     => $context->getNavigator()->accept($product->getUpdatedAt(), null, $context),
            'variations'    => $context->getNavigator()->accept($product->getVariations(), null, $context),
        ];

        if (null === $root) {
            $visitor->setRoot($data);
        }

        return $data;
    }

    public function getType($object)
    {
        return 'Vespolina\Entity\Product\Product';
    }
} 
