import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import { useState, useEffect } from "@wordpress/element";
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
  edit({ attributes, setAttributes }) {
    const {
      landing_page_heading,
      landing_page_subheading,
      heading,
      subheading,
      title,
      view_more_link,
    } = attributes;
    const blockProps = useBlockProps();

    const job_published_at = new Date();
    const job_published_at_iso = job_published_at.toISOString();
    const job_published_at_formatted = job_published_at.toLocaleString();

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Information", block.textdomain)}>
            <TextareaControl
              label={__("Landing Page Heading", block.textdomain)}
              value={landing_page_heading}
              onChange={(value) =>
                setAttributes({ landing_page_heading: value })
              }
            />
            <TextareaControl
              label={__("Landing Page Subheading", block.textdomain)}
              value={landing_page_subheading}
              onChange={(value) =>
                setAttributes({ landing_page_subheading: value })
              }
            />
            <TextareaControl
              label={__("Heading", block.textdomain)}
              value={heading}
              onChange={(value) => setAttributes({ heading: value })}
            />
            <TextareaControl
              label={__("Subheading", block.textdomain)}
              value={subheading}
              onChange={(value) => setAttributes({ subheading: value })}
            />
            <TextareaControl
              label={__("Title", block.textdomain)}
              value={title}
              onChange={(value) => setAttributes({ title: value })}
            />
            <TextareaControl
              label={__("View More Link", block.textdomain)}
              value={view_more_link}
              onChange={(value) => setAttributes({ view_more_link: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-cta">
            <RichText
              tagName="h2"
              value={landing_page_heading}
              onChange={(value) =>
                setAttributes({ landing_page_heading: value })
              }
              help={__(
                "This heading will be displayed when the block is used on the landing page",
                block.textdomain
              )}
            />
            <RichText
              tagName="h4"
              value={landing_page_subheading}
              onChange={(value) =>
                setAttributes({ landing_page_subheading: value })
              }
              help={__(
                "This subheading will be displayed when the block is used on the landing page",
                block.textdomain
              )}
            />
            <RichText
              tagName="h2"
              value={heading}
              onChange={(value) => setAttributes({ heading: value })}
              help={__(
                "This heading will be displayed when the block is used in a province",
                block.textdomain
              )}
            />
            <RichText
              tagName="h4"
              value={subheading}
              onChange={(value) => setAttributes({ subheading: value })}
              help={__(
                "This subheading will be displayed when the block is used in a province",
                block.textdomain
              )}
            />
          </div>
          <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-header">
            <RichText
              tagName="h5"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
            />
            <span className="jobs-platform-link">
              {__("View more", block.textdomain)}
            </span>
          </div>
          <ul className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list">
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
            <li className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
              <div className="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                <h5>Lorem ipsum dolor sit amet</h5>
                <time datetime={job_published_at_iso}>
                  {__("Published at", block.textdomain)}{" "}
                  <span>{job_published_at_formatted}</span>
                </time>
              </div>
              <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </li>
          </ul>
        </div>
      </>
    );
  },
});
