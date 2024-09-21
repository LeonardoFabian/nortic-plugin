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
    const blockProps = useBlockProps();
    const {
      online_service_available,
      phone_service_available,
      email_service_available,
      in_person_service_available,
      app_service_available,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    const handleTitleChange = (value) => {
      setAttributes({ title: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={__("Show default title", block.textdomain)}
              checked={use_default_title}
              onChange={(use_default_title) =>
                setAttributes({ use_default_title })
              }
              help={
                use_default_title
                  ? __("Showing title by default", block.textdomain)
                  : __("Add a custom title", block.textdomain)
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
            <h5>{__("Available in:", block.textdomain)}</h5>
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
          <ul className="service-delivery-channels-wrapper">
            {phone_service_available && (
              <li className="service-delivery-channels-item">
                <i class="bi bi-headset"></i>
                <span>{__("Phone", block.textdomain)}</span>
              </li>
            )}

            {email_service_available && (
              <li className="service-delivery-channels-item">
                <i className="bi bi-envelope-at"></i>
                <span>{__("Email", block.textdomain)}</span>
              </li>
            )}

            {in_person_service_available && (
              <li className="service-delivery-channels-item">
                <i class="bi bi-pin"></i>
                <span>{__("In person", block.textdomain)}</span>
              </li>
            )}

            {online_service_available && (
              <li className="service-delivery-channels-item">
                <i class="bi bi-laptop"></i>
                <span>{__("Online", block.textdomain)}</span>
              </li>
            )}

            {app_service_available && (
              <li className="service-delivery-channels-item">
                <i className="bi bi-phone"></i>
                <span>{__("App mobile", block.textdomain)}</span>
              </li>
            )}
          </ul>
        </div>
      </>
    );
  },
});
