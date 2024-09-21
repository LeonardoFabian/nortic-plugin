import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import { PanelBody, QueryControls } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { categories, count, orderBy, order } = attributes;
    const blockProps = useBlockProps();

    const awardCategories = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "award_category", {
        per_page: -1,
      });
    }, []);
    // console.log(awardCategories);

    const awardCategoriesArray = {};

    awardCategories?.forEach((term) => {
      awardCategoriesArray[term.name] = term;
    });

    const awardCategoriesID = categories.map((term) => term.id);

    const awards = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "award", {
          per_page: count,
          _embed: true,
          categories: awardCategoriesID,
          orderby: orderBy,
          order: order,
        });
      },
      [count, awardCategoriesID, orderBy, order, categories]
    );

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={-1}
              maxItems={100}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={awardCategoriesArray}
              onCategoryChange={(newCat) => {
                const newAwardCategoriesArray = [];

                newCat.forEach((cat) => {
                  if (typeof cat === "object") {
                    return newAwardCategoriesArray.push(cat);
                  }

                  const awardTerm = awardCategories?.find(
                    (term) => term.name === cat
                  );

                  if (awardTerm) newAwardCategoriesArray.push(awardTerm);
                });
                setAttributes({ categories: newAwardCategoriesArray });
              }}
              selectedCategories={categories}
              orderBy={orderBy}
              onOrderByChange={(orderBy) => setAttributes({ orderBy })}
              order={order}
              onOrderChange={(order) => setAttributes({ order })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="stamp-container">
            <div className="stamp-box">
              <div className="stamp">
                <a
                  href="https://nortic.ogtic.gob.do/instituciones/MT"
                  target="_blank"
                  className="stamp stack-top"
                  title="Norma sobre Publicación de Datos Abiertos del Gobierno Dominicano."
                  rel="noopener"
                >
                  <iframe
                    src="https://be.nortic.ogtic.gob.do/stampprocesses/stamp/147"
                    height="100"
                    width="100"
                    // frameborder="0"
                    // scrolling="no"
                    style={{ width: "99%" }}
                  ></iframe>
                </a>
              </div>
            </div>
            <div className="stamp-box">
              <div className="stamp">
                <a
                  href="https://nortic.ogtic.gob.do/instituciones/MT"
                  target="_blank"
                  className="stamp stack-top"
                  title="Norma para la Interoperabilidad entre los Organismos del Gobierno Dominicano."
                  rel="noopener"
                >
                  <iframe
                    src="https://be.nortic.ogtic.gob.do/stampprocesses/stamp/148"
                    height="100"
                    width="100"
                    // frameborder="0"
                    // scrolling="no"
                    style={{ width: "99%" }}
                  ></iframe>
                </a>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
});
