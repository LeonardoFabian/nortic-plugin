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
    const { card_layout, columns, gap } = attributes;
    const blockProps = useBlockProps({
      className: `grid grid-cols-${columns} ${card_layout} gap-${gap}`,
    });

    const setNumberOfColumns = (number) => {
      setAttributes({ columns: number });
    };

    const setCardLayout = (layout) => {
      setAttributes({ card_layout: layout });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <RangeControl
              label={__("Columns", "nortic-plugin")}
              onChange={setNumberOfColumns}
              value={columns}
              min={1}
              max={5}
            />
            <SelectControl
              label={__("Card layout", "nortic-plugin")}
              value={card_layout}
              onChange={setCardLayout}
              options={[
                {
                  label: __("Card group", "nortic-plugin"),
                  value: "card-group",
                },
                { label: __("Card deck", "nortic-plugin"), value: "card-deck" },
                {
                  label: __("Card columns", "nortic-plugin"),
                  value: "card-columns",
                },
              ]}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <InnerBlocks
            orientation="horizontal"
            allowedBlocks={["nortic-plugin/card"]}
          />
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { card_layout, columns, gap } = attributes;
    const blockProps = useBlockProps.save({
      className: `grid grid-cols-${columns} ${card_layout} gap-${gap}`,
    });

    return (
      <div {...blockProps}>
        <InnerBlocks.Content />
      </div>
    );
  },
});
