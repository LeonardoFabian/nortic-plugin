import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar } from "@wordpress/edit-post";
import { __, _x } from "@wordpress/i18n";
import {
  PanelBody,
  TextControl,
  TextareaControl,
  SelectControl,
  ToggleControl,
  Spinner,
  __experimentalSurface as Surface,
  __experimentalText as Text,
} from "@wordpress/components";
import { useSelect, useDispatch } from "@wordpress/data";

registerPlugin("nortic-plugin-sidebar", {
  render() {
    const { url, target_audience, alias, icon, use_default_icon } = useSelect(
      (select) => {
        return select("core/editor").getEditedPostAttribute("meta");
      }
    );

    const { editPost } = useDispatch("core/editor");

    return (
      <PluginSidebar
        name="nortic_plugin_sidebar"
        icon="menu-alt"
        title={__("System metadata", "nortic-plugin")}
      >
        <PanelBody title={__("Information", "nortic-plugin")}>
          <TextControl
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
            label={__("URL", "nortic-plugin")}
            value={url}
            onChange={(url) =>
              editPost({
                meta: {
                  url,
                },
              })
            }
          />
          <SelectControl
            label={__("Target audience", "nortic-plugin")}
            value={target_audience}
            options={[
              { label: __("None", "nortic-plugin"), value: "" },
              { label: __("Companies", "nortic-plugin"), value: "empresas" },
              { label: __("Workers", "nortic-plugin"), value: "trabajadores" },
              { label: __("Candidates", "nortic-plugin"), value: "candidatos" },
              {
                label: __("Companies/Workers", "nortic-plugin"),
                value: "empresas-y-trabajadores",
              },
              {
                label: __("Workers/Candidates", "nortic-plugin"),
                value: "trabajadores-y-candidatos",
              },
              {
                label: __("Companies/Workers/Candidates", "nortic-plugin"),
                value: "empresas-trabajadores-y-candidatos",
              },
            ]}
            onChange={(target_audience) =>
              editPost({
                meta: {
                  target_audience,
                },
              })
            }
          />
          <TextControl
            label={__("Bootstrap icon", "nortic-plugin")}
            value={icon}
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
        </PanelBody>
        {/* <PanelBody title={__('Settings', 'nortic-plugin')}>

        </PanelBody> */}
      </PluginSidebar>
    );
  },
});
