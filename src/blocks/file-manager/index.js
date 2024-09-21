import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  PanelColorSettings,
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
      title,
      description,
      fileID,
      fileUrl,
      fileSize,
      fileImageUrl,
      downloadBtnColor,
      downloadBtnBorderColor,
      downloadBtnTextColor,
      viewBtnColor,
      viewBtnBorderColor,
      viewBtnTextColor,
    } = attributes;
    const blockProps = useBlockProps({
      className:
        "w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700",
    });

    // Load plugin directory to load assets, ex.: images
    const { pluginDirectoryUri } = pluginPublicScripts;

    // console.log(pluginDirectoryUri);

    // Upload or select file from media library
    const handleFileSelect = (file) => {
      // console.log(file);

      let newFileURL = null;
      let formattedFileSize = null;
      let newFileImageURL = null;

      if (isBlobURL(file.url)) {
        newFileURL = file.url;
      } else {
        newFileURL = file.url;

        newFileImageURL = setFileImageUrl(file.mime_type);

        formattedFileSize = formatBytes(file.media_details.filesize);

        setAttributes({
          fileID: file.id,
          fileSize: formattedFileSize,
          fileImageUrl: newFileImageURL,
          fileUrl: newFileURL,
        });

        revokeBlobURL(fileImagePreview);
      }

      setFileImagePreview(newFileImageURL);

      //console.log(fileImagePreview);
    };

    // Select file from URL
    const handleFileSelectUrl = (url) => {
      setAttributes({
        fileID: null,
        fileUrl: url,
      });

      // TODO: obtener la extension desde la url del archivo
      // setFileImagePreview(url);
    };

    function formatBytes(bytes, decimals = 2) {
      if (!+bytes) return "0 Bytes";

      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

      const i = Math.floor(Math.log(bytes) / Math.log(k));

      return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
    }

    function setFileImageUrl(mime_type) {
      if (!mime_type) return;

      let file_mime_type = mime_type.substring(mime_type.indexOf("/") + 1);

      file_mime_type = `${pluginDirectoryUri}/dist/public/images
      /${file_mime_type}.svg`;
      return file_mime_type;
    }

    const [fileImagePreview, setFileImagePreview] = useState(fileImageUrl);

    return (
      <>
        {fileImageUrl && (
          <BlockControls group="inline">
            <MediaReplaceFlow
              name={__("Replace File", block.textdomain)}
              mediaId={fileID}
              mediaURL={fileUrl}
              allowedTypes={[
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
              ]}
              accept={"application/*, text/*, audio/*, video/*, image/*"}
              onError={(e) => console.error(e)}
              onSelect={handleFileSelect}
              onSelectURL={handleFileSelectUrl}
            />
            <ToolbarButton
              onClick={() => {
                setAttributes({
                  fileID: 0,
                  fileSize: 0,
                  fileUrl: "",
                  fileImageUrl: "",
                });

                setFileImagePreview("");
              }}
            >
              {__("Remove file", block.textdomain)}
            </ToolbarButton>
          </BlockControls>
        )}

        <InspectorControls>
          <PanelColorSettings
            title={__("Download Button", block.textdomain)}
            colorSettings={[
              {
                label: __("Background Color", block.textdomain),
                value: downloadBtnColor,
                onChange: (downloadBtnColor) =>
                  setAttributes({ downloadBtnColor }),
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
          <PanelBody title={__("Settings", block.textdomain)}>
            {fileUrl && (
              <TextareaControl
                label={__("Description", block.textdomain)}
                value={description}
                onChange={(description) => setAttributes({ description })}
                help={__("Add a File description", block.textdomain)}
              />
            )}
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="file-options flex justify-between items-center px-4 pt-4">
            <i class="bi bi-info-circle"></i>
            <button
              id="dropdownButton"
              data-dropdown-toggle="dropdown"
              className="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
              type="button"
            >
              <span className="sr-only">Open dropdown</span>
              <i class="bi bi-three-dots-vertical"></i>
              {/* <svg
                className="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
              </svg> */}
            </button>
            {/* Dropdown menu */}
            <div
              id="dropdown"
              className="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
            >
              <ul className="py-2" aria-labelledby="dropdownButton">
                <li>
                  <a
                    href="#"
                    className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                  >
                    Edit
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                  >
                    Export Data
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    className="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                  >
                    Delete
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div className="file-meta flex flex-col items-center pb-4 px-6">
            {fileUrl && (
              <img
                className="h-16 mb-6"
                src={fileImagePreview}
                alt="Bonnie image"
              />
            )}
            {/* Spinner */}
            {isBlobURL(fileUrl) && <Spinner />}
            <div className="media-placeholder">
              <MediaPlaceholder
                allowedTypes={[
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
                ]}
                accept={"application/*, text/*, audio/*, video/*, image/*"}
                // icon="media-document"
                onSelect={handleFileSelect}
                onError={(e) => {
                  console.error(e);
                }}
                disableMediaButtons={fileUrl}
                onSelectURL={handleFileSelectUrl}
              />
            </div>
            <RichText
              tagName="h5"
              className="file-name mb-1 text-xl font-semibold text-gray-900 text-center"
              placeholder={__("File Title", "nortic-plugin")}
              value={title}
              onChange={(title) => setAttributes({ title })}
            />
            <span className="text-xs text-gray-500 dark:text-gray-400">
              {fileSize}
            </span>
            <div className="flex justify-center mt-4 gap-x-2 md:mt-6">
              <a
                href={fileUrl}
                target="_blank"
                className="file-view-btn inline-flex items-center px-4 py-2 text-sm font-medium text-center border rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                style={{
                  color: viewBtnTextColor,
                  backgroundColor: viewBtnColor,
                  borderColor: viewBtnBorderColor,
                }}
              >
                {__("View", "nortic-plugin")}
              </a>
              <a
                href={fileUrl}
                download
                className="file-download-btn inline-flex items-center px-4 py-2 text-sm font-medium text-center  border rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200"
                style={{
                  color: downloadBtnTextColor,
                  backgroundColor: downloadBtnColor,
                  borderColor: downloadBtnBorderColor,
                }}
              >
                {__("Download", "nortic-plugin")}
              </a>
            </div>
          </div>
        </div>
      </>
    );
  },
  save({ attributes }) {
    const {
      title,
      description,
      fileID,
      fileUrl,
      fileSize,
      fileImageUrl,
      downloadBtnColor,
      downloadBtnBorderColor,
      downloadBtnTextColor,
      viewBtnColor,
      viewBtnBorderColor,
      viewBtnTextColor,
    } = attributes;
    const blockProps = useBlockProps.save({
      className:
        "max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700",
    });

    return (
      <div {...blockProps}>
        <div className="file-options flex justify-between items-center px-4 pt-4">
          <i class="bi bi-info-circle"></i>
          <button
            id="dropdownButton"
            data-dropdown-toggle="dropdown"
            className="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5"
            type="button"
          >
            <span className="sr-only">Open dropdown</span>
            <i class="bi bi-three-dots-vertical"></i>
          </button>
          {/* Dropdown menu */}
          <div
            id="dropdown"
            className="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
          >
            <ul className="py-2" aria-labelledby="dropdownButton">
              <li>
                <a
                  href="#"
                  className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                >
                  Edit
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                >
                  Export Data
                </a>
              </li>
              <li>
                <a
                  href="#"
                  className="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                >
                  Delete
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div className="file-meta flex flex-col items-center pb-4 px-6">
          {fileUrl && (
            <img className="h-16 mb-6" src={fileImageUrl} alt={title} />
          )}
          <RichText.Content
            tagName="h5"
            className="file-name mb-1 text-xl font-semibold text-gray-900 text-center"
            value={title}
          />
          <span className="text-xs text-gray-500 dark:text-gray-400">
            {fileSize}
          </span>
          <div className="flex justify-center mt-4 gap-x-2 md:mt-6">
            <a
              href={fileUrl}
              target="_blank"
              className="file-view-btn inline-flex items-center px-4 py-2 text-sm font-medium text-center border rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
              style={{
                color: viewBtnTextColor,
                backgroundColor: viewBtnColor,
                borderColor: viewBtnBorderColor,
              }}
            >
              {__("View", "nortic-plugin")}
            </a>
            <a
              href={fileUrl}
              download
              className="file-download-btn inline-flex items-center px-4 py-2 text-sm font-medium text-center  border rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200"
              style={{
                color: downloadBtnTextColor,
                backgroundColor: downloadBtnColor,
                borderColor: downloadBtnBorderColor,
              }}
            >
              {__("Download", "nortic-plugin")}
            </a>
          </div>
        </div>
      </div>
    );
  },
});
