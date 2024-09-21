import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
} from "@wordpress/block-editor";
import { PanelBody, RangeControl, SelectControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { columns, imageShape } = attributes;
    const blockProps = useBlockProps({
      className: `cols-${columns}`,
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <RangeControl
              label={__("Columns", "nortic-plugin")}
              onChange={(columns) => setAttributes({ columns })}
              value={columns}
              min={1}
              max={5}
            />
            <SelectControl
              label={__("Image Shape", "nortic-plugin")}
              value={imageShape}
              options={[
                { label: __("Circle", "nortic-plugin"), value: "circle" },
                { label: __("Square", "nortic-plugin"), value: "square" },
                { label: __("Rectangle", "nortic-plugin"), value: "rectangle" },
                { label: __("Triangle", "nortic-plugin"), value: "triangle" },
                { label: __("Rhombus", "nortic-plugin"), value: "rhombus" },
                { label: __("Pentagon", "nortic-plugin"), value: "pentagon" },
                { label: __("Hexagon", "nortic-plugin"), value: "hexagon" },
                { label: __("Octagon", "nortic-plugin"), value: "octagon" },
              ]}
              onChange={(imageShape) => setAttributes({ imageShape })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <InnerBlocks
            orientation="horizontal"
            allowedBlocks={[
              "nortic-plugin/team-member",
              "nortic-plugin/office-locations",
              "nortic-plugin/office-location",
              "nortic-plugin/banner",
              "nortic-plugin/file",
              "nortic-plugin/file-list",
              "nortic-plugin/link",
              "nortic-plugin/image-gallery",
            ]}
            // template={[
            //   [
            //     "nortic-plugin/team-member",
            //     {
            //       name: "John Doe",
            //       title: "CEO",
            //       bio: "This is an example bio.",
            //     },
            //   ],
            //   ["nortic-plugin/team-member"],
            //   ["nortic-plugin/team-member"],
            // ]}
            // templateLock="insert"
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { columns } = attributes;
    const blockProps = useBlockProps.save({
      className: `cols-${columns}`,
    });

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
