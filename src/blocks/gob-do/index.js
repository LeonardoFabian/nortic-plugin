import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, SelectControl, TextControl } from "@wordpress/components";
import { useState, useEffect } from "@wordpress/element";
import { useSelect } from "@wordpress/data";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
        <div className="container mx-auto text-white">
          <div className="h-8 flex items-center justify-start gap-2 flex-nowrap">
            <img
              src="/wp-content/plugins/nortic-plugin/dist/public/images/dominican-flag.svg"
              className="w-6"
            />
            <span className="text-xs">
              Esta es una web oficial del Gobierno de la República Dominicana
            </span>
            <button
              id="gob-do-button"
              className="flex items-center gap-2 text-blue-400 text-xs"
            >
              Así es como puedes saberlo
              <i className="bi bi-chevron-down ml-2"></i>
            </button>
          </div>
          {/* trigger */}
          <div id="gob-do-dropdown" className="flex items-center gap-8 py-4">
            <div className="w-1/2 flex items-center gap-4">
              {/* gob.do */}
              <div className="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                <img
                  src="/wp-content/plugins/nortic-plugin/dist/public/images/cupula.svg"
                  className="w-4"
                />
              </div>
              <div className="flex flex-1 flex-col gap-2 justify-start">
                <span className="text-xs font-semibold">
                  Los sitios web oficiales utilizan <strong>.gob.do</strong>,{" "}
                  <strong>.gov.do</strong> ó <strong>.mil.do</strong>
                </span>
                <span className="text-xs">
                  Un sitio .gob.do, .gov.do ó .mil.do significa que pertenece a
                  una organización oficial del Estado dominicano.
                </span>
              </div>
            </div>
            {/* ssl */}
            <div className="w-1/2 flex items-center gap-4">
              <div className="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                <img
                  src="/wp-content/plugins/nortic-plugin/dist/public/images/lock.svg"
                  className="w-4"
                />
              </div>
              <div className="flex flex-1 flex-col gap-2 justify-start">
                <span className="text-xs font-semibold">
                  Los sitios web oficiales <strong>.gob.do</strong>,{" "}
                  <strong>.gov.do</strong> ó <strong>.mil.do</strong> usan HTTPS
                </span>
                <span className="text-xs">
                  Un candado (🔒) o https:// ignifica que estas conectado a un
                  sitio seguro dentro de .gob.do ó .gov.do. Comparte información
                  confidencial sólo en los sitios seguros de .gob.do ó gov.do.
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  },
  save() {
    const blockProps = useBlockProps.save();

    return (
      <div {...blockProps}>
        <div className="container mx-auto text-white">
          <div className="h-8 flex items-center justify-start gap-2 flex-nowrap">
            <img
              src="/wp-content/plugins/nortic-plugin/dist/public/images/dominican-flag.svg"
              className="w-6"
            />
            <span className="text-xs">
              Esta es una web oficial del Gobierno de la República Dominicana
            </span>
            <button
              id="gob-do-button"
              className="flex items-center gap-2 text-blue-400 text-xs"
            >
              Así es como puedes saberlo
              <i className="bi bi-chevron-down ml-2"></i>
            </button>
          </div>
          {/* trigger */}
          <div id="gob-do-dropdown" className="flex items-center gap-8 py-4">
            <div className="w-1/2 flex items-center gap-4">
              {/* gob.do */}
              <div className="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                <img
                  src="/wp-content/plugins/nortic-plugin/dist/public/images/cupula.svg"
                  className="w-4"
                />
              </div>
              <div className="flex flex-1 flex-col gap-2 justify-start">
                <span className="text-xs font-semibold">
                  Los sitios web oficiales utilizan <strong>.gob.do</strong>,{" "}
                  <strong>.gov.do</strong> ó <strong>.mil.do</strong>
                </span>
                <span className="text-xs">
                  Un sitio .gob.do, .gov.do ó .mil.do significa que pertenece a
                  una organización oficial del Estado dominicano.
                </span>
              </div>
            </div>
            {/* ssl */}
            <div className="w-1/2 flex items-center gap-4">
              <div className="flex items-center justify-center w-12 h-12 bg-blue-500 rounded-full">
                <img
                  src="/wp-content/plugins/nortic-plugin/dist/public/images/lock.svg"
                  className="w-4"
                />
              </div>
              <div className="flex flex-1 flex-col gap-2 justify-start">
                <span className="text-xs font-semibold">
                  Los sitios web oficiales <strong>.gob.do</strong>,{" "}
                  <strong>.gov.do</strong> ó <strong>.mil.do</strong> usan HTTPS
                </span>
                <span className="text-xs">
                  Un candado (🔒) o https:// ignifica que estas conectado a un
                  sitio seguro dentro de .gob.do ó .gov.do. Comparte información
                  confidencial sólo en los sitios seguros de .gob.do ó gov.do.
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  },
});
