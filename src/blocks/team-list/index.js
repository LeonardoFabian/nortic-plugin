import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";
import {
  RangeControl,
  Spinner,
  PanelBody,
  ToggleControl,
  TextareaControl,
  QueryControls,
  RichText,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import block from "./block.json";
import icons from "../../icons.js";
import "./main.css";

registerBlockType(block.name, {
  icon: icons.domo,
  edit({ attributes, setAttributes }) {
    const {
      group_terms,
      numberOfItems,
      order,
      orderBy,
      show_navigation_thumbs,
    } = attributes;
    const blockProps = useBlockProps();

    console.log("Terms: ", group_terms);

    const groupTermsQuery = {
      per_page: -1,
    };

    // retrieve team tags
    const groupTerms = useSelect((select) => {
      return select("core").getEntityRecords(
        "taxonomy",
        "group",
        groupTermsQuery
      );
    }, []);
    const teamGroupsArray = {};

    groupTerms?.forEach((term) => {
      teamGroupsArray[term.name] = term;
    });

    const groupIDs = group_terms.map((term) => term.id);

    const teams = useSelect(
      (select) => {
        const query = {
          per_page: numberOfItems,
          _embed: true,
          order: order,
          orderby: orderBy,
          tax_query: [
            {
              taxonomy: "group",
              field: "term_id",
              terms: groupIDs,
              operator: "IN",
            },
          ],
        };

        return select("core").getEntityRecords("postType", "team", query);
      },
      [numberOfItems, groupIDs, group_terms, order, orderBy]
    );

    if (!teams) {
      return (
        <div {...blockProps}>
          <Spinner />
        </div>
      );
    }

    console.log("teams: ", teams);

    const handleShowNavigationThumbs = () => {
      setAttributes({ show_navigation_thumbs: !show_navigation_thumbs });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__("Settings", block.textdomain)}>
            <ToggleControl
              label={__("Show Navigation Thumbs", block.textdomain)}
              checked={show_navigation_thumbs}
              onChange={handleShowNavigationThumbs}
              helpText={
                show_navigation_thumbs
                  ? __("Displaying thumbnail images", block.textdomain)
                  : __("Hiding thumbnail images", block.textdomain)
              }
            />
            <QueryControls
              numberOfItems={numberOfItems}
              minItems={-1}
              maxItems={100}
              onNumberOfItemsChange={(numberOfItems) =>
                setAttributes({ numberOfItems })
              }
              categorySuggestions={teamGroupsArray}
              // categoriesList={groupTerms}
              onCategoryChange={(newTerms) => {
                const newGroups = [];

                newTerms.forEach((group) => {
                  if (typeof group === "object") {
                    return newGroups.push(group);
                  }

                  const groupTerm = groupTerms?.find(
                    (term) => term.name === group
                  );

                  if (groupTerm) newGroups.push(groupTerm);
                });

                setAttributes({ group_terms: newGroups });
              }}
              selectedCategories={group_terms}
              orderBy={orderBy}
              onOrderByChange={(value) => setAttributes({ orderBy: value })}
              order={order}
              onOrderChange={(value) => setAttributes({ order: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...blockProps}>
          <ul className={`team-list-wrapper`}>
            {teams?.length > 0 ? (
              teams?.map((team) => (
                <li key={team?.id} className="team-list-item">
                  <i className="bi bi-briefcase"></i>
                  <span>
                    <p className="team-list-item-title">
                      {team?.title?.rendered}
                    </p>
                  </span>
                </li>
              ))
            ) : (
              <p>{__("No teams available", block.textdomain)}</p>
            )}
          </ul>
        </div>
      </>
    );
  },
});
