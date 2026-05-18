/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  config.language = "th";
  config.extraPlugins = "uploadimage";
  // config.uploadUrl = "/file/ckeditor-uploader.php";
  config.height = "40em";
  config.font_defaultLabel =
    "Inter/Inter,-apple-system, BlinkMacSystemFont, sans-serif;";
  config.font_names =
    "Inter/Inter,-apple-system, BlinkMacSystemFont, sans-serif;" +
    "Kanit;" +
    "Sarabun;" +
    "Bai Jamjuree;";
  config.allowedContent = true;
  config.contentsCss = [
    "/static/library/fontawesome-free-6.2.1-web/css/all.min.css",
    "/static/library/bootstrap-4.6.2-dist/css/bootstrap.min.css",
    "/static/library/mdbootstrap-4.19.1/css/mdb.min.css",
    "/static/asset/style.css",
  ]
};

CKEDITOR.on("dialogDefinition", function (ev) {
  var dialogName = ev.data.name,
    dialogDefinition = ev.data.definition;
  if (dialogName == "image") {
    var infoTab = dialogDefinition.getContents("info");
    infoTab.remove("txtWidth"); // Remove width element from Info tab
    infoTab.remove("txtHeight"); // Remove height element from Info tab
  }
});
