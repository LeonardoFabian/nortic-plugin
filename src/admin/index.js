import "./main.css";

// Options Page

const logoImgUploadBtn = document.querySelector("#np-theme-logo-upload-btn");
const logoImgPreview = document.querySelector("#np-theme-logo-preview");
const logoImgInput = document.querySelector("#np_theme_logo");

const logoFooterImgUploadBtn = document.querySelector(
  "#np-theme-footer-logo-upload-btn"
);
const logoFooterImgPreview = document.querySelector(
  "#np-theme-footer-logo-preview"
);
const logoFooterImgInput = document.querySelector("#np_theme_footer_logo");

// Open Graph Options Page

const ogImgUploadBtn = document.querySelector("#np-og-img-upload-btn");
const ogImgPreview = document.querySelector("#np-og-img-preview");
const ogImgInput = document.querySelector("#np_og_image");

// initialize media library
const logoMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media",
  },
  multiple: false,
});
const logoFooterMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media",
  },
  multiple: false,
});
const opengraphMediaFrame = wp.media({
  title: "Select or Upload Media",
  button: {
    text: "Use this media",
  },
  multiple: false,
});

logoImgUploadBtn?.addEventListener("click", (event) => {
  event.preventDefault();
  logoMediaFrame.open();
});
logoMediaFrame.on("select", () => {
  const logoAttachment = logoMediaFrame
    .state()
    .get("selection")
    .first()
    .toJSON();
  logoImgPreview.src = logoAttachment.sizes.logo.url;
  logoImgInput.value = logoAttachment.sizes.logo.url;
});

logoFooterImgUploadBtn?.addEventListener("click", (event) => {
  event.preventDefault();
  logoFooterMediaFrame.open();
});
logoFooterMediaFrame.on("select", () => {
  const logoFooterAttachment = logoFooterMediaFrame
    .state()
    .get("selection")
    .first()
    .toJSON();
  logoFooterImgPreview.src = logoFooterAttachment.sizes.logoFooter.url;
  logoFooterImgInput.value = logoFooterAttachment.sizes.logoFooter.url;
});

ogImgUploadBtn?.addEventListener("click", (event) => {
  event.preventDefault();
  opengraphMediaFrame.open();
});
opengraphMediaFrame.on("select", () => {
  const opengraphAttachment = opengraphMediaFrame
    .state()
    .get("selection")
    .first()
    .toJSON();
  ogImgPreview.src = opengraphAttachment.sizes.opengraph.url;
  ogImgInput.value = opengraphAttachment.sizes.opengraph.url;
});
