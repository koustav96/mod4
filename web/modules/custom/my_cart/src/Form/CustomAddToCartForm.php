<?php

namespace Drupal\my_cart\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Implements a custom Add to Cart form.
 */
class CustomAddToCartForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_add_to_cart_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['add_to_cart'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add to Cart'),
      '#name' => 'add_to_cart', 
      '#attributes' => ['class' => ['button--primary']],
    ];

    $form['actions']['buy_now'] = [
      '#type' => 'submit',
      '#value' => $this->t('Buy Now'),
      '#name' => 'buy_now', 
      '#attributes' => ['class' => ['button--secondary']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $button_name = $form_state->getTriggeringElement()['#name'];

    if ($button_name === 'buy_now') {
      // Set a session variable to indicate Buy Now action.
      \Drupal::state()->set('buy_now_clicked', TRUE);
      // Get the current node (product) if available.
      $node = \Drupal::routeMatch()->getParameter('node');

      if ($node instanceof Node && $node->bundle() === 'product') {
        // Retrieve the title of the current node.
        $item_name = $node->getTitle();
      }
      // Store item name in the state.
      \Drupal::state()->set('thank_you_item_name', $item_name);
      // \Drupal::state()->set('thank_you_item_name', $item_name);
      \Drupal::state()->set('thank_you_user_name', \Drupal::currentUser()->getDisplayName());

      // Redirect to the thank you page.
      $form_state->setRedirect('my_cart.thank_you_page');
    } else {
      \Drupal::messenger()->addMessage($this->t('Product has been added to the cart.'));
    }
  }
}
