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
} from "@wordpress/components";
import { Rating, Typography } from "@mui/material";
import { useState } from "@wordpress/element";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const {
      iframe,
      rating,
      total_ratings,
      description,
      requirements,
      procedure,
      criteria,
      additional_info,
      cost,
      url,
      phone,
      email,
      location,
      is_expired,
      begin_date,
      end_date,
    } = useSelect((select) => {
      return select("core/editor").getEditedPostAttribute("meta");
    });

    const [currentDate, setCurrentDate] = useState(new Date());

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
        <PanelBody title={__("Content", "nortic-plugin")}>
          <TextareaControl
            label={__("Description", "nortic-plugin")}
            value={description}
            onChange={(description) => {}}
          />
          <TextareaControl
            label={__("Requirements", "nortic-plugin")}
            value={requirements}
            onChange={(requirements) => {}}
          />
          <TextareaControl
            label={__("Procedures", "nortic-plugin")}
            value={procedure}
            onChange={(procedure) => {}}
          />

          <TextareaControl
            label={__("Embed a map", "nortic-plugin")}
            value={iframe}
            onChange={(iframe) => {}}
          />
        </PanelBody>
        <PanelBody title={__("Begin Date", "nortic-plugin")}>
          <DateTimePicker
            currentDate={currentDate}
            onChange={(begin_date) => {}}
            is12Hour={true}
          />
        </PanelBody>
        <PanelBody title={__("End Date", "nortic-plugin")}>
          <DateTimePicker
            currentDate={currentDate}
            onChange={(end_date) => {}}
            is12Hour={true}
          />
        </PanelBody>
      </PluginSidebar>
    );
  },
});
