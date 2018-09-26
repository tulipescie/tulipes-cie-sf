/**
 * @param gap offset from which element is
 * considered as in viewport. Default is 0 (bottom)
 */
export default function(element, gap = 0) {
  const viewport = {
    top: window.pageYOffset,
    left: window.pageXOffset,
  };

  viewport.right = viewport.left + window.innerWidth;
  viewport.bottom = viewport.top + window.innerHeight;

  // const halfHeight = window.innerHeight / 2;

  const rect = element.getBoundingClientRect();
  const bounds = {
    top: rect.top + window.pageYOffset,
    left: rect.left + window.pageXOffset,
  };

  bounds.right = bounds.left + element.offsetWidth;
  bounds.bottom = bounds.top + element.outerHeight;

  return !(
    viewport.right < bounds.left ||
    viewport.left > bounds.right ||
    viewport.bottom < bounds.top + gap ||
    viewport.top > bounds.bottom
  );
}
