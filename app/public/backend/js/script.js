document.addEventListener("DOMContentLoaded", function () {

  const toggler = document.querySelector(".navbar-toggler");

  if (toggler) {
    toggler.addEventListener("click", () => {
      if (window.innerWidth < 992) {
        document.body.classList.toggle("sidebar-open");
      }
    });
  }

  document.addEventListener("click", function (e) {
    if (window.innerWidth >= 992) return;
    if (!document.body.classList.contains("sidebar-open")) return;

    const sidebar = document.getElementById("sidebar");
    const clickedInsideSidebar = sidebar && sidebar.contains(e.target);
    const clickedToggler = toggler && toggler.contains(e.target);

    if (!clickedInsideSidebar && !clickedToggler) {
      document.body.classList.remove("sidebar-open");
    }
  });

  const currentPath = window.location.pathname;

  document.querySelectorAll(".sidebar-link").forEach(function (link) {
    const url = link.getAttribute("data-url") || link.getAttribute("href");
    if (url === currentPath) {
      link.classList.add("active");
    }
  });

  const urlParams = new URLSearchParams(window.location.search);
  const artistId = urlParams.get("artist_id");

  if (
    artistId &&
    document.getElementById("artistName") &&
    document.getElementById("artistImage")
  ) {
    fetchArtistDetails(artistId);
  }
});


$(document).ready(function () {

  $(".summernote").summernote({
    placeholder: "Enter your content . . .",
    height: 200
  });

  $(".page-switch").on("change", function () {
    const pageId = $(this).data("id");
    const isActive = $(this).is(":checked") ? 1 : 0;

    $.ajax({
      url: "/page/status?id=" + encodeURIComponent(pageId),
      type: "POST",
      data: { active: isActive }
    });
  });

});


function fetchArtistDetails(artistId) {
  fetch(`/artists-details?artist_id=${encodeURIComponent(artistId)}`)
    .then(response => response.ok ? response.json() : null)
    .then(data => {
      if (!data) return;

      const name = document.getElementById("artistName");
      const image = document.getElementById("artistImage");

      if (name) {
        name.textContent = data.artist_name || "";
      }

      if (image) {
        image.src = data.image_url
          ? `/images/${data.image_url}`
          : "/images/default.jpg";
      }
    });
}