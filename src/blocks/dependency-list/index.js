import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { title, use_default_title } = attributes;
    const { postId } = context;
    console.log("postId", postId);
    const blockProps = useBlockProps();
    const currentPostType = useSelect(
      (select) => select("core/editor").getCurrentPostType(),
      [postId]
    );
    console.log("currentPostType", currentPostType);

    if (currentPostType !== "dependency") {
      return (
        <div {...blockProps}>
          <p>
            {__(
              "This block can only be used in Dependency post types.",
              block.textdomain
            )}
          </p>
        </div>
      );
    }

    const dependencies = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "dependency", {
          _embed: true,
          meta_key: "parent_dependency_id",
          meta_value: postId,
        });
      },
      [postId]
    );

    console.log("Dependencies", dependencies);

    if (!dependencies) {
      return (
        <div {...blockProps}>
          <Spinner />
        </div>
      );
    }

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={__("Show default title", block.textdomain)}
              checked={use_default_title}
              onChange={(value) => setAttributes({ use_default_title: value })}
              help={
                use_default_title
                  ? __("Showing title by default", "nortic-plugin")
                  : __("Add a custom title", "nortic-plugin")
              }
            />
            {!use_default_title && (
              <TextareaControl
                label={__("Title", block.textdomain)}
                value={title}
                onChange={(value) => setAttributes({ title: value })}
              />
            )}
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {use_default_title ? (
            <h5>{__("Dependencies", block.textdomain)}</h5>
          ) : (
            <RichText
              tagName="h5"
              placeholder={__("Click to add a title", block.textdomain)}
              value={title}
              onChange={(title) => setAttributes({ title })}
              allowedFormats={[
                "core/bold",
                "core/italic",
                "core/link",
                "core/text-color",
              ]}
            />
          )}
          <ul>
            {dependencies?.length > 0 &&
              dependencies?.map((dependency) => {
                console.log(dependency);
                const dependencyTitle = dependency?.title?.rendered;
                return (
                  <li key={dependency.id}>
                    <span className="title">{dependencyTitle}</span>
                    <span>phone</span>
                  </li>
                );
              })}
          </ul>
        </div>
      </>
    );
  },
  save() {
    return null;
  },
});
