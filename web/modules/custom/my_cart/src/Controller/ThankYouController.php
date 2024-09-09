<?php

namespace Drupal\my_cart\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for the Thank You page.
 */
class ThankYouController extends ControllerBase {

  /**
   * Returns the thank you page content.
   *
   * @return array
   *   Render array.
   */
  public function content(Request $request) {
    // Retrieve the item name and user name from the state.
    $item_name = \Drupal::state()->get('thank_you_item_name');
    $user_name = \Drupal::state()->get('thank_you_user_name');

    // Ensure the item name and user name are available.
    if (!$item_name || !$user_name) {
      return [
        '#type' => 'markup',
        '#markup' => '<h3>You are not authorized to access this page.</h3>',
      ];
    }

    // Clear state values after use.
    \Drupal::state()->delete('thank_you_item_name');
    \Drupal::state()->delete('thank_you_user_name');

    // Display the thank you page with item name and user name.
    return [
      '#type' => 'markup',
      '#markup' => '<h3>Thank you, ' . $user_name . ', for your purchase of ' . $item_name . '!</h3>',
    ];
  }
}
