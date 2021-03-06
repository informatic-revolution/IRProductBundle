<?php

/*
 * This file is part of the IRProductBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ProductBundle\Form\EventListener;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Build Variable Product Form Listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class BuildVariableProductFormListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    /**
     * Adds fields according to the product state.
     *
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $product = $event->getData();
        $form = $event->getForm();

        if (null === $product || $product->getId()) {
            return;
        }
        
        // We should only be able to select options during the creation process.
        $form->add('options', 'collection', array(
            'type' => 'ir_product_product_option',
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label' => 'form.product.options',
            'translation_domain' => 'ir_product',
        ));        
    }
}