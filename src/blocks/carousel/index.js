import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls, ToggleControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { dateI18n } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      textColor,
      btnColor,
      count,
      categories,
      order,
      orderBy,
      show_the_excerpt,
    } = attributes;
    const blockProps = useBlockProps({
      className: "glide-carousel relative w-full overflow-hidden",
    });

    const postCategories = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "category", {
        per_page: -1,
      });
    }, []);
    const postCategoriesArray = {};

    postCategories?.forEach((term) => {
      postCategoriesArray[term.name] = term;
    });

    // console.log(postCategoriesArray);

    const categoriesIDs = categories.map((term) => term.id);

    const carouselPosts = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "post", {
          per_page: count,
          _embed: true,
          categories: categoriesIDs,
          orderby: orderBy,
          order: order,
        });
      },
      [count, categoriesIDs, categories]
    );

    // console.log(carouselPosts);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={1}
              maxItems={7}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={postCategoriesArray}
              onCategoryChange={(newTerms) => {
                const newPostCategories = [];

                newTerms.forEach((cat) => {
                  if (typeof cat === "object") {
                    return newPostCategories.push(cat);
                  }

                  const postCategoriesTerms = postCategories?.find(
                    (term) => term.name === cat
                  );

                  if (postCategoriesTerms)
                    newPostCategories.push(postCategoriesTerms);
                });

                setAttributes({ categories: newPostCategories });
              }}
              selectedCategories={categories}
              orderBy={orderBy}
              onOrderByChange={(value) => setAttributes({ orderBy: value })}
              order={order}
              onOrderChange={(value) => setAttributes({ order: value })}
            />
            <ToggleControl
              checked={show_the_excerpt}
              onChange={(show_the_excerpt) =>
                setAttributes({ show_the_excerpt })
              }
              help={
                show_the_excerpt
                  ? __("Showing the excerpt", "nortic-plugin")
                  : __("Hiding the excerpt", "nortic-plugin")
              }
            />
          </PanelBody>
        </InspectorControls>
        {/* <div {...blockProps} data-carousel="slide"> */}
        <div {...blockProps}>
          {/* Carousel wrapper */}
          <div className="glide__track" data-glide-el="track">
            <div className="glide__slides">
              {carouselPosts?.map((post) => {
                {
                  /* console.log(post); */
                }
                const postFeaturedImage =
                  post._embedded &&
                  post._embedded["wp:featuredmedia"] &&
                  post._embedded["wp:featuredmedia"].length > 0 &&
                  post._embedded["wp:featuredmedia"][0];

                const date = dateI18n("F j, Y", post.date);

                return (
                  <div className="h-96 glide__slide">
                    {postFeaturedImage &&
                      postFeaturedImage.media_details.sizes.bannerHero && (
                        <div
                          className="carousel_bg-image pt-8"
                          style={{
                            backgroundImage: `url(${postFeaturedImage.media_details.sizes.bannerHero.source_url})`,
                            backgroundRepeat: "no-repeat",
                            backgroundPosition: "center",
                            backgroundSize: "cover",
                          }}
                        >
                          <div className="carousel_content absolute bottom-0 flex flex-col justify-end w-screen pb-10 cursor-pointer">
                            <div className="container">
                              <h5>
                                {/* <RawHTML>{post.title.rendered[0]}</RawHTML> */}
                                {__(
                                  "The Post Title will be displayed here on the frontend",
                                  "nortic-plugin"
                                )}
                              </h5>
                              {show_the_excerpt && (
                                <p className="carousel-content-excerpt">
                                  Lorem ipsum dolor sit amet, consectetur
                                  adipscing elit. Praesent mi tortor, vehicula
                                  et porta vel, aliquam eu est.
                                </p>
                              )}
                              <a
                                href="javascript:void(0)"
                                className="wp-block-button__link wp-element-button"
                              >
                                {__("Read more", "nortic-plugin")}
                              </a>
                            </div>
                          </div>
                        </div>
                      )}
                  </div>
                );
              })}
            </div>
            {/* Slider indicators  */}
            <div className="glide__bullets slide-indicators absolute bottom-4 w-full z-30 flex items-center justify-center mx-auto space-x-3">
              {carouselPosts?.map((bullets, index) => (
                <button
                  type="button"
                  className="w-3 h-3 rounded-full"
                  aria-current="true"
                  aria-label="Slide 1"
                  data-glide-dir={index}
                ></button>
              ))}
            </div>
          </div>

          {/* Slider controls  */}
          <button
            type="button"
            className="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev
          >
            <span className="inline-flex items-center justify-center w-8 h-8 rounded-full">
              <i class="bi bi-arrow-left text-md"></i>
              <span className="sr-only">{__("Previous", "nortic-plugin")}</span>
            </span>
          </button>
          <button
            type="button"
            className="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next
          >
            <span className="inline-flex items-center justify-center w-8 h-8 rounded-full">
              <i class="bi bi-arrow-right text-md"></i>
              <span className="sr-only">{__("Next", "nortic-plugin")}</span>
            </span>
          </button>
        </div>
      </>
    );
  },
});
