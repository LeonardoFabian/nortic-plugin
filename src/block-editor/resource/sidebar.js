import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { useSelect, useDispatch } from "@wordpress/data";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  Button,
} from "@wordpress/components";
import { Typography } from "@mui/material";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      resource_ID,
      resource_title,
      resource_name,
      resource_alternative_text,
      resource_file_url,
      resource_related_post_id,
      resource_size_readable,
      resource_size_in_bytes,
      resource_format,
      resource_mime_type,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const [isFileSelected, setIsFileSelected] = useState(false);

    const { editPost } = useDispatch("core/editor");

    const ALLOWED_MEDIA = [
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

    const handleSelectMedia = (media) => {
      console.log("Resource: ", media);

      editPost({
        meta: {
          resource_ID: media?.id,
          resource_title: media?.title,
          resource_name: media?.filename,
          resource_alternative_text: media?.alt,
          resource_file_url: media?.url,
          resource_related_post_id: media?.uploadedTo,
          resource_size_readable: media?.filesizeHumanReadable,
          resource_size_in_bytes: media?.filesizeInBytes,
          resource_format: media?.subtype,
          resource_mime_type: media?.mime,
        },
      });

      setIsFileSelected(true);
    };

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="paperclip"
        title={__("Attached File", "nortic-plugin")}
      >
        <PanelBody title={__("File", "nortic-plugin")}>
          <MediaUploadCheck>
            <MediaUpload
              allowedTypes={ALLOWED_MEDIA}
              render={({ open }) => {
                return (
                  <Button onClick={open} className="is-primary">
                    {__("Select file", "nortic-plugin")}
                  </Button>
                );
              }}
              onSelect={handleSelectMedia}
            />
          </MediaUploadCheck>

          {isFileSelected && (
            <div
              style={{
                margin: "30px auto",
                display: "flex",
                flexDirection: "column",
                gap: "10px",
              }}
            >
              <embed
                src={`${resource_file_url}#page=1`}
                type={resource_mime_type}
                width={200}
                height={250}
              />
              <Typography variant="body2" color="text.secondary">
                <span className="dashicons dashicons-paperclip"></span>
                {resource_name}
              </Typography>
            </div>
          )}
        </PanelBody>
      </PluginSidebar>
    );
  },
});
