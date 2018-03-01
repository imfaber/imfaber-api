/**
 * @file
 * Basic prism settings.
 */

(function ($, Drupal, drupalSettings) {
  'use strict';

  Drupal.behaviors.imfaberPrismWidget = {
    attach: function (context, settings) {

      $('.field--widget-imfaber-text-prism').each(function (i, elem) {
        var $textarea    = $('.imfaber-prism-widget__textarea', $(elem)),
            $select      = $('.imfaber-prism-widget__lang-select', $(elem)),
            textarea_val = $textarea.val();

        $select.on('change', function (e) {
          var lang             = $(this).val() || 'none',
              textarea_new_val = '';

          textarea_val = $textarea.val().replace(/\[\/?prism:((\w+)|((?:\w+-)+\w+))\]/igm, '');
          textarea_new_val += '[prism:' + lang + ']\r' + textarea_val + '[/prism:' + lang + ']';
          $textarea.val(textarea_new_val);
          Drupal.editors.ace_editor.onChange($textarea, function () {
          });
        });

        // If textarea is empty init prism.
        if (!textarea_val) {
          $select.trigger('change');
        }
      });

    }
  };

})(jQuery, Drupal, drupalSettings);
