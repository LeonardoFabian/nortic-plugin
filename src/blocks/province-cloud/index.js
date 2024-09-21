import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { useState, useEffect } from "@wordpress/element";
import { PanelBody, TextareaControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { heading, subheading } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Information", block.textdomain)}>
            <TextareaControl
              label={__("Heading", block.textdomain)}
              value={heading}
              onChange={(value) => setAttributes({ heading: value })}
            />
            <TextareaControl
              label={__("Subheading", block.textdomain)}
              value={subheading}
              onChange={(value) => setAttributes({ subheading: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="wp-block-nortic-plugin-province-cloud-header">
            <RichText
              tagName="h2"
              value={heading}
              onChange={(value) => setAttributes({ heading: value })}
              help={__(
                "This heading will be displayed when the block is used in a province",
                block.textdomain
              )}
            />
            <RichText
              tagName="h4"
              value={subheading}
              onChange={(value) => setAttributes({ subheading: value })}
              help={__(
                "This subheading will be displayed when the block is used in a province",
                block.textdomain
              )}
            />
          </div>
          <ul className="wp-block-nortic-plugin-province-cloud-list">
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
            <li className="wp-block-nortic-plugin-province-cloud-item">
              <span>{__("Province", block.textdomain)}</span>
            </li>
          </ul>
        </div>
      </>
    );
  },
});
