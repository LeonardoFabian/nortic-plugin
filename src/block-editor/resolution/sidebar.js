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
  Button,
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";
import { useState, useRef, useEffect } from "@wordpress/element";
import { MediaUpload, MediaUploadCheck } from "@wordpress/block-editor";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      rating,
      total_ratings,
      description,
      identification_number,
      date,
      og_title,
      og_description,
      og_image,
      og_override_image,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Resolution Metadata", "nortic-plugin")}
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
          <TextControl
            label={__("Resolution Number", "nortic-plugin")}
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
        </PanelBody>
        <PanelBody title={__("Date Settings", "nortic-plugin")}>
          <Typography variant="body2" color="text.secondary">
            {__("Resolution Date", "nortic-plugin")}
          </Typography>
          <TextControl
            label={__("Resolution Date", "nortic-plugin")}
            value={date}
            onChange={(date) =>
              editPost({
                meta: {
                  date,
                },
              })
            }
          />
          <DateTimePicker
            currentDate={date}
            onChange={(date) =>
              editPost({
                meta: {
                  date,
                },
              })
            }
            is12Hour={true}
          />
        </PanelBody>
        <PanelBody title={__("Open Graph Settings", "nortic-plugin")}>
          <TextControl
            label={__("Open Graph Title", "nortic-plugin")}
            value={og_title}
            onChange={(og_title) =>
              editPost({
                meta: {
                  og_title,
                },
              })
            }
          />
          <TextareaControl
            label={__("Open Graph Description", "nortic-plugin")}
            value={og_description}
            onChange={(og_description) =>
              editPost({
                meta: {
                  og_description,
                },
              })
            }
          />
          <ToggleControl
            label={__("Override Featured Image", "nortic-plugin")}
            checked={og_override_image}
            help={__(
              "By default, the featured image will be used as the image. Check this option to use a different image.",
              "nortic-plugin"
            )}
            onChange={(og_override_image) =>
              editPost({
                meta: {
                  og_override_image,
                },
              })
            }
          />
          {og_override_image && (
            <>
              <img src={og_image} />
              <MediaUploadCheck>
                <MediaUpload
                  accept={["image"]}
                  render={({ open }) => {
                    return (
                      <Button isPrimary onClick={open}>
                        {__("Change image", "nortic-plugin")}
                      </Button>
                    );
                  }}
                  onSelect={(image) => {
                    editPost({
                      meta: {
                        og_image: image.sizes.opengraph.url,
                      },
                    });
                  }}
                />
              </MediaUploadCheck>
            </>
          )}
        </PanelBody>
      </PluginSidebar>
    );
  },
});
