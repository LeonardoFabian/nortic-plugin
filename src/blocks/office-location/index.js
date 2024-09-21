import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
} from "@wordpress/block-editor";
import {
  PanelBody,
  TextareaControl,
  Spinner,
  ToolbarButton,
  SelectControl,
} from "@wordpress/components";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      name,
      address,
      phone,
      email,
      mapUrl,
      mapUrlTarget,
      mapIframe,
      imageID,
      imageAlt,
      imageUrl,
      location_manager,
      location_manager_phone,
      location_manager_email,
      readmoreLink,
      readmoreLinkTarget,
    } = attributes;
    const blockProps = useBlockProps();

    // Upload or select image from media library
    const handleLocationImageSelect = (img) => {
      // console.log(img);

      let newLocationImageURL = null;

      if (isBlobURL(img.url)) {
        newLocationImageURL = img.url;
      } else {
        newLocationImageURL = img.sizes
          ? img.sizes.horizontalMap.url
          : img.media_details.sizes.horizontalMap.source_url;

        setAttributes({
          imageID: img.id,
          imageUrl: newLocationImageURL,
        });

        revokeBlobURL(locationImagePreview);
      }

      setLocationImagePreview(newLocationImageURL);
    };

    // Select image from URL
    const handleLocationImageSelectUrl = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });

      setLocationImagePreview(url);
    };

    const [locationImagePreview, setLocationImagePreview] = useState(imageUrl);

    return (
      <>
        {locationImagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", "nortic-plugin")}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg", "image/webp"]}
              accept={"image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleLocationImageSelect}
              onSelectURL={handleLocationImageSelectUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  imageID: 0,
                  imageAlt: "",
                  imageUrl: "",
                });

                setLocationImagePreview("");
              }}
            >
              {__("Remove image", "nortic-plugin")}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <TextareaControl
              label={__("Paste link", "nortic-plugin")}
              value={mapUrl}
              onChange={(mapUrl) => setAttributes({ mapUrl })}
              help={__("Copy and paste the link to share", "nortic-plugin")}
            />
            <SelectControl
              label={__("Open the link in:", "nortic-plugin")}
              value={mapUrlTarget}
              options={[
                { label: __("Same tab", "nortic-plugin"), value: "_self" },
                { label: __("New tab", "nortic-plugin"), value: "_blank" },
              ]}
              onChange={(mapUrlTarget) => setAttributes({ mapUrlTarget })}
            />
            <TextareaControl
              label={__("Embed a map", "nortic-plugin")}
              value={mapIframe}
              onChange={(mapIframe) => setAttributes({ mapIframe })}
              help={__(
                "Copy and paste the iframe src attribute",
                "nortic-plugin"
              )}
            />
            {locationImagePreview && !isBlobURL(locationImagePreview) && (
              <TextareaControl
                label={__("Image Alt Attribute", "nortic-plugin")}
                value={imageAlt}
                onChange={(imageAlt) => setAttributes({ imageAlt })}
                help={__(
                  "Image desciption for screen readers",
                  "nortic-plugin"
                )}
              />
            )}

            <TextareaControl
              label={__("Read More Link", "nortic-plugin")}
              value={readmoreLink}
              onChange={(readmoreLink) => setAttributes({ readmoreLink })}
              help={__("Paste the read more link to share", "nortic-plugin")}
            />
            <SelectControl
              label={__("Open Read More Link in:", "nortic-plugin")}
              value={readmoreLinkTarget}
              options={[
                { label: __("Same tab", "nortic-plugin"), value: "_self" },
                { label: __("New tab", "nortic-plugin"), value: "_blank" },
              ]}
              onChange={(readmoreLinkTarget) =>
                setAttributes({ readmoreLinkTarget })
              }
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="bg-white h-72 rounded shadow-md flex text-grey-darkest office-location-meta">
            {locationImagePreview && (
              <a
                href="#"
                className="office-location-meta-img-wrap block h-full"
              >
                <div
                  className="office-location-meta-img h-full rounded-l-sm bg-cover bg-center"
                  style={{
                    backgroundImage: `url(${locationImagePreview})`,
                  }}
                ></div>
              </a>
            )}
            {/* Spinner */}
            {isBlobURL(imageUrl) && <Spinner />}
            <div className="media-placeholder">
              <MediaPlaceholder
                allowedTypes={["image/png", "image/jpeg", "image/webp"]}
                accept={"image/*"}
                icon="location-alt"
                onSelect={handleLocationImageSelect}
                onError={(e) => console.error(e)}
                disableMediaButtons={imageUrl}
                onSelectURL={handleLocationImageSelectUrl}
              />
            </div>
            {/* <img
              className="w-1/2 h-full rounded-l-sm"
              src="http://wordpressmt.local/wp-content/uploads/2023/03/default-scaled.jpg"
              alt="Room Image"
            /> */}
            <div className="w-full flex flex-col">
              <div className="p-4 pb-0 flex-1 office-location-metadata">
                <h4 className="office-location-name">
                  <RichText
                    tagName="span"
                    placeholder={__("Location Name", "nortic-plugin")}
                    onChange={(name) => setAttributes({ name })}
                    value={name}
                    className="font-light mb-1 text-grey-darkest"
                  />
                </h4>
                <div className="text-xs flex items-center mb-4">
                  <i className="bi bi-geo-alt mr-2 text-grey-dark"></i>
                  <RichText
                    tagName="span"
                    placeholder={__("Address", "nortic-plugin")}
                    onChange={(address) => setAttributes({ address })}
                    value={address}
                  />
                </div>
                <div className="flex items-center">
                  <i className="bi bi-telephone mr-2 text-grey-dark"></i>
                  <RichText
                    tagName="span"
                    className="text-lg whitespace-nowrap"
                    placeholder={__("Phone Number", "nortic-plugin")}
                    onChange={(phone) => setAttributes({ phone })}
                    value={phone}
                  />
                </div>

                <div className="mt-2 mb-1">
                  <RichText
                    tagName="strong"
                    placeholder={__("Location Manager", "nortic-plugin")}
                    onChange={(location_manager) =>
                      setAttributes({ location_manager })
                    }
                    value={location_manager}
                  />
                </div>
                <div className="mt-4">
                  <div className="flex items-center mb-1">
                    <i className="bi bi-phone text-green mr-3"></i>
                    <RichText
                      tagName="span"
                      className="text-xs whitespace-nowrap"
                      placeholder={__("Manager Phone", "nortic-plugin")}
                      onChange={(location_manager_phone) =>
                        setAttributes({ location_manager_phone })
                      }
                      value={location_manager_phone}
                    />
                  </div>
                  <div className="flex items-center mb-1">
                    <i className="text-grey-darker bi bi-envelope-at mr-3"></i>
                    <RichText
                      tagName="span"
                      className="text-xs whitespace-nowrap"
                      placeholder={__("Manager Email", "nortic-plugin")}
                      onChange={(location_manager_email) =>
                        setAttributes({ location_manager_email })
                      }
                      value={location_manager_email}
                    />
                  </div>
                </div>
              </div>
              <a href="#" className="mt-auto">
                <div className="p-3 flex items-center justify-between transition hover:bg-grey-light office-location-readmore-link">
                  {__("Read more", "nortic-plugin")}
                  <i className="bi bi-chevron-right"></i>
                </div>
              </a>
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      name,
      address,
      phone,
      email,
      mapUrl,
      mapUrlTarget,
      mapIframe,
      imageID,
      imageAlt,
      imageUrl,
      location_manager,
      location_manager_phone,
      location_manager_email,
      readmoreLink,
      readmoreLinkTarget,
    } = attributes;
    const blockProps = useBlockProps.save();

    return (
      <div {...blockProps}>
        <div className="bg-white h-72 rounded shadow-md flex text-grey-darkest office-location-meta">
          {imageUrl && (
            <a
              href={mapUrl ? mapUrl : "#"}
              target={mapUrlTarget}
              className="office-location-meta-img-wrap block h-full"
            >
              <div
                className="office-location-meta-img h-full rounded-l-sm bg-cover bg-center"
                style={{
                  backgroundImage: `url(${imageUrl})`,
                }}
                title={imageAlt}
              ></div>
            </a>
          )}

          {/* <img
              className="w-1/2 h-full rounded-l-sm"
              src="http://wordpressmt.local/wp-content/uploads/2023/03/default-scaled.jpg"
              alt="Room Image"
            /> */}
          <div className="w-full flex flex-col">
            <div className="p-4 pb-0 flex-1 office-location-metadata">
              <h4 className="office-location-name">
                <RichText.Content
                  tagName="span"
                  value={name}
                  className="font-light mb-1 text-grey-darkest"
                />
              </h4>
              {address && (
                <div className="text-xs flex items-center mb-4">
                  <i className="bi bi-geo-alt mr-2 text-grey-dark"></i>
                  <RichText.Content tagName="span" value={address} />
                </div>
              )}
              {phone && (
                <div className="flex items-center">
                  <i className="bi bi-telephone mr-2 text-grey-dark"></i>
                  <RichText.Content
                    tagName="span"
                    className="text-lg whitespace-nowrap"
                    barra
                    estabilizadora
                    delanterattcttcrbarrbarra
                    mazda
                    value={phone}
                  />
                </div>
              )}

              <div className="mt-2 mb-1">
                <RichText.Content tagName="strong" value={location_manager} />
              </div>
              <div className="mt-4">
                {location_manager_phone && (
                  <div className="flex items-center mb-1">
                    <i className="bi bi-phone text-green mr-3"></i>
                    <RichText.Content
                      tagName="span"
                      className="text-xs whitespace-nowrap"
                      value={location_manager_phone}
                    />
                  </div>
                )}
                {location_manager_email && (
                  <div className="flex items-center mb-1">
                    <i className="text-grey-darker bi bi-envelope-at mr-3"></i>
                    <RichText.Content
                      tagName="span"
                      className="text-xs whitespace-nowrap"
                      value={location_manager_email}
                    />
                  </div>
                )}
              </div>
            </div>
            <a
              href={readmoreLink ? readmoreLink : "#"}
              className="mt-auto"
              target={readmoreLinkTarget}
            >
              <div className="p-3 flex items-center justify-between transition hover:bg-grey-light office-location-readmore-link">
                {__("Read more", "nortic-plugin")}
                <i className="bi bi-chevron-right"></i>
              </div>
            </a>
          </div>
        </div>
      </div>
    );
  },
});
