import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
} from "@wordpress/components";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
        <form className="w-full max-w-lg">
          <div className="flex flex-wrap mb-6">
            <div className="w-full mb-6">
              <label
                className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="name"
              >
                {_x("Name", "Contact form label", "nortic-plugin")}
              </label>
              <TextControl placeholder={__("Name", "nortic-plugin")} readOnly />
            </div>

            <div className="w-full mb-6">
              <label
                className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="subject"
              >
                {_x("Subject", "Contact form label", "nortic-plugin")}
              </label>
              <TextControl
                placeholder={__("Subject", "nortic-plugin")}
                readOnly
              />
            </div>

            <div className="w-full mb-6">
              <label
                className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="email"
              >
                {_x("Email", "Contact form label", "nortic-plugin")}
              </label>
              <TextControl
                placeholder={__("Email", "nortic-plugin")}
                readOnly
              />
            </div>

            <div className="w-full mb-6">
              <label
                className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                for="message"
              >
                {_x("Message", "Contact form label", "nortic-plugin")}
              </label>
              <TextareaControl rows={3} readOnly />
            </div>
          </div>
        </form>
      </div>
    );
  },
});
