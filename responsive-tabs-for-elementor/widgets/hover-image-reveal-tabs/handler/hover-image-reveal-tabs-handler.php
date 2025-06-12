<script>
  function toggleRepeaterAddButton() {
    const controlElement = document.querySelector('.elementor-control-hover_image_reveal_tabs_content_section');

    if (controlElement && controlElement.classList.contains('e-open')) {
      const repeaterWrapper = document.querySelector('.responsive-hover-image-tabs-control .elementor-repeater-fields-wrapper');
      const addButton = document.querySelector('.responsive-hover-image-tabs-control .elementor-button.elementor-repeater-add');

      if (!repeaterWrapper || !addButton) return;

      const items = repeaterWrapper.querySelectorAll('.elementor-repeater-fields');

      if (items.length >= 8) {
        addButton.setAttribute('disabled', 'disabled');
      } else {
        addButton.removeAttribute('disabled');
      }
    }
  }

  function mutationObserverHandler() {
    const observer = new MutationObserver(mutations => {
      mutations.forEach(mutation => {
        toggleRepeaterAddButton();
      });
    });

    const elementorPanel = document.querySelector('#elementor-panel');

    if (elementorPanel) {
      observer.observe(elementorPanel, {
        childList: true,
        subtree: true
      });
    }
  }

  if (window.elementorFrontend && window.elementorFrontend.isEditMode()) {
    window.elementorFrontend.hooks.addAction(
      'frontend/element_ready/global',
      mutationObserverHandler
    );
  } else {
    document.addEventListener('DOMContentLoaded', mutationObserverHandler);
  }
</script>