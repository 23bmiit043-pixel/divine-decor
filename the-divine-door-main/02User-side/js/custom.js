(function () {
  "use strict";

  function ready(callback) {
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", callback, { once: true });
      return;
    }

    callback();
  }

  function initTestimonialSlider() {
    var sliderContainer = document.querySelector(".testimonial-slider");

    if (!sliderContainer || typeof tns === "undefined") {
      return;
    }

    tns({
      container: ".testimonial-slider",
      items: 1,
      axis: "horizontal",
      controlsContainer: "#testimonial-nav",
      swipeAngle: false,
      speed: 700,
      nav: true,
      controls: true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3500,
      autoplayButtonOutput: false,
    });
  }

  function initProductSliders() {
    if (typeof tns === "undefined") {
      return;
    }

    document.querySelectorAll("[data-products-slider]").forEach(function (slider) {
      if (slider.dataset.sliderReady === "true") {
        return;
      }

      var scope = slider.closest("[data-slider-scope]") || document;
      var prevButton = scope.querySelector("[data-slider-prev]");
      var nextButton = scope.querySelector("[data-slider-next]");
      var totalSlides = slider.children.length;

      if (totalSlides <= 1) {
        if (prevButton) {
          prevButton.style.display = "none";
        }

        if (nextButton) {
          nextButton.style.display = "none";
        }

        slider.dataset.sliderReady = "true";
        return;
      }

      tns({
        container: slider,
        items: 1,
        slideBy: 1,
        autoplay: totalSlides > 1,
        autoplayTimeout: 2750,
        autoplayButtonOutput: false,
        controls: !!(prevButton && nextButton),
        prevButton: prevButton || undefined,
        nextButton: nextButton || undefined,
        nav: false,
        mouseDrag: totalSlides > 1,
        gutter: 0,
        loop: totalSlides > 4,
        responsive: {
          576: { items: Math.min(2, totalSlides) },
          992: { items: Math.min(3, totalSlides) },
          1200: { items: Math.min(4, totalSlides) },
        },
      });

      slider.dataset.sliderReady = "true";
    });
  }

  function initSiteNav() {
    var nav = document.querySelector("[data-site-nav]");
    var toggle = document.querySelector("[data-nav-toggle]");
    var menu = document.querySelector("[data-nav-menu]");

    if (!nav) {
      return;
    }

    var syncScrollState = function () {
      nav.classList.toggle("is-scrolled", window.scrollY > 8);
    };

    syncScrollState();
    window.addEventListener("scroll", syncScrollState, { passive: true });

    if (!toggle || !menu) {
      return;
    }

    toggle.addEventListener("click", function () {
      var isOpen = menu.classList.toggle("show");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    menu.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        if (window.innerWidth <= 991) {
          menu.classList.remove("show");
          toggle.setAttribute("aria-expanded", "false");
        }
      });
    });

    document.addEventListener("click", function (event) {
      if (window.innerWidth > 991) {
        return;
      }

      if (!nav.contains(event.target)) {
        menu.classList.remove("show");
        toggle.setAttribute("aria-expanded", "false");
      }
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth > 991) {
        menu.classList.remove("show");
        toggle.setAttribute("aria-expanded", "false");
      }
    });
  }

  function initNavSearch() {
    var searchShell = document.querySelector("[data-nav-search]");

    if (!searchShell) {
      return;
    }

    var toggle = searchShell.querySelector("[data-search-toggle]");
    var panel = searchShell.querySelector("[data-search-panel]");
    var input = searchShell.querySelector("[data-search-input]");

    if (!toggle || !panel || !input) {
      return;
    }

    var setOpenState = function (isOpen) {
      searchShell.classList.toggle("is-open", isOpen);
      panel.hidden = !isOpen;
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");

      if (isOpen) {
        window.requestAnimationFrame(function () {
          input.focus();

          if (input.value) {
            input.select();
          }
        });
      }
    };

    setOpenState(input.value.trim() !== "");

    toggle.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      setOpenState(!searchShell.classList.contains("is-open"));
    });

    document.addEventListener("click", function (event) {
      if (searchShell.contains(event.target)) {
        return;
      }

      setOpenState(false);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        setOpenState(false);
      }
    });
  }

  function initGenericQuantityControls() {
    var quantityGroups = document.getElementsByClassName("quantity-container");

    function bindGroup(group) {
      var quantityAmount = group.getElementsByClassName("quantity-amount")[0];
      var increase = group.getElementsByClassName("increase")[0];
      var decrease = group.getElementsByClassName("decrease")[0];

      if (!quantityAmount || !increase || !decrease) {
        return;
      }

      if (increase.hasAttribute("data-cart-control") || decrease.hasAttribute("data-cart-control")) {
        return;
      }

      increase.addEventListener("click", function () {
        var value = parseInt(quantityAmount.value, 10);
        quantityAmount.value = isNaN(value) ? 1 : value + 1;
      });

      decrease.addEventListener("click", function () {
        var value = parseInt(quantityAmount.value, 10);
        value = isNaN(value) ? 1 : value;
        quantityAmount.value = value > 1 ? value - 1 : 1;
      });
    }

    for (var index = 0; index < quantityGroups.length; index += 1) {
      bindGroup(quantityGroups[index]);
    }
  }

  function initLegalAccordions() {
    document.querySelectorAll("[data-legal-accordion]").forEach(function (accordion) {
      var items = accordion.querySelectorAll(".legal-accordion-item");

      if (!items.length) {
        return;
      }

      var setItemState = function (item, isOpen) {
        var trigger = item.querySelector("[data-legal-trigger]");
        var panel = item.querySelector("[data-legal-panel]");
        var icon = item.querySelector(".legal-accordion-toggle i");

        item.classList.toggle("is-open", isOpen);

        if (trigger) {
          trigger.setAttribute("aria-expanded", isOpen ? "true" : "false");
        }

        if (panel) {
          panel.hidden = !isOpen;
        }

        if (icon) {
          icon.className = isOpen ? "fas fa-minus" : "fas fa-plus";
        }
      };

      items.forEach(function (item) {
        var trigger = item.querySelector("[data-legal-trigger]");

        setItemState(item, item.classList.contains("is-open"));

        if (!trigger) {
          return;
        }

        trigger.addEventListener("click", function () {
          var shouldOpen = !item.classList.contains("is-open");

          items.forEach(function (otherItem) {
            setItemState(otherItem, false);
          });

          setItemState(item, shouldOpen);
        });
      });
    });
  }

  function initHorizontalScrollRails() {
    document.querySelectorAll(".shop-filter-scroll").forEach(function (rail) {
      if (rail.dataset.scrollRailReady === "true") {
        return;
      }

      var startX = 0;
      var startScrollLeft = 0;
      var isPointerDown = false;
      var isDragging = false;

      rail.addEventListener(
        "wheel",
        function (event) {
          if (rail.scrollWidth <= rail.clientWidth) {
            return;
          }

          var delta = Math.abs(event.deltaX) > Math.abs(event.deltaY) ? event.deltaX : event.deltaY;

          if (!delta) {
            return;
          }

          event.preventDefault();
          rail.scrollLeft += delta;
        },
        { passive: false }
      );

      rail.addEventListener("pointerdown", function (event) {
        if (event.pointerType === "mouse" && event.button !== 0) {
          return;
        }

        isPointerDown = true;
        isDragging = false;
        startX = event.clientX;
        startScrollLeft = rail.scrollLeft;
        rail.classList.add("is-dragging");
      });

      rail.addEventListener("pointermove", function (event) {
        if (!isPointerDown) {
          return;
        }

        var distance = event.clientX - startX;

        if (Math.abs(distance) > 6) {
          isDragging = true;
        }

        if (!isDragging) {
          return;
        }

        rail.scrollLeft = startScrollLeft - distance;
      });

      var stopDragging = function () {
        isPointerDown = false;
        window.setTimeout(function () {
          isDragging = false;
        }, 0);
        rail.classList.remove("is-dragging");
      };

      rail.addEventListener("pointerup", stopDragging);
      rail.addEventListener("pointercancel", stopDragging);
      rail.addEventListener("pointerleave", function () {
        if (!isPointerDown) {
          rail.classList.remove("is-dragging");
        }
      });

      rail.addEventListener(
        "click",
        function (event) {
          if (!isDragging) {
            return;
          }

          event.preventDefault();
          event.stopPropagation();
        },
        true
      );

      rail.dataset.scrollRailReady = "true";
    });
  }

  function initShopSubcategoryPanel() {
    var panel = document.querySelector("[data-subcategory-panel]");
    var groups = document.querySelectorAll("[data-filter-group]");

    if (!panel || !groups.length) {
      return;
    }

    var closePanel = function () {
      groups.forEach(function (group) {
        var toggle = group.querySelector("[data-subcategory-toggle]");

        group.classList.remove("is-open");

        if (toggle) {
          toggle.setAttribute("aria-expanded", "false");
        }
      });

      panel.innerHTML = "";
      panel.hidden = true;
    };

    var openPanel = function (group) {
      var toggle = group.querySelector("[data-subcategory-toggle]");
      var template = group.querySelector("[data-filter-menu-template]");

      if (!toggle || !template) {
        closePanel();
        return;
      }

      groups.forEach(function (otherGroup) {
        var otherToggle = otherGroup.querySelector("[data-subcategory-toggle]");

        otherGroup.classList.remove("is-open");

        if (otherToggle) {
          otherToggle.setAttribute("aria-expanded", "false");
        }
      });

      group.classList.add("is-open");
      toggle.setAttribute("aria-expanded", "true");
      panel.innerHTML = template.innerHTML;
      panel.hidden = false;
    };

    groups.forEach(function (group) {
      var toggle = group.querySelector("[data-subcategory-toggle]");

      if (!toggle) {
        return;
      }

      toggle.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (group.classList.contains("is-open")) {
          closePanel();
          return;
        }

        openPanel(group);
      });
    });

    document.addEventListener("click", function (event) {
      if (panel.hidden) {
        return;
      }

      if (panel.contains(event.target)) {
        return;
      }

      var clickedToggle = event.target.closest("[data-subcategory-toggle]");

      if (clickedToggle) {
        return;
      }

      closePanel();
    });

    var selectedGroup = document.querySelector("[data-filter-group].is-selected");

    if (selectedGroup) {
      openPanel(selectedGroup);
    }
  }

  window.updateCartBadge = function (count) {
    var badges = document.querySelectorAll(".cart-count");
    var badgeValue = parseInt(count, 10);
    var safeCount = isNaN(badgeValue) ? 0 : badgeValue;

    badges.forEach(function (badge) {
      badge.textContent = safeCount;
      badge.style.display = safeCount > 0 ? "inline-flex" : "none";
    });
  };

  ready(function () {
    initTestimonialSlider();
    initProductSliders();
    initSiteNav();
    initNavSearch();
    initGenericQuantityControls();
    initLegalAccordions();
    initHorizontalScrollRails();
    initShopSubcategoryPanel();
  });
})();
