import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  InspectorControls,
  RichText,
} from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";
import { PanelBody, QueryControls } from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { RawHTML } from "@wordpress/element";
import { format, dateI18n, __experimentalGetSettings } from "@wordpress/date";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const { count, directories, order, orderBy } = attributes;
    const blockProps = useBlockProps();

    // Load plugin directory to load assets, ex.: images
    const { pluginDirectoryUri } = pluginPublicScripts;

    const cardStyle = `col-${count} flex justify-between items-center rounded-xl border border-gray-100 p-4 shadow-xl file-category`;

    const fileDirectoriesTerms = useSelect((select) => {
      return select("core").getEntityRecords("taxonomy", "directory", {
        per_page: -1,
      });
    }, []);
    const fileDirectoryArray = {};

    fileDirectoriesTerms?.forEach((term) => {
      fileDirectoryArray[term.name] = term;
    });

    // console.log(fileDirectoryArray);

    const directoryIDs = directories.map((term) => term.id);
    const files = useSelect(
      (select) => {
        return select("core").getEntityRecords("postType", "document", {
          per_page: count,
          _embed: true,
          directory: directoryIDs,
          order: order,
          orderby: orderBy,
        });
      },
      [count, directoryIDs]
    );

    // console.log(files);

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", "nortic-plugin")}>
            <QueryControls
              numberOfItems={count}
              minItems={1}
              maxItems={10}
              onNumberOfItemsChange={(count) => setAttributes({ count })}
              categorySuggestions={fileDirectoryArray}
              onCategoryChange={(newTerms) => {
                const newDirectories = [];

                newTerms.forEach((directory) => {
                  if (typeof directory === "object") {
                    return newDirectories.push(directory);
                  }

                  const directoryTerm = fileDirectoriesTerms?.find(
                    (term) => term.name === directory
                  );

                  if (directoryTerm) newDirectories.push(directoryTerm);
                });

                setAttributes({ directories: newDirectories });
              }}
              selectedCategories={directories}
              orderBy={orderBy}
              onOrderByChange={(value) => setAttributes({ orderBy: value })}
              order={order}
              onOrderChange={(value) => setAttributes({ order: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          {/* Service Section Start */}
          <section className="pb-12">
            <div className="mx-auto">
              <div className="file-list-container">
                {
                  files?.map((file) => {

                  

                    return (
                      <div className="relative rounded-xl bg-white border-solid border border-gray-200 py-2 px-4 mb-2 shadow-xl flex justify-between items-center">
                  
                        <i className="bi-info-circle-fill !text-md color-yellow absolute top-0 right-0 p-2"></i>
                      
                        
                        <div className="file-data py-2 text-gray-500 flex justify-start items-center">
                          <span className="dashicons dashicons-media-default file-icon w-14"></span>
                          <div className="flex flex-col items-start px-4">
                            <h6 className="text-md font-semibold">
                              <RawHTML>
                                {file.title.rendered
                                  ? file.title.rendered
                                  : __("No Title", "nortic-plugin")}
                              </RawHTML>
                            </h6>
                            <div className="flex items-center justify-start gap-4">
                              <span className="file-size text-sm">{file.meta.file_size_readable}</span>
                              <span>
                              {__('Publication date', 'nortic-plugin')}:
                              <time
                              dateTime={format("c", file.date_gmt)}
                              className="text-sm text-body-color"
                            >
                              {dateI18n(
                                __experimentalGetSettings().formats.date,
                                file.date_gmt
                              )}
                            </time>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div className="file-options gap-4 justify-between">
                          <a className="button button-accent" href="#">{__('Download', 'nortic-plugin')}</a>
                        </div>
                    
                      </div>
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
