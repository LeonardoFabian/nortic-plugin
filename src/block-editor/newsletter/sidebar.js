import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __, _x } from "@wordpress/i18n";
import { PanelBody, SelectControl, Spinner } from "@wordpress/components";
import { useSelect, useDispatch } from "@wordpress/data";
import { Rating, Typography } from "@mui/material";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const { rating, total_ratings, dependency_id } = useSelect((select) => {
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

    const dependencyOptions = [];

    if (!!dependencies) {
      Object.values(dependencies).forEach((dependency) => {
        dependencyOptions.push({
          value: dependency?.id,
          label: dependency?.title?.rendered
            ? dependency.title.rendered
            : __("No title", "nortic-plugin"),
        });
      });
    }

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Newsletter Metadata", "nortic-plugin")}
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
          {!dependencies && <Spinner />}
          {!!dependencies && (
            <SelectControl
              label={_x(
                "Select a Dependency",
                "Select control label",
                "nortic-plugin"
              )}
              value={dependency_id}
              options={[
                { label: __("None", "nortic-plugin"), value: 0 },
                ...dependencyOptions,
              ]}
              onChange={(dependency_id) =>
                editPost({
                  meta: {
                    dependency_id,
                  },
                })
              }
            />
          )}
        </PanelBody>
      </PluginSidebar>
    );
  },
});
