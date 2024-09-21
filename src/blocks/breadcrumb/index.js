import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl } from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { showSectionName } = attributes;
    const blockProps = useBlockProps({
      className: "shadow-sm",
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <ToggleControl
              label={__("Show Section Name", "nortic-plugin")}
              checked={showSectionName}
              onChange={(showSectionName) => setAttributes({ showSectionName })}
              help={
                showSectionName
                  ? _x(
                      "Section Name shown",
                      "Breadcrumb label",
                      "nortic-plugin"
                    )
                  : _x(
                      "Section Name hidden",
                      "Breadcrumb label",
                      "nortic-plugin"
                    )
              }
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="container mx-auto py-4">
            <div className="w-full flex flex-wrap items-center justify-between text-sm">
              {showSectionName && (
                <h6 className="text-sm color-blue font-medium">
                  {_x("Section name")}
                </h6>
              )}
              <div className="flex items-center gap-2">
                <span className="font-medium color-black">
                  {_x("Is here", "Breadcrumb preview label", "nortic-plugin")}
                  {": "}
                </span>
                {_x("Home", "Breadcrumb preview label", "nortic-plugin")}
                <span>{" / "}</span>
                {_x("Stage 1", "Breadcrumb preview label", "nortic-plugin")}
                <span>{" / "}</span>
                {_x("Stage 2", "Breadcrumb preview label", "nortic-plugin")}
                <span>{" / "}</span>
                <span>
                  {_x("Stage 3", "Breadcrumb preview label", "nortic-plugin")}
                </span>
                <span>{" / "}</span>
                <span className="color-blue font-medium">
                  {_x("Stage 4", "Breadcrumb preview label", "nortic-plugin")}
                </span>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
});
