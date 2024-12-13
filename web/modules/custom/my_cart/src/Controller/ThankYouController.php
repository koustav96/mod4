<?php

namespace Drupal\my_cart\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the Thank You page.
 */
class ThankYouController extends ControllerBase {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a ThankYouController object.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  /**
   * Returns the thank you page content.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   Render array.
   */
  public function content(Request $request) {
    // Retrieve the item name and user name from the state.
    $item_name = $this->state->get('thank_you_item_name');
    $user_name = $this->state->get('thank_you_user_name');

    // Ensure the item name and user name are available. 
    if (!$item_name || !$user_name) {
      return [
        '#type' => 'markup',
        '#markup' => '<h3>You are not authorized to access this page.</h3>',
      ];
    }

    // Clear state values after use.
    $this->state->delete('thank_you_item_name');
    $this->state->delete('thank_you_user_name');

    // Display the thank you page with item name and user name.
    return [
      '#type' => 'markup',
      '#markup' => '<h3>Thank you, ' . $user_name . ', for your purchase of ' . $item_name . '!</h3>',
    ];
  }
}
