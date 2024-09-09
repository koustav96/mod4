(function ($, Drupal) {
  Drupal.behaviors.customToggle = {
    attach: function (context, settings) {
      $('#toggle-button', context).once('customToggle').click(function () {
        var button = $(this);
        var content = $('#body-content');

        if (button.text() === 'Read More') {
          // Expand the content.
          content.html(settings.fullBodyText);
          button.text('Show Less');
        } else {
          // Collapse the content.
          content.html(settings.trimmedBodyText + '...');
          button.text('Read More');
        }
      });
    }
  };

  // Pass trimmed and full body text to JavaScript.
  Drupal.behaviors.customToggle.settings = {
    trimmedBodyText: "{{ body_text_trimmed|escape('js') }}",
    fullBodyText: "{{ body_text|escape('js') }}"
  };
})(jQuery, Drupal);
