import $ from 'jquery';
import animateTarget from './lib/animateOnAnchor.js';

const selectFilter = $(".filter-select");
const formSFilter = $(".filter-form");

let curFiltersUri = null;

window.addEventListener("hashchange",function(event){
  console.log("toto est content");
  getFilterByUrl()
});

/**
 * Reset form of filter selection
 */
function resetForm() {
  $('.filter-reset').click(resetFilterSelect);
}

/**
 * Reset all filters select element
 */
function resetFilterSelect() {
  selectFilter.each(function (i, filter) {
    $(filter).val("");
  });

  selectFilter.trigger('change');
}

/**
 * Get all filters values
 * @returns Object {}
 */
function getFiltersValues() {
  let data = {};
  selectFilter.each(function (i, filter) {
    let $filter = $(filter);
    let val =parseInt($filter.val());
    if (val > 0) {
      data[$filter.attr('name')] = val;
    }
  });

  return data;
}

function activeStickyFilter() {
  const filter = $(".filter");
  const heightHeader = $(".achievements .header").outerHeight() + $(".achievements .addContent").outerHeight();

  window.addEventListener(
    "scroll",
    () => {
      let heightNavbar = $(".achievements .navbar.sticky").outerHeight();
      if (window.scrollY >= heightHeader - heightNavbar ) {
        filter.addClass("sticky");
      } else {
        filter.removeClass("sticky");
      }
    },
    false
  );

}

function customFiltersSelect() {
  selectFilter.on("change" , function() {
    $(this).parent(".filter-customSelect").toggleClass("filter-open");
  });

  $(document).mouseup(function (e) {
    const container = $(".filter-customSelect");
    if (container.has(e.target).length === 0) {
      container.removeClass("filter-open");
    }
  });

  selectFilter.on("change" , function() {
    var selection = $(this).find("option:selected").text(),
        labelFor = $(this).attr("id"),
        label = $("[for='" + labelFor + "']");

    label.find("span").html(selection);

  });
}

/**
 * Manage filter form in mobile's device
 */
function showFilterFormInMobile() {
  let data;

  //Button Show form
  $('.filter-show').click(()=>{
    formSFilter.show();
    data = getFiltersValues();
  });

  //Button Cancel
  $('.filter-cancel').click(() => {
    resetFilterSelect();

    //set filters select with the previous values
    $.each(data, (filter, value) => {$('select[name='+ filter +']').val(value)});

    selectFilter.trigger('change');

    return false;
  });

  ////Button Apply form
  $('.filter-apply').click(()=>{
    formSFilter.hide();
    return false;
  });
}

/**
 * Get projects if one filter's select change
 */
function getProjectByFilter() {
  selectFilter.on("change" , function() {
    loadProjectList();
  });
}

/**
 * Repalce uri with a newURi that have filters
 * @param filters
 */
function addFilterInUri(filters) {
  if ("object" === typeof filters) {
    const route = window.location.pathname;
    let newUri = route + "#filters:";

    Object.keys(filters).map((filterType) => {
      const filterId = filters[filterType];
      newUri += filterType.toLowerCase() + '=' + filterId + '&';
    });

    newUri = newUri.substr(0, newUri.length-1);

    window.history.pushState("", "", newUri);
  }
}

/**
 * Get in Json all the projects with filter in form
 */
function loadProjectList() {
  // Build data
  let data = getFiltersValues();
  addFilterInUri(data);
  console.log("data: ", data);
  const topProjects = $("#top-projects");

  // Send ajax
  $.ajax({
    'url': formSFilter.attr('action'),
    'method': 'POST',
    'data': data,
    'dataType': 'json'
  }).done(function(response) {
    renderProjectsByFilters(response);
    animateTarget(topProjects);
  }).fail(function(){
    console.log("Error ajax");
  });
}

/**
 * Render the html project list with those in param data
 * @param data
 */
function renderProjectsByFilters(data) {
  let projects = data.projects;
  let locale = data.locale;

  const containerProjects = $(".projects").find(".container");

  if (projects.length == 0){
    containerProjects.html('<h3 class="no-projetcs">' + data.message + '</h3>');
  } else{
    let html ='';
    projects.forEach((project, index)=>{
      let j = (index % 5) + 1;
      if (j === 1) html += '<div class="projects-row">';
      let urlProject = $('.project-routeUrl').text().replace('slug', project.slug);
      html += '<a href="'+ urlProject +'" class="projects-tile">';
      html += '<img class="projects-img" src="'+ project.image +'" >';
      html += '<span class="projects-name">'+ project.title +'</span></a>';

      if (j == 5 || (index===projects.length-1)) html += '</div>';
    });
    containerProjects.html(html);
  }
}

/**
 * Select filter with the value in url
 * http://tulipes-cie.com.ved/fr/realisations#filter:tech=11&customer=18
 */
function getFilterByUrl() {

  const url = location.href;
  if (url.indexOf("#filters") !== -1) {
    const dataInUrl = url.split("#filters:")[1];
    const filters = dataInUrl.split('&');
    resetFilterSelect();

    filters.forEach( filter => {
      let filterType = filter.split('=')[0];
      let filterId = filter.split('=')[1];

      switch(filterType) {
        case "activity":
          $("select[name=Activity]").val(filterId).change();
          break;

        case "thematic":
          $("select[name=Thematic]").val(filterId).change();
          break;

        case "award":
          $("select[name=Award]").val(filterId).change();
          break;

        case "customer":
          $("select[name=Customer]").val(filterId).change();
          break;

        case "tech":
          $("select[name=Tech]").val(filterId).change();
          break;

        case "director":
          $("select[name=Director]").val(filterId).change();
          break;
      }

    });
  }
}

export default function () {
  resetForm();
  customFiltersSelect();
  showFilterFormInMobile();
  activeStickyFilter();
  getProjectByFilter();
  getFilterByUrl();
}