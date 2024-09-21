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
      className: "mb-12 mt-8",
    });
    const { phone, email, location, map_iframe } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

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
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="contact-info-wrapper">
            <>
              <div className="contact-info-content-wrapper">
                {use_default_title ? (
                  <h5>{__("Contact Information", block.textdomain)}</h5>
                ) : (
                  <RichText
                    tagName="h5"
                    placeholder={__("Click to add a title", block.textdomain)}
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
                <div className="contact-info-content-meta">
                  <div className="flex items-start gap-4">
                    <TextControl
                      label={__("Email", block.textdomain)}
                      className="w-full"
                      value={email}
                      onChange={(email) =>
                        editPost({
                          meta: {
                            email,
                          },
                        })
                      }
                      help={__("Add an email", block.textdomain)}
                    />
                    <TextControl
                      label={__("Phone Number", block.textdomain)}
                      className="w-full"
                      value={phone}
                      onChange={(phone) =>
                        editPost({
                          meta: {
                            phone,
                          },
                        })
                      }
                      help={__("Add a phone number", block.textdomain)}
                    />
                  </div>
                  <TextareaControl
                    label={__("Location", block.textdomain)}
                    value={location}
                    onChange={(location) =>
                      editPost({
                        meta: {
                          location,
                        },
                      })
                    }
                    help={__("Add an address.", block.textdomain)}
                  />
                </div>
              </div>

              <div className="contact-info-map-wrapper">
                <TextareaControl
                  label={__("Map iframe", block.textdomain)}
                  value={map_iframe}
                  onChange={(map_iframe) =>
                    editPost({
                      meta: {
                        map_iframe,
                      },
                    })
                  }
                  help={__("Add an address.", block.textdomain)}
                />
              </div>
            </>
          </div>
        </div>
      </>
    );
  },
});
