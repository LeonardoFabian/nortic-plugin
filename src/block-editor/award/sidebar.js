import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  DateTimePicker,
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";
import { useState, useRef, useEffect } from "@wordpress/element";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      iframe,
      identification_number,
      description,
      url,
      expiry_date,
      is_expired,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    return (
      <PluginSidebar
        className="nortic-plugin-sidebar"
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Award Metadata", "nortic-plugin")}
      >
        <PanelBody title={__("Information", "nortic-plugin")}>
          {is_expired && (
            <Typography variant="body2" color="text.secondary">
              {__("the award has expired.", "nortic-plugin")}
            </Typography>
          )}
          <TextControl
            label={__("Identification Number", "nortic-plugin")}
            value={identification_number}
            onChange={(identification_number) =>
              editPost({
                meta: {
                  identification_number,
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
          <TextareaControl
            label={__("Award URL", "nortic-plugin")}
            value={url}
            onChange={(url) =>
              editPost({
                meta: {
                  url,
                },
              })
            }
          />
        </PanelBody>
        <PanelBody title={__("Embed content", "nortic-plugin")}>
          <TextareaControl
            label={__("Embed award", "nortic-plugin")}
            value={iframe}
            onChange={(iframe) =>
              editPost({
                meta: {
                  iframe,
                },
              })
            }
          />
        </PanelBody>
        <PanelBody title={__("Date Settings", "nortic-plugin")}>
          <Typography variant="body2" color="text.secondary">
            {__("Expiry Date", "nortic-plugin")}
          </Typography>
          <TextControl
            label={__("Expiry Date", "nortic-plugin")}
            value={expiry_date}
            onChange={(expiry_date) =>
              editPost({
                meta: {
                  expiry_date,
                },
              })
            }
          />
          <DateTimePicker
            currentDate={expiry_date}
            onChange={(expiry_date) =>
              editPost({
                meta: {
                  expiry_date,
                },
              })
            }
            is12Hour={true}
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
