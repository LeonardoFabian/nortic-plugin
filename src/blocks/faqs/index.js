import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { dateI18n } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, count } = attributes;
    const blockProps = useBlockProps();

    const faqs = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "faq", {
          per_page: count,
          _embed: true,
          order: "asc",
          orderby: "title",
        });
      },
      [count]
    );

    // console.log(faqs);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={1}
              maxItems={10}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {/* FAQs Section Start */}
          <section className="relative py-20 overflow-hidden bg-gray-50">
            <img
              className="absolute top-0 left-0 mt-44"
              src="saturn-assets/images/faq/light-blue-left.png"
              alt=""
            />
            <img
              className="absolute top-0 right-0 mt-10"
              src="saturn-assets/images/faq/star-right.svg"
              alt=""
            />
            <div className="relative container px-4 mx-auto">
              <div className="max-w-5xl mx-auto">
                <div className="text-left mb-24">
                  <span className="inline-block py-1 px-3 mb-4 text-xs font-semibold text-orange-900 bg-orange-50 rounded-full">
                    FREQUENTLY ASK QUESTION
                  </span>
                  <RichText
                    tagName="h2"
                    className="font-heading text-5xl font-bold text-gray-900"
                    value={title}
                    onChange={(title) => setAttributes({ title })}
                    placeholder={__("Add a title", "nortic-plugin")}
                  />
                </div>
                <div className="pt-16 px-8 pb-16 bg-white rounded-4xl shadow-lg">
                  {faqs?.map((faq) => {
                    return (
                      <button className="flex mb-8 pb-8 group w-full items-start justify-between border-b border-gray-100 text-left">
                        <div className="max-w-xl pr-5">
                          <a href={faq.link}>
                            <h3 className="text-xl font-semibold text-orange-900 mb-3">
                              <RawHTML>{faq.title.rendered}</RawHTML>
                            </h3>
                          </a>
                          <p className="text-lg text-gray-500">
                            <RawHTML>{faq.content.rendered}</RawHTML>
                          </p>
                        </div>
                        <div className="pt-1">
                          <span>
                            <i class="bi bi-dash"></i>
                          </span>
                        </div>
                      </button>
                    );
                  })}
                </div>
              </div>
            </div>
          </section>
          {/* FAQs Section End  */}
        </div>
      </>
    );
  },
});
