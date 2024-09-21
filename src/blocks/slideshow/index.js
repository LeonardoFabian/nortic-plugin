import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InnerBlocks,
  InspectorControls,
  PanelColorSettings,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls } from "@wordpress/components";
import { dateI18n } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";
import "@glidejs/glide";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { align, bgColor } = attributes;
    const blockProps = useBlockProps({
      className: "glide-slideshow relative w-full py-10 overflow-hidden",
      style: {
        "background-color": bgColor,
      },
    });

    return (
      <>
        <InspectorControls>
          <PanelColorSettings
            title={__("Colors", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Background Color", "nortic-plugin"),
                value: bgColor,
                onChange: (bgColor) => setAttributes({ bgColor }),
              },
            ]}
          />
        </InspectorControls>
        <div {...blockProps}>
          <div className="glide__track" data-glide-el="track">
            {/* Slideshow wrapper */}
            <ul className="glide__slides">
              <InnerBlocks
                allowedBlocks={["nortic-plugin/slide", "nortic-plugin/banner"]}
              />
            </ul>

            {/* Slider indicators  */}
            <div className="glide__bullets slide-indicators absolute bottom-4 w-full z-30 flex items-center justify-center mx-auto space-x-3">
              <button
                type="button"
                className="w-3 h-3 rounded-full"
                aria-current="true"
                aria-label="Slide 1"
                data-glide-dir="0"
              ></button>
              <button
                type="button"
                className="w-3 h-3 rounded-full"
                // aria-current="false"
                aria-label="Slide 2"
                data-glide-dir="1"
              ></button>
              <button
                type="button"
                className="w-3 h-3 rounded-full"
                // aria-current="false"
                aria-label="Slide 3"
                data-glide-dir="2"
              ></button>
              <button
                type="button"
                className="w-3 h-3 rounded-full"
                // aria-current="false"
                aria-label="Slide 4"
                data-glide-dir="3"
              ></button>
              <button
                type="button"
                className="w-3 h-3 rounded-full"
                // aria-current="false"
                aria-label="Slide 5"
                data-glide-dir="4"
              ></button>
            </div>

            {/* Slider controls  */}
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { align, bgColor } = attributes;
    const blockProps = useBlockProps.save({
      className: "glide-slideshow relative w-full py-10 overflow-hidden",
      style: {
        "background-color": bgColor,
      },
    });

    return (
      <div {...blockProps}>
        {/* Slideshow wrapper */}
        <div className="glide__track" data-glide-el="track">
          <ul className="glide__slides flex">
            <InnerBlocks.Content />
          </ul>

          {/* Slider indicators  */}
          <div
            className="glide__bullets slide-indicators absolute bottom-4 w-full z-30 flex items-center justify-center mx-auto space-x-3"
            data-glide-el="controls[nav]"
          >
            <button
              type="button"
              className="glide__bullet w-3 h-3 rounded-full"
              //   aria-current="true"
              aria-label="Slide 1"
              data-glide-dir="=0"
            ></button>
            <button
              type="button"
              className="glide__bullet w-3 h-3 rounded-full"
              //   aria-current="false"
              aria-label="Slide 2"
              data-glide-dir="=1"
            ></button>
            <button
              type="button"
              className="glide__bullet w-3 h-3 rounded-full"
              //   aria-current="false"
              aria-label="Slide 3"
              data-glide-dir="=2"
            ></button>
            <button
              type="button"
              className="glide__bullet w-3 h-3 rounded-full"
              //   aria-current="false"
              aria-label="Slide 4"
              data-glide-dir="=3"
            ></button>
            <button
              type="button"
              className="glide__bullet w-3 h-3 rounded-full"
              //   aria-current="false"
              aria-label="Slide 5"
              data-glide-dir="=4"
            ></button>
          </div>

          {/* Slider controls  */}
          <div data-glide-el="controls">
            <button
              type="button"
              className="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
              data-glide-dir="<"
            >
              <span className="slide-control inline-flex items-center justify-center w-8 h-8 rounded-full">
                <i class="bi bi-arrow-left text-md"></i>
                <span className="sr-only">
                  {__("Previous", "nortic-plugin")}
                </span>
              </span>
            </button>
            <button
              type="button"
              className="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
              data-glide-dir=">"
            >
              <span className="slide-control inline-flex items-center justify-center w-8 h-8 rounded-full">
                <i class="bi bi-arrow-right text-md"></i>
                <span className="sr-only">{__("Next", "nortic-plugin")}</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    );
  },
});
