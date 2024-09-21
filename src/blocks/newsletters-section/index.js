import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";
import { registerBlockType } from "@wordpress/blocks";
import {
  InnerBlocks,
  useBlockProps,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
  RichText,
} from "@wordpress/block-editor";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useSelect } from "@wordpress/data";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { heading, subheading, count, order, orderBy } = attributes;

    const blockProps = useBlockProps();

    const newsletters = useSelect((select) => {
      return select("core").getEntityRecords("postType", "newsletter", {
        per_page: count,
        _embed: true,
        order: order,
        orderby: orderBy,
      });
    }, []);

    console.log("Newsletters: ", newsletters);

    return (
      <section {...blockProps}>
        <div className="newsletters-section-header">
          <RichText
            tagName="h2"
            className="newsletters-section-heading"
            placeholder={__("Click to add a heading", block.textdomain)}
            value={heading}
            onChange={(heading) => setAttributes({ heading })}
            allowedFormats={["core/bold", "core/link", "core/text-color"]}
          />
          <RichText
            tagName="h4"
            className="newsletters-section-subheading"
            placeholder={__("Click to add a subheading", block.textdomain)}
            value={subheading}
            onChange={(subheading) => setAttributes({ subheading })}
            allowedFormats={["core/italic", "core/text-color"]}
          />
        </div>

        <div
          className="newsletters-section-content-wrapper"
          data-glide-el="track"
        >
          <ul class="glide__slides">
            {(newsletters || []).map((resource) => {
              const featuredImage =
                resource?._embedded &&
                resource?._embedded["wp:featuredmedia"] &&
                resource?._embedded["wp:featuredmedia"].length > 0 &&
                resource?._embedded["wp:featuredmedia"][0];

              return (
                <li className="max-w-sm bg-white shadow flex flex-col justify-between">
                  <div className="text-center mb-6">
                    {featuredImage?.media_details?.sizes?.full && (
                      <div className="service-card-image-wrapper text-center mb-6 h-[50px]">
                        <img
                          src={
                            featuredImage?.media_details?.sizes?.full
                              ?.source_url
                          }
                          alt={featuredImage?.alt_text || "Image"}
                        />
                      </div>
                    )}
                    <h5 className="mb-2 text-2xl font-semibold tracking-tight">
                      {resource?.title?.rendered}
                    </h5>
                  </div>
                  <div className="flex items-center justify-center">
                    <a
                      href="#"
                      className="inline-flex font-medium items-center text-blue-600 hover:underline"
                    >
                      Ver más
                      <svg
                        class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 18 18"
                      >
                        <path
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"
                        />
                      </svg>
                    </a>
                  </div>
                </li>
              );
            })}
          </ul>
        </div>
      </section>
    );
  },
});
