import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  SelectControl,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { postType, heading, subHeading, renderType, showHeader } =
      attributes;
    const blockProps = useBlockProps();

    const systems = useSelect((select) => {
      return select("core").getEntityRecords("postType", "system", {
        per_page: -1,
        _embed: true,
        orderByName: 1,
        order: "asc",
      });
    }, []);

    console.log("Systems: ", systems);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <SelectControl
              label={__("Render type", block.textdomain)}
              value={renderType}
              options={[
                { label: __("None", block.textdomain), value: "none" },
                { label: __("Carousel", block.textdomain), value: "carousel" },
                { label: __("Slider", block.textdomain), value: "slider" },
              ]}
              onChange={(renderType) => setAttributes({ renderType })}
              help={
                renderType === "carousel" || renderType === "slider"
                  ? __(
                      "Type of the movement. Visit https://glidejs.com/ for more.",
                      block.textdomain
                    )
                  : null
              }
            />
          </PanelBody>
          <PanelBody title={__("Information", block.textdomain)}>
            <TextControl
              label={__("Heading", block.textdomain)}
              value={heading}
              onChange={(heading) => setAttributes({ heading })}
            />
            <TextareaControl
              label={__("Subheading", block.textdomain)}
              value={subHeading}
              onChange={(subHeading) => setAttributes({ subHeading })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="system-list-wrapper">
            {systems?.map((system) => {
              console.log("System: ", system);

              return (
                <div className="system-list-item">
                  <a href="#" onClick={(e) => e.preventDefault()}>
                    <div className="system-list-item__icon">
                      <RawHTML>{system?.meta?.icon}</RawHTML>
                    </div>
                  </a>
                  <div className="system-list-item__meta">
                    <h3>
                      <a href="#" onClick={(e) => e.preventDefault()}>
                        {system?.meta?.alias}
                      </a>
                    </h3>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </>
    );
  },
});
