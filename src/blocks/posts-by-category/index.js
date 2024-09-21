import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import { PanelBody, QueryControls, ToggleControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { format, dateI18n, __experimentalGetSettings } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { count, categories, order, orderBy, useTemplateQuery } = attributes;
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
    // console.log("Post categories array: ", postCategoriesArray);

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

    // console.log("Featured posts: ", posts);

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

    const handleUseTemplateQuery = (value) => {
      setAttributes({ useTemplateQuery: value });
    };

    // handle category array attribute change
    const handleCategoryChange = (cats) => {
      const newCategories = [];

      cats?.forEach((cat) => {
        if (typeof cat === "object") {
          return newCategories.push(cat);
        }

        const postCategory = postCategories?.find(
          (postCatgoryObj) => postCatgoryObj.name === cat
        );

        if (postCategory) newCategories.push(postCategory);
      });

      setAttributes({ categories: newCategories });

      // console.log("Categories: ", categories);
    };

    const truncateString = (string, maxLength) => {
      if (string.length <= maxLength) {
        return string;
      }
      return string.substring(0, maxLength) + "...";
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
          {!!categories && (
            <div className="posts-by-category-header">
              <ul>
                {categories?.map((category) => (
                  <li>
                    <span>
                      <a href="#">{category?.value}</a>
                    </span>
                  </li>
                ))}
              </ul>
            </div>
          )}
          <div className="posts-by-category-wrapper">
            {posts?.map((post, i) => {
              console.log("Post by category: ", post);

              let truncatedTitle = null;
              let truncatedExcerpt = null;

              if (i < 1) {
                truncatedTitle = truncateString(post.title.rendered, 120);
                truncatedExcerpt = truncateString(post.excerpt.rendered, 230);
              } else {
                truncatedTitle = truncateString(post.title.rendered, 200);
                truncatedExcerpt = truncateString(post.excerpt.rendered, 80);
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

              return (
                <div
                  key={post.id}
                  className={`post-by-category-item post-by-category-item-${i}`}
                >
                  <div className="post-by-category-image-wrapper">
                    <img
                      src={
                        featuredMedia?.media_details?.sizes?.full?.source_url
                      }
                      alt={featuredMediaAltText}
                    />
                  </div>
                  <div className="post-by-category-data">
                    {post?.title?.rendered && (
                      <h6>
                        <a href={post.link}>
                          <RawHTML>{truncatedTitle}</RawHTML>
                        </a>
                      </h6>
                    )}
                    <div className="post-by-category-metadata">
                      <time
                        dateTime={format("c", post.date_gmt)}
                        className="post-by-category-date"
                      >
                        <i class="bi bi-calendar4-week"></i> <span>{date}</span>
                      </time>
                    </div>
                    <div className="post-by-category-excerpt">
                      <p>
                        <RawHTML>{truncatedExcerpt}</RawHTML>
                      </p>
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
