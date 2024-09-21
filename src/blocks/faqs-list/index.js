import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import {
  PanelBody,
  QueryControls,
  TextareaControl,
  ToggleControl,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { title, use_default_title, categories, count, orderBy, order } =
      attributes;
    const { postId } = context;
    const blockProps = useBlockProps();

    const faqCategories = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "faq_category", {
        per_page: -1,
      });
    }, []);
    // console.log(faqCategories);

    const faqCategoriesArray = {};

    faqCategories?.forEach((term) => {
      faqCategoriesArray[term.name] = term;
    });
    // console.log(faqCategoriesArray);

    const faqCategoriesIDs = categories.map((term) => term.id);
    // console.log(faqCategoriesIDs);

    const faqs = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "faq", {
          per_page: count,
          _embed: true,
          categories: faqCategoriesIDs,
          orderby: orderBy,
          order: order,
        });
      },
      [count, faqCategoriesIDs, order, orderBy, categories]
    );

    const handleTitleChange = (value) => {
      setAttributes({ title: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <ToggleControl
              label={__("Show default title", block.textdomain)}
              checked={use_default_title}
              onChange={(use_default_title) => {
                setAttributes({ use_default_title });
              }}
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
            <QueryControls
              numberOfItems={count}
              minItems={-1}
              maxItems={100}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={faqCategoriesArray}
              onCategoryChange={(newFaqCat) => {
                const newFaqCategories = [];

                newFaqCat.forEach((faqCat) => {
                  if (typeof faqCat === "object") {
                    return newFaqCategories.push(faqCat);
                  }

                  const faqTerm = faqCategories?.find(
                    (term) => term.name === faqCat
                  );

                  if (faqTerm) newFaqCategories.push(faqTerm);
                });

                setAttributes({ categories: newFaqCategories });
              }}
              selectedCategories={categories}
              orderBy={orderBy}
              onOrderByChange={(orderBy) => setAttributes({ orderBy })}
              order={order}
              onOrderChange={(order) => setAttributes({ order })}
            />
          </PanelBody>
        </InspectorControls>
        <section {...blockProps}>
          {use_default_title ? (
            <h5>{__("Frequently asked questions", block.textdomain)}</h5>
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
          <div className="faqs-container mt-8 space-y-8 lg:mt-12">
            {/* opened card */}
            <div className="faq-item p-8 bg-light-blue rounded-lg mb-8">
              <button className="flex items-center justify-between text-left w-full gap-4">
                <h6 className="faq-title font-semibold color-black">
                  Lorem Ipsum Dolo Sit Amet
                </h6>
                <span className="bg-light-blue rounded-full">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className=" faq-iconw-6 h-6 color-blue"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M18 12H6"
                    />
                  </svg>
                </span>
              </button>
              <p className="color-dark-gray mt-8">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                diam nonumy eirmod tempor invidunt ut labore et dolore magna
                aliquyam erat, sed diam voluptua. At vero eos et accusam et
                justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea
                takimata sanctus est Lorem ipsum dolor sit amet.
              </p>
            </div>
            {/* END opened card */}
            {/* closed card */}
            <div className="faq-item p-8 bg-light-blue rounded-lg mb-8">
              <button className="flex items-center justify-between text-left w-full gap-4">
                <h6 className="faq-title font-semibold color-black">
                  Lorem Ipsum Dolo Sit Amet
                </h6>
                <span className="bg-light-blue rounded-full">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="faq-icon w-6 h-6 color-blue"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                  </svg>
                </span>
              </button>
            </div>
            {/* END closed card */}
            {/* closed card */}
            <div className="faq-item p-8 bg-light-blue rounded-lg mb-8">
              <button className="flex items-center justify-between text-left w-full gap-4">
                <h6 className="faq-title font-semibold color-black">
                  Lorem Ipsum Dolo Sit Amet
                </h6>
                <span className="bg-light-blue rounded-full">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="faq-icon w-6 h-6 color-blue"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    />
                  </svg>
                </span>
              </button>
            </div>
            {/* END closed card */}
          </div>
        </section>
      </>
    );
  },
});
