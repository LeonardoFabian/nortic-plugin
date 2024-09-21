import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __, _x } from "@wordpress/i18n";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  DateTimePicker,
  SelectControl,
  Spinner,
  __experimentalSurface as Surface,
  __experimentalText as Text,
} from "@wordpress/components";
import { useSelect, useDispatch } from "@wordpress/data";
import { Rating, Typography } from "@mui/material";

// Icon : dashicon value

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      iframe,
      rating,
      total_ratings,
      alias,
      description,
      target_audience,
      online_service_available,
      app_service_available,
      url,
      phone_service_available,
      phone,
      email_service_available,
      email,
      in_person_service_available,
      location,
      requirements,
      procedure,
      benefits,
      criteria,
      schedule,
      cost,
      completion_time,
      additional_info,
      icon,
      use_default_icon,
      override_icon,
      date,
      service_dependency_id,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const { editPost } = useDispatch("core/editor");

    // get all dependencies
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

    // console.log(dependencies);

    const options = [];

    // Make an array from the REST API response if posts are available
    if (!!dependencies) {
      Object.values(dependencies).forEach((dependency) => {
        options.push({
          value: dependency.id,
          label: dependency.title.rendered
            ? dependency.title.rendered
            : _x("No title", "SelectControl option label", "nortic-plugin"),
        });
      });
    }

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Service Metadata", "nortic-plugin")}
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
        <PanelBody title={__("Settings", "nortic-plugin")}>
          <Surface
            style={{
              margin: "1rem auto",
            }}
          >
            <Text>{__("Service Channels", "nortic-plugin")}</Text>
          </Surface>
          <ToggleControl
            label={__("In-Person service available", "nortic-plugin")}
            checked={in_person_service_available}
            onChange={(in_person_service_available) =>
              editPost({
                meta: {
                  in_person_service_available,
                },
              })
            }
          />
          <ToggleControl
            label={__("Phone service available", "nortic-plugin")}
            checked={phone_service_available}
            onChange={(phone_service_available) =>
              editPost({
                meta: {
                  phone_service_available,
                },
              })
            }
          />
          <ToggleControl
            label={__("Email service available", "nortic-plugin")}
            checked={email_service_available}
            onChange={(email_service_available) =>
              editPost({
                meta: {
                  email_service_available,
                },
              })
            }
          />
          <ToggleControl
            label={__("Online service available", "nortic-plugin")}
            checked={online_service_available}
            onChange={(online_service_available) =>
              editPost({
                meta: {
                  online_service_available,
                },
              })
            }
          />
          <ToggleControl
            label={__("App mobile service available", "nortic-plugin")}
            checked={app_service_available}
            onChange={(app_service_available) =>
              editPost({
                meta: {
                  app_service_available,
                },
              })
            }
          />
        </PanelBody>
        {/* Information */}
        <PanelBody title={__("Information", "nortic-plugin")}>
          <TextControl
            label={__("Bootstrap icon", "nortic-plugin")}
            value={icon}
            placeholder={`<i class="bi bi-calculator"></i>`}
            onChange={(icon) =>
              editPost({
                meta: {
                  icon,
                },
              })
            }
            help={__(
              "Select, copy and paste an icon from Bootstrap Icons list from https://icons.getbootstrap.com/",
              "nortic-plugin"
            )}
          />
          {!dependencies && <Spinner />}
          {!!dependencies && (
            <SelectControl
              label={_x(
                "Select a Dependency",
                "Select control label",
                "nortic-plugin"
              )}
              value={service_dependency_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...options,
              ]}
              onChange={(service_dependency_id) =>
                editPost({
                  meta: {
                    service_dependency_id,
                  },
                })
              }
            />
          )}

          <TextareaControl
            label={__("Alias", "nortic-plugin")}
            value={alias}
            onChange={(alias) =>
              editPost({
                meta: {
                  alias,
                },
              })
            }
          />
          <TextareaControl
            label={__("Description", "nortic-plugin")}
            value={description}
            onChange={(description) =>
              editPost({
                meta: {
                  description,
                },
              })
            }
          />
          <TextareaControl
            label={__("Target audience", "nortic-plugin")}
            value={target_audience}
            onChange={(target_audience) =>
              editPost({
                meta: {
                  target_audience,
                },
              })
            }
          />
          <TextareaControl
            label={__("Requirements", "nortic-plugin")}
            value={requirements}
            onChange={(requirements) =>
              editPost({
                meta: {
                  requirements,
                },
              })
            }
          />

          <TextareaControl
            label={__("Procedure", "nortic-plugin")}
            value={procedure}
            onChange={(procedure) =>
              editPost({
                meta: {
                  procedure,
                },
              })
            }
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
