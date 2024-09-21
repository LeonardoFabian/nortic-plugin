// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import {
  PanelBody,
  QueryControls,
  ToggleControl,
  RangeControl,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { format, dateI18n, __experimentalGetSettings } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      title,
      columns,
      itemsPerPage,
      newsletterCategories,
      order,
      orderBy,
    } = attributes;
    const blockProps = useBlockProps();

    const cardStyle = `col-${columns} nortic-plugin__newsletters`;

    const newsletterCategoriesTerms = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "newsletter_category",
        {
          per_page: -1,
        }
      );
    }, []);
    const newsletterCategoryArray = {};

    newsletterCategoriesTerms?.forEach((term) => {
      newsletterCategoryArray[term.name] = term;
    });

    const newsletterCategoryIDs = newsletterCategories.map((term) => term.id);
    // console.log(newsletterCategoryIDs);

    const newsletters = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "newsletter", {
          per_page: itemsPerPage,
          _embed: true,
          categories: newsletterCategoryIDs,
          orderby: orderBy,
          order: order,
        });
      },
      [
        itemsPerPage,
        newsletterCategoryIDs,
        order,
        orderBy,
        newsletterCategories,
      ]
    );

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <QueryControls
              numberOfItems={itemsPerPage}
              minItems={-1}
              maxItems={200}
              onNumberOfItemsChange={(itemsPerPage) =>
                setAttributes({ itemsPerPage })
              }
              categorySuggestions={newsletterCategoryArray}
              // categoriesList={newsletterCategoriesTerms}
              onCategoryChange={(newTerms) => {
                const newCategories = [];

                newTerms.forEach((cat) => {
                  if (typeof cat === "object") {
                    return newCategories.push(cat);
                  }

                  const categoryTerm = newsletterCategoriesTerms?.find(
                    (term) => term.name === cat
                  );

                  if (categoryTerm) newCategories.push(categoryTerm);
                });

                setAttributes({ newsletterCategories: newCategories });
              }}
              selectedCategories={newsletterCategories}
              orderBy={orderBy}
              onOrderByChange={(value) => setAttributes({ orderBy: value })}
              order={order}
              onOrderChange={(value) => setAttributes({ order: value })}
            />
            <RangeControl
              label={__("Columns", block.textdomain)}
              onChange={(columns) => setAttributes({ columns })}
              value={columns}
              min={1}
              max={5}
              help={__(
                "Number of columns in which the newsletters will be displayed",
                block.textdomain
              )}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="wp-block-nortic-plugin-nortic-newsletter-list-container">
            <div className="wp-block-nortic-plugin-nortic-newsletter-list-header">
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
            </div>
            <ul className="wp-block-nortic-plugin-nortic-newsletter-list-wrapper">
              {newsletters?.map((newsletter) => {
                const featuredImage =
                  newsletter._embedded &&
                  newsletter._embedded["wp:featuredmedia"] &&
                  newsletter._embedded["wp:featuredmedia"].length > 0 &&
                  newsletter._embedded["wp:featuredmedia"][0];

                {
                  /* console.log(featuredImage); */
                }

                return (
                  <li
                    key={newsletter.id}
                    className="wp-block-nortic-plugin-nortic-newsletter-list-item"
                  >
                    <div className="newsletter-list-item-img-container">
                      {featuredImage &&
                        featuredImage.media_details.sizes.landscape && (
                          <span>
                            <img
                              src={
                                featuredImage.media_details.sizes.landscape
                                  .source_url
                              }
                              alt={featuredImage?.alt_text}
                              className="newsletter-list-item-img"
                            />
                          </span>
                        )}
                    </div>

                    {newsletter.title.rendered && (
                      <h6 className="newsletter-title">
                        <span>
                          <RawHTML>{newsletter.title.rendered}</RawHTML>
                        </span>
                      </h6>
                    )}

                    <div className="newsletter-meta">
                      <span className="newsletter-category-name">
                        Category name
                      </span>
                      <span className="newsletter-dependency-name">
                        Dependency name
                      </span>
                    </div>
                  </li>
                );
              })}
            </ul>
          </div>
        </div>
      </>
    );
  },
});
