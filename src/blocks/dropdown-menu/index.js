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
      show_on_desktop,
      desktop_menu_icon, // menu-grid-r, menu-outline
      desktop_menu_icon_url,
      show_on_mobile,
      mobile_menu_icon,
      mobile_menu_icon_url,
      close_menu_icon,
      menu_position,
      desktop_columns,
      mobile_columns,
    } = attributes;
    const blockProps = useBlockProps({
      className: `relative ${
        show_on_mobile
          ? "show-on-mobile sm:inline-flex"
          : "hidden sm:hidden hide-on-mobile"
      } ${
        show_on_desktop
          ? "show-on-desktop md:inline-flex"
          : "md:hidden hide-on-desktop"
      } inline-block`,
    });

    useEffect(() => {
      setAttributes({
        desktop_menu_icon_url: `/wp-content/plugins/nortic-plugin/dist/public/images/icons/${desktop_menu_icon}.svg`,
      });
    }, [desktop_menu_icon]);

    useEffect(() => {
      setAttributes({
        mobile_menu_icon_url: `/wp-content/plugins/nortic-plugin/dist/public/images/icons/${mobile_menu_icon}.svg`,
      });
    }, [mobile_menu_icon]);

    const handleMenuPosition = (position) => {
      setAttributes({ menu_position: position });
    };

    const handleDesktopMenuIcon = (desktop_icon) => {
      setAttributes({ desktop_menu_icon: desktop_icon });
    };

    const handleMobileMenuIcon = (mobile_icon) => {
      setAttributes({ mobile_menu_icon: mobile_icon });
    };

    const handleMobileCloseMenuIcon = (close_icon) => {
      setAttributes({ close_menu_icon: close_icon });
    };

    const dropdownMenuClasses = `${menu_position} dropdown-menu overflow-hidden right-0 z-50 origin-top-right mt-2 rounded-lg shadow-lg block`;

    return (
      <>
        <InspectorControls>
          <PanelColorSettings
            title={_x("Colors", "PanelColorSettings label", block.textdomain)}
            colorSettings={[
              {
                label: __("Text Color", block.textdomain),
                value: color,
                onChange: (color) => setAttributes({ color }),
              },
              {
                label: __("Background Color", block.textdomain),
                value: background_color,
                onChange: (background_color) =>
                  setAttributes({ background_color }),
              },
            ]}
          />
          <PanelBody title={__("Settings", block.textdomain)}>
            <SelectControl
              label={_x(
                "Menu position",
                "SelectControl label",
                block.textdomain
              )}
              value={menu_position}
              options={[
                {
                  label: _x(
                    "Absolute",
                    "SelectControl label",
                    block.textdomain
                  ),
                  value: "absolute",
                },
                {
                  label: _x(
                    "Relative",
                    "SelectControl label",
                    block.textdomain
                  ),
                  value: "relative",
                },
              ]}
              onChange={handleMenuPosition}
            />

            <RangeControl
              label={__("Desktop Columns", block.textdomain)}
              onChange={(desktop_columns) => setAttributes({ desktop_columns })}
              value={desktop_columns}
              min={1}
              max={3}
            />

            <RangeControl
              label={__("Mobile Columns", block.textdomain)}
              onChange={(mobile_columns) => setAttributes({ mobile_columns })}
              value={mobile_columns}
              min={1}
              max={3}
            />

            <ToggleControl
              label={_x(
                "Show on desktop",
                "ToggleControl label",
                block.textdomain
              )}
              checked={show_on_desktop}
              onChange={(show_on_desktop) => setAttributes({ show_on_desktop })}
              help={
                show_on_desktop
                  ? __("Desktop shown", block.textdomain)
                  : __("Hide menu", block.textdomain)
              }
            />

            <SelectControl
              label={_x(
                "Desktop menu icon",
                "SelectControl label",
                block.textdomain
              )}
              value={desktop_menu_icon}
              options={[
                {
                  label: _x("Grid", "SelectControl label", block.textdomain),
                  value: "dropdown-menu-grid",
                },
                {
                  label: _x("Bars", "SelectControl label", block.textdomain),
                  value: "dropdown-menu-hamburger",
                },
              ]}
              onChange={handleDesktopMenuIcon}
            />
            {desktop_menu_icon ? (
              <HStack
                alignment="center"
                style={{
                  backgroundColor: "#f1f1f1",
                  padding: ".5rem",
                  marginBottom: "1rem",
                }}
              >
                <img
                  src={`/wp-content/plugins/nortic-plugin/dist/public/images/icons/${desktop_menu_icon}.svg`}
                  style={{ width: "32px" }}
                />
              </HStack>
            ) : null}

            <ToggleControl
              label={_x(
                "Show on mobile",
                "ToggleControl label",
                block.textdomain
              )}
              checked={show_on_mobile}
              onChange={(show_on_mobile) => setAttributes({ show_on_mobile })}
              help={
                show_on_mobile
                  ? __("Mobile shown", block.textdomain)
                  : __("Hide menu", block.textdomain)
              }
            />

            <SelectControl
              label={_x(
                "Mobile menu icon",
                "SelectControl label",
                block.textdomain
              )}
              value={mobile_menu_icon}
              options={[
                {
                  label: _x("Grid", "SelectControl label", block.textdomain),
                  value: "dropdown-menu-grid",
                },
                {
                  label: _x("Bars", "SelectControl label", block.textdomain),
                  value: "dropdown-menu-hamburger",
                },
              ]}
              onChange={handleMobileMenuIcon}
            />
            {mobile_menu_icon ? (
              <HStack
                alignment="center"
                style={{
                  backgroundColor: "#f1f1f1",
                  padding: ".5rem",
                  marginBottom: "1rem",
                }}
              >
                <img
                  src={`/wp-content/plugins/nortic-plugin/dist/public/images/icons/${mobile_menu_icon}.svg`}
                  style={{ width: "32px" }}
                />
              </HStack>
            ) : null}
            <SelectControl
              label={_x(
                "Mobile close menu icon",
                "SelectControl label",
                block.textdomain
              )}
              value={close_menu_icon}
              options={[
                {
                  label: _x(
                    "X Circle",
                    "SelectControl label",
                    block.textdomain
                  ),
                  value: "dropdown-menu-close-circle",
                },
                {
                  label: _x("X", "SelectControl label", block.textdomain),
                  value: "dropdown-menu-close",
                },
              ]}
              onChange={handleMobileCloseMenuIcon}
            />
            {close_menu_icon ? (
              <HStack
                alignment="center"
                style={{
                  backgroundColor: "#f1f1f1",
                  padding: ".5rem",
                  marginBottom: "1rem",
                }}
              >
                <img
                  src={`/wp-content/plugins/nortic-plugin/dist/public/images/icons/${close_menu_icon}.svg`}
                  style={{ width: "32px" }}
                />
              </HStack>
            ) : null}
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <button
            className="dropdown-menu-toggle flex items-center justify-center text-sm font-medium text-center text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            type="button"
            style={{ width: "40px", height: "40px" }}
          >
            <div className="hide-on-mobile hidden md:inline-flex items-center">
              <img src={desktop_menu_icon_url} className="w-full" />
            </div>
            <div className="hide-on-desktop inline-flex md:hidden items-center">
              <img src={mobile_menu_icon_url} className="w-full" />
            </div>
          </button>
          {/* Dropdown menu */}
          <div
            className={dropdownMenuClasses}
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="dropdown-menu-toggle"
            tabindex="-1"
            style={{ backgroundColor: background_color }}
          >
            <div className="dropdown-menu-title px-4 py-2 font-medium flex items-center justify-between rounded-t-lg border-b">
              <RichText
                tagName="span"
                placeholder={_x(
                  "Click to add a title",
                  "RichText label",
                  block.textdomain
                )}
                value={title}
                onChange={(title) => setAttributes({ title })}
                style={{ color: color }}
              />
            </div>
            <div
              className={`dropdown-menu-content overflow-hidden px-4 justify-items-center content-start divide-y`}
            >
              <InnerBlocks orientation="vertical" />
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      color,
      background_color,
      show_on_desktop,
      desktop_menu_icon,
      desktop_menu_icon_url,
      show_on_mobile,
      mobile_menu_icon,
      mobile_menu_icon_url,
      close_menu_icon,
      menu_position,
      desktop_columns,
      mobile_columns,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: `relative ${
        show_on_mobile
          ? "show-on-mobile sm:inline-flex"
          : "hidden sm:hidden hide-on-mobile"
      } ${
        show_on_desktop
          ? "show-on-desktop md:inline-flex"
          : "md:hidden hide-on-desktop"
      } inline-block`,
    });

    const dropdownMenuClasses = `${menu_position} dropdown-menu overflow-hidden right-0 z-50 origin-top-right mt-2 rounded-lg shadow-lg block`;

    return (
      <div {...blockProps}>
        <button
          className="dropdown-menu-toggle flex items-center justify-center text-sm font-medium text-center text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          type="button"
          style={{ width: "40px", height: "40px" }}
        >
          <div className="hide-on-mobile hidden md:inline-flex items-center">
            <img src={desktop_menu_icon_url} className="w-full" />
          </div>
          <div className="hide-on-desktop inline-flex md:hidden items-center">
            <img src={mobile_menu_icon_url} className="w-full" />
          </div>
        </button>
        {/* Dropdown menu */}
        <div
          className={dropdownMenuClasses}
          role="menu"
          aria-orientation="vertical"
          aria-labelledby="dropdown-menu-toggle"
          tabindex="-1"
          style={{ backgroundColor: background_color, maxHeight: "0" }}
        >
          {title && (
            <div className="dropdown-menu-title px-4 py-2 font-medium flex items-center justify-between rounded-t-lg border-b">
              <RichText.Content
                tagName="span"
                value={title}
                style={{ color: color }}
              />
            </div>
          )}

          <div
            className={`dropdown-menu-content px-4 overflow-hidden grid grid-cols-${mobile_columns} md:grid-cols-${desktop_columns} justify-items-center content-start divide-y`}
          >
            <InnerBlocks.Content />
          </div>
        </div>
      </div>
    );
  },
});
