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
    const { count, directories } = attributes;
    const blockProps = useBlockProps();
    const [availableTerms, setAvailableTerms] = useState([]);

    const terms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "directory", {
        per_page: -1,
      });
    });

    console.log(terms);

    useEffect(() => {
      setAvailableTerms(terms);
      console.log(availableTerms);
    }, [terms]);

    return (
      <>
        <InspectorControls>
          <PanelBody title="Configuración">
            <TextControl
              label="Cantidad de documentos"
              type="number"
              value={count}
              onChange={(value) =>
                setAttributes({ count: parseInt(value) || -1 })
              }
            />
            <SelectControl
              multiple
              label="Seleccionar términos"
              value={directories}
              options={availableTerms?.map((term) => ({
                label: term.name,
                value: term.id,
              }))}
              onChange={(value) => setAttributes({ directories: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <p>Directories tab</p>
        </div>
      </>
    );
  },
});
