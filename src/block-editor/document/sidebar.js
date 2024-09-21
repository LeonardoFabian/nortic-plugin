import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import { Rating, Typography } from "@mui/material";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  Button,
} from "@wordpress/components";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      rating,
      total_ratings,
      icon,
      default_icon,
      use_default_icon,
      description,
      file_title,
      file_name,
      file_alt,
      file_url,
      file_related_post,
      file_size_readable,
      file_size_in_bytes,
      file_format,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    // Load plugin directory to load assets, ex.: images
    const { pluginDirectoryUri } = pluginPublicScripts;

    const ALLOWED_MEDIA_TYPES = [
      "application/pdf",
      "application/vnd.ms-powerpoint",
      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
      "text/plain",
      "application/vnd.ms-excel",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      "text/csv",
      "application/msword",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "application/vnd.oasis.opendocument.spreadsheet",
      "application/vnd.oasis.opendocument.text",
    ];

    const handleImageSelect = (file) => {
      console.log(file);

      let newIcon = `${pluginDirectoryUri}/dist/public/images/${file.subtype}.svg`;

      editPost({
        meta: {
          file_title: file.title,
          file_name: file.filename,
          file_alt: file.alt,
          file_url: file.url,
          file_related_post: file.uploadedTo,
          file_size_readable: file.filesizeHumanReadable,
          file_size_in_bytes: file.filesizeInBytes,
          file_format: file.subtype,
          default_icon: file.icon,
          icon: newIcon,
        },
      });
    };

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Document Metadata", "nortic-plugin")}
      >
        <PanelBody title={__("Statistics", "nortic-plugin")}>
          <Rating value={rating} precision={0.5} readOnly />
          <Typography variant="body2" color="text.secondary">
            {__("Rating", "nortic-plugin")}: {rating}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            {__("Total", "nortic-plugin")}: {total_ratings}{" "}
            {total_ratings == 1
              ? __("user rating", "nortic-plugin")
              : __("users rating", "nortic-plugin")}
          </Typography>
        </PanelBody>
        <PanelBody title={__("Information", "nortic-plugin")}>
          <TextareaControl
            label={__("File title", "nortic-plugin")}
            value={file_title}
            onChange={(file_title) =>
              editPost({
                meta: {
                  file_title,
                },
              })
            }
          />
          <TextareaControl
            label={__("Description", "nortic-plugin")}
            value={description}
            onChange={(description) =>
              editPost({
                meta: {
                  description,
                },
              })
            }
          />

          <Typography variant="body2" color="text.secondary">
            <strong>{__("File name", "nortic-plugin")}:</strong> {file_name}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            <strong>{__("File size", "nortic-plugin")}:</strong>{" "}
            {file_size_readable}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            <strong>{__("File format", "nortic-plugin")}:</strong> {file_format}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            <strong>{__("File URL", "nortic-plugin")}:</strong>
            <a href={file_url} target="_blank">
              {file_url}
            </a>
          </Typography>

          <MediaUploadCheck>
            <MediaUpload
              allowedTypes={ALLOWED_MEDIA_TYPES}
              render={({ open }) => {
                return (
                  <Button isPrimary onClick={open}>
                    {__("Select file", "nortic-plugin")}
                  </Button>
                );
              }}
              onSelect={handleImageSelect}
            />
          </MediaUploadCheck>

          <ToggleControl
            label={__("Use default icon", "nortic-plugin")}
            checked={use_default_icon}
            help={
              use_default_icon
                ? __(
                    "Show the default WordPress icon for documents.",
                    "nortic-plugin"
                  )
                : __(
                    "Show the plugin icon. The image is associated with the file format."
                  )
            }
            onChange={(use_default_icon) =>
              editPost({
                meta: {
                  use_default_icon,
                },
              })
            }
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
