import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
  BlockControls,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls, SelectControl } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { dateI18n } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { count, areas, categories, shadow } =
      attributes;
    const blockProps = useBlockProps();

    const toggleShadow = () => {
      setAttributes({ shadow: !shadow });
    };

    const cardStyle = `border ${
      shadow == true ? "has-shadow" : ""
    }`;

    const officeAreasTerms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "area", {
        per_page: -1,
      });
    }, []);
    // console.log(officeAreasTerms);
    const officeAreaArray = {};

    officeAreasTerms?.forEach((term) => {
      officeAreaArray[term.name] = term;
    });

    // console.log(officeAreaArray);

    const officeCategoriesTerms = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "dependency_category",
        {
          per_page: -1,
        }
      );
    }, []);
    const officeCategoryArray = {};

    officeCategoriesTerms?.forEach((term) => {
      officeCategoryArray[term.name] = term;
    });

    // console.log(officeCategoryArray);

    const areaIDs = areas.map((term) => term.id);
    const locations = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "dependency", {
          per_page: count,
          _embed: true,
          area: areaIDs,
          order: "asc",
          orderByName: 1,
        });
      },
      [count, areaIDs]
    );

    // console.log(locations);

    return (
      <>
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
              minItems={-1}
              maxItems={100}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={officeAreaArray}
              onCategoryChange={(newTerms) => {
                const newAreas = [];

                newTerms.forEach((area) => {
                  if (typeof area === "object") {
                    return newAreas.push(area);
                  }

                  const areaTerm = officeAreasTerms?.find(
                    (term) => term.name === area
                  );

                  if (areaTerm) newAreas.push(areaTerm);
                });

                setAttributes({ areas: newAreas });
              }}
              selectedCategories={areas}
            />
          </PanelBody>
        </InspectorControls>
        
    
                {locations?.map((location) => {
                  const featuredImage =
                    location._embedded &&
                    location._embedded["wp:featuredmedia"] &&
                    location._embedded["wp:featuredmedia"].length > 0 &&
                    location._embedded["wp:featuredmedia"][0];

                  const locationImage =
                    featuredImage?.media_details.sizes.horizontalMap.source_url;

                  return (
                    <div {...blockProps}>
          {/* Blog Section Start */}
                    <div className={cardStyle}>
                      <div className="bg-white h-48 rounded shadow-md flex text-grey-darkest office-location-meta">
                        {locationImage && (
                          <a
                            href="#"
                            className="office-location-meta-img-wrap block h-full"
                          >
                            <div
                              className="office-location-meta-img h-full rounded-l-sm bg-cover bg-center"
                              style={{
                                backgroundImage: `${locationImage}`,
                              }}
                            ></div>
                          </a>
                        )}

                        <div className="w-full flex flex-col">
                          <div className="p-4 pb-0 flex-1 office-location-metadata">
                            <h6 className="office-location-name">
                              <span className="font-light mb-1 text-grey-darkest">
                                <RawHTML>{location.title.rendered}</RawHTML>
                              </span>
                            </h6>                          

                            
                          </div>
                        </div>
                      </div>
                    </div>
                    {/* Blog Section End  */}
        </div>
                  );
                })}
           
  
          
      </>
    );
  },
});
