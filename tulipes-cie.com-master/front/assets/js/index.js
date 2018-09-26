import $ from 'jquery';
import animateOnScroll from "./lib/animateOnScroll";
import numberCounter from "./lib/numberCounter";
import viewMore from "./lib/viewMoreTiles";
import cookiesDisclaimer from './cookiesDisclaimer';
import navbar from './navbar.js';
import newsletter from './newsletter.js';
import home from "./home.js";
import achievements from "./achievements.js";
import project from "./project.js";
import agency from "./agency.js";
import contact from "./contact.js";
import instagram from "./instagram.js";
import bulbe from "./bulbe.js"

const page = $("body");

cookiesDisclaimer();
navbar();
animateOnScroll(".animated");
newsletter();


if (page.hasClass("home")) {
  home();
} else if (page.hasClass("achievements")) {
  achievements();
  viewMore(1);
} else if (page.hasClass("project")) {
  project();
} else if (page.hasClass("agency")) {
  agency();
  numberCounter();
} else if (page.hasClass("contact")) {
  contact();
} else if (page.hasClass("instagram")) {
  instagram();
} else if (page.hasClass("team")) {
  viewMore(4);
} else if (page.hasClass("bulbe")) {
  // viewMore(3);
  bulbe();
} else if (page.hasClass("news")) {
  viewMore(1);
}
