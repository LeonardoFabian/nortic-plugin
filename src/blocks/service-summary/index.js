import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { useEntityProp } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes, context }) {
    const { hours, cost, completion_time, online_service_url, icon_color } =
      attributes;
    const { postId } = context;
    // console.log(postId);

    const [classificationTermsIDs] = useEntityProp(
      "postType",
      "service",
      "service_classification",
      postId
    );

    // query to retrieve the terms associated with the service classification term
    const { classifications } = useSelect(
      (select) => {
        const { getEntityRecords } = select("core");

        return {
          classifications: getEntityRecords(
            "taxonomy",
            "service_classification",
            {
              include: classificationTermsIDs,
            }
          ),
        };
      },
      [classificationTermsIDs]
    );

    // console.log(classificationTermsIDs);
    // console.log(classifications);

    const blockProps = useBlockProps({
      className: "-mx-4",
    });
    return (
      <>
        <div {...blockProps}>
          <div className="service-summary-card mb-4 flex-1 p-8 cursor-pointer border border-gray-200 rounded-lg shadow-lg  bg-white">
            <div className="block relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
              <i
                className="bi bi-calendar4-week"
                style={{ color: icon_color }}
              ></i>
              <h4 className="service-summary-title">
                {__("Schedule and place of provision", "nortic-plugin")}
              </h4>
              <RichText
                tagName="span"
                value={hours}
                onChange={(hours) => setAttributes({ hours })}
                placeholder={__("Click to edit", "nortic-plugin")}
              />
              <div className="absolute">
                <span className="text-white">{hours}</span>
              </div>
            </div>
          </div>
          <div className="service-summary-card mb-4 flex-1 p-8 cursor-pointer border border-gray-200 rounded-lg shadow-lg  bg-white">
            <div className="block relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
              <i
                className="bi bi-clock-history"
                style={{ color: icon_color }}
              ></i>
              <h4 className="service-summary-title">
                {__("Completion time", "nortic-plugin")}
              </h4>
              <RichText
                tagName="span"
                value={completion_time}
                onChange={(completion_time) =>
                  setAttributes({ completion_time })
                }
                placeholder={__("Click to edit", "nortic-plugin")}
              />
              <div className="absolute">
                <span className="text-white">{completion_time}</span>
              </div>
            </div>
          </div>
          <div className="service-summary-card mb-4 flex-1 p-8 cursor-pointer border border-gray-200 rounded-lg shadow-lg  bg-white">
            <div className="block relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
              <i
                className="bi bi-currency-dollar"
                style={{ color: icon_color }}
              ></i>
              <h4 className="service-summary-title">
                {__("Cost", "nortic-plugin")}
              </h4>
              <RichText
                tagName="span"
                value={cost}
                onChange={(cost) => setAttributes({ cost })}
                placeholder={__("Click to edit", "nortic-plugin")}
              />
              <div className="absolute">
                <span className="text-white">{cost}</span>
              </div>
            </div>
          </div>
          <div className="service-summary-card mb-4 flex-1 p-8 cursor-pointer border border-gray-200 rounded-lg shadow-lg  bg-white">
            <div className="block relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
              <i className="bi bi-link-45deg" style={{ color: icon_color }}></i>
              <h4 className="service-summary-title">
                {__("Link", "nortic-plugin")}
              </h4>
              <RichText
                tagName="span"
                value={online_service_url}
                onChange={(online_service_url) =>
                  setAttributes({ online_service_url })
                }
                placeholder={__("Click to edit", "nortic-plugin")}
              />
              <div className="absolute">
                <span className="text-white">{online_service_url}</span>
              </div>
            </div>
          </div>
        </div>
      </>
    );
  },
});
