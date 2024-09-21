import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Content Metadata", "nortic-plugin")}
      ></PluginSidebar>
    );
  },
});
