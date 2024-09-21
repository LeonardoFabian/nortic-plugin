import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, QueryControls } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { format, dateI18n, __experimentalGetSettings } from "@wordpress/date";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { count } = attributes;
    const blockProps = useBlockProps();

    const data = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "gallery", {
          per_page: count,
          _embed: true,
        });
      },
      [count]
    );

    console.log(data);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Gallery settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={1}
              maxItems={50}
              order="desc"
              orderBy="date"
              onNumberOfItemsChange={(count) => setAttributes({ count })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="nortic-plugin-gallery-archive-wrapper grid grid-cols-4 md:grid-cols-3 gap-4">
            {data &&
              data?.map((gallery) => {
                const galleryFeaturedImage =
                  gallery._embedded &&
                  gallery._embedded["wp:featuredmedia"] &&
                  gallery._embedded["wp:featuredmedia"].length > 0 &&
                  gallery._embedded["wp:featuredmedia"][0];

                return (
                  <div className="nortic-plugin-gallery-archive-item">
                    <figure>
                      <img
                        class="h-auto max-w-full rounded-lg"
                        src={
                          galleryFeaturedImage.media_details.sizes.full
                            .source_url
                        }
                        alt={galleryFeaturedImage.alt_text}
                      />
                      <figcaption>
                        <div className="flex flex-col items-center justify-center">
                          {gallery.title.rendered && (
                            <h3>
                              <a href={gallery.link}>
                                <RawHTML>{gallery.title.rendered}</RawHTML>
                              </a>
                            </h3>
                          )}
                          <time dateTime={format("c", gallery.date_gmt)}>
                            {dateI18n(
                              __experimentalGetSettings().formats.date,
                              gallery.date_gmt
                            )}
                          </time>
                        </div>
                      </figcaption>
                    </figure>
                  </div>
                );
              })}
          </div>
        </div>
      </>
    );
  },
});
