import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __, _x } from "@wordpress/i18n";
import {
  PanelBody,
  TextareaControl,
  ToggleControl,
  SelectControl,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { title, use_page_title, pageId } = attributes;
    const blockProps = useBlockProps();

    const pages = useSelect((select) => {
      return select("core").getEntityRecords("postType", "page", {
        per_page: -1,
        orderby: "title",
        order: "asc",
      });
    }, []);
    console.log("Pages: ", pages);

    console.log("pageId: ", pageId);

    const pagesObject = {};

    const pageOptions = [];
    if (!!pages) {
      Object.values(pages).forEach((page) => {
        pageOptions.push({
          value: page?.id,
          label: page?.title?.rendered,
        });
      });
    }

    const handleChangeTitle = (value) => {
      setAttributes({ title: value });
    };

    const handleSelectPage = (value) => {
      setAttributes({ pageId: parseInt(value) });
    };

    const handleToggleUsePageTitle = () => {
      setAttributes({ use_page_title: !use_page_title });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            {use_page_title && (
              <TextareaControl
                label={__("Title", block.textdomain)}
                value={title}
                onChange={handleChangeTitle}
              />
            )}
            <SelectControl
              label={__("Add a link to a page", block.textdomain)}
              value={pageId}
              options={[
                { label: __("None", block.textdomain), value: 0 },
                ...pageOptions,
              ]}
              onChange={handleSelectPage}
            />
            <ToggleControl
              label={__("Use page title", block.textdomain)}
              checked={use_page_title}
              onChange={handleToggleUsePageTitle}
            />
          </PanelBody>
        </InspectorControls>

        <li {...blockProps}>
          <i className="bi bi-check-lg"></i>
          <span>
            {use_page_title && pageId && pages ? (
              <RichText.Content
                tagName="p"
                value={
                  pages?.find((page) => page.id === pageId)?.title.rendered
                }
              />
            ) : (
              <RichText
                tagName="p"
                placeholder={__(
                  "Click here to add custom text or select a page from the side menu and activate the use page title option.",
                  block.textdomain
                )}
                value={title}
                onChange={handleChangeTitle}
              />
            )}
            {pageId > 0 && (
              <a href={pages?.find((page) => page.id === pageId)?.link}>
                {__("Read More", block.textdomain)}
              </a>
            )}
          </span>
        </li>
      </>
    );
  },
});
