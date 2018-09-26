import $ from 'jquery';

const navbar = $(".navbar");

function stickyNavbar() {
  window.addEventListener(
    "scroll",
    () => {
      if (window.scrollY === 0) {
        navbar.removeClass("sticky");
      } else {
        navbar.addClass("sticky");
      }
    },
    false
  );
}

function openMenuResponsive() {
  const btnToggle = $(".navbar-burger");
  const menu = $(".navbar-menu");
  btnToggle.click(()=>{
    btnToggle.toggleClass("navbar-burger__active");
    menu.toggleClass("navbar-menu__open");
    return false;
  });
}

export default function () {
  stickyNavbar();
  openMenuResponsive();
}
