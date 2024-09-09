<?php

declare(strict_types=1);

namespace Drupal\my_cart\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Custom Add to Cart' Block.
 *
 * @Block(
 *   id = "custom_add_to_cart_block",
 *   admin_label = @Translation("Custom Add to Cart Block"),
 * )
 */
class CustomAddToCartBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\my_cart\Form\CustomAddToCartForm');
    return $form;
  }
}
