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
  Tooltip,
  Icon,
  TextControl,
  Button,
} from "@wordpress/components";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";
import Sidebar from "../../components/sidebar/index.js";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context, isSelected }) {
    const {
      name,
      title,
      bio,
      imageID,
      imageAlt,
      imageUrl,
      files_title,
      files,
      socialHandles,
      imageShape,
    } = attributes;
    const blockProps = useBlockProps({
      className: "max-w-xs",
    });
    const [showInfo, setShowInfo] = useState(false);
    const [teamMemberImagePreview, setTeamMemberImagePreview] = useState(imageUrl);
    const [activeSocialLink, setActiveSocialLink] = useState(null);

    // Select Image
    const handleSelectTeamMemberImage = (img) => {
      // console.log(img);

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

        revokeBlobURL(teamMemberImagePreview);
      }

      setTeamMemberImagePreview(newImageURL);
    };

    // select image from URL
    const handleSelectTeamMemberImageUrl = (url) => {
      setAttributes({
        imageID: null,
        imageAlt: null,
        imageUrl: url,
      });

      setTeamMemberImagePreview(url);
    };

    const handleShowInfo = (event) => {
      console.log(event);
      setShowInfo(!showInfo);
    };

    

    const imageClass = `wp-image-${imageID} img-${context["nortic-plugin/grid-list-image-shape"]} mx-auto mb-4 w-36 h-36`;

    

    setAttributes({
      imageShape: context["nortic-plugin/grid-list-image-shape"],
    });

    return (
      <>
        {teamMemberImagePreview && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace image", block.textdomain)}
              mediaId={imageID}
              mediaURL={imageUrl}
              allowedTypes={["image/png", "image/jpeg", "image/webp"]}
              accept={"image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleSelectTeamMemberImage}
              onSelectURL={handleSelectTeamMemberImageUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({ imageID: 0, imageAlt: "", imageUrl: "" });
                setTeamMemberImagePreview("");
              }}
            >
              {__("Remove image", block.textdomain)}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            {teamMemberImagePreview && !isBlobURL(teamMemberImagePreview) && (
              <TextareaControl
                label={__("Image Alt Attribute", "nortic-plugin")}
                value={imageAlt}
                onChange={(imageAlt) => setAttributes({ imageAlt })}
                help={__(
                  "Image description for screen readers",
                  "nortic-plugin"
                )}
              />
            )}
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="file-options flex justify-between items-center px-4 pt-4">
            <button
              className="inline-block text-gray-500  focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-2xl p-1.5"
              onClick={handleShowInfo}
            >
              <span className="sr-only">
                {__("Show info", "nortic-plugin")}
              </span>
              <i class="bi bi-info-circle"></i>
            </button>
          </div>
          <div className="text-center text-gray-500 dark:text-gray-400 team-member-meta">
            {teamMemberImagePreview && (
              <img
                className={imageClass}
                src={teamMemberImagePreview}
                alt={imageAlt}
              />
            )}
            {/* Spinner */}
            {isBlobURL(imageUrl) && <Spinner />}
            <div className="media-placeholder">
              <MediaPlaceholder
                allowedTypes={["image/png", "image/jpeg", "image/webp"]}
                accept={"image/*"}
                icon="admin-users"
                onSelect={handleSelectTeamMemberImage}
                // onSelect={(img) => {
                //   setAttributes({
                //     imageID: img.id,
                //     imageAlt: img.alt,
                //     imageUrl: img.media_details.sizes.teamMember.source_url,
                //   });
                // }}
                onError={(e) => {
                  console.error(e);
                }}
                disableMediaButtons={imageUrl}
                onSelectURL={handleSelectTeamMemberImageUrl}
              />
            </div>

            <RichText
              tagName="h4"
              className="mb-1 font-bold tracking-tight text-gray-900 dark:text-white"
              placeholder={__("Name", "nortic-plugin")}
              onChange={(name) => setAttributes({ name })}
              value={name}
            />

            <RichText
              tagName="span"
              placeholder={__("Title", "nortic-plugin")}
              onChange={(title) => setAttributes({ title })}
              value={title}
            />
            <RichText
              tagName="p"
              placeholder={__("Biography", "nortic-plugin")}
              onChange={(bio) => setAttributes({ bio })}
              value={bio}
            />
            <div className="flex justify-center mt-4 space-x-4 social-media-links">
              {socialHandles.map((handle, index) => {
                return (
                  <a
                    href={handle.url}
                    key={index}
                    target="_blank"
                    onClick={(event) => {
                      event.preventDefault();
                      setActiveSocialLink(
                        activeSocialLink === index ? null : index
                      );
                    }}
                    className={
                      activeSocialLink === index && isSelected
                        ? "is-active"
                        : ""
                    }
                  >
                    <i className={`bi bi-${handle.icon}`}></i>
                  </a>
                );
              })}
              {isSelected && (
                <Tooltip text={__("Add Social Media Link", "nortic-plugin")}>
                  <a
                    href="#"
                    onClick={(event) => {
                      event.preventDefault();
                      setAttributes({
                        socialHandles: [
                          ...socialHandles,
                          {
                            icon: "question",
                            url: "",
                          },
                        ],
                      });

                      setActiveSocialLink(socialHandles.length);
                    }}
                  >
                    <Icon icon="plus" />
                  </a>
                </Tooltip>
              )}
            </div>
            {isSelected && activeSocialLink !== null && (
              <div className="team-member-social-edit-ctr">
                <TextControl
                  label={__("URL", "nortic-plugin")}
                  value={socialHandles[activeSocialLink].url}
                  onChange={(url) => {
                    const tempLink = { ...socialHandles[activeSocialLink] };
                    const tempSocial = [...socialHandles];

                    tempLink.url = url;
                    tempSocial[activeSocialLink] = tempLink;

                    setAttributes({ socialHandles: tempSocial });
                  }}
                />
                <TextControl
                  label={__("Icon", "nortic-plugin")}
                  value={socialHandles[activeSocialLink].icon}
                  onChange={(icon) => {
                    const tempLink = { ...socialHandles[activeSocialLink] };
                    const tempSocial = [...socialHandles];

                    tempLink.icon = icon;
                    tempSocial[activeSocialLink] = tempLink;

                    setAttributes({ socialHandles: tempSocial });
                  }}
                />
                <Button
                  isDestructive
                  onClick={() => {
                    const tempCopy = [...socialHandles];
                    tempCopy.splice(activeSocialLink, 1);

                    setAttributes({ socialHandles: tempCopy });
                    setActiveSocialLink(null);
                  }}
                >
                  {__("Remove", "nortic-plugin")}
                </Button>
              </div>
            )}
          </div>
        </div>
        <Sidebar show={showInfo} />
      </>
    );
  },
  save({ attributes }) {
    const {
      name,
      title,
      bio,
      imageID,
      imageAlt,
      imageUrl,
      files_title,
      files,
      socialHandles,
      imageShape,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: "max-w-xs",
    });

    const imageClass = `wp-image-${imageID} img-${imageShape} mx-auto mb-4 w-36 h-36`;

    return (
      <div {...blockProps}>
        <div className="text-center text-gray-500 dark:text-gray-400 team-member-meta">
          {imageUrl && (
            <img className={imageClass} src={imageUrl} alt={imageAlt} />
          )}

          <RichText.Content
            tagName="h4"
            className="mb-1 font-bold tracking-tight text-gray-900 dark:text-white"
            value={name}
          />

          <RichText.Content tagName="span" value={title} />
          <RichText.Content tagName="p" value={bio} />
          <div className="flex justify-center mt-4 space-x-4 social-media-links">
            {socialHandles.map((handle) => {
              return (
                <a href={handle.url} target="_blank" data-icon={handle.icon}>
                  <i className={`bi bi-${handle.icon}`}></i>
                </a>
              );
            })}
          </div>
        </div>
      </div>
    );
  },
});
