import { registerBlockType } from "@wordpress/blocks";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";
import {
  SelectControl,
  PanelBody,
  __experimentalVStack as VStack,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { icon_class, icon_category, icon_size } = attributes;
    const blockProps = useBlockProps({
      className: `bi ${icon_class} overflow-hidden`,
      style: {
        width: `${icon_size}px`,
        height: `${icon_size}px`,
      },
    });

    const selectIcon = (icon) => {
      setAttributes({ icon_class: icon });
    };

    const selectCategory = (cat) => {
      setAttributes({ icon_category: cat });
    };

    const selectIconSize = (size) => {
      setAttributes({ icon_size: size });
    };

    const iconClass = `bi ${icon_class}`;

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <SelectControl
              label={__("Icon", "nortic-plugin")}
              value={icon_class}
              onChange={selectIcon}
              options={[
                { label: __("Flag", "nortic-plugin"), value: "bi-flag" },
                { label: __("Star", "nortic-plugin"), value: "bi-star" },
              ]}
            />
            <VStack>
              <i
                className={iconClass}
                style={{ fontSize: icon_size + "px" }}
              ></i>
            </VStack>
            <SelectControl
              label={__("Category", "nortic-plugin")}
              value={icon_category}
              onChange={selectCategory}
              options={[
                { label: __("Shape", "nortic-plugin"), value: "shape" },
                { label: __("Star", "nortic-plugin"), value: "bi-star" },
              ]}
            />
            <SelectControl
              label={__("Size", "nortic-plugin")}
              value={icon_size}
              onChange={selectIconSize}
              options={[
                { label: __("16x16", "nortic-plugin"), value: 16 },
                { label: __("32x32", "nortic-plugin"), value: 32 },
                { label: __("96x96", "nortic-plugin"), value: 96 },
                { label: __("180x180", "nortic-plugin"), value: 180 },
                { label: __("300x300", "nortic-plugin"), value: 300 },
                { label: __("512x512", "nortic-plugin"), value: 512 },
              ]}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <i className={iconClass} style={{ fontSize: icon_size + "px" }}></i>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { icon_class, icon_category, icon_size } = attributes;
    const blockProps = useBlockProps.save({
      className: `bi ${icon_class} overflow-hidden`,
      style: {
        width: `${icon_size}px`,
        height: `${icon_size}px`,
      },
    });

    return (
      <div {...blockProps}>
        <i className={iconClass} style={{ fontSize: icon_size + "px" }}></i>
      </div>
    );
  },
});
