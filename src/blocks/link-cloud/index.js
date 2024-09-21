import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  InnerBlocks,
  RichText,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  Button,
  PanelBody,
  SelectControl,
  Spinner,
  ToolbarButton,
  Dashicon,
} from "@wordpress/components";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";
import { __, _x } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, link, linkTarget, imageID, imageAlt, imageUrl } = attributes;
    const blockProps = useBlockProps({
      className: "h-full",
    });

    const [linkCloudImagePreview, setLinkCloudImagePreview] =
      useState(imageUrl);

    // select image
    const handleSelectLinkCloudImage = (img) => {
      let newImageURL = null;

      if (isBlobURL(img.url)) {
        newImageURL = img.url;
      } else {
        newImageURL = img.sizes
          ? img.sizes.teamMember.url
          : img.media_details.sizes.teamMember.source_url;

        setAttributes({
          imageID: img.id,
          imageAlt: img.alt,
          imageUrl: newImageURL,
        });

        revokeBlobURL(linkCloudImagePreview);
      }

      setLinkCloudImagePreview(newImageURL);
    };

    // select image from URL
    const handleSelectLinkCloudImageURL = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });

      setLinkCloudImagePreview(url);
    };

    return (
      <>
        {linkCloudImagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", block.textdomain)}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={[
                "image/png",
                "image/jpeg",
                "image/webp",
                "image/svg",
              ]}
              accept={"image/*"}
              onSelect={handleSelectLinkCloudImage}
              onSelectURL={handleSelectLinkCloudImageURL}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageID: 0,
                  imageAlt: "",
                  imageUrl: "",
                });
                setLinkCloudImagePreview("");
              }}
            >
              {__("Remove image", block.textdomain)}
            </ToolbarButton>
          </BlockControls>
        )}
        <InspectorControls>
          <PanelBody
            title={_x("Settings", "PanelBody label", block.textdomain)}
          >
            <TextareaControl
              label={_x("Link", "TextareaControl label", block.textdomain)}
              value={link}
              onChange={(link) => setAttributes({ link })}
              help={__("Add a custom link", block.textdomain)}
            />
            <TextControl
              label={__("Label", block.textdomain)}
              value={title}
              onChange={(title) => setAttributes({ title })}
            />
            <SelectControl
              label={__("Link target", block.textdomain)}
              value={linkTarget}
              options={[
                { label: __("Same tab", block.textdomain), value: "_self" },
                { label: __("New tab", block.textdomain), value: "_blank" },
              ]}
              onChange={(linkTarget) => setAttributes({ linkTarget })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="link-cloud flex flex-col items-center">
            <div className="flex-1">
              <div className="flex items-center justify-center">
                {/* https://mt.gob.do/images/svg/logos/311.svg */}
                {linkCloudImagePreview && (
                  <img
                    className="link-cloud-image w-full rounded-full shadow-lg"
                    src={linkCloudImagePreview}
                    alt={imageAlt}
                  />
                )}
                {isBlobURL(imageUrl) && <Spinner />}
                <div className="media-placeholder">
                  <MediaPlaceholder
                    allowedTypes={["image/png", "image/jpeg", "image/webp"]}
                    accept={"image/*"}
                    icon="format-image"
                    onSelect={handleSelectLinkCloudImage}
                    onError={(e) => {
                      console.log(e);
                    }}
                    disableMediaButtons={imageUrl}
                    onSelectURL={handleSelectLinkCloudImageURL}
                  />
                </div>
              </div>
              <div className="mt-4 text-center">
                <RichText
                  tagName="h5"
                  placeholder={_x(
                    "Add a custom title",
                    "RichText label",
                    block.textdomain
                  )}
                  className="mb-1 text-sm color-blue"
                  value={title}
                  onChange={(title) => setAttributes({ title })}
                />
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const { title, link, linkTarget, imageID, imageAlt, imageUrl } = attributes;
    const blockProps = useBlockProps.save({
      className: "h-full",
    });

    return (
      <div {...blockProps}>
        <a
          href={link}
          target={link == "#" ? "_self" : "_blank"}
          aria-label={title}
        >
          <div className="link-cloud flex flex-col items-center">
            <div className="flex-1">
              <div className="flex items-center justify-center py-2">
                {imageUrl && (
                  <img
                    className="link-cloud-image w-full rounded-full shadow-lg"
                    src={imageUrl}
                    alt={imageAlt}
                  />
                )}
              </div>
              <div className="mt-4 text-center">
                <RichText.Content
                  tagName="h5"
                  className="mb-1 text-sm color-blue"
                  value={title}
                />
              </div>
            </div>
          </div>
        </a>
      </div>
    );
  },
});
