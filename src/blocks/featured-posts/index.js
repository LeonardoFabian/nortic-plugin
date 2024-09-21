import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import { PanelBody, QueryControls, RangeControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { format, dateI18n, __experimentalGetSettings } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { count, categories, order, orderBy } = attributes;
    const blockProps = useBlockProps();

    const postCategoriesObj = {
      per_page: -1,
    };

    // retrieve all post categories
    const postCategories = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "category",
        postCategoriesObj
      );
    }, []);

    const postCategoriesArray = {};

    postCategories?.forEach((category) => {
      postCategoriesArray[category.name] = category;
    });

    const postCategoriesIDs = categories.map((term) => term.id);

    const postsObj = {
      per_page: count, // limit to 5 posts important
      _embed: true,
      categories: postCategoriesIDs,
      orderby: orderBy,
      order: order,
    };

    const posts = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "post", postsObj);
      },
      [postCategoriesIDs, count, orderBy, order, categories]
    );

    console.log("Featured posts: ", posts);

    // handle order attribute change
    const handleCount = (value) => {
      setAttributes({ count: value });
    };

    // handle orderBy attribute change
    const handleOrderByChange = (value) => {
      setAttributes({ orderBy: value });
    };

    const handleOrderChange = (value) => {
      setAttributes({ order: value });
    };

    // handle category array attribute change
    const handleCategoryChange = (cats) => {
      const newCategories = [];

      cats.forEach((cat) => {
        if (typeof cat === "object") {
          return newCategories.push(cat);
        }

        const postCategory = postCategories?.find(
          (postCatgoryObj) => postCatgoryObj.name === cat
        );

        if (postCategory) newCategories.push(postCategory);
      });

      setAttributes({ categories: newCategories });
    };

    const truncateTitle = (title, maxLength) => {
      if (title.length <= maxLength) {
        return title;
      }
      return title.substring(0, maxLength) + "...";
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <QueryControls
              numberOfItems={count}
              minItems={3}
              maxItems={5}
              onNumberOfItemsChange={handleCount}
              categorySuggestions={postCategoriesArray}
              onCategoryChange={handleCategoryChange}
              selectedCategories={categories}
              orderBy={orderBy}
              onOrderByChange={handleOrderByChange}
              order={order}
              onOrderChange={handleOrderChange}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="featured-posts-wrapper">
            {posts?.map((post, i) => {
              let truncatedTitle = null;

              if (i < 1) {
                truncatedTitle = truncateTitle(post.title.rendered, 120);
              } else {
                truncatedTitle = truncateTitle(post.title.rendered, 50);
              }

              // get the featured media
              const featuredMedia =
                post._embedded &&
                post._embedded["wp:featuredmedia"] &&
                post._embedded["wp:featuredmedia"].length > 0 &&
                post._embedded["wp:featuredmedia"][0];

              const featuredMediaAltText = featuredMedia?.alt_text
                ? featuredMedia.alt_text
                : __("Post featured media", block.textdomain);

              // using wordpress format for dates
              const date = dateI18n(
                __experimentalGetSettings().formats.date,
                post.date_gmt
              );

              const postItemStyles = {
                backgroundImage: `linear-gradient(
    180deg,
    rgba(0, 56, 118, 0.1) 0%,
    rgba(0, 56, 118, 0.3) 25%,
    rgba(0, 56, 118, 0.5) 75%,
    rgba(0, 56, 118, 1) 100%
  ), url(${featuredMedia?.media_details?.sizes?.full?.source_url})`,
                backgroundRepeat: "no-repeat",
                backgroundPosition: "center",
                backgroundSize: "cover",
              };

              return (
                <div
                  key={post.id}
                  className={`featured-posts-item featured-post-item-${i}`}
                  style={postItemStyles}
                >
                  <div className="featured-post-data">
                    {post?.title?.rendered && (
                      <h5>
                        <a href={post.link}>
                          <RawHTML>{truncatedTitle}</RawHTML>
                        </a>
                      </h5>
                    )}
                    <div className="featured-post-metadata">
                      <time
                        dateTime={format("c", post.date_gmt)}
                        className="featured-post-date"
                      >
                        <i class="bi bi-calendar4-week"></i> <span>{date}</span>
                      </time>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </>
    );
  },
});
