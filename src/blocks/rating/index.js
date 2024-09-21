import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { Rating } from "@mui/material";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { rating_mode, cookie_time, default_rating } = attributes;
    const { postId } = context;
    // console.log("POST ID: ", postId);
    const blockProps = useBlockProps();

    const { rating } = useSelect((select) => {
      const { getCurrentPostAttribute } = select("core/editor");

      return {
        rating: getCurrentPostAttribute("meta")?.rating,
      };
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Rating settings", "nortic-plugin")}>
            <SelectControl
              label={__("Rating mode", "nortic-plugin")}
              value={rating_mode}
              options={[
                { label: __("Cookie", "nortic-plugin"), value: "cookie" },
                { label: __("Username", "nortic-plugin"), value: "username" },
              ]}
              onChange={(rating_mode) => setAttributes({ rating_mode })}
            />
            <SelectControl
              label={__("Cookie expires time", "nortic-plugin")}
              value={cookie_time}
              options={[
                { label: __("1 day", "nortic-plugin"), value: "86400" },
                { label: __("1 hour", "nortic-plugin"), value: "3600" },
                { label: __("30 min", "nortic-plugin"), value: "1800" },
                { label: __("15 min", "nortic-plugin"), value: "900" },
                { label: __("5 min", "nortic-plugin"), value: "300" },
              ]}
              onChange={(newVal) => setAttributes({ cookie_time: newVal })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {rating ? (
            <Rating value={rating} readOnly />
          ) : (
            <div className="has-shadow p-8">
              <ul className="editor-rating-preview flex items-center gap-4  justify-center">
                <li>
                  <i className="bi bi-star-fill"></i>
                </li>
                <li>
                  <i className="bi bi-star-fill"></i>
                </li>
                <li>
                  <i className="bi bi-star-fill"></i>
                </li>
                <li>
                  <i className="bi bi-star-half"></i>
                </li>
                <li>
                  <i className="bi bi-star"></i>
                </li>
              </ul>
              <div className="mx-auto text-center mt-2">
                {__("Rating preview", "nortic-plugin")}
              </div>
            </div>
          )}
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { rating_mode, cookie_time, default_rating } = attributes;
  },
});
