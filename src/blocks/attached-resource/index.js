import block from "./block.json";
import icons from "../../icons.js";
import mimeToIconMap from "../../mimeToIconMap.js";
import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  PanelColorSettings,
  MediaPlaceholder,
  BlockControls,
  MediaReplaceFlow,
} from "@wordpress/block-editor";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  PanelBody,
  Spinner,
  ToolbarButton,
  TextControl,
  TextareaControl,
  SelectControl,
} from "@wordpress/components";
import { isBlobURL, revokeBlobURL } from "@wordpress/blob";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const {
      fileID,
      fileUrl,
      fileSize,
      fileName,
      fileMime,
      fileSubtype,
      fileDate,
      renderOption,
      title,
      downloadBtnBgColor,
      downloadBtnBorderColor,
      downloadBtnTextColor,
      downloadBtnText,
    } = attributes;
    const { postId } = context;
    const blockProps = useBlockProps({
      className: `${renderOption}`,
    });

    // Load plugin directory to load assets, ex.: images
    const { pluginDirectoryUri } = pluginPublicScripts;

    const ALLOWED_TYPES = [
      "application/pdf",
      "application/vnd.ms-powerpoint",
      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
      "text/plain",
      "application/vnd.ms-excel",
      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      "text/csv",
      "application/msword",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "audio/mpeg",
      "video/mp4",
      "video/mpeg",
      "application/vnd.oasis.opendocument.spreadsheet",
      "application/vnd.oasis.opendocument.text",
      "image/jpeg",
      "image/png",
      "image/gif",
      "image/webp",
      "image/svg+xml",
    ];

    const handleOnSelect = (media) => {
      console.log("Attached Resource: ", media);

      // let newMediaURL = null;
      let newMediaURL = media.url;

      // if (isBlobURL(media.url)) {
      //   newMediaURL = media.url;
      // } else {
      //   newMediaURL = media.url;
      // }

      setAttributes({
        fileID: media?.id,
        fileUrl: media?.url,
        fileSize: media?.filesizeHumanReadable,
        fileName: media?.filename,
        fileMime:
          mimeToIconMap[media?.mime_type] ||
          mimeToIconMap[media?.mime] ||
          "file",
        fileSubtype: media?.subtype,
        fileDate: media?.dateFormatted,
      });
    };

    const handleOnSelectURL = (url) => {
      console.log("URL: ", url);

      setAttributes({
        fileID: null,
        fileUrl: url,
        fileSize: null,
        fileName: null,
        fileMime: "file",
        fileSubtype: null,
        fileDate: null,
      });
    };

    return (
      <>
        {fileUrl && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace", block.textdomain)}
              mediaId={fileID}
              newMediaURL={fileUrl}
              allowedTypes={ALLOWED_TYPES}
              accept={"application/*, text/*, audio/*, video/*, image/*"}
              onSelect={handleOnSelect}
              onSelectURL={handleOnSelectURL}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  fileID: 0,
                  fileUrl: "",
                  fileSize: "",
                  fileName: "",
                  fileMime: "",
                  fileSubtype: "",
                  fileDate: "",
                });
              }}
            >
              {__("Remove", block.textdomain)}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelColorSettings
            title={__("Download Button", block.textdomain)}
            colorSettings={[
              {
                label: __("Background Color", block.textdomain),
                value: downloadBtnBgColor,
                onChange: (downloadBtnBgColor) =>
                  setAttributes({ downloadBtnBgColor }),
              },
              {
                label: __("Text Color", block.textdomain),
                value: downloadBtnTextColor,
                onChange: (downloadBtnTextColor) =>
                  setAttributes({ downloadBtnTextColor }),
              },
              {
                label: __("Border Color", block.textdomain),
                value: downloadBtnBorderColor,
                onChange: (downloadBtnBorderColor) =>
                  setAttributes({ downloadBtnBorderColor }),
              },
            ]}
          />
          <PanelBody title={__("Show", block.textdomain)}>
            <TextareaControl
              label={__("Title", block.textdomain)}
              value={title}
              onChange={(title) => setAttributes({ title })}
            />
            <SelectControl
              label={__("Display options", block.textdomain)}
              value={renderOption}
              options={[
                { label: __("Button", block.textdomain), value: "button" },
                { label: __("File", block.textdomain), value: "file" },
                { label: __("Link", block.textdomain), value: "link" },
              ]}
              onChange={(renderOption) => setAttributes({ renderOption })}
            />
            <TextControl
              label={__("Link label", block.textdomain)}
              value={downloadBtnText}
              onChange={(downloadBtnText) => setAttributes({ downloadBtnText })}
              help={__("Button text", block.textdomain)}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <MediaPlaceholder
            allowedTypes={ALLOWED_TYPES}
            accept={"application/*, text/*, audio/*, video/*, image/*"}
            icon="upload"
            onSelect={handleOnSelect}
            onError={(e) => {
              console.error(e);
            }}
            disableMediaButtons={fileUrl}
            onSelectURL={handleOnSelectURL}
          />
          {renderOption === "button" && (
            <a
              href={fileUrl}
              className="attached-resource-download-option inline-block py-4 px-8 gap-4 relative"
              style={{
                color: `${downloadBtnTextColor}`,
                backgroundColor: `${downloadBtnBgColor}`,
              }}
            >
              <i className="bi bi-download mr-2"></i> {downloadBtnText}
            </a>
          )}
          {renderOption === "file" && (
            <>
              {/* <i className={`bi bi-filetype-${fileMime}`}></i> */}
              <div>
                <img
                  src={`${pluginDirectoryUri}dist/public/images/${fileMime}.svg`}
                  alt={title}
                />
                <div>
                  <span>{title}</span>
                  <div className="file-meta divide-x">
                    <span className="px-2">{fileSize}</span>
                  </div>
                </div>
              </div>
              <a href={fileUrl}>
                <i className="bi bi-download mr-2"></i> {downloadBtnText}
              </a>
            </>
          )}
          {renderOption === "link" && (
            <a href={fileUrl}>
              <span>{title}</span>
            </a>
          )}
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      fileID,
      fileUrl,
      fileSize,
      fileName,
      fileMime,
      fileSubtype,
      fileDate,
      renderOption,
      title,
      downloadBtnBgColor,
      downloadBtnBorderColor,
      downloadBtnTextColor,
      downloadBtnText,
    } = attributes;
    const blockProps = useBlockProps.save({
      className: `${renderOption}`,
    });

    const { pluginDirectoryUri } = pluginPublicScripts;

    // const [showInfo, setShowInfo] = useState(false);

    // const handleOnMouseEnter = () => setShowInfo(true);

    // const handleOnMouseLeave = () => setShowInfo(false);

    return (
      <div {...blockProps}>
        {renderOption === "button" && (
          <a
            href={fileUrl}
            className="attached-resource-download-option inline-block py-4 px-8 gap-4 relative"
            style={{
              color: `${downloadBtnTextColor}`,
              backgroundColor: `${downloadBtnBgColor}`,
            }}
            target="_blank"
            role="link"
          >
            <i className="bi bi-download mr-2"></i> {downloadBtnText}
          </a>
        )}
        {renderOption === "file" && (
          <>
            {/* <i className={`bi bi-filetype-${fileMime}`}></i> */}

            <div>
              <img
                src={`${pluginDirectoryUri}dist/public/images/${fileMime}.svg`}
                alt={title}
              />

              <div>
                <span>{title}</span>
                <div className="file-meta divide-x">
                  <span className="px-2">{fileSize}</span>
                </div>
              </div>
            </div>
            <a href={fileUrl} target="_blank" role="link">
              <i className="bi bi-download mr-2"></i>
              {downloadBtnText}
            </a>
          </>
        )}
        {renderOption === "link" && (
          <a href={fileUrl} target="_blank" role="link">
            <span>{title}</span>
          </a>
        )}
      </div>
    );
  },
});
