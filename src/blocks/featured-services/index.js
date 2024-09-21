import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
  BlockControls,
  AlignmentToolbar,
  PanelColorSettings,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import {
  PanelBody,
  QueryControls,
  Spinner,
  SelectControl,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { dateI18n } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      title,
      description,
      count,
      classifications,
      alignment,
      icon,
      icon_color,
      shadow,
      text_color,
    } = attributes;
    const blockProps = useBlockProps();

    // handle cards shadow
    const toggleShadow = () => {
      setAttributes({ shadow: !shadow });
    };

    const cardStyle = `col-${count} relative rounded-xl border border-gray-100 p-8 ${
      shadow == true ? "has-shadow" : ""
    }`;

    const serviceClassificationsTerms = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "service_classification",
        {
          per_page: -1,
        }
      );
    }, []);
    const serviceClassificationArray = {};

    serviceClassificationsTerms?.forEach((term) => {
      serviceClassificationArray[term.name] = term;
    });

    // console.log(serviceClassificationArray);

    const classificationIDs = classifications.map((term) => term.id);
    const services = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "service", {
          per_page: count,
          _embed: true,
          service_classification: classificationIDs,
          order: "desc",
          orderByRating: 1,
        });
      },
      [count, classificationIDs]
    );

    // console.log(services);

    const handleServiceContentAlignment = (newAlignment) => {
      setAttributes({ alignment: newAlignment });
    };

    const serviceIcon = `bi bi-${icon} text-5xl`;

    return (
      <>
        <BlockControls group="inline">
          <AlignmentToolbar
            onChange={handleServiceContentAlignment}
            value={alignment}
          />
        </BlockControls>
        <BlockControls
          controls={[
            {
              icon: "admin-page",
              title: __("Shadow", "nortic-plugin"),
              onClick: toggleShadow,
              isActive: shadow,
            },
          ]}
        ></BlockControls>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={1}
              maxItems={10}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={serviceClassificationArray}
              onCategoryChange={(newTerms) => {
                const newClassifications = [];

                newTerms.forEach((classification) => {
                  if (typeof classification === "object") {
                    return newClassifications.push(classification);
                  }

                  const classificationTerm = serviceClassificationsTerms?.find(
                    (term) => term.name === classification
                  );

                  if (classificationTerm)
                    newClassifications.push(classificationTerm);
                });

                setAttributes({ classifications: newClassifications });
              }}
              selectedCategories={classifications}
            />
            <SelectControl
              label={__("Bootstrap Icon", "nortic-plugin")}
              value={icon}
              options={[
                { label: __("Briefcase"), value: "briefcase" },
                { label: __("Bank"), value: "bank" },
                { label: __("Bank 2"), value: "bank2" },
                { label: __("Bar Chart"), value: "bar-chart" },
                { label: __("Book"), value: "book" },
                { label: __("Box Seam"), value: "box-seam" },
                { label: __("Building"), value: "building" },
                { label: __("Calculator"), value: "calculator" },
                { label: __("Calendar Week"), value: "calendar2-week" },
                { label: __("Clock"), value: "clock" },
                { label: __("Database Lock"), value: "database-lock" },
                {
                  label: __("Exclamation Circle"),
                  value: "exclamation-circle",
                },
                { label: __("Eye"), value: "eye" },
                { label: __("File Text"), value: "file-text" },
                { label: __("Fingerprint"), value: "fingerprint" },
                { label: __("Flag"), value: "flag" },
                { label: __("Folder Open"), value: "folder2-open" },
                { label: __("Gear"), value: "gear" },
                { label: __("Geo Alt"), value: "geo-alt" },
                { label: __("Globe"), value: "globe" },
                { label: __("Graph Up Arrow"), value: "graph-up-arrow" },
                { label: __("Grid"), value: "grid" },
                { label: __("Hand Thumbs Up"), value: "hand-thumbs-up" },
                { label: __("Headset"), value: "headset" },
                { label: __("Heart Pulse"), value: "heart-pulse" },
                { label: __("Hourglass"), value: "hourglass" },
                { label: __("House"), value: "house" },
                { label: __("Info Circle"), value: "info-circle" },
                { label: __("Life Preserver"), value: "life-preserver" },
                { label: __("Lightning Charge"), value: "lightning-charge" },
                { label: __("Lock"), value: "lock" },
                { label: __("Mortarboard"), value: "mortarboard" },
                { label: __("People"), value: "people" },
                { label: __("Person"), value: "person" },
                { label: __("Puzzle"), value: "puzzle" },
                { label: __("Question Circle"), value: "question-circle" },
                { label: __("Search"), value: "search" },
                { label: __("Share"), value: "share" },
                { label: __("Shield Check"), value: "shield-check" },
                { label: __("Shop"), value: "shop" },
                { label: __("Signpost 2"), value: "signpost-2" },
                { label: __("Sliders"), value: "sliders" },
                { label: __("Star"), value: "star" },
                { label: __("Stopwatch"), value: "stopwatch" },
                { label: __("Ticket Perforated"), value: "ticket-perforated" },
                { label: __("Tools"), value: "tools" },
                { label: __("Trophy"), value: "trophy" },
                { label: __("Truck"), value: "truck" },
                { label: __("Umbrella"), value: "umbrella" },
                { label: __("Vector Pen"), value: "vector-pen" },
                { label: __("Wallet 2"), value: "wallet2" },
              ]}
              onChange={(icon) => setAttributes({ icon })}
            />
          </PanelBody>
          <PanelColorSettings
            title={__("Colors", "nortic-plugin")}
            colorSettings={[
              {
                label: __("Text color", "nortic-plugin"),
                value: text_color,
                onChange: (text_color) => setAttributes({ text_color }),
              },
              {
                label: __("Icon color", "nortic-plugin"),
                value: icon_color,
                onChange: (icon_color) => setAttributes({ icon_color }),
              },
            ]}
          />
        </InspectorControls>
        <div {...blockProps}>
          {/* Service Section Start */}
          <section className="pt-20 pb-10">
            <div className="container">
              <div className="flex flex-wrap justify-center -mx-4">
                <div className="w-full px-4">
                  <div className="text-center mx-auto">
                    <RichText
                      tagName="h5"
                      className="font-bold text-3xl text-dark mb-4"
                      value={title}
                      onChange={(title) => setAttributes({ title })}
                      placeholder={__("Add a title", "nortic-plugin")}
                    />
                  </div>
                  <div className="text-center mx-auto">
                    <RichText
                      tagName="p"
                      className="text-base text-body-color"
                      value={description}
                      onChange={(description) => setAttributes({ description })}
                      placeholder={__("Add description", "nortic-plugin")}
                    />
                  </div>
                </div>
              </div>
              <div className="flex flex-wrap -mx-4 featured-services-container">
                {services?.map((service) => {
                  return (
                    <a
                      className={cardStyle}
                      href={service.link}
                      onClick={(e) => {
                        e.preventDefault();
                      }}
                    >
                      <div className="flex justify-end">
                        <span className="featured-service-rating rounded-full bg-green-100 px-3 py-1.5 text-xs font-medium text-green-600">
                          {service.meta.rating}
                        </span>
                      </div>
                      <div
                        className="py-4 text-gray-500"
                        style={{ "text-align": alignment }}
                      >
                        <i
                          className={serviceIcon}
                          style={{ color: icon_color }}
                        ></i>

                        <h3 className="mt-4 text-lg font-bold">
                          <RawHTML>{service.title.rendered}</RawHTML>
                        </h3>

                        <p className="mt-2 text-md">
                          <RawHTML>{service.excerpt.rendered}</RawHTML>
                        </p>
                      </div>
                    </a>
                  );
                })}
              </div>
            </div>
          </section>
          {/* Service Section End  */}
        </div>
      </>
    );
  },
});
