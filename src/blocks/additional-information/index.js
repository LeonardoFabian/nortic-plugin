import { registerBlockType } from "@wordpress/blocks";
import { useSelect } from "@wordpress/data";
import { useEntityProp } from "@wordpress/core-data";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import {
  PanelBody,
  TextareaControl,
  TextControl,
  ToggleControl,
  SelectControl,
  RangeControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const {
      title,
      use_default_title,
      farewell,
      enable_aos_animation,
      data_aos,
      data_aos_direction,
      data_aos_easing,
      data_aos_duration,
      data_aos_offset,
      data_aos_delay,
      data_aos_anchor,
      data_aos_anchor_placement,
    } = attributes;
    const blockProps = useBlockProps({
      className:
        "mb-4 rounded-lg bg-blue-100 px-6 py-5 text-base text-blue-700",
    });
    const postType = useSelect(
      (select) => select("core/editor").getCurrentPostType(),
      []
    );

    const [meta, setMeta] = useEntityProp("postType", postType, "meta");

    const additionalInfo = meta["additional_info"];

    const updateAdditionalInfo = (newValue) => {
      setMeta({ ...meta, additional_info: newValue });
    };

    const getAosDirectionOptions = () => {
      const options = [];

      if (data_aos === "fade") {
        options.push(
          { label: __("Up", "nortic-plugin"), value: "up" },
          { label: __("Down", "nortic-plugin"), value: "down" },
          { label: __("Right", "nortic-plugin"), value: "right" },
          { label: __("Left", "nortic-plugin"), value: "left" },
          { label: __("Up to right", "nortic-plugin"), value: "up-right" },
          { label: __("Up to left", "nortic-plugin"), value: "up-left" },
          { label: __("Down to right", "nortic-plugin"), value: "down-right" },
          { label: __("Down to left", "nortic-plugin"), value: "down-left" }
        );
      }

      if (data_aos === "flip") {
        options.push(
          { label: __("Up", "nortic-plugin"), value: "up" },
          { label: __("Down", "nortic-plugin"), value: "down" },
          { label: __("Right", "nortic-plugin"), value: "right" },
          { label: __("Left", "nortic-plugin"), value: "left" }
        );
      }

      if (data_aos === "zoom") {
        options.push(
          { label: __("In", "nortic-plugin"), value: "in" },
          { label: __("In to up", "nortic-plugin"), value: "in-up" },
          { label: __("In to down", "nortic-plugin"), value: "in-down" },
          { label: __("In to left", "nortic-plugin"), value: "in-left" },
          { label: __("In to right", "nortic-plugin"), value: "in-right" },

          { label: __("Out", "nortic-plugin"), value: "out" },
          { label: __("Out to up", "nortic-plugin"), value: "out-up" },
          { label: __("Out to down", "nortic-plugin"), value: "out-down" },
          { label: __("Out to left", "nortic-plugin"), value: "out-left" },
          { label: __("Out to right", "nortic-plugin"), value: "out-right" }
        );
      }

      return options;
    };

    const handleTitleChange = (value) => {
      setAttributes({ title: value });
    };

    if (additionalInfo === undefined) {
      return (
        <div
          className="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4"
          role="alert"
        >
          <p className="font-bold">{__("Warning", "nortic-plugin")}</p>
          <p>
            {__(
              "This post type does not have a meta additional_info field.",
              "nortic-plugin"
            )}
          </p>
        </div>
      );
    } else {
      return (
        <>
          <InspectorControls>
            <PanelBody title={__("Settings", "nortic-plugin")}>
              <ToggleControl
                label={__("Show default title", "nortic-plugin")}
                checked={use_default_title}
                onChange={(use_default_title) =>
                  setAttributes({ use_default_title })
                }
                help={
                  use_default_title
                    ? __("Showing title by default", "nortic-plugin")
                    : __("Add a custom title", "nortic-plugin")
                }
              />
              {!use_default_title && (
                <TextareaControl
                  label={__("Title", block.textdomain)}
                  value={title}
                  onChange={handleTitleChange}
                />
              )}
            </PanelBody>
            <PanelBody title={__("Animation", "nortic-plugin")}>
              <ToggleControl
                label={__("Enable AOS animation", "nortic-plugin")}
                checked={enable_aos_animation}
                onChange={(enable_aos_animation) =>
                  setAttributes({ enable_aos_animation })
                }
                help={
                  enable_aos_animation
                    ? __(
                        "Enable Animation On Scroll Library for this block.",
                        "nortic-plugin"
                      )
                    : __(
                        "Disable Animation On Scroll Library for this block.",
                        "nortic-plugin"
                      )
                }
              />
              {enable_aos_animation ? (
                <>
                  <SelectControl
                    label={__("AOS animation", "nortic-plugin")}
                    value={data_aos}
                    options={[
                      { label: __("Fade", "nortic-plugin"), value: "fade" },
                      { label: __("Flip", "nortic-plugin"), value: "flip" },
                      { label: __("Zoom", "nortic-plugin"), value: "zoom" },
                    ]}
                    onChange={(data_aos) => setAttributes({ data_aos })}
                    help={__(
                      "Default animation for AOS animations is fade",
                      "nortic-plugin"
                    )}
                  />
                  <SelectControl
                    label={__("Direction", "nortic-plugin")}
                    value={data_aos_direction}
                    options={getAosDirectionOptions()}
                    onChange={(data_aos_direction) =>
                      setAttributes({ data_aos_direction })
                    }
                    help={__(
                      "Default direction for AOS animations is up",
                      "nortic-plugin"
                    )}
                  />
                  <SelectControl
                    label={__("Easing", "nortic-plugin")}
                    value={data_aos_easing}
                    options={[
                      { label: __("Ease", "nortic-plugin"), value: "ease" },
                      { label: __("Linear", "nortic-plugin"), value: "linear" },
                      {
                        label: __("Ease in sine", "nortic-plugin"),
                        value: "ease-in-sine",
                      },
                      {
                        label: __("Ease in back", "nortic-plugin"),
                        value: "ease-in-back",
                      },
                      {
                        label: __("Ease out cubic", "nortic-plugin"),
                        value: "ease-out-cubic",
                      },
                    ]}
                    onChange={(data_aos_easing) =>
                      setAttributes({ data_aos_easing })
                    }
                    help={__(
                      "Default easing for AOS animations is ease",
                      "nortic-plugin"
                    )}
                  />
                  <RangeControl
                    label={__("Duration", "nortic-plugin")}
                    onChange={(data_aos_duration) =>
                      setAttributes({ data_aos_duration })
                    }
                    value={data_aos_duration}
                    min={0}
                    max={3000}
                    help={__(
                      "Values from 0 to 3000, with step 50ms, default 3000",
                      "nortic-plugin"
                    )}
                  />
                  <RangeControl
                    label={__("Offset", "nortic-plugin")}
                    onChange={(data_aos_offset) =>
                      setAttributes({ data_aos_offset })
                    }
                    value={data_aos_offset}
                    min={120}
                    max={300}
                    help={__(
                      "Offset (in px) from the original trigger point",
                      "nortic-plugin"
                    )}
                  />
                  <RangeControl
                    label={__("Delay", "nortic-plugin")}
                    onChange={(data_aos_delay) =>
                      setAttributes({ data_aos_delay })
                    }
                    value={data_aos_delay}
                    min={0}
                    max={3000}
                    help={__(
                      "Values from 0 to 3000, with step 50ms",
                      "nortic-plugin"
                    )}
                  />
                  <TextControl
                    label={__("Anchor (optional")}
                    value={data_aos_anchor}
                    onChange={(data_aos_anchor) =>
                      setAttributes({ data_aos_anchor })
                    }
                    help={__(
                      "ID of the html element related to the animation (optional)",
                      "nortic-plugin"
                    )}
                  />
                  {data_aos_anchor !== "" ? (
                    <SelectControl
                      label={__("Anchor placement", "nortic-plugin")}
                      value={data_aos_anchor_placement}
                      options={[
                        {
                          label: __("Top - Bottom", "nortic-plugin"),
                          value: "top-bottom",
                        },
                        {
                          label: __("Center - bottom", "nortic-plugin"),
                          value: "center-bottom",
                        },
                        {
                          label: __("Bottom - Bottom", "nortic-plugin"),
                          value: "bottom-bottom",
                        },
                        {
                          label: __("Top - Center", "nortic-plugin"),
                          value: "top-center",
                        },
                        {
                          label: __("Center - Center", "nortic-plugin"),
                          value: "center-center",
                        },
                      ]}
                      onChange={(data_aos_anchor_placement) =>
                        setAttributes({ data_aos_anchor_placement })
                      }
                      help={__(
                        "Defines which position of the element regarding to window should trigger the animation. Default top-bottom",
                        "nortic-plugin"
                      )}
                    />
                  ) : null}
                </>
              ) : null}
            </PanelBody>
          </InspectorControls>

          <div {...blockProps}>
            {use_default_title ? (
              <h5>{__("Additional information", "nortic-plugin")}</h5>
            ) : (
              <RichText
                tagName="h5"
                className="mb-2 text-2xl font-medium leading-tight"
                placeholder={__("Click to add a title", "nortic-plugin")}
                value={title}
                onChange={(title) => setAttributes({ title })}
                allowedFormats={[
                  "core/bold",
                  "core/italic",
                  "core/link",
                  "core/text-color",
                ]}
              />
            )}
            <TextareaControl
              label={__("Add additional information", "nortic-plugin")}
              value={additionalInfo}
              onChange={updateAdditionalInfo}
              help={__(
                "Add additional info for your post type.",
                "nortic-plugin"
              )}
            />
            <hr className="border-blue-600 opacity-30" />
            <RichText
              tagName="p"
              className="mb-0 mt-4"
              placeholder={__("Click to add a farewell", "nortic-plugin")}
              value={farewell}
              onChange={(farewell) => setAttributes({ farewell })}
              allowedFormats={[
                "core/bold",
                "core/italic",
                "core/link",
                "core/text-color",
              ]}
            />
          </div>
        </>
      );
    }
  },
});
