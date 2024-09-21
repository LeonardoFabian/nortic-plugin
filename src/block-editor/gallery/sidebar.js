import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import { PanelBody } from "@wordpress/components";
import { Rating, Typography } from "@mui/material";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const { rating, total_ratings } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Gallery Metadata", "nortic-plugin")}
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
      </PluginSidebar>
    );
  },
});
