import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, ToggleControl, SelectControl } from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const {
      justify_content,
      show_export_option,
      show_print_option,
      show_send_option,
    } = attributes;
    const { postId } = context;
    const blockProps = useBlockProps({
      className: "shadow-sm",
    });

    const handleContentAlignment = (newAlignment) => {
      setAttributes({ justify_content: newAlignment });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <SelectControl
              label={_x(
                "Justify Content",
                "SelectControl label",
                "nortic-plugin"
              )}
              value={justify_content}
              options={[
                {
                  label: _x("Normal", "SelectControl label", "nortic-plugin"),
                  value: "normal",
                },
                {
                  label: _x("Start", "SelectControl label", "nortic-plugin"),
                  value: "flex-start",
                },
                {
                  label: _x("End", "SelectControl label", "nortic-plugin"),
                  value: "flex-end",
                },
                {
                  label: _x("Center", "SelectControl label", "nortic-plugin"),
                  value: "center",
                },
                {
                  label: _x("Between", "SelectControl label", "nortic-plugin"),
                  value: "space-between",
                },
                {
                  label: _x("Around", "SelectControl label", "nortic-plugin"),
                  value: "space-around",
                },
                {
                  label: _x("Evenly", "SelectControl label", "nortic-plugin"),
                  value: "space-evenly",
                },
                {
                  label: _x("Stretch", "SelectControl label", "nortic-plugin"),
                  value: "stretch",
                },
              ]}
              onChange={handleContentAlignment}
            />
            <ToggleControl
              label={_x(
                "Show print option",
                "ToggleControl label",
                block.textdomain
              )}
              checked={show_print_option}
              onChange={(show_print_option) =>
                setAttributes({ show_print_option })
              }
              help={
                show_print_option
                  ? __("Print option shown", "nortic-plugin")
                  : __("Hidden print option", "nortic-plugin")
              }
            />
            <ToggleControl
              label={_x(
                "Show export option",
                "ToggleControl label",
                "nortic-plugin"
              )}
              checked={show_export_option}
              onChange={(show_export_option) =>
                setAttributes({ show_export_option })
              }
              help={
                show_export_option
                  ? __("Export option shown", "nortic-plugin")
                  : __("Hidden export option", "nortic-plugin")
              }
            />
            <ToggleControl
              label={_x(
                "Show send option",
                "ToggleControl label",
                "nortic-plugin"
              )}
              checked={show_send_option}
              onChange={(show_send_option) =>
                setAttributes({ show_send_option })
              }
              help={
                show_send_option
                  ? __("Send option shown", "nortic-plugin")
                  : __("Hidden send option", "nortic-plugin")
              }
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div
            className="page-options-wrapper w-full flex flex-wrap items-center text-md"
            style={{ justifyContent: justify_content }}
          >
            {/* print */}
            <button
              type="button"
              className="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                className="bi bi-printer"
                viewBox="0 0 16 16"
              >
                {" "}
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />{" "}
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />{" "}
              </svg>
              <span className="sr-only">
                {_x("Print", "SelectControl label", "nortic-plugin")}
              </span>
            </button>
            {/* END print */}
            {/* export */}
            <button
              type="button"
              className="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                className="bi bi-box-arrow-up-right"
                viewBox="0 0 16 16"
              >
                {" "}
                <path
                  fill-rule="evenodd"
                  d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"
                />{" "}
                <path
                  fill-rule="evenodd"
                  d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"
                />{" "}
              </svg>
              <span className="sr-only">
                {_x("Export", "SelectControl label", "nortic-plugin")}
              </span>
            </button>
            {/* END export */}
            {/* send */}
            <button
              type="button"
              className="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                className="bi bi-send"
                viewBox="0 0 16 16"
              >
                {" "}
                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />{" "}
              </svg>
              <span className="sr-only">
                {_x("Send", "SelectControl label", "nortic-plugin")}
              </span>
            </button>
            {/* END send */}
          </div>
        </div>
      </>
    );
  },
});
