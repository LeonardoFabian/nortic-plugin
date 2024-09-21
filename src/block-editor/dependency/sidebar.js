import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __, _x } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  SelectControl,
  Spinner,
  __experimentalHStack as HStack,
  __experimentalText as Text,
  Icon,
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      iframe,
      general_objective,
      specific_objective,
      main_functions,
      achievements,
      reponsible_member_id,
      parent_dependency_id,
      rating,
      total_ratings,
      description,

      schedule,
      url,
      phone_service_available,
      phone,
      email_service_available,
      email,
      in_person_service_available,
      location,
      mission,
      vision,
      values,
      interests,
      map_link,
      map_iframe,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const postType = useSelect(
      (select) => select("core/editor").getCurrentPostType(),
      []
    );

    const { editPost } = useDispatch("core/editor");

    const { dependencies } = useSelect((select) => {
      return {
        dependencies: select("core").getEntityRecords(
          "postType",
          "dependency",
          {
            per_page: -1,
            order: "asc",
            order_by: "post_title",
          }
        ),
      };
    }, []);

    const { teamMembers } = useSelect((select) => {
      return {
        teamMembers: select("core").getEntityRecords("postType", "team", {
          per_page: -1,
          order: "asc",
          order_by: "post_title",
        }),
      };
    }, []);

    const dependencyOptions = [];
    const teamOptions = [];

    if (!!dependencies) {
      Object.values(dependencies).forEach((dependency) => {
        dependencyOptions.push({
          value: dependency?.id,
          label: dependency?.title?.rendered
            ? dependency.title.rendered
            : _x("No title", "SelectControl option label", "nortic-plugin"),
        });
      });
    }

    if (!!teamMembers) {
      Object.values(teamMembers).forEach((member) => {
        teamOptions.push({
          value: member?.id,
          label: member.title.rendered
            ? member?.title?.rendered
            : _x("No title", "SelectControl option label", "nortic-plugin"),
        });
      });
    }

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Dependency Metadata", "nortic-plugin")}
      >
        <PanelBody title={__("Statistics", "nortic-plugin")}>
          <Rating value={rating} precision={0.5} readOnly />
          <Typography variant="body2" color="text.secondary">
            {__("Rating", "nortic-plugin")}: {rating}
          </Typography>
          <Typography variant="body2" color="text.secondary">
            {__("Total", "nortic-plugin")}: {total_ratings}{" "}
            {total_ratings == 1
              ? __("user rating", "nortic-plugin")
              : __("users rating", "nortic-plugin")}
          </Typography>
        </PanelBody>
        <PanelBody title={__("Parent Dependency", "nortic-plugin")}>
          {!dependencies && <Spinner />}
          {!!dependencies && (
            <SelectControl
              label={__("Select Parent Dependency", "nortic-plugin")}
              value={parent_dependency_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...dependencyOptions,
              ]}
              onChange={(parent_dependency_id) =>
                editPost({
                  meta: {
                    parent_dependency_id,
                  },
                })
              }
            />
          )}
        </PanelBody>
        <PanelBody title={__("Information", "nortic-plugin")}>
          {!teamMembers && <Spinner />}
          {!!teamMembers && (
            <SelectControl
              label={_x(
                "Select a member",
                "Select control label",
                "nortic-plugin"
              )}
              value={reponsible_member_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...teamOptions,
              ]}
              onChange={(reponsible_member_id) =>
                editPost({
                  meta: {
                    reponsible_member_id,
                  },
                })
              }
            />
          )}
          <TextareaControl
            label={__("General objective", "nortic-plugin")}
            value={general_objective}
            onChange={(general_objective) =>
              editPost({
                meta: {
                  general_objective,
                },
              })
            }
          />
          <TextareaControl
            label={__("Specific objective", "nortic-plugin")}
            value={specific_objective}
            onChange={(specific_objective) =>
              editPost({
                meta: {
                  specific_objective,
                },
              })
            }
          />
          <TextareaControl
            label={__("Main functions", "nortic-plugin")}
            value={main_functions}
            onChange={(main_functions) =>
              editPost({
                meta: {
                  main_functions,
                },
              })
            }
          />

          <TextareaControl
            label={__("Embed a map", "nortic-plugin")}
            value={map_iframe}
            onChange={(map_iframe) =>
              editPost({
                meta: {
                  map_iframe,
                },
              })
            }
          />
        </PanelBody>
        <PanelBody title={__("Contact", "nortic-plugin")}>
          {postType !== "team" && (
            <>
              <HStack
                alignment="center"
                justify="start"
                spacing="3"
                style={{
                  marginBottom: ".5rem",
                }}
              >
                <Icon icon="location" />
                <Text>{__("Location", "nortic-plugin")}</Text>
              </HStack>
              <TextareaControl
                value={location}
                onChange={(location) =>
                  editPost({
                    meta: {
                      location,
                    },
                  })
                }
              />
            </>
          )}
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="phone" />
            <Text>{__("Phone Number", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            // label={__("Phone Number", "nortic-plugin")}
            value={phone}
            onChange={(phone) =>
              editPost({
                meta: {
                  phone,
                },
              })
            }
          />
          <HStack
            alignment="center"
            justify="start"
            spacing="3"
            style={{
              marginBottom: ".5rem",
            }}
          >
            <Icon icon="email" />
            <Text>{__("Email", "nortic-plugin")}</Text>
          </HStack>
          <TextControl
            value={email}
            onChange={(email) =>
              editPost({
                meta: {
                  email,
                },
              })
            }
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
