// Service Card

import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import {
  InnerBlocks,
  useBlockProps,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";

import {
  PanelBody,
  Dashicon,
  Spinner,
  ToolbarButton,
  TextControl,
  TextareaControl,
} from "@wordpress/components";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      useIcon,
      icon,
      iconColor,
      imageId,
      imageAlt,
      imageUrl,
      title,
      description,
      bgColor,
      textColor,
    } = attributes;

    const blockProps = useBlockProps({
      className: `max-w-sm p-6 bg-white border border-gray-200 rounded-lg hover:shadow-lg transition duration-700 ease-in-out flex flex-col justify-between`,
      style: {
        color: textColor,
      },
    });

    const [imagePreview, setImagePreview] = useState(imageUrl);

    // handle select image
    const handleSelectImage = async (image) => {
      console.log("Image selected: ", image);
      let newImageUrl = null;
      if (isBlobURL(image?.url)) {
        newImageUrl = await image.url;
      } else {
        newImageUrl = (await image.sizes)
          ? image.sizes.full.url
          : image.media_details.sizes.full.source_url;
        setAttributes({
          imageId: image.id,
          imageAlt: image.alt,
          imageUrl: newImageUrl,
        });
        revokeBlobURL(imagePreview);
      }
      setImagePreview(newImageUrl);
    };

    // handle select image from URL
    const handleSelectImageFromUrl = (url) => {
      setAttributes({
        imageId: null,
        imageAlt: null,
        imageUrl: url,
      });
      setImagePreview(url);
    };

    return (
      <>
        {imagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", block.textdomain)}
              mediaId={imageId}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg", "image/webp"]}
              accept={"image/*"}
              onSelect={handleSelectImage}
              onSelectURL={handleSelectImageFromUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageId: 0,
                  imageAlt: "",
                  imageUrl: "",
                });
                setImagePreview("");
              }}
            >
              {__("Remove image", block.textdomain)}
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
            <TextareaControl
              label={__("Description", block.textdomain)}
              value={description}
              onChange={(description) => setAttributes({ description })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="text-center flex flex-col justify-between gap-4">
            {useIcon ? (
              <div
                className="service-card-image-wrapper flex items-center justify-center text-center h-16 w-16 rounded-full"
                style={{ backgroundColor: bgColor }}
              >
                <Dashicon
                  icon={icon}
                  style={{ color: iconColor }}
                  className="h-12 max-h-12"
                />
              </div>
            ) : (
              <div className="service-card-image-wrapper text-center h-16">
                {imagePreview && (
                  <img
                    src={imageUrl}
                    alt={imageAlt}
                    className="h-full object-contain"
                  />
                )}
                {isBlobURL(imageUrl) && <Spinner />}
                <MediaPlaceholder
                  allowedTypes={["image/png", "image/jpeg", "image/webp"]}
                  accept={"image/*"}
                  icon={"format-image"}
                  onSelect={handleSelectImage}
                  onSelectURL={handleSelectImageFromUrl}
                  onError={(e) => {
                    console.error("Error on select image: ", e);
                  }}
                  disableMediaButtons={imageUrl}
                />
              </div>
            )}
            <div className="flex flex-col gap-2">
              <div className="flex flex-col">
                <RichText
                  tagName="h6"
                  className="mb-2 text-sm font-semibold tracking-tight"
                  placeholder={__("Click to add a title", block.textdomain)}
                  value={title}
                  onChange={(title) => setAttributes({ title })}
                  allowedFormats={["core/bold", "core/link", "core/text-color"]}
                />
                <RichText
                  tagName="p"
                  className="mb-3 font-normal"
                  placeholder={__(
                    "Click to add a description",
                    block.textdomain
                  )}
                  value={description}
                  onChange={(description) => setAttributes({ description })}
                  allowedFormats={["core/italic", "core/text-color"]}
                />
              </div>

              <div className="flex items-center justify-center">
                <InnerBlocks
                  orientation="horizontal"
                  allowedBlocks={["core/buttons", "core/button"]}
                />
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      useIcon,
      icon,
      iconColor,
      imageId,
      imageAlt,
      imageUrl,
      title,
      description,
      bgColor,
      textColor,
    } = attributes;

    const blockProps = useBlockProps.save({
      className: `glide__slide max-w-sm p-6 bg-white bg-opacity-50 border border-gray-200 rounded-lg hover:shadow-lg transition duration-700 ease-in-out flex flex-col justify-between`,
      style: {
        color: textColor,
      },
    });

    return (
      <div {...blockProps}>
        <div className="text-center flex flex-col justify-between gap-4">
          {useIcon ? (
            <div
              className="service-card-image-wrapper text-center h-16 w-16 rounded-full"
              style={{ backgroundColor: bgColor }}
            >
              <Dashicon
                icon={icon}
                style={{ color: iconColor }}
                className="h-12 max-h-12"
              />
            </div>
          ) : (
            <div className="service-card-image-wrapper text-center h-16">
              <img
                src={imageUrl}
                alt={imageAlt}
                className="h-full object-contain"
              />
            </div>
          )}
          <div className="flex flex-col gap-2">
            <div className=" flex flex-col">
              <RichText.Content
                tagName="h6"
                className="mb-2 text-sm font-semibold tracking-tight"
                value={title}
              />
              {description && (
                <RichText.Content
                  tagName="p"
                  className="mb-3 font-normal"
                  value={description}
                />
              )}
            </div>
            <div className="flex items-center justify-center">
              <InnerBlocks.Content />
            </div>
          </div>
        </div>
      </div>
    );
  },
});
