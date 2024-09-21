//===============================================
// np-query.js v1.0
//===============================================

/**
 * Displaying post types based on diferent query parameters and visual configurations.
 */

import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
} from "@wordpress/block-editor";
import {
  PanelBody,
  RangeControl,
  SelectControl,
  ToggleControl,
} from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      columns,
      numberOfPosts,
      categories,
      taxonomies,
      order,
      orderBy,
      displayFeaturedImage,
      displayDate,
    } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={_x("Settings", "PanelBody title", "nortic-plugin")}>
            <RangeControl
              label={_x(
                "Number of Posts",
                "RangeControl label",
                "nortic-plugin"
              )}
              onChange={(numberOfPosts) => setAttributes({ numberOfPosts })}
              value={numberOfPosts}
              min={-1}
              max={100}
            />
            <RangeControl
              label={_x("Columns", "RangeControl label", "nortic-plugin")}
              onChange={(columns) => setAttributes({ columns })}
              value={columns}
              min={1}
              max={5}
            />
            <ToggleControl
              label={_x(
                "Show Featured Image",
                "ToggleControl label",
                "nortic-plugin"
              )}
              checked={displayFeaturedImage}
              onChange={(displayFeaturedImage) =>
                setAttributes({ displayFeaturedImage })
              }
              help={
                displayFeaturedImage
                  ? __("Featured Image viewable", "nortic-plugin")
                  : __("Hidden Featured Image", "nortic-plugin")
              }
            />
            <ToggleControl
              label={_x("Show Date", "ToggleControl label", "nortic-plugin")}
              checked={displayDate}
              onChange={(displayDate) => setAttributes({ displayDate })}
              help={
                displayFeaturedImage
                  ? __("Date viewable", "nortic-plugin")
                  : __("Hidden Date", "nortic-plugin")
              }
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <InnerBlocks
            orientation="horizontal"
            allowedBlocks={["nortic-plugin/np-post-template"]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const blockProps = useBlockProps.save();

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
