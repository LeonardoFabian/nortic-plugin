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
      className: "glide-slideshow relative",
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
            <ul className="glide__slides" style={{ display: "flex", flexDirection: "row"}}>
              <InnerBlocks
                allowedBlocks={["nortic-plugin/slide", "nortic-plugin/banner"]}
              />
            </ul>

            {/* Slider controls  */}
          </div>

          {/* Slider indicators  */}
          <div className="glide__bullets" data-glide-el="controls[nav]">
            <button
              type="button"
              className="glide__bullet w-4 h-4 rounded-full"
              aria-current="true"
              aria-label="Slide 1"
              data-glide-dir="0"
            ></button>
            <button
              type="button"
              className="glide__bullet w-4 h-4 rounded-full"
              // aria-current="false"
              aria-label="Slide 2"
              data-glide-dir="1"
            ></button>
            <button
              type="button"
              className="glide__bullet w-4 h-4 rounded-full"
              // aria-current="false"
              aria-label="Slide 3"
              data-glide-dir="2"
            ></button>
            <button
              type="button"
              className="glide__bullet w-4 h-4 rounded-full"
              // aria-current="false"
              aria-label="Slide 4"
              data-glide-dir="3"
            ></button>
            <button
              type="button"
              className="glide__bullet w-4 h-4 rounded-full"
              // aria-current="false"
              aria-label="Slide 5"
              data-glide-dir="4"
            ></button>
          </div>

          {/* Slider controls  */}
          <div className="glide__arrows" data-glide-el="controls[nav]">
            <button
              type="button"
              className="glide__arrow glide__arrow--prev"
              data-glide-dir="<"
            >
              <i class="bi bi-chevron-left"></i>
            </button>
            <button
              type="button"
              className="glide__arrow glide__arrow--next"
              data-glide-dir=">"
            >
              <i class="bi bi-chevron-right"></i>
            </button>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { align, bgColor } = attributes;
    const blockProps = useBlockProps.save({
      className: "glide-slideshow relative",
      style: {
        "background-color": bgColor,
      },
    });

    return (
      <div {...blockProps}>
        {/* Slideshow wrapper */}
        <div className="glide__track" data-glide-el="track">
          <ul className="glide__slides" style={{ display: "flex", flexDirection: "row"}}>
            <InnerBlocks.Content />
          </ul>
        </div>

        {/* Slider indicators  */}
        <div className="glide__bullets" data-glide-el="controls[nav]">
          <button
            type="button"
            className="glide__bullet w-4 h-4 rounded-full"
            //   aria-current="true"
            aria-label="Slide 1"
            data-glide-dir="=0"
          ></button>
          <button
            type="button"
            className="glide__bullet w-4 h-4 rounded-full"
            //   aria-current="false"
            aria-label="Slide 2"
            data-glide-dir="=1"
          ></button>
          <button
            type="button"
            className="glide__bullet w-4 h-4 rounded-full"
            //   aria-current="false"
            aria-label="Slide 3"
            data-glide-dir="=2"
          ></button>
          <button
            type="button"
            className="glide__bullet w-4 h-4 rounded-full"
            //   aria-current="false"
            aria-label="Slide 4"
            data-glide-dir="=3"
          ></button>
          <button
            type="button"
            className="glide__bullet w-4 h-4 rounded-full"
            //   aria-current="false"
            aria-label="Slide 5"
            data-glide-dir="=4"
          ></button>
        </div>

        {/* Slider controls  */}
        <div className="glide__arrows" data-glide-el="controls[nav]">
          <button
            type="button"
            className="glide__arrow glide__arrow--prev"
            data-glide-dir="<"
          >
            <i class="bi bi-chevron-left"></i>
          </button>
          <button
            type="button"
            className="glide__arrow glide__arrow--next"
            data-glide-dir=">"
          >
            <i class="bi bi-chevron-right"></i>
          </button>
        </div>
      </div>
    );
  },
});
