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
      description,
      columns,
      count,
      categories,
      tags,
      displayFeaturedImage,
      displayViewMoreButton,
      order,
      orderBy,
      useTemplateQuery,
    } = attributes;
    const blockProps = useBlockProps();

    const cardStyle = `col-${columns} nortic-plugin__post`;

    const postCategoriesTerms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "category", {
        per_page: -1,
      });
    }, []);
    const postCategoryArray = {};

    postCategoriesTerms?.forEach((term) => {
      postCategoryArray[term.name] = term;
    });

    const postTagsTerms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "tag");
    }, []);
    const postTagArray = {};

    postTagsTerms?.forEach((term) => {
      postTagArray[term.name] = term;
    });

    // console.log(postCategoryArray);
    // console.log(postTagArray);

    const categoryIDs = categories.map((term) => term.id);
    // console.log(categoryIDs);

    const posts = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "post", {
          per_page: count,
          _embed: true,
          categories: categoryIDs,
          orderby: orderBy,
          order: order,
        });
      },
      [count, categoryIDs, order, orderBy, categories]
    );

    // console.log(posts);

    const handleUseTemplateQuery = (value) => {
      setAttributes({ useTemplateQuery: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={_x(
                "Inherit the template query",
                "ToggleControl label",
                block.textdomain
              )}
              checked={useTemplateQuery}
              onChange={handleUseTemplateQuery}
              help={__(
                "Toggle using the global query context that is set with the current template, such as a file or a search. Turn it off to customize settings independently.",
                block.textdomain
              )}
            />
            <QueryControls
              numberOfItems={count}
              minItems={-1}
              maxItems={200}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={postCategoryArray}
              // categoriesList={postCategoriesTerms}
              onCategoryChange={(newTerms) => {
                const newCategories = [];

                newTerms.forEach((cat) => {
                  if (typeof cat === "object") {
                    return newCategories.push(cat);
                  }

                  const categoryTerm = postCategoriesTerms?.find(
                    (term) => term.name === cat
                  );

                  if (categoryTerm) newCategories.push(categoryTerm);
                });

                setAttributes({ categories: newCategories });
              }}
              selectedCategories={categories}
              orderBy={orderBy}
              onOrderByChange={(value) => setAttributes({ orderBy: value })}
              order={order}
              onOrderChange={(value) => setAttributes({ order: value })}
            />
            <RangeControl
              label={__("Columns", "nortic-plugin")}
              onChange={(columns) => setAttributes({ columns })}
              value={columns}
              min={1}
              max={5}
              help={__(
                "Number of columns in which the posts will be displayed",
                block.textdomain
              )}
            />
            <ToggleControl
              label={__("Show Featured Image", block.textdomain)}
              checked={displayFeaturedImage}
              onChange={(displayFeaturedImage) =>
                setAttributes({ displayFeaturedImage })
              }
              help={
                displayFeaturedImage
                  ? __("Featured Image viewable", block.textdomain)
                  : __("Hidden Featured Image", block.textdomain)
              }
            />
            <ToggleControl
              label={__("Display view more button", block.textdomain)}
              checked={displayViewMoreButton}
              onChange={(displayViewMoreButton) =>
                setAttributes({ displayViewMoreButton })
              }
              help={
                displayViewMoreButton
                  ? __("View more button is visible", block.textdomain)
                  : __("View more button is hidden", block.textdomain)
              }
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {/* Blog Section Start */}
          <section className="pt-20 pb-10">
            <div className="container">
              <div className="flex flex-wrap justify-center -mx-4">
                <div className="w-full px-4">
                  <div className="text-center mx-auto">
                    <RichText
                      tagName="h2"
                      className="
                  font-bold
                  text-3xl                  
                  text-dark
                  mb-4
                  "
                      value={title}
                      onChange={(title) => setAttributes({ title })}
                      placeholder={__("Add a title", block.textdomain)}
                    />
                  </div>
                  <div className="text-center mx-auto">
                    <RichText
                      tagName="p"
                      className="text-base text-body-color"
                      value={description}
                      onChange={(description) => setAttributes({ description })}
                      placeholder={__("Add description", block.textdomain)}
                    />
                  </div>
                </div>
              </div>
              <div className="flex flex-wrap -mx-4 latest-post-container">
                {posts?.map((post) => {
                  const featuredImage =
                    post._embedded &&
                    post._embedded["wp:featuredmedia"] &&
                    post._embedded["wp:featuredmedia"].length > 0 &&
                    post._embedded["wp:featuredmedia"][0];

                  {
                    /* console.log(featuredImage); */
                  }

                  const postDate = dateI18n(
                    __experimentalGetSettings().formats.date,
                    post.date_gmt
                  );

                  return (
                    <div key={post.id} className={cardStyle}>
                      <div className="mx-auto mb-10">
                        <div className="rounded overflow-hidden mb-8">
                          {displayFeaturedImage &&
                            featuredImage &&
                            featuredImage.media_details.sizes.landscape && (
                              <a
                                className="nortic-plugin__single_post--image"
                                href={post.link}
                              >
                                <img
                                  src={
                                    featuredImage.media_details.sizes.landscape
                                      .source_url
                                  }
                                  alt={featuredImage?.alt_text}
                                />
                              </a>
                            )}
                        </div>
                        <div>
                          {post.title.rendered && (
                            <h3>
                              <a
                                href={post.link}
                                className="
                        font-semibold
                        text-xl                        
                        mb-4
                        inline-block
                        text-dark"
                              >
                                <RawHTML>{post.title.rendered}</RawHTML>
                              </a>
                            </h3>
                          )}

                          <time
                            dateTime={format("c", post.date_gmt)}
                            className="text-base text-body-color"
                          >
                            {postDate}
                          </time>
                        </div>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </section>
          {/* Blog Section End  */}
        </div>
      </>
    );
  },
});
