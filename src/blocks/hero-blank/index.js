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
      className: "w-full",
      style: {
        width: width,
      },
    });

    const handleHeroBlankImageSelect = (image) => {
      let newHeroBlankImageURL = null;
      let newHeroBlankImageHeight = null;

      if (isBlobURL(image.url)) {
        newHeroBlankImageURL = image.url;
      } else {
        if (image.sizes) {
          newHeroBlankImageURL = image.sizes.bannerHero
            ? image.sizes.bannerHero.url
            : image.sizes.full.url;
          newHeroBlankImageHeight = image.sizes.bannerHero
            ? image.sizes.bannerHero.height
            : image.sizes.full.height;
        } else {
          newHeroBlankImageURL =
            image.media_details.sizes.bannerHero.source_url;
          newHeroBlankImageHeight = image.media_details.sizes.bannerHero.height;
        }

        setAttributes({
          imageID: image.id,
          imageUrl: newHeroBlankImageURL,
          height: newHeroBlankImageHeight,
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
        <div {...blockProps}>
          <div
            className="hero-blank__bg-image"
            style={{
              backgroundImage: `url(${imageUrl})`,
              backgroundRepeat: "no-repeat",
            }}
          >
            <div className="hero-blank__content container">
              <InnerBlocks
                allowedBlocks={[
                  "core/heading",
                  "core/paragraph",
                  "core/buttons",
                  "core/list",
                ]}
              />
            </div>
          </div>
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
      </>
    );
  },
  save({ attributes }) {
    const { width, height, imageID, imageAlt, imageUrl } = attributes;
    const blockProps = useBlockProps.save({
      className: "w-full",
      style: {
        width: width,
      },
    });

    return (
      <div {...blockProps}>
        <div
          className="hero-blank__bg-image"
          style={{
            backgroundImage: `url(${imageUrl})`,
            backgroundRepeat: "no-repeat",
          }}
        >
          <div className="hero-blank__content container">
            <InnerBlocks.Content />
          </div>
        </div>
      </div>
    );
  },
});
