import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import {
  TextControl,
  TextareaControl,
  ToggleControl,
  PanelBody,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { title, use_default_title, show_featured_image } = attributes;
    const { postId } = context;
    const blockProps = useBlockProps();
    const { full_name, job_title } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={__("Show the title", block.textdomain)}
              checked={use_default_title}
              onChange={(use_default_title) =>
                setAttributes({ use_default_title })
              }
              help={
                use_default_title
                  ? __("Showing the post title", block.textdomain)
                  : __("Do not show the post title", block.textdomain)
              }
            />
            <ToggleControl
              label={__("Show featured image", block.textdomain)}
              checked={show_featured_image}
              onChange={(show_featured_image) =>
                setAttributes({ show_featured_image })
              }
              help={
                show_featured_image
                  ? __("Showing featured image", block.textdomain)
                  : __("Do not show the featured image", block.textdomain)
              }
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <TextControl
            label={__("Full Name", block.textdomain)}
            value={full_name}
            onChange={(full_name) =>
              editPost({
                meta: {
                  full_name,
                },
              })
            }
            help={__("Member full name.", block.textdomain)}
          />
          <div className="flex items-start gap-4">
            <TextControl
              label={__("Job Title", block.textdomain)}
              className="w-full"
              value={job_title}
              onChange={(job_title) =>
                editPost({
                  meta: {
                    job_title,
                  },
                })
              }
              help={__("Member job title", block.textdomain)}
            />
          </div>
        </div>
      </>
    );
  },
});
