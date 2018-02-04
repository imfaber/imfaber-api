<?php

namespace Drupal\imfaber_prism\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\prism\PrismConfig;
use Drupal\text\Plugin\Field\FieldWidget\TextareaWidget;

/**
 * Plugin implementation of the 'imfaber_text_prism' widget.
 *
 * @FieldWidget(
 *   id = "imfaber_text_prism",
 *   label = @Translation("Imfaber text prism"),
 *   field_types = {
 *     "text_long"
 *   }
 * )
 */
class ImfaberTextPrismWidget extends TextareaWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state
  ) {

    $element = parent::formElement($items, $delta, $element, $form,
      $form_state);
    $element['#type'] = 'text_format';
    $element['#format'] = $items[$delta]->format;
    $element['#attributes'] = [
      'class' => ['imfaber-prism-widget__textarea'],
    ];

    $config = \Drupal::config('prism.settings');
    $all_languages = PrismConfig::getLanguages();
    $config_language = array_filter($config->get('languages'));
    $languages = array_intersect_key($all_languages, $config_language);

    $element['languages'] = [
      '#type'          => 'select',
      '#title'         => t('Prism language'),
      '#default_value' => $items[$delta]->languages,
      '#options'       => $languages,
      '#description'   => t('Select the language to highlight.'),
      '#weight'        => '99',
      '#empty_option'  => t('None'),
      '#empty_value'   => 'none',
      '#attributes'    => [
        'class' => ['imfaber-prism-widget__lang-select'],
      ],
      '#attached'      => [
        'library' => [
          'imfaber_prism/imfaber_prism.widget',
        ],
      ],
    ];

    return $element;
  }

}
