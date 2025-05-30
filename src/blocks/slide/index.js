import { registerBlockType } from "@wordpress/blocks";
import {
  InnerBlocks,
  useBlockProps,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
  InspectorControls,
  PanelColorSettings,
} from "@wordpress/block-editor";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import {
  ToolbarButton,
  Spinner,
  PanelBody,
  ToggleControl,
  TextControl,
  TextareaControl,
} from "@wordpress/components";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      title,
      titleColor,
      subTitle,
      subTitleColor,
      imageID,
      imageUrl,
      imageAlt,
      showTitle,
      showSubTitle,
      buttonLabel,
      buttonUrl,
      buttonColor,
      showButton,
    } = attributes;
    const blockProps = useBlockProps({
      className: "glide__slide relative",
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
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <TextControl
              label={__("Title", block.textdomain)}
              value={title}
              onChange={(title) => setAttributes({ title })}
            />
            <ToggleControl
              label={__("Show title", block.textdomain)}
              checked={showTitle}
              onChange={(showTitle) => setAttributes({ showTitle })}
            />
            <TextControl
              label={__("Sub title", block.textdomain)}
              value={subTitle}
              onChange={(subTitle) => setAttributes({ subTitle })}
            />
            <ToggleControl
              label={__("Show sub title", block.textdomain)}
              checked={showSubTitle}
              onChange={(showSubTitle) => setAttributes({ showSubTitle })}
            />
            <ToggleControl
              label={__("Show button", block.textdomain)}
              checked={showButton}
              onChange={(showButton) => setAttributes({ showButton })}
            />
            {showButton && (
              <>
                <TextControl
                  label={__("Button label", block.textdomain)}
                  value={buttonLabel}
                  onChange={(buttonLabel) => setAttributes({ buttonLabel })}
                />
                <TextControl
                  label={__("Button url", block.textdomain)}
                  value={buttonUrl}
                  onChange={(buttonUrl) => setAttributes({ buttonUrl })}
                />
              </>
            )}
          </PanelBody>
          <PanelColorSettings
            title={__("Colors", block.textdomain)}
            initialOpen={true}
            colorSettings={[
              {
                value: titleColor,
                onChange: (newColor) => setAttributes({ titleColor: newColor }),
                label: __("Title color", block.textdomain),
              },
              {
                value: subTitleColor,
                onChange: (newColor) =>
                  setAttributes({ subTitleColor: newColor }),
                label: __("Sub title color", block.textdomain),
              },
              {
                value: buttonColor,
                onChange: (newColor) =>
                  setAttributes({ buttonColor: newColor }),
                label: __("Button color", block.textdomain),
              },
            ]}
          />
        </InspectorControls>
        <li {...blockProps}>
          <div className="slide_bg-image-container">
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
            <img className="slide_bg-image" src={imageUrl} alt={imageAlt} />
          </div>
          <div className="slide_content">
            {showTitle && (
              <h2
                className="slide_title  text-2xl font-bold"
                style={{ color: titleColor }}
              >
                {title}
              </h2>
            )}
            {showSubTitle && (
              <p
                className="slide_sub-title text-lg"
                style={{ color: subTitleColor }}
              >
                {subTitle}
              </p>
            )}
            {showButton && (
              <a
                href={buttonUrl}
                className="inline-block mt-4 px-4 py-2 rounded text-white"
                style={{ backgroundColor: buttonColor }}
              >
                {buttonLabel}
              </a>
            )}
          </div>
        </li>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      titleColor,
      subTitle,
      subTitleColor,
      imageID,
      imageUrl,
      imageAlt,
      showTitle,
      showSubTitle,
      buttonLabel,
      buttonUrl,
      buttonColor,
      showButton,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: "glide__slide relative",
    });

    return (
      <li {...blockProps}>
        <div className="slide_bg-image-container">
          <img className="slide_bg-image" src={imageUrl} alt={imageAlt} />
        </div>
        <div className="slide_content">
          {showTitle && (
            <h1
              className="slide_title text-2xl font-bold"
              style={{ color: titleColor }}
            >
              {title}
            </h1>
          )}
          {showSubTitle && (
            <p
              className="slide_sub-title text-lg"
              style={{ color: subTitleColor }}
            >
              {subTitle}
            </p>
          )}
          {showButton && (
            <a
              href={buttonUrl}
              className="inline-block mt-4 px-4 py-2 rounded text-white"
              style={{ backgroundColor: buttonColor }}
            >
              {buttonLabel}
            </a>
          )}
        </div>
      </li>
    );
  },
});
