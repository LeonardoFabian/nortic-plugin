import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  ToggleControl,
  DateTimePicker,
  CheckboxControl,
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";
import { useState } from "@wordpress/element";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const { highlight_achievement } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("Dependency Metadata", "nortic-plugin")}
      >
        <PanelBody title={__("Settings", "nortic-plugin")}>
          <CheckboxControl
            label={__("Highlight achievement", "nortic-plugin")}
            help={__("If the achievement will be highlighted", "nortic-plugin")}
            checked={highlight_achievement}
            onChange={(highlight_achievement) => {}}
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
