import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  RangeControl,
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
  QueryControls,
  RichText,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import svgMap from "../../interactiveMap.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { provinces, numberOfItems } = attributes;
    const blockProps = useBlockProps();

    const provinceTerms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "province", {
        per_page: -1,
      });
    }, []);

    const dependencies = useSelect(
      (select) => {
        const query = {
          post_type: "dependency",
          per_page: numberOfItems,
          tax_query: [
            {
              taxonomy: "province",
              field: "term_id",
              terms: provinces.map((term) => term.id),
            },
          ],
        };
        return select("core").getEntityRecords("postType", "dependency", query);
      },
      [provinces]
    );

    if (!dependencies) {
      return (
        <div {...blockProps}>
          <p>{__("Loading...", block.textdomain)}</p>
        </div>
      );
    }

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <QueryControls
              numberOfItems={numberOfItems}
              onNumberOfItemsChange={(value) =>
                setAttributes({ numberOfItems: value })
              }
              categoriesList={provinceTerms}
              selectedCategories={provinces}
              onCategoryChange={(newProvinces) =>
                setAttributes({ provinces: newProvinces })
              }
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div id="dependency-interactive-map"></div>
        </div>
      </>
    );
  },
});
