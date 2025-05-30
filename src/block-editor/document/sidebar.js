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
  SelectControl,
  Button,
} from "@wordpress/components";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      document_type,
      document_parent_id,
      document_external_url,
      document_external_url_label,
      note,
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

      const newIcon = `${pluginDirectoryUri}/dist/public/images/${file.subtype}.svg`;

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
        icon="admin-generic"
        title={__("Document Settings", "nortic-plugin")}
      >
        <PanelBody title={__("Document Options", "nortic-plugin")}>
          <SelectControl
            label={__("Document type", "nortic-plugin")}
            options={[
              {
                label: __("-- Select document type --", "nortic-plugin"),
                value: "",
              },
              { label: __("File", "nortic-plugin"), value: "file" },
              { label: __("Folder", "nortic-plugin"), value: "folder" },
              {
                label: __("External Link", "nortic-plugin"),
                value: "external_link",
              },
              { label: __("Note", "nortic-plugin"), value: "note" },
            ]}
            value={document_type}
            onChange={(value) =>
              editPost({
                meta: {
                  document_type: value,
                },
              })
            }
          />
          {document_type === "external_link" && (
            <>
              <TextControl
                label={__("External URL", "nortic-plugin")}
                value={document_external_url || ""}
                onChange={(document_external_url) =>
                  editPost({
                    meta: {
                      document_external_url,
                    },
                  })
                }
              />
              <TextControl
                label={__("External URL Label", "nortic-plugin")}
                value={document_external_url_label || ""}
                onChange={(document_external_url_label) =>
                  editPost({
                    meta: {
                      document_external_url_label,
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
            </>
          )}
          {document_type === "note" && (
            <TextareaControl
              label={__("Note", "nortic-plugin")}
              value={note}
              onChange={(note) =>
                editPost({
                  meta: {
                    note,
                  },
                })
              }
            />
          )}
        </PanelBody>
        {/* <PanelBody title={__("Statistics", "nortic-plugin")}>
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
        </PanelBody> */}
        {document_type === "file" && (
          <PanelBody title={__("Information", "nortic-plugin")}>
            {/* <TextareaControl
              label={__("File title", "nortic-plugin")}
              value={file_title}
              onChange={(file_title) =>
                editPost({
                  meta: {
                    file_title,
                  },
                })
              }
            /> */}
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

            <Typography variant="body2" color="text.secondary">
              <strong>{__("File name", "nortic-plugin")}:</strong> {file_name}
            </Typography>
            <Typography variant="body2" color="text.secondary">
              <strong>{__("File size", "nortic-plugin")}:</strong>{" "}
              {file_size_readable}
            </Typography>
            <Typography variant="body2" color="text.secondary">
              <strong>{__("File format", "nortic-plugin")}:</strong>{" "}
              {file_format}
            </Typography>
            <Typography variant="body2" color="text.secondary">
              <strong>{__("File URL", "nortic-plugin")}:</strong>
              <a href={file_url} target="_blank">
                {file_url}
              </a>
            </Typography>

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
        )}
      </PluginSidebar>
    );
  },
});
