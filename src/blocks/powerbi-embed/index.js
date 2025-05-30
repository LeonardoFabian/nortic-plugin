import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { embedUrl } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Power BI Embed URL")}>
            <TextControl
              value={embedUrl}
              onChange={(url) => setAttributes({ embedUrl: url })}
              placeholder="https://app.powerbi.com/view?r=..."
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <p>
            {__(
              "Enter the Power BI URL in the settings panel.",
              block.textdomain
            )}
          </p>
          {embedUrl && (
            <iframe
              title="Power BI Report"
              src={embedUrl}
              width="100%"
              height="600"
              frameBorder="0"
              allowFullScreen
            />
          )}
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { embedUrl } = attributes;
    const blockProps = useBlockProps.save();

    return embedUrl ? (
      <div {...blockProps}>
        <iframe
          title="Power BI Report"
          src={embedUrl}
          width="100%"
          height="600"
          frameBorder="0"
          allowFullScreen
        />
      </div>
    ) : null;
  },
});
