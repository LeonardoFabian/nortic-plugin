import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  MediaPlaceholder,
  RichText,
  BlockControls,
  MediaReplaceFlow,
  store as blockEditorStore,
} from "@wordpress/block-editor";
import {
  PanelBody,
  SelectControl,
  Spinner,
  TextareaControl,
  ToolbarButton,
} from "@wordpress/components";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, imageID, imageAlt, imageUrl, objectFit, link, linkTarget } =
      attributes;

    // Upload or select image from media library
    const handleBannerSelect = (img) => {
      // console.log(img);

      let newBannerImageURL = null;
      let newBannerImageHeight = null;

      if (isBlobURL(img.url)) {
        newBannerImageURL = img.url;
      } else {
        // console.log(img);

        if (img.sizes) {
          newBannerImageURL = img.sizes.mediumRectangle
            ? img.sizes.mediumRectangle.url
            : img.sizes.full.url;
          newBannerImageHeight = img.sizes.mediumRectangle
            ? img.sizes.mediumRectangle.height
            : img.sizes.full.height;
        } else {
          newBannerImageURL =
            img.media_details.sizes.mediumRectangle.source_url;
          newBannerImageHeight = img.media_details.sizes.mediumRectangle.height;
        }

        setAttributes({
          imageID: img.id,
          imageUrl: newBannerImageURL,
        });

        revokeBlobURL(bannerImagePreview);
      }

      setBannerImagePreview(newBannerImageURL);
    };

    // Select image from URL
    const handleBannerSelectUrl = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });
      setBannerImagePreview(url);
    };

    // retrieve image object
    const bannerImageObject = useSelect(
      (select) => {
        const { getMedia } = select("core");
        return imageID ? getMedia(imageID) : null;
      },
      [imageID]
    );

    // console.log(bannerImageObject);

    // retrieve image sizes
    const bannerImageSizes = useSelect((select) => {
      return select(blockEditorStore).getSettings().imageSizes;
    });

    console.log(bannerImageSizes);

    const getBannerImageSizeOptions = () => {
      if (!bannerImageObject) return [];

      const options = [];
      const sizes = bannerImageObject.media_details.sizes;
      for (const key in sizes) {
        const size = sizes[key];
        const imageSize = bannerImageSizes.find((s) => s.slug === key);
        if (imageSize) {
          options.push({
            label: imageSize.name,
            value: size.source_url,
          });
        }
      }
      return options;
    };

    const [bannerImagePreview, setBannerImagePreview] = useState(imageUrl);

    const blockProps = useBlockProps({
      className: `h-full relative`,
    });

    // handle image size select
    const handleOnChangeBannerImageSize = (newImageURL) => {
      setAttributes({ imageUrl: newImageURL });
      setBannerImagePreview(newImageURL);
    };

    return (
      <>
        {bannerImagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", "nortic-plugin")}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg", "image/webp"]}
              accept={"image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleBannerSelect}
              onSelectURL={handleBannerSelectUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageID: 0,
                  imageAlt: "",
                  imageUrl: "",
                });
                setBannerImagePreview("");
              }}
            >
              {__("Remove image", "nortic-plugin")}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelBody title={__("Image settings", "nortic-plugin")}>
            {bannerImagePreview && (
              <SelectControl
                label={__("Image size", "nortic-plugin")}
                options={getBannerImageSizeOptions()}
                value={imageUrl}
                onChange={handleOnChangeBannerImageSize}
              />
            )}
            <SelectControl
              label={__("Object fit", "nortic-plugin")}
              value={objectFit}
              options={[
                { label: __("Contain", "nortic-plugin"), value: "contain" },
                { label: __("Cover", "nortic-plugin"), value: "cover" },
                { label: __("Fill", "nortic-plugin"), value: "fill" },
                {
                  label: __("Scale Down", "nortic-plugin"),
                  value: "scale-down",
                },
                { label: __("None", "nortic-plugin"), value: "none" },
              ]}
              onChange={(objectFit) => setAttributes({ objectFit })}
            />
            {bannerImagePreview && !isBlobURL(bannerImagePreview) && (
              <TextareaControl
                label={__("Alt text (alternative text)", "nortic-plugin")}
                value={imageAlt}
                onChange={(imageAlt) => setAttributes({ imageAlt })}
                help={__(
                  "Describe the purpose of the image. Leave empty if the image is purely decorative.",
                  "nortic-plugin"
                )}
              />
            )}

            <TextareaControl
              label={__("Image link", "nortic-plugin")}
              value={link}
              onChange={(link) => setAttributes({ link })}
              help={__("Add a link to the banner", "nortic-plugin")}
            />
            <SelectControl
              label={__("Link target", "nortic-plugin")}
              value={linkTarget}
              options={[
                { label: __("Same tab", "nortic-plugin"), value: "_self" },
                { label: __("New tab", "nortic-plugin"), value: "_blank" },
              ]}
              onChange={(linkTarget) => setAttributes({ linkTarget })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {bannerImagePreview && (
            <img
              src={bannerImagePreview}
              alt={imageAlt}
              className={`w-full object-${objectFit}`}
            />
          )}
          {/* Spinner */}
          {isBlobURL(imageUrl) && <Spinner />}
          <div className="media-placeholder">
            <MediaPlaceholder
              allowedTypes={["image/png", "image/jpeg", "image/webp"]}
              accept={"image/*"}
              icon="format-image"
              onSelect={handleBannerSelect}
              onError={(e) => console.error(e)}
              disableMediaButtons={imageUrl}
              onSelectURL={handleBannerSelectUrl}
            />
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { title, imageID, imageAlt, imageUrl, objectFit, link, linkTarget } =
      attributes;
    const blockProps = useBlockProps.save({
      className: `h-full relative`,
    });

    return (
      <div {...blockProps}>
        <a
          target={linkTarget}
          href={link}
          className="inline-block h-full w-full"
        >
          {imageUrl && (
            <img
              src={imageUrl}
              alt={imageAlt}
              className={`w-full object-${objectFit}`}
            />
          )}
        </a>
      </div>
    );
  },
});
