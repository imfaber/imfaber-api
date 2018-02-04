<?php

namespace Drupal\imfaber_global\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ImfaberGlobalController.
 */
class ImfaberGlobalController extends ControllerBase {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Constructs a new DefaultController object.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
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
   * Homepage.
   *
   * @return string
   *   Return Hello string.
   */
  public function homepage() {
    $entity = config_pages_config('frontpage');
    $view_builder = $this->entityTypeManager->getViewBuilder('config_pages');
    return $view_builder->view($entity);
  }

}
