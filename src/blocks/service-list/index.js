import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  RangeControl,
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
  SelectControl,
  RichText,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const {
      heading,
      subHeading,
      use_default_title,
      columns,
      service_tags,
      numberOfItems,
      filter_by_tags,
    } = attributes;
    const { postId } = context;
    const blockProps = useBlockProps();

    console.log("Service Tags: ", service_tags);

    let listClasses = `grid-cols-${columns}`;

    const currentPostType = useSelect(
      (select) => select("core/editor").getCurrentPostType(),
      [postId]
    );

    const serviceTagsQuery = {
      per_page: -1,
    };

    // retrieve service tags
    const serviceTags = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "service_tag",
        serviceTagsQuery
      );
    }, []);

    let serviceTagOptions = [];

    if (!!serviceTags) {
      Object.values(serviceTags).forEach((tag) => {
        serviceTagOptions.push({
          value: tag?.id,
          label: tag?.name ? tag.name : __("No title", block.textdomain),
        });
      });
    } else {
      serviceTagOptions.push({
        value: 0,
        label: __("Loading", block.textdomain),
      });
    }

    let services = {};

    if (currentPostType === "dependency") {
      // if current post type is a dependency, list dependency services
      services = useSelect(
        (select) => {
          const query = {
            per_page: numberOfItems,
            _embed: true,
            meta_key: "service_dependency_id",
            meta_value: postId,
            order: "asc",
            orderby: "title",
          };

          if (service_tags.length > 0) {
            query["service_tag"] = service_tags;
          }
          return select("core").getEntityRecords("postType", "service", query);
        },
        [postId, numberOfItems, service_tags]
      );
    } else {
      services = useSelect(
        (select) => {
          const query = {
            per_page: numberOfItems,
            _embed: true,
            order: "asc",
            orderby: "title",
          };

          if (service_tags.length > 0) {
            query["service_tag"] = service_tags;
          }
          return select("core").getEntityRecords("postType", "service", query);
        },
        [postId, numberOfItems, service_tags]
      );
    }

    if (!services) {
      return (
        <div {...blockProps}>
          <Spinner />
        </div>
      );
    }

    console.log("Services: ", services);

    const handleChangeColumns = (value) => {
      setAttributes({ columns: value });
    };

    const handleChangeHeading = (value) => {
      setAttributes({ heading: value });
    };
    const handleChangeSubHeading = (value) => {
      setAttributes({ subHeading: value });
    };

    const handleServiceTagsChange = (newTags) => {
      setAttributes({ service_tags: newTags });
    };

    const handleNumberOfItemsChange = (value) => {
      setAttributes({ numberOfItems: value });
    };

    const handleFilterByTags = (value) => {
      setAttributes({ filter_by_tags: value });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <RangeControl
              labe={__("Number of items", block.textdomain)}
              value={numberOfItems}
              onChange={handleNumberOfItemsChange}
              min={1}
              max={100}
            />
            <RangeControl
              labe={__("Columns to display", block.textdomain)}
              value={columns}
              onChange={handleChangeColumns}
              min={1}
              max={3}
            />
            <ToggleControl
              label={__("Show default heading", block.textdomain)}
              checked={use_default_title}
              onChange={(use_default_title) =>
                setAttributes({ use_default_title })
              }
              help={
                use_default_title
                  ? __("Showing title by default", block.textdomain)
                  : __("Add a custom title", block.textdomain)
              }
            />
            <ToggleControl
              label={__("Filter by Tags", block.textdomain)}
              checked={filter_by_tags}
              onChange={handleFilterByTags}
              help={
                filter_by_tags
                  ? __(
                      "Filtering and grouping services by tag",
                      block.textdomain
                    )
                  : __("Showing a list of all services", block.textdomain)
              }
            />
            {filter_by_tags && (
              <SelectControl
                label={__("Filter by tags", block.textdomain)}
                options={serviceTagOptions}
                onChange={handleServiceTagsChange}
                value={service_tags}
                multiple={true}
                __nextHasNoMarginBottom
                help={__(
                  "Ctrl + click to deselect a selection",
                  block.textdomain
                )}
              />
            )}
          </PanelBody>
          <PanelBody title={__("Information", block.textdomain)}>
            <TextareaControl
              label={__("Heading", block.textdomain)}
              value={heading}
              onChange={handleChangeHeading}
            />
            <TextareaControl
              label={__("Subheading", block.textdomain)}
              value={subHeading}
              onChange={handleChangeSubHeading}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {use_default_title ? (
            <h5 className="service-list-heading">
              {__("Services", block.textdomain)}
            </h5>
          ) : (
            <RichText
              tagName="h5"
              className="service-list-heading"
              placeholder={__("Click to add a title", block.textdomain)}
              value={heading}
              onChange={handleChangeHeading}
              allowedFormats={[
                "core/bold",
                "core/italic",
                "core/link",
                "core/text-color",
              ]}
            />
          )}
          <h6 className="service-list-subheading">{subHeading}</h6>
          <ul className={`service-list-wrapper ${listClasses}`}>
            {services?.map((service) => (
              <li key={service?.id} className="service-list-item">
                <i className="bi bi-briefcase"></i>
                <span>
                  <p className="service-list-item-title">
                    {service?.title?.rendered}
                  </p>
                </span>
              </li>
            ))}
          </ul>
        </div>
      </>
    );
  },
});
