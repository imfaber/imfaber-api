/**
 * @file
 * Basic prism settings.
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.imfaberPrismWidget = {
    attach: function (context, settings) {

      $('.field--widget-imfaber-text-prism .text-format-wrapper').each(function (i, elem) {
        var $textarea    = $('.imfaber-prism-widget__textarea', $(elem)),
            $select      = $('.imfaber-prism-widget__lang-select', $(elem)),
            textarea_val = $textarea.val();

        $select.on('change', function (e) {
          var lang             = $(this).val() || 'None',
              textarea_new_val = '';

          textarea_val = $textarea.val().replace(/\[\/?prism:((\w+)|((?:\w+-)+\w+))\]/igm, '');
          textarea_new_val += '[prism:' + lang + ']\r' + textarea_val + '[/prism:' + lang + ']';
          $textarea.val(textarea_new_val);
          Drupal.editors.ace_editor.onChange($textarea, function () {
          });
        });

        // Set selected languange in the prism select.
        if ($textarea.val()) {
          $select
            .val($textarea.val().match(/\[prism:(.*?)\]/)[1])
            .trigger("chosen:updated");
        }

      });

    }
  };

})(jQuery, Drupal, drupalSettings);
