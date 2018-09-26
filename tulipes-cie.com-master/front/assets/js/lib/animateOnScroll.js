// import isInViewport from "./isInViewPort.js";
import forEach from "./forEach.js";
import isInViewport from "in-viewport";

function showAnimated(selector) {
  const elements = document.querySelectorAll(selector);

  const gap = parseInt((window.innerHeight / 4).toFixed(), 10);

  for (let i = 0; i < elements.length; i++) {
    const item = elements[i];

    if (isInViewport(item)) {
      item.classList.add("in");
    }
  }

  if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
    const remaining = document.querySelectorAll(".animated:not(.in)");

    forEach(remaining, item => {
      item.classList.add("in");
    });
  }
}

/**
 * animations on scroll
 * Adds class "in" on every element having "animated" class
 * appearing in the viewport on scroll.
 * CSS has to do the rest.
 */
function animateOnScroll(selector) {
  showAnimated(selector);

  window.addEventListener("newChildren", () => showAnimated(selector));
  window.addEventListener("scroll", () => showAnimated(selector));
}

export default animateOnScroll;