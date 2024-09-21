import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import {
  TextControl,
  ToggleControl,
  PanelBody,
  Card,
  CardHeader,
  CardBody,
  CardFooter,
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
    const blockProps = useBlockProps({
      className: "mb-12 mt-8",
    });

    // plugin public url
    const { pluginDirectoryUri } = pluginPublicScripts;

    const { reponsible_member_id } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });
    // console.log("responsible_member_id", reponsible_member_id);

    const { editPost } = useDispatch("core/editor");

    const teamMember = useSelect(
      (select) => {
        const query = {
          _embed: true,
          include: reponsible_member_id, // consulta el post por su ID
        };
        return select("core").getEntityRecords("postType", "team", query);
      },
      [reponsible_member_id]
    );

    // console.log("teamMember", teamMember);

    if (
      reponsible_member_id === undefined ||
      reponsible_member_id == 0 ||
      !teamMember
    ) {
      return (
        <div
          className="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4"
          role="alert"
        >
          <p className="font-bold">{__("Warning", block.textdomain)}</p>
          <p>
            {__(
              "This post type does not have a meta reponsible_member_id field or the dependency has not been assigned yet.",
              block.textdomain
            )}
          </p>
        </div>
      );
    } else {
      return (
        <>
          <InspectorControls>
            <PanelBody title={__("Settings", "nortic-plugin")}>
              <ToggleControl
                label={__("Show default title", "nortic-plugin")}
                checked={use_default_title}
                onChange={(use_default_title) =>
                  setAttributes({ use_default_title })
                }
                help={
                  use_default_title
                    ? __("Showing title by default", "nortic-plugin")
                    : __("Add a custom title", "nortic-plugin")
                }
              />
            </PanelBody>
          </InspectorControls>

          <div {...blockProps}>
            {use_default_title ? (
              <h5>{__("Responsible member", block.textdomain)}</h5>
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
            <div className="dependency-responsible-member-wrapper">
              {teamMember?.length > 0 &&
                teamMember?.map((member) => {
                  const teamMemberPosition = member.title?.rendered;
                  const teamMemberName = member.meta?.full_name;
                  const teamMemberJobTitle = member.meta?.job_title;
                  const teamMemberImageUrl = member._embedded[
                    "wp:featuredmedia"
                  ]
                    ? member._embedded["wp:featuredmedia"]?.[0]?.source_url
                    : pluginDirectoryUri + "dist/public/images/avatar.svg";

                  return (
                    <>
                      <div className="dependency-responsible-member-avatar-wrapper">
                        <img
                          src={teamMemberImageUrl}
                          alt={teamMemberPosition}
                          className="dependency-responsible-member-avatar"
                        />
                      </div>
                      <div className="dependency-responsible-member-meta">
                        <h6 className="dependency-responsible-member-name">
                          {teamMemberName}
                        </h6>
                        <span className="dependency-responsible-member-position">
                          {teamMemberPosition}
                        </span>
                      </div>
                    </>
                  );
                })}
            </div>
          </div>
        </>
      );
    }
  },
});
