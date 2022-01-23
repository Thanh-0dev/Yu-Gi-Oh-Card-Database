/* Diplay view list or grid */
const list_button = document.querySelector("#list-button");
const grid_button = document.querySelector("#grid-button");
const yu_view_list = document.querySelector("#yu-list-card");
const yu_view_gallery = document.querySelector("#yu-gallery-card");

function update_view(e) {
  if (e === list_button) {
    if ((yu_view_list.style.display = "flex")) {
      yu_view_gallery.style.display = "none";
      list_button.classList.add("active");
      grid_button.classList.remove("active");
      return;
    }
  }

  if (e === grid_button) {
    if ((yu_view_list.style.display = "none")) {
      yu_view_gallery.style.display = "flex";
      grid_button.classList.add("active");
      list_button.classList.remove("active");
      return;
    }
  }
}

/* Select filter */

const attribute_form = document.querySelector("#attribute-form");
const race_form = document.querySelector("#race-form");
const type_form = document.querySelector("#type-form");
const level_form = document.querySelector("#level-form");
attribute_form.style.display = "none";
race_form.style.display = "none";
type_form.style.display = "none";
level_form.style.display = "none";

const attribute_filter_button = document.querySelector("#attribute-filter");
const race_filter_button = document.querySelector("#race-filter");
const type_filter_button = document.querySelector("#type-filter");
const level_filter_button = document.querySelector("#level-filter");

const attribute_svg = document.querySelector("#attribute-svg");
const race_svg = document.querySelector("#race-svg");
const type_svg = document.querySelector("#type-svg");
const level_svg = document.querySelector("#level-svg");

function openFilterOnClick(e) {
  if (e === race_filter_button) {
    /* Race */
    if (race_form.style.display === "flex") {
      race_form.style.display = "none";
      race_svg.classList.remove("drop-down");
      race_svg.classList.add("drop-up");
      return;
    }

    if (race_form.style.display === "none") {
      race_form.style.display = "flex";
      attribute_form.style.display = "none";
      type_form.style.display = "none";
      level_form.style.display = "none";
      downToUp(attribute_svg);
      downToUp(type_svg);
      downToUp(level_svg);
      race_svg.classList.remove("drop-up");
      race_svg.classList.add("drop-down");
      return;
    }
  }

  /* Attribute */
  if (e === attribute_filter_button) {
    if (attribute_form.style.display === "flex") {
      attribute_form.style.display = "none";
      attribute_svg.classList.remove("drop-down");
      attribute_svg.classList.add("drop-up");
      return;
    }

    if (attribute_form.style.display === "none") {
      attribute_form.style.display = "flex";
      race_form.style.display = "none";
      type_form.style.display = "none";
      level_form.style.display = "none";
      downToUp(race_svg);
      downToUp(type_svg);
      downToUp(level_svg);
      attribute_svg.classList.remove("drop-up");
      attribute_svg.classList.add("drop-down");
      return;
    }
  }

  /* Type */
  if (e === type_filter_button) {
    if (type_form.style.display === "flex") {
      type_form.style.display = "none";
      type_svg.classList.remove("drop-down");
      type_svg.classList.add("drop-up");
      return;
    }

    if (type_form.style.display === "none") {
      type_form.style.display = "flex";
      race_form.style.display = "none";
      attribute_form.style.display = "none";
      level_form.style.display = "none";
      downToUp(attribute_svg);
      downToUp(race_svg);
      downToUp(level_svg);
      type_svg.classList.remove("drop-up");
      type_svg.classList.add("drop-down");
      return;
    }
  }

  /* Level */
  if (e === level_filter_button) {
    if (level_form.style.display === "flex") {
      level_form.style.display = "none";
      level_svg.classList.remove("drop-down");
      level_svg.classList.add("drop-up");
      return;
    }

    if (level_form.style.display === "none") {
      level_form.style.display = "flex";
      type_form.style.display = "none";
      race_form.style.display = "none";
      attribute_form.style.display = "none";
      downToUp(attribute_svg);
      downToUp(type_svg);
      downToUp(race_svg);
      level_svg.classList.remove("drop-up");
      level_svg.classList.add("drop-down");
      return;
    }
  }
}

function downToUp(e) {
  if (e.classList.contains("drop-down")) {
    e.classList.remove("drop-down");
    e.classList.add("drop-up");
  }
}
