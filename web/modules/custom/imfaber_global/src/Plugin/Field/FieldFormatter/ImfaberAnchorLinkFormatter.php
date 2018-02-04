<?php

namespace Drupal\imfaber_global\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Plugin implementation of the 'imfaber_string_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "imfaber_anchor_link_formatter",
 *   label = @Translation("Imfaber anchor link"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class ImfaberAnchorLinkFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
        // Implement settings form.
      ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    foreach ($items as $delta => $item) {
      $view_value = $this->viewValue($item);
      $id = Html::getUniqueId($view_value);
      $elements[$delta] = [
        '#type'       => 'link',
        '#title'      => $view_value,
        '#url'        => Url::fromRoute('<current>', [], [
          'fragment' => $id,
        ]),
        '#attributes' => [
          'name' => $id,
          'class' => 'imfaber-anchor-link',
        ],
      ];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    return nl2br(Html::escape($item->value));
  }

}
