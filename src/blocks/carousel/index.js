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
          {/* glide__track */}
          <div className="glide__track" data-glide-el="track">
            <ul className="glide__slides">
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
                  <li className="glide__slide">
                    {postFeaturedImage &&
                      postFeaturedImage.media_details.sizes.bannerHero && (
                        <>
                          <div
                            className="carousel_image_container "
                            // style={{
                            //   backgroundImage: `url(${postFeaturedImage.media_details.sizes.bannerHero.source_url})`,
                            //   backgroundRepeat: "no-repeat",
                            //   backgroundPosition: "center",
                            //   backgroundSize: "cover",
                            // }}
                          >
                            <img
                              src={
                                postFeaturedImage.media_details.sizes.bannerHero
                                  .source_url
                              }
                              alt={post.title.rendered}
                            />
                          </div>
                          <div className="carousel_content ">
                            <h2 className="carousel-content-title">
                              {/* <RawHTML>{post.title.rendered[0]}</RawHTML> */}
                              {__(
                                "The Post Title will be displayed here on the frontend",
                                "nortic-plugin"
                              )}
                            </h2>
                            {show_the_excerpt && (
                              <p className="carousel-content-excerpt">
                                Lorem ipsum dolor sit amet, consectetur
                                adipscing elit. Praesent mi tortor, vehicula et
                                porta vel, aliquam eu est.
                              </p>
                            )}
                            <a
                              href="javascript:void(0)"
                              className="wp-block-button__link wp-element-button"
                            >
                              {__("Read more", "nortic-plugin")}
                            </a>
                          </div>
                        </>
                      )}
                  </li>
                );
              })}
            </ul>
          </div>
          {/* end glide__track */}

          {/* Slider indicators  */}
          <div className="glide__bullets">
            {carouselPosts?.map((bullets, index) => (
              <button
                type="button"
                className="glide__bullet w-4 h-4 rounded-full"
                aria-current="true"
                aria-label="Slide 1"
                data-glide-dir={index}
              ></button>
            ))}
          </div>

          {/* Slider controls  */}
          <div className="glide__arrows" data-glide-el="controls[nav]">
            <button class="glide__arrow glide__arrow--prev" data-glide-dir="<">
              &lt;
            </button>
            <button class="glide__arrow glide__arrow--next" data-glide-dir=">">
              &gt;
            </button>
          </div>
        </div>
      </>
    );
  },
});
