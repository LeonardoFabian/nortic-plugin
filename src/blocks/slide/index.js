import { registerBlockType } from "@wordpress/blocks";
import {
  InnerBlocks,
  useBlockProps,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
} from "@wordpress/block-editor";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { ToolbarButton, Spinner } from "@wordpress/components";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { width, height, imageID, imageAlt, imageUrl } = attributes;
    const blockProps = useBlockProps({
      className: "w-full h-96 glide__slide",
      style: {
        width: width,
        height: height,
        "max-height": height,
      },
    });

    const handleHeroBlankImageSelect = (image) => {
      let newHeroBlankImageURL = null;

      if (isBlobURL(image.url)) {
        newHeroBlankImageURL = image.url;
      } else {
        newHeroBlankImageURL = image.sizes
          ? image.sizes.bannerHero.url
          : image.media_details.sizes.bannerHero.source_url;

        setAttributes({
          imageID: image.id,
          imageUrl: newHeroBlankImageURL,
          //   height: image.media_details.sizes.bannerHero.height,
        });

        revokeBlobURL(heroBlankImagePreview);
      }

      setHeroBlankImagePreview(newHeroBlankImageURL);
    };

    const handleHeroBlankImageSelectUrl = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });

      setHeroBlankImagePreview(url);
    };

    const [heroBlankImagePreview, setHeroBlankImagePreview] =
      useState(imageUrl);

    return (
      <>
        {heroBlankImagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", "nortic-plugin")}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg"]}
              accept={"image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleHeroBlankImageSelect}
              onSelectURL={handleHeroBlankImageSelectUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageID: 0,
                  imageAlt: "",
                  imageUrl: "",
                });

                setHeroBlankImagePreview("");
              }}
            >
              {__("Remove image", "nortic-plugin")}
            </ToolbarButton>
          </BlockControls>
        )}
        <li {...blockProps}>
          <div
            className="slide_bg-image pt-8 pb-8"
            style={{
              backgroundImage: `url(${imageUrl})`,
              backgroundRepeat: "no-repeat",
              backgroundPosition: "center",
              backgroundSize: "cover",
            }}
          >
            <div className="slide_content flex flex-col justify-end container pt-8 pb-8">
              <InnerBlocks
                allowedBlocks={[
                  "core/heading",
                  "core/paragraph",
                  "core/buttons",
                  "core/list",
                ]}
              />
            </div>
            {isBlobURL(imageUrl) && <Spinner />}
            <MediaPlaceholder
              allowedTypes={["image/png", "image/jpeg"]}
              accept={"image/*"}
              icon="format-image"
              onSelect={handleHeroBlankImageSelect}
              onError={(e) => console.error(e)}
              disableMediaButtons={imageUrl}
              onSelectURL={handleHeroBlankImageSelectUrl}
            />
          </div>
        </li>
      </>
    );
  },
  save({ attributes }) {
    const { width, height, imageID, imageAlt, imageUrl } = attributes;
    const blockProps = useBlockProps.save({
      className: "w-full h-96 glide__slide",
      style: {
        width: width,
        height: height,
        "max-height": height,
      },
    });

    return (
      <li {...blockProps}>
        <div
          className="slide_bg-image"
          style={{
            backgroundImage: `url(${imageUrl})`,
            backgroundRepeat: "no-repeat",
            backgroundPosition: "center",
            backgroundSize: "cover",
          }}
        >
          <div className="slide_content absolute bottom-0 flex flex-col w-screen py-2 cursor-pointer">
            <div className="container">
              <InnerBlocks.Content />
            </div>
          </div>
        </div>
      </li>
    );
  },
});
