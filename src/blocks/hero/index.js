import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
  MediaPlaceholder,
  PanelColorSettings,
  BlockControls,
  MediaReplaceFlow,
  AlignmentToolbar,
  store as blockEditorStore,
} from "@wordpress/block-editor";
import {
  Spinner,
  SelectControl,
  PanelBody,
  ToolbarButton,
  TextareaControl,
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
    const {
      title,
      subtitle,
      content,
      headingColor,
      textColor,
      btnText,
      btnColor,
      imageID,
      imageAlt,
      imageUrl,
      width,
      height,
      alignment,
      readMoreText,
      readMoreColor,
    } = attributes;

    // http://wordpressmt.local/wp-content/uploads/2023/03/default-scaled.jpg

    // Upload or select image from media library
    const handleHeroImageSelect = (img) => {
      // console.log(img);

      let newHeroImageURL = null;
      let newHeroImageHeight = null;

      if (isBlobURL(img.url)) {
        newHeroImageURL = img.url;
      } else {
        // console.log(img);

        if (img.sizes) {
          newHeroImageURL = img.sizes.bannerHero
            ? img.sizes.bannerHero.url
            : img.sizes.full.url;
          newHeroImageHeight = img.sizes.bannerHero
            ? img.sizes.bannerHero.height
            : img.sizes.full.height;
        } else {
          newHeroImageURL = img.media_details.sizes.bannerHero.source_url;
          newHeroImageHeight = img.media_details.sizes.bannerHero.height;
        }

        setAttributes({
          imageID: img.id,
          imageUrl: newHeroImageURL,
          height: newHeroImageHeight,
        });

        revokeBlobURL(heroImagePreview);
      }

      setHeroImagePreview(newHeroImageURL);
    };

    // Select image from URL
    const handleHeroImageSelectUrl = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });

      setHeroImagePreview(url);
    };

    // Retrieve image object
    const imageObject = useSelect(
      (select) => {
        const { getMedia } = select("core");
        return imageID ? getMedia(imageID) : null;
      },
      [imageID]
    );

    // console.log(imageObject);

    // Retrieve image sizes
    const imageSizes = useSelect((select) => {
      return select(blockEditorStore).getSettings().imageSizes;
    }, []);

    // console.log(imageSizes);

    const getImageSizeOptions = () => {
      if (!imageObject) return [];

      const options = [];
      const sizes = imageObject.media_details.sizes;
      for (const key in sizes) {
        const size = sizes[key];
        const imageSize = imageSizes.find((s) => s.slug === key);
        if (imageSize) {
          options.push({
            label: imageSize.name,
            value: size.source_url,
          });
        }
      }
      return options;
    };

    const [heroImagePreview, setHeroImagePreview] = useState(imageUrl);

    const blockProps = useBlockProps({
      className: `w-full`,
      style: {
        "background-image": `url(${heroImagePreview})`,
        "background-repeat": "no-repeat",
        width: width,
        height: height,
        "max-height": height,
        color: textColor,
      },
    });

    // handle image size select
    const handleOnChangeImageSize = (newImageURL) => {
      setAttributes({ imageUrl: newImageURL });
      setHeroImagePreview(newImageURL);
    };

    // Handle content alignment
    const handleContentAlignment = (newAlignment) => {
      setAttributes({ alignment: newAlignment });
    };

    return (
      <>
        {heroImagePreview && (
          <BlockControls group="inline">
            <AlignmentToolbar
              onChange={handleContentAlignment}
              value={alignment}
            />
            <MediaReplaceFlow
              name={__("Replace image", "nortic-plugin")}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg"]}
              accept={"image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleHeroImageSelect}
              onSelectURL={handleHeroImageSelectUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageID: 0,
                  imageAlt: "",
                  imageUrl: "",
                });

                setHeroImagePreview("");
              }}
            >
              {__("Remove image", "nortic-plugin")}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelBody title={__("Image settings", "nortic-plugin")}>
            {heroImagePreview && (
              <SelectControl
                label={__("Image size", "nortic-plugin")}
                options={getImageSizeOptions()}
                value={imageUrl}
                onChange={handleOnChangeImageSize}
              />
            )}
            {heroImagePreview && !isBlobURL(heroImagePreview) && (
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

            {/* <SelectControl
              label={__("Text align", "nortic-plugin")}
              value={alignment}
              options={[
                { label: __("Center", "nortic-plugin"), value: "center" },
                { label: __("Left", "nortic-plugin"), value: "left" },
                { label: __("Right", "nortic-plugin"), value: "right" },
              ]}
              onChange={(alignment) => setAttributes({ alignment })}
            /> */}
          </PanelBody>
          <PanelColorSettings
            title={__("Color settings", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Heading Color", "nortic-plugin"),
                value: headingColor,
                onChange: (headingColor) => setAttributes({ headingColor }),
              },
              {
                label: __("Text Color", "nortic-plugin"),
                value: textColor,
                onChange: (textColor) => setAttributes({ textColor }),
              },
              {
                label: __("Button Color", "nortic-plugin"),
                value: btnColor,
                onChange: (btnColor) => setAttributes({ btnColor }),
              },
              {
                label: __("Link Color", "nortic-plugin"),
                value: readMoreColor,
                onChange: (readMoreColor) => setAttributes({ readMoreColor }),
              },
            ]}
          />
        </InspectorControls>
        <div {...blockProps}>
          {/* Spinner */}
          {isBlobURL(imageUrl) && <Spinner />}
          <div className="media-placeholder">
            <MediaPlaceholder
              allowedTypes={["image/png", "image/jpeg"]}
              accept={"image/*"}
              icon="format-image"
              onSelect={handleHeroImageSelect}
              onError={(e) => console.error(e)}
              disableMediaButtons={imageUrl}
              onSelectURL={handleHeroImageSelectUrl}
            />
          </div>

          {/* <img src={imageUrl} style={{ position: 'relative', margin: '0 auto'}} /> */}

          <div className="relative isolate px-6 lg:px-8">
            <div
              className="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
              aria-hidden="true"
            ></div>
            <div
              className={
                alignment == "center"
                  ? "container mx-auto max-w-3xl py-16"
                  : "container py-16"
              }
            >
              <div
                className={
                  alignment == "center"
                    ? `text-${alignment}`
                    : `text-${alignment} float-${alignment}`
                }
              >
                <RichText
                  tagName="h1"
                  placeholder={__("Click to add a title", "nortic-plugin")}
                  value={title}
                  onChange={(title) => setAttributes({ title })}
                  className="text-4xl font-bold tracking-tight sm:text-6xl max-w-3xl"
                  style={{
                    color: headingColor,
                  }}
                  allowedFormats={["core/bold", "core/italic", "core/link"]}
                />
                <RichText
                  tagName="h2"
                  placeholder={__("Click to add a subtitle", "nortic-plugin")}
                  value={subtitle}
                  onChange={(subtitle) => setAttributes({ subtitle })}
                  className="text-2xl font-semibold max-w-3xl"
                  style={{
                    color: headingColor,
                  }}
                  allowedFormats={["core/bold", "core/italic"]}
                />
                <RichText
                  tagName="p"
                  placeholder="Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua."
                  value={content}
                  onChange={(content) => setAttributes({ content })}
                  className="mt-6 text-lg leading-8 max-w-3xl"
                  style={{
                    color: textColor,
                  }}
                />
                <div
                  className="mt-10 flex items-center gap-x-6"
                  style={{ "justify-content": alignment }}
                >
                  {/* <a
                    href="#"
                    className="rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    style={{ "background-color": btnColor }}
                  >
                    Get started
                  </a> */}
                  <RichText
                    tagName="span"
                    className="rounded-md px-6 py-4 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    style={{ "background-color": btnColor, color: textColor }}
                    placeholder={__("Edit Text", "nortic-plugin")}
                    value={btnText}
                    onChange={(btnText) => setAttributes({ btnText })}
                    allowedFormats={["core/link"]}
                  />
                  <RichText
                    tagName="span"
                    className="text-sm font-semibold leading-6"
                    style={{ color: readMoreColor }}
                    placeholder={__("Add link", "nortic-plugin")}
                    value={readMoreText}
                    onChange={(readMoreText) => setAttributes({ readMoreText })}
                    allowedFormats={["core/link"]}
                  />
                </div>
              </div>
            </div>
            <div
              className="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
              aria-hidden="true"
            >
              {/* <div
                  className="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                  style={{
                    clipPath:
                      "polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)",
                  }}
                ></div> */}
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      subtitle,
      content,
      headingColor,
      textColor,
      btnText,
      btnColor,
      imageID,
      imageAlt,
      imageUrl,
      width,
      height,
      alignment,
      readMoreText,
      readMoreColor,
    } = attributes;

    const blockProps = useBlockProps.save({
      className: "w-full",
      style: {
        "background-image": `url(${imageUrl})`,
        "background-repeat": "no-repeat",
        width: width,
        height: height,
        "max-height": height,
        color: textColor,
      },
    });

    return (
      <div {...blockProps}>
        <div className="relative isolate px-6 lg:px-8">
          <div
            className="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
            aria-hidden="true"
          ></div>
          <div
            className={
              alignment == "center"
                ? "container mx-auto max-w-3xl py-16"
                : "container py-16"
            }
          >
            <div
              className={
                alignment == "center"
                  ? `text-${alignment}`
                  : `text-${alignment} float-${alignment}`
              }
            >
              <RichText.Content
                tagName="h1"
                value={title}
                className="text-4xl font-bold tracking-tight sm:text-6xl max-w-3xl"
                style={{
                  color: headingColor,
                }}
              />
              <RichText.Content
                tagName="h2"
                value={subtitle}
                className="text-2xl font-semibold max-w-3xl"
                style={{
                  color: headingColor,
                }}
              />
              <RichText.Content
                tagName="p"
                value={content}
                className="mt-6 text-lg leading-8 max-w-3xl"
                style={{
                  color: textColor,
                }}
              />
              <div
                className="mt-10 flex items-center gap-x-6"
                style={{ "justify-content": alignment }}
              >
                {/* <a
                  href="#"
                  className="rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                  style={{ "background-color": btnColor }}
                >
                  Get started
                </a> */}
                {btnText && (
                  <RichText.Content
                    tagName="span"
                    className="rounded-md px-6 py-4 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    style={{ "background-color": btnColor, color: textColor }}
                    value={btnText}
                  />
                )}
                {readMoreText && (
                  <RichText.Content
                    tagName="span"
                    className="text-sm font-semibold leading-6"
                    style={{ color: readMoreColor }}
                    value={readMoreText}
                  />
                )}
              </div>
            </div>
          </div>
          <div
            className="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
            aria-hidden="true"
          ></div>
        </div>
      </div>
    );
  },
});
