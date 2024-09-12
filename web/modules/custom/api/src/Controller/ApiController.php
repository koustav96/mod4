<?php

declare(strict_types=1);

namespace Drupal\api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Api routes.
 */
final class ApiController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a MovieApiController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Returns a JSON response with movie nodes data.
   */
  public function getProducts() {

    // Get the node storage.
    $node_storage = $this->entityTypeManager->getStorage('node');

    // Load all Product nodes.
    $query = $node_storage->getQuery()
      ->condition('type', 'product')
      ->condition('status', 1)
      ->accessCheck(FALSE)
      ->execute();

    $nodes = $node_storage->loadMultiple($query);

    // Prepare data to be returned.
    $products = [];
    foreach ($nodes as $node) {
      $products[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
        'body' => $node->get('body')->value,
        'product_price' => $node->get('field_price')->value,
        'product_image' => $node->get('field_images')->entity ? $node->get('field_images')->entity->createFileUrl() : '',
      ];
    }

    // Return JSON response.
    return new JsonResponse($products);
  }
}
