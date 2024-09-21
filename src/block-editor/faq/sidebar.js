import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __, _x } from "@wordpress/i18n";
import { useSelect, useDispatch } from "@wordpress/data";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  Spinner,
  SelectControl,
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const { rating, total_ratings, faq_service_id, faq_dependency_id } =
      useSelect((select) => {
        return select("core/editor").getEditedPostAttribute("meta");
      });

    const { editPost } = useDispatch("core/editor");

    // get all services
    const { services } = useSelect((select) => {
      return {
        services: select("core").getEntityRecords("postType", "service", {
          per_page: -1,
          order: "asc",
          order_by: "post_title",
        }),
      };
    }, []);

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

    const serviceOptions = [];
    const dependencyOptions = [];

    if (!!services) {
      Object.values(services).forEach((service) => {
        serviceOptions.push({
          value: service.id,
          label: service.title.rendered
            ? service.title.rendered
            : _x("No title", "SelectControl option label", "nortic-plugin"),
        });
      });
    }

    if (!!dependencies) {
      Object.values(dependencies).forEach((dependency) => {
        dependencyOptions.push({
          value: dependency.id,
          label: dependency.title.rendered
            ? dependency.title.rendered
            : _x("No title", "SelectControl option label", "nortic-plugin"),
        });
      });
    }

    const handleSelectService = (faq_service_id) => {
      editPost({
        meta: {
          faq_service_id,
        },
      });
    };

    const handleSelectDependency = (faq_dependency_id) => {
      editPost({
        meta: {
          faq_dependency_id,
        },
      });
    };

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("FAQs Metadata", "nortic-plugin")}
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
        <PanelBody title={__("Information", "nortic-plugin")}>
          {!services && <Spinner />}
          {!!services && (
            <SelectControl
              label={__("Associate with a Service", "nortic-plugin")}
              value={faq_service_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...serviceOptions,
              ]}
              onChange={handleSelectService}
            />
          )}
          {!dependencies && <Spinner />}
          {!!dependencies && (
            <SelectControl
              label={__("Associate with a Dependency", "nortic-plugin")}
              value={faq_dependency_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...dependencyOptions,
              ]}
              onChange={handleSelectDependency}
            />
          )}
        </PanelBody>
      </PluginSidebar>
    );
  },
});
