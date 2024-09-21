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
      className: `max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-between`,
      style: {
        color: textColor,
        backgroundColor: bgColor,
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
              <div className="service-card-image-wrapper text-center h-24">
                <Dashicon icon={icon} style={{ color: "#ee2a24" }} />
              </div>
            ) : (
              <div className="service-card-image-wrapper text-center h-24">
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
            <RichText
              tagName="h5"
              className="mb-2 text-2xl font-semibold tracking-tight"
              placeholder={__("Click to add a title", block.textdomain)}
              value={title}
              onChange={(title) => setAttributes({ title })}
              allowedFormats={["core/bold", "core/link", "core/text-color"]}
            />
            <RichText
              tagName="p"
              className="mb-3 font-normal"
              placeholder={__("Click to add a description", block.textdomain)}
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
            {/* <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                            Ver más
                            <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                            </svg>
                        </a> */}
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
      className: `glide__slide max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-between`,
      style: {
        color: textColor,
        backgroundColor: bgColor,
      },
    });

    return (
      <div {...blockProps}>
        <div className="text-center flex flex-col justify-between gap-4">
          {useIcon ? (
            <div className="service-card-image-wrapper text-center h-24">
              <Dashicon icon={icon} style={{ color: "#ee2a24" }} />
            </div>
          ) : (
            <div className="service-card-image-wrapper text-center h-24">
              <img
                src={imageUrl}
                alt={imageAlt}
                className="h-full object-contain"
              />
            </div>
          )}
          <RichText.Content
            tagName="h5"
            className="mb-2 text-2xl font-semibold tracking-tight"
            value={title}
          />
          <RichText.Content
            tagName="p"
            className="mb-3 font-normal"
            value={description}
          />
        </div>
        <div className="flex items-center justify-center">
          <InnerBlocks.Content />
          {/* <a href="#" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                        Ver más
                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                        </svg>
                    </a> */}
        </div>
      </div>
    );
  },
});
