import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
  RichText,
  PanelColorSettings,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
  SelectControl,
  RangeControl,
  ToggleControl,
  __experimentalHStack as HStack,
} from "@wordpress/components";
import { useEffect } from "@wordpress/element";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      title,
      color,
      background_color,
      menu_icon, // menu-grid-r, menu-outline
      menu_icon_url,
      menu_position,
      transition_direction,
      visibility,
      display,
      columns,
    } = attributes;
    const blockProps = useBlockProps({
      className: `relative w-full ${visibility}`,
      style: {
        backgroundColor: background_color,
      },
    });

    useEffect(() => {
      setAttributes({
        menu_icon_url: `https://mt.gob.do/images/svg/icons/${menu_icon}.svg`,
      });
    }, [menu_icon]);

    const handleMenuPosition = (position) => {
      setAttributes({ menu_position: position });
    };

    const handleVisibility = (new_visibility) => {
      setAttributes({ visibility: new_visibility });
    };

    const handleDisplay = (new_display) => {
      setAttributes({ display: new_display });
    };

    const handleNumberOfColumns = (new_value) => {
      setAttributes({ columns: new_value });
    };

    const handleMenuIcon = (icon) => {
      setAttributes({ menu_icon: icon });
    };

    // const dropdownMenuClasses = `${menu_position} dropdown-menu overflow-hidden right-0 z-50 origin-top-right mt-2 rounded-lg shadow-lg block`;

    return (
      <>
        <InspectorControls>
          <PanelColorSettings
            title={_x("Colors", "PanelColorSettings label", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Text Color", "nortic-plugin"),
                value: color,
                onChange: (color) => setAttributes({ color }),
              },
              {
                label: __("Background Color", "nortic-plugin"),
                value: background_color,
                onChange: (background_color) =>
                  setAttributes({ background_color }),
              },
            ]}
          />
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <SelectControl
              label={_x(
                "Menu position",
                "SelectControl label",
                "nortic-plugin"
              )}
              value={menu_position}
              options={[
                {
                  label: _x("Absolute", "SelectControl label", "nortic-plugin"),
                  value: "absolute",
                },
                {
                  label: _x("Relative", "SelectControl label", "nortic-plugin"),
                  value: "relative",
                },
              ]}
              onChange={handleMenuPosition}
            />
            {/* Menu visibility settings */}
            <SelectControl
              label={_x("Visibility", "SelectControl label", "nortic-plugin")}
              value={visibility}
              options={[
                { label: __("Desktop and Mobile"), value: "block" },
                { label: __("Desktop only"), value: "hidden lg:block" },
                { label: __("Mobile only"), value: "block lg:hidden" },
                { label: __("None"), value: "hidden" },
              ]}
              onChange={handleVisibility}
            />

            {/* Content display settings */}
            <SelectControl
              label={_x("Display", "SelectControl label", "nortic-plugin")}
              value={display}
              options={[
                { label: __("Inline"), value: "inline" },
                { label: __("Block"), value: "block" },
                { label: __("Grid"), value: "grid" },
                { label: __("List"), value: "list-item" },
                { label: __("None"), value: "hidden" },
              ]}
              onChange={handleDisplay}
            />

            {/* Grid columns */}
            {display === "grid" && (
              <RangeControl
                label={__("Columns", "nortic-plugin")}
                onChange={handleNumberOfColumns}
                value={columns}
                min={2}
                max={4}
              />
            )}

            <SelectControl
              label={_x("Menu icon", "SelectControl label", "nortic-plugin")}
              value={menu_icon}
              options={[
                {
                  label: _x("Grid", "SelectControl label", "nortic-plugin"),
                  value: "menu-grid-r",
                },
                {
                  label: _x("Bars", "SelectControl label", "nortic-plugin"),
                  value: "menu-outline",
                },
              ]}
              onChange={handleMenuIcon}
            />
            {menu_icon ? (
              <HStack
                alignment="center"
                style={{
                  backgroundColor: "#f1f1f1",
                  padding: ".5rem",
                  marginBottom: "1rem",
                }}
              >
                <img
                  src={`https://mt.gob.do/images/svg/icons/${menu_icon}.svg`}
                  style={{ width: "32px" }}
                />
              </HStack>
            ) : null}
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <>
            <div className="menu-toggle">
              <div className="menu-toggle-header py-4 cursor-pointer">
                <button className="menu-toggle-button flex items-center">
                  <div className="inline-flex items-center">
                    <img src={menu_icon_url} className="w-4" />
                  </div>

                  <div className="px-2 font-medium flex items-center">
                    <RichText
                      tagName="span"
                      placeholder={_x(
                        "Click to add a title",
                        "RichText label",
                        "nortic-plugin"
                      )}
                      value={title}
                      onChange={(title) => setAttributes({ title })}
                      style={{ color: color }}
                    />
                  </div>
                  <span className="bg-transparent rounded-full">
                    <i className="accordion-icon faq-icon bi bi-plus-lg color-blue text-xl font-semibold"></i>
                  </span>
                </button>
              </div>
              <div
                className={`menu-toggle-content accordion-body overflow-hidden ${display} ${
                  display === "grid" ? "grid-cols-" + columns : ""
                } justify-items-center content-start transition-all duration-200 ease-out divide-y`}
              >
                <InnerBlocks orientation="vertical" />
              </div>
            </div>
          </>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      color,
      background_color,
      menu_icon, // menu-grid-r, menu-outline
      menu_icon_url,
      menu_position,
      transition_direction,
      visibility,
      display,
      columns,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: `relative w-full ${visibility}`,
      style: {
        backgroundColor: background_color,
      },
    });

    return (
      <div {...blockProps}>
        <>
          <div className="menu-toggle">
            <div className="menu-toggle-header py-4 cursor-pointer">
              <button className={`menu-toggle-button flex items-center`}>
                <div className="inline-flex items-center">
                  <img src={menu_icon_url} className="w-4" />
                </div>

                <div className="px-2 font-medium flex items-center">
                  <RichText.Content
                    tagName="span"
                    value={title}
                    style={{ color: color }}
                  />
                </div>
                <span className="bg-transparent rounded-full">
                  <i className="accordion-icon faq-icon bi bi-plus-lg color-blue text-xl font-semibold"></i>
                </span>
              </button>
            </div>
            <div
              className={`menu-toggle-content accordion-body overflow-hidden ${display} ${
                display === "grid" ? "grid-cols-" + columns : ""
              } justify-items-center content-start transition-all duration-200 ease-out divide-y`}
            >
              <InnerBlocks.Content />
            </div>
          </div>
        </>
      </div>
    );
  },
});
