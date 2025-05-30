import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
  TextControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useEffect } from "@wordpress/element";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, use_default_title, ENDPOINT, departamentos } = attributes;
    const blockProps = useBlockProps();

    useEffect(() => {
      (async () => {
        const url = `/wp-json/nortic/v1/${ENDPOINT}`;
        const departamentosResponse = await fetch(url);
        const result = await departamentosResponse.json();
        console.log("Departamentos response: ", result);
        setAttributes({
          departamentos: result?.data,
        });
      })();
    }, [ENDPOINT]);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={__("Show default title", block.textdomain)}
              checked={use_default_title}
              onChange={(use_default_title) =>
                setAttributes({ use_default_title })
              }
              help={
                use_default_title
                  ? __("Showing title by default", block.textdomain)
                  : __("Add a custom title", block.textdomain)
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
          <PanelBody title={__("API", block.textdomain)}>
            <TextControl
              label={__("Endpoint", block.textdomain)}
              value={ENDPOINT}
              onChange={(ENDPOINT) => setAttributes({ ENDPOINT })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {use_default_title ? (
            <h5>{__("Departamentos", block.textdomain)}</h5>
          ) : (
            <RichText
              tagName="h5"
              placeholder={__("Click to add a title", block.textdomain)}
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
          {departamentos ? (
            <ul className="mt-departamentos-list">
              {departamentos.map((departamento) => {
                return <li key={departamento.CODIGO}>{departamento.NOMBRE}</li>;
              })}
            </ul>
          ) : null}
        </div>
      </>
    );
  },
});
