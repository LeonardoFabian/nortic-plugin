import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  ToggleControl,
  PanelBody,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { title, use_default_title } = attributes;
    const { postId } = context;
    const blockProps = useBlockProps({
      className: "mb-8 mt-8",
    });
    const { alias } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    const handleTitleChange = (value) => {
      setAttributes({ title: value });
    };

    if (alias === undefined) {
      return (
        <div
          className="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4"
          role="alert"
        >
          <p className="font-bold">{__("Warning", "nortic-plugin")}</p>
          <p>
            {__(
              "This post type does not have a meta alias field.",
              "nortic-plugin"
            )}
          </p>
        </div>
      );
    } else {
      return (
        <>
          <InspectorControls>
            <PanelBody title={__("Settings", "nortic-plugin")}>
              <ToggleControl
                label={__("Show default title", "nortic-plugin")}
                checked={use_default_title}
                onChange={(use_default_title) =>
                  setAttributes({ use_default_title })
                }
                help={
                  use_default_title
                    ? __("Showing title by default", "nortic-plugin")
                    : __("Add a custom title", "nortic-plugin")
                }
              />
              {!use_default_title && (
                <TextareaControl
                  label={__("Title", block.textdomain)}
                  value={title}
                  onChange={handleTitleChange}
                />
              )}
            </PanelBody>
          </InspectorControls>

          <div {...blockProps}>
            {use_default_title ? (
              <h5>{__("Common name", "nortic-plugin")}</h5>
            ) : (
              <RichText
                tagName="h5"
                placeholder={__("Click to add a title")}
                value={title}
                onChange={(title) => setAttributes({ title })}
                allowedFormats={[
                  "core/bold",
                  "core/italic",
                  "core/link",
                  "core/text-color",
                ]}
              />
            )}
            <TextControl
              label={__("Common name", "nortic-plugin")}
              value={alias}
              onChange={(alias) =>
                editPost({
                  meta: {
                    alias,
                  },
                })
              }
            />
          </div>
        </>
      );
    }
  },
});
