/**
 * @file
 * Flickity default carousel behavior.
 */
(function ($) {

  "use strict";

  Backdrop.behaviors.flickityCarousels = {
    /**
     * @param object sliderOptions
     *   Initial options from data attribute.
     * @param object slider
     *   Flickity slider.
     * @param object element
     *   HTMLDivElement.
     */
    applyBreakpoint: function(sliderOptions, slider, element) {
      // Note: this does not update the current index (active items).
      let groupCellsInitial = '100%';
      if (sliderOptions.moveBy > 0) {
        groupCellsInitial = sliderOptions.moveBy;
      }

      if (window.innerWidth <= sliderOptions.breakpoint) {
        slider.options.groupCells = 1;
        element.classList.remove('perpage-' + sliderOptions.perPage);
        element.classList.add('perpage-1');
      }
      else {
        slider.options.groupCells = groupCellsInitial;
        element.classList.remove('perpage-1');
        element.classList.add('perpage-' + sliderOptions.perPage);
      }
    },
    /**
     * We want the cells to expand to full height, but that prevents proper
     * height calculation, so we set the class dynamically after resize.
     *
     * @param object element
     * @param object slider
     */
    sliderResize: function (element, slider) {
      element.classList.remove('cell-full-height');
      slider.resize();
      element.classList.add('cell-full-height');
    },
    /**
     * @param object slider
     */
    localizeButtons: function (slider) {
      let prevLabel = Backdrop.t('Previous');
      slider.prevButton.element.ariaLabel = prevLabel;
      // Descend to the title element inside the svg.
      slider.prevButton.element.firstElementChild.firstElementChild.textContent = prevLabel;
      let nextLabel = Backdrop.t('Next');
      slider.nextButton.element.ariaLabel = nextLabel;
      slider.nextButton.element.firstElementChild.firstElementChild.textContent = nextLabel;
    },
    /**
     * Backdrop.attachBehavior.
     */
    attach: function () {
      if (typeof Flickity === 'undefined') {
        return;
      }
      const widget = this;

      $('.flickity-carousel').once('flickity-carousel').each(function () {
        const element = this;

        // Flickity could initialize OOTB with a data attribute, but we're
        // already initializing here on document ready, so its listener won't
        // work for dynamically loaded content (like views preview).
        let options = {};
        if (element.dataset.flickityOptions) {
          options = JSON.parse(element.dataset.flickityOptions);
        }
        // Allow some room for vertical scrolling for touch devices.
        if (('ontouchstart' in window)) {
          options.dragThreshold = 5;
        }
        const slider = new Flickity(element, options);
        // After slider height calculation is done:
        element.classList.add('cell-full-height');

        if (options.breakpoint > 0) {
          widget.applyBreakpoint(options, slider, element);
          // Initial dot count (number of "pages") might be wrong after applying
          // the breakpoint.
          widget.sliderResize(element, slider);
        }

        widget.localizeButtons(slider);

        // Alternative to Flickity's own resize handling to also handle
        // items-per-page breakpoints.
        let resizeTimer;
        window.addEventListener('resize', function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function() {
            if (options.breakpoint > 0) {
              widget.applyBreakpoint(options, slider, element);
            }
            widget.sliderResize(element, slider);
          }, 150);
        });

        // If we have a button sidebar, handle that... here?
        const parentElem = element.parentElement;
        if (parentElem.classList.contains('flickity-carousel-sidebar-wrapper')) {
          let buttons = element.parentElement.querySelectorAll('button.toggle');
          buttons[slider.selectedIndex].classList.add('active');

          buttons.forEach(function (button) {
            button.addEventListener('click', function () {
              slider.stopPlayer();
              let index = button.dataset.index;
              slider.select(index);
              buttons.forEach(function (b) {
                b.classList.remove('active');
              });
              button.classList.add('active');
            });
          });
          // Keep up with slide changes...
          slider.on('change', function (index) {
            buttons.forEach(function (button) {
              button.classList.remove("active");
            });
            buttons[index].classList.add('active');
          });
        }
      });
    }
  };

})(jQuery);
